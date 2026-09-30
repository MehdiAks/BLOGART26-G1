<?php
// On charge la configuration globale du site (connexion DB, constantes, etc.).
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// On prépare la liste des feuilles de style spécifiques à cette page.
$pageStyles = [
    ROOT_URL . '/src/css/style.css',
];
$pageTitle = 'Accueil';
$pageDescription = 'Le Bordeaux Étudiant Club Basket : prochains matchs, résultats, actualités, équipes et informations pratiques.';

// On inclut l'en-tête HTML (balises <head>, menu, etc.).
require_once 'header.php';

// On ouvre la connexion à la base de données.
sql_connect();

function resolve_article_image_url(?string $path, string $defaultImage): string
{
    return uploaded_file_url($path, $defaultImage);
}

// On prépare la requête SQL pour récupérer 3 articles au hasard.
// - ORDER BY RAND() mélange aléatoirement les lignes.
// - LIMIT 3 garantit qu'on n'affiche jamais plus de 3 articles.

$articleStmt = $DB->prepare(
    'SELECT numArt, libTitrArt, libChapoArt, urlPhotArt, dtCreaArt
    FROM ARTICLE
    ORDER BY RAND()
    LIMIT 3'
);
// On exécute la requête préparée.
$articleStmt->execute();
// On récupère les résultats sous forme de tableau associatif.
$ba_bec_articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC);

// On récupère les prochains matchs à domicile (Barbey) pour les équipes 1 garçons et filles.
$nextMatches = [
    'SG1' => null,
    'SF1' => null,
];
$becMatchesAvailable = true;

$logoDirectory = $_SERVER['DOCUMENT_ROOT'] . '/src/images/logo/logo-adversaire';
$logoWebBase = ROOT_URL . '/src/images/logo/logo-adversaire';
$becLogoUrl = ROOT_URL . '/src/images/logo/logo-bec/logo.png';
$defaultLogoUrl = ROOT_URL . '/src/images/logo/team-default.svg';

$normalizeClubKey = static function (string $name): string {
    $name = trim($name);
    if ($name === '') {
        return '';
    }
    $name = preg_replace('/\s+\d+$/', '', $name);
    $name = preg_replace('/\s+/', ' ', $name);
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    if ($transliterated !== false) {
        $name = $transliterated;
    }
    $name = strtoupper($name);
    $name = preg_replace('/[^A-Z0-9]+/', '_', $name);
    return trim($name, '_');
};

$buildLogoMap = static function () use ($logoDirectory, $logoWebBase, $normalizeClubKey): array {
    static $logoMap = null;
    if (is_array($logoMap)) {
        return $logoMap;
    }
    $logoMap = [];
    if (!is_dir($logoDirectory)) {
        return $logoMap;
    }
    $files = glob($logoDirectory . '/*.{png,PNG,jpg,JPG,jpeg,JPEG,avif,AVIF,webp,WEBP,svg,SVG}', GLOB_BRACE) ?: [];
    foreach ($files as $file) {
        $baseName = pathinfo($file, PATHINFO_FILENAME);
        $key = $normalizeClubKey($baseName);
        if ($key === '' || isset($logoMap[$key])) {
            continue;
        }
        $logoMap[$key] = $logoWebBase . '/' . basename($file);
    }
    return $logoMap;
};

$resolveClubLogo = static function (?string $clubName) use ($normalizeClubKey, $buildLogoMap, $defaultLogoUrl): string {
    $key = $normalizeClubKey((string) $clubName);
    if ($key === '') {
        return $defaultLogoUrl;
    }
    $logoMap = $buildLogoMap();
    return $logoMap[$key] ?? $defaultLogoUrl;
};

$resolveTeamLogo = static function (string $teamName, string $becTeamName) use ($normalizeClubKey, $resolveClubLogo, $becLogoUrl): string {
    $normalizedTeam = $normalizeClubKey($teamName);
    $normalizedBec = $normalizeClubKey($becTeamName);
    if ($normalizedTeam !== '' && $normalizedTeam === $normalizedBec) {
        return $becLogoUrl;
    }
    return $resolveClubLogo($teamName);
};

$clubIdentifiers = [
    'bec',
    'bordeaux',
    'etudiant',
];

$matches = [];
try {
    $matchesStmt = $DB->prepare(
        "SELECT
            m.dateMatch AS matchDate,
            m.heureMatch AS matchTime,
            m.lieuMatch AS location,
            m.scoreBec AS scoreBec,
            m.scoreAdversaire AS scoreAdversaire,
            m.clubAdversaire AS clubAdversaire,
            m.numEquipeAdverse AS numEquipeAdverse,
            m.source AS source,
            m.codeEquipe AS teamCode,
            e.nomEquipe AS teamName
        FROM `MATCH` m
        INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
        WHERE m.dateMatch >= CURDATE()
        ORDER BY m.dateMatch ASC, m.heureMatch ASC"
    );
    $matchesStmt->execute();
    $matches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $becMatchesAvailable = false;
}

$resolveMatchSide = static function (?string $location): string {
    $location = strtolower(trim((string) $location));
    if ($location === '') {
        return 'home';
    }
    if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
        return 'away';
    }
    if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
        return 'home';
    }
    return 'home';
};

$buildOpponent = static function (array $match): string {
    $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
    if (!empty($match['numEquipeAdverse'])) {
        $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
    }
    return $opponent !== '' ? $opponent : 'Adversaire';
};

foreach ($matches as $match) {
    $side = $resolveMatchSide($match['location'] ?? '');
    $isHome = $side !== 'away';
    $opponent = $buildOpponent($match);
    $teamHome = $isHome ? ($match['teamName'] ?? 'BEC') : $opponent;
    $teamAway = $isHome ? $opponent : ($match['teamName'] ?? 'BEC');
    $teamCode = strtoupper(trim((string) ($match['teamCode'] ?? '')));
    $teamHomeName = strtolower($teamHome);
    $teamAwayName = strtolower($teamAway);
    $key = null;
    if ($teamCode === 'SF1') {
        $key = 'SF1';
    } elseif ($teamCode === 'SG1') {
        $key = 'SG1';
    } elseif ($teamHomeName !== '' && (str_contains($teamHomeName, 'sf1') || str_contains($teamHomeName, 'filles 1') || str_contains($teamHomeName, 'fille 1'))) {
        $key = 'SF1';
    } elseif ($teamHomeName !== '' && (str_contains($teamHomeName, 'sg1') || str_contains($teamHomeName, 'garçons 1') || str_contains($teamHomeName, 'garcons 1') || str_contains($teamHomeName, 'garcon 1'))) {
        $key = 'SG1';
    }

    if ($key === null || $nextMatches[$key] !== null) {
        continue;
    }
    $location = strtolower(trim((string) ($match['location'] ?? '')));
    if ($location !== '' && !str_contains($location, 'barbey') && !str_contains($location, 'domicile')) {
        continue;
    }

    $nextMatches[$key] = [
        'teamHome' => $teamHome,
        'teamAway' => $teamAway,
        'matchDate' => $match['matchDate'],
        'matchTime' => $match['matchTime'] ?? '',
        'location' => $match['location'] ?? 'Gymnase Barbey',
        'source' => $match['source'] ?? '',
        'becTeam' => $match['teamName'] ?? 'BEC',
        'teamCode' => $teamCode,
    ];
}

$homeStats = [];
if ($becMatchesAvailable) {
    try {
        $homeStatsStmt = $DB->prepare(
            "SELECT
                SUM(CASE WHEN scoreBec IS NOT NULL THEN scoreBec ELSE 0 END) AS pointsFor,
                SUM(CASE WHEN scoreAdversaire IS NOT NULL THEN scoreAdversaire ELSE 0 END) AS pointsAgainst,
                SUM(CASE WHEN scoreBec IS NOT NULL AND scoreAdversaire IS NOT NULL THEN 1 ELSE 0 END) AS homeMatchCount
            FROM `MATCH`"
        );
        $homeStatsStmt->execute();
        $homeStats = $homeStatsStmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $homeStats = [
            'matches' => (int) ($homeStats['homeMatchCount'] ?? 0),
            'pointsFor' => (int) ($homeStats['pointsFor'] ?? 0),
            'pointsAgainst' => (int) ($homeStats['pointsAgainst'] ?? 0),
        ];
    } catch (PDOException $exception) {
        $becMatchesAvailable = false;
    }
}

if (!$becMatchesAvailable) {
    $homeStats = [];
}
?>
<section class="home-hero">
    <div class="container home-hero__content">
        <h1>Bordeaux Étudiant Club</h1>
        <p>Club de basket à Bordeaux, salle Barbey</p>
        <div class="home-hero__actions">
            <a class="btn btn-boutique-header" href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>">Voir le calendrier</a>
            <a class="home-hero__link" href="<?php echo ROOT_URL . '/contact.php'; ?>">Rejoindre le club</a>
        </div>
    </div>
</section>

<?php $matchCards = array_values(array_filter([$nextMatches['SG1'], $nextMatches['SF1']])); ?>
<section class="home-match-centre" aria-labelledby="home-matches-title">
    <div class="container">
        <header class="home-section-heading home-section-heading--dark">
            <h2 id="home-matches-title">Prochains matchs</h2>
            <a href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>">Tout le calendrier</a>
        </header>
        <?php if (!empty($matchCards)): ?>
            <div class="home-match-grid">
                <?php foreach ($matchCards as $match): ?>
                    <?php
                    $homeLogo = $resolveTeamLogo($match['teamHome'], $match['becTeam']);
                    $awayLogo = $resolveTeamLogo($match['teamAway'], $match['becTeam']);
                    $location = trim((string) ($match['location'] ?? 'Gymnase Barbey'));
                    ?>
                    <article class="home-match-card">
                        <span class="home-match-card__badge">Domicile</span>
                        <div class="home-match-card__teams">
                            <div><img src="<?php echo e($homeLogo); ?>" alt="" loading="lazy" decoding="async"><strong><?php echo e($match['teamHome']); ?></strong></div>
                            <span>contre</span>
                            <div><img src="<?php echo e($awayLogo); ?>" alt="" loading="lazy" decoding="async"><strong><?php echo e($match['teamAway']); ?></strong></div>
                        </div>
                        <p class="home-match-card__date"><?php echo e(format_date_fr(trim($match['matchDate'] . ' ' . ($match['matchTime'] ?? '')), !empty($match['matchTime']))); ?></p>
                        <p class="home-match-card__place"><?php echo e($location); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="home-match-empty"><p>Pas de match programmé pour l'instant.</p><a href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>">Consulter le calendrier</a></div>
        <?php endif; ?>
    </div>
</section>

<div class="container home-sections">
    <section class="home-news" aria-labelledby="home-news-title">
        <header class="home-section-heading"><h2 id="home-news-title">Actualités</h2><a href="<?php echo ROOT_URL . '/actualites.php'; ?>">Toutes les actualités</a></header>
        <?php if (!empty($ba_bec_articles)): ?>
            <div class="home-news-grid">
                <?php foreach ($ba_bec_articles as $index => $ba_bec_article): ?>
                    <?php
                    $imagePath = resolve_article_image_url($ba_bec_article['urlPhotArt'] ?? null, ROOT_URL . '/src/images/image-defaut.jpeg');
                    $chapo = (string) ($ba_bec_article['libChapoArt'] ?? '');
                    $excerpt = (function_exists('mb_substr') ? mb_substr($chapo, 0, 160) : substr($chapo, 0, 160));
                    ?>
                    <a class="home-news-item<?php echo $index === 0 ? ' home-news-item--lead' : ''; ?>" href="<?php echo ROOT_URL . '/article.php?numArt=' . (int) $ba_bec_article['numArt']; ?>">
                        <div class="home-news-item__media"><img src="<?php echo e($imagePath); ?>" alt="<?php echo e($ba_bec_article['libTitrArt']); ?>" loading="lazy" decoding="async"></div>
                        <div><time datetime="<?php echo e($ba_bec_article['dtCreaArt']); ?>"><?php echo e(format_date_fr($ba_bec_article['dtCreaArt'])); ?></time><h3><?php echo e($ba_bec_article['libTitrArt']); ?></h3><?php if ($index === 0): ?><p><?php echo e($excerpt); ?></p><?php endif; ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?><div class="empty-state">Aucune actualité disponible pour le moment.</div><?php endif; ?>
    </section>

    <section class="home-welcome">
        <div><h2>Bienvenue au BEC</h2><p>À Bordeaux, le BEC rassemble les passionnés de basket autour de la salle Barbey. Suivez ici l'actualité du club, les matchs, les résultats, les équipes et les événements qui rythment la saison.</p><a class="btn btn-primary" href="<?php echo ROOT_URL . '/Pages_supplementaires/notre-histoire.php'; ?>">Découvrir le club</a></div>
        <img src="<?php echo ROOT_URL . '/src/images/background/background-index-3.webp'; ?>" alt="Joueurs du Bordeaux Étudiant Club sur le terrain" loading="lazy" decoding="async">
    </section>

    <?php if (!empty($homeStats) && (int) $homeStats['matches'] > 0): ?>
        <section class="home-season" aria-labelledby="season-title"><h2 id="season-title">Cette saison</h2><div class="home-season__stats"><div><strong><?php echo (int) $homeStats['matches']; ?></strong><span>Matchs joués</span></div><div><strong><?php echo (int) $homeStats['pointsFor']; ?></strong><span>Points marqués</span></div><div><strong><?php echo (int) $homeStats['pointsAgainst']; ?></strong><span>Points encaissés</span></div></div></section>
    <?php endif; ?>

    <?php $homePartners = ['Caisseepargne.png' => "Caisse d'Épargne", 'Proprietepriv.png' => 'Propriétés Privées', 'Thecockandbull.png' => 'The Cock and Bull', 'PouvoirPlus.png' => 'Pouvoir Plus', 'ALEDE_Logo_v3.png' => 'Alexia Elineau']; ?>
    <section class="home-partners" aria-labelledby="partners-title"><header class="home-section-heading"><h2 id="partners-title">Partenaires</h2><a href="<?php echo ROOT_URL . '/Pages_supplementaires/nos-partenaires.php'; ?>">Tous les partenaires</a></header><div class="home-partners__rail"><?php foreach ($homePartners as $partnerFile => $partnerName): ?><span class="home-partner-logo"><?php if (is_file(ROOT . '/src/images/Logo partenaires/' . $partnerFile)): ?><img src="<?php echo e(ROOT_URL . '/src/images/Logo partenaires/' . rawurlencode($partnerFile)); ?>" alt="<?php echo e($partnerName); ?>" loading="lazy" decoding="async"><?php else: ?><strong><?php echo e($partnerName); ?></strong><?php endif; ?></span><?php endforeach; ?></div></section>
</div>
<?php require_once 'footer.php'; ?>
