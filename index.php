<?php
// On charge la configuration globale du site (connexion DB, constantes, etc.).
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// On prépare la liste des feuilles de style spécifiques à cette page.
$pageStyles = [
    ROOT_URL . '/src/css/style.css',
];
$pageHasVideo = true;
$pageBackgroundVideo = ROOT_URL . '/src/video/Background_index.mp4';
$pageBackgroundPoster = ROOT_URL . '/src/images/background/background-index-1.webp';

// On inclut l'en-tête HTML (balises <head>, menu, etc.).
require_once 'header.php';

// On ouvre la connexion à la base de données.
sql_connect();

function resolve_article_image_url(?string $path, string $defaultImage): string
{
    if (!$path) {
        return $defaultImage;
    }

    if (preg_match('/^https?:\/\//', $path)) {
        return $path;
    }

    if (strpos($path, '/src/uploads/') !== false) {
        $relative = substr($path, strpos($path, '/src/uploads/') + strlen('/src/uploads/'));
    } else {
        $relative = ltrim($path, '/');
    }

    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $relative;
    if (file_exists($filePath)) {
        return ROOT_URL . '/src/uploads/' . $relative;
    }

    return $defaultImage;
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

$formatMatchDate = static function (string $matchDate): string {
    $date = DateTime::createFromFormat('Y-m-d', $matchDate);
    if (!$date) {
        return $matchDate;
    }

    if (class_exists('IntlDateFormatter')) {
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            $date->getTimezone()->getName(),
            IntlDateFormatter::GREGORIAN,
            'EEEE d MMMM'
        );
        $formatted = $formatter->format($date);
        if ($formatted !== false) {
            return $formatted;
        }
    }

    return $date->format('d/m/Y');
};

$formatMatchTime = static function (?string $matchTime): string {
    if (empty($matchTime)) {
        return '';
    }
    $time = DateTime::createFromFormat('H:i:s', $matchTime) ?: DateTime::createFromFormat('H:i', $matchTime);
    return $time ? $time->format('H\hi') : $matchTime;
};

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
        'becTeam' => $match['teamName'] ?? 'BEC',
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
    $homeStats = [
        'matches' => 'À déterminer',
        'pointsFor' => 'beaucoup',
        'pointsAgainst' => '0',
    ];
}
?>

<style>
    .typewriter-line {
        position: relative;
        display: inline-block;
        white-space: nowrap;
    }
    .typewriter-line::after {
        content: "";
        display: inline-block;
        width: 2px;
        height: 1em;
        background: currentColor;
        margin-left: 6px;
        vertical-align: -0.1em;
        animation: caret-blink 0.9s steps(1) infinite;
    }
    .typewriter-line.is-done::after {
        opacity: 0;
        animation: none;
    }
    @keyframes caret-blink {
        50% { opacity: 0; }
    }
    @media (prefers-reduced-motion: reduce) {
        .typewriter-line::after {
            animation: none;
        }
    }
</style>
<section class="home-hero full-bleed">
    <div class="home-hero-content text-start">
        <h2 class="fw-bold mb-0 typewriter-line" data-typewriter data-text="Bordeaux étudiant club"></h2><br>
        <h3 class="fw-bold mb-0 typewriter-line" data-typewriter data-text="Basket-ball"></h3>
    </div>
</section>
<div class="container py-5 home-main-surface home-main-surface--hidden">
    <section class="home-section">
        <h1 class="fw-bold mb-3">Bienvenue au BEC</h1>
        <p class="lead mb-4">
            Bordeaux n'est pas seulement son miroir d'eau ou encore ses cannelés. C'est aussi une ville de sport et de talent ! <br>
            Ce blog permet de suivre toute l'actualité du Bordeaux Etudiant Club, les jours de matchs, les résultats, les évènements, les joueurs, ...
            <br>Le but ? Mettre en valeur la section basket du club, partager les performances de l'équipe ainsi que ses valeurs du sport.
        </p>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="actualites.php">Voir les actualités</a>
            <a class="btn btn-outline-secondary" href="contact.php">Nous contacter</a>
        </div>
    </section>

    <section class="home-section">
        <h2 class="fw-bold mb-4">Nos prochains matchs à Barbey !</h2>
        <p class="text-body-secondary mb-4">Retrouvez nos équipes à domicile, à Barbey.</p>
        <div class="row g-4">
            <?php if (!$becMatchesAvailable): ?>
                <div class="col-12">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <span class="badge text-bg-secondary mb-2">Matchs à venir</span>
                            <h3 class="h5 mb-2">Consultez le calendrier officiel</h3>
                            <p class="mb-3 text-body-secondary">
                                Les prochains matchs sont disponibles sur le site de la FFBB.
                            </p>
                            <a class="btn btn-primary" href="https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024" target="_blank" rel="noopener noreferrer">
                                Voir le calendrier FFBB
                            </a>
                        </div>
                    </article>
                </div>
            <?php else: ?>
                <?php
                $matchCards = [
                    $nextMatches['SG1'] ? array_merge($nextMatches['SG1'], ['badge' => 'text-bg-primary']) : null,
                    $nextMatches['SF1'] ? array_merge($nextMatches['SF1'], ['badge' => 'text-bg-danger']) : null,
                ];
                ?>
                <?php foreach ($matchCards as $match): ?>
                    <div class="col-12 col-lg-6">
                        <article class="card h-100 border-0 shadow-sm home-match-card">
                            <div class="card-body">
                                <?php if ($match): ?>
                                    <?php $label = $match['label'] ?? ''; ?>
                                    <?php if ($label !== ''): ?>
                                        <span class="badge <?php echo $match['badge']; ?> mb-2">
                                            <?php echo htmlspecialchars($label); ?>
                                        </span>
                                    <?php endif; ?>
                                    <h3 class="h5 mb-2">
                                        <?php echo htmlspecialchars($match['teamHome']); ?> vs. <?php echo htmlspecialchars($match['teamAway']); ?>
                                    </h3>
                                    <?php
                                    $homeLogo = $resolveTeamLogo($match['teamHome'], $match['becTeam']);
                                    $awayLogo = $resolveTeamLogo($match['teamAway'], $match['becTeam']);
                                    ?>
                                    <div class="home-match-logos justify-content-center my-3">
                                        <div class="home-match-logo">
                                            <img src="<?php echo htmlspecialchars($homeLogo); ?>" alt="Logo <?php echo htmlspecialchars($match['teamHome']); ?>">
                                        </div>
                                        <span class="home-match-vs">vs</span>
                                        <div class="home-match-logo">
                                            <img src="<?php echo htmlspecialchars($awayLogo); ?>" alt="Logo <?php echo htmlspecialchars($match['teamAway']); ?>">
                                        </div>
                                    </div>
                                    <p class="mb-1 text-center">
                                        <strong><?php echo htmlspecialchars($formatMatchDate($match['matchDate'])); ?></strong>
                                    </p>
                                    <?php if ($formatMatchTime($match['matchTime']) !== ''): ?>
                                        <p class="mb-1 text-center"><?php echo htmlspecialchars($formatMatchTime($match['matchTime'])); ?></p>
                                    <?php endif; ?>
                                    <p class="mb-0 text-center text-body-secondary"><?php echo htmlspecialchars($match['location']); ?></p>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary mb-2">Match à venir</span>
                                    <h3 class="h5 mb-2">Planning en cours</h3>
                                    <p class="mb-1 text-body-secondary">Nous publierons bientôt les prochains matchs à Barbey.</p>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="home-section">
        <h2 class="fw-bold mb-4">Cette saison à Barbey</h2>
        <p class="text-body-secondary mb-4">
        Les chiffres des matchs séniors disputés à domicile.
        </p>
        <div class="row g-4">
        <div class="col-12 col-md-4">
            <article class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <p class="text-uppercase text-body-secondary mb-2">Matchs joués</p>
                <p
                class="display-6 fw-bold mb-0"
                <?php if ($becMatchesAvailable): ?>
                    data-counter
                    data-target="<?php echo number_format((int) $homeStats['matches'], 0, ',', ' '); ?>"
                <?php endif; ?>
                >
                <?php echo $becMatchesAvailable ? '0' : htmlspecialchars((string) $homeStats['matches']); ?>
                </p>
            </div>
            </article>
        </div>
        <div class="col-12 col-md-4">
            <article class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <p class="text-uppercase text-body-secondary mb-2">Points marqués</p>
                <p
                class="display-6 fw-bold mb-0"
                <?php if ($becMatchesAvailable): ?>
                    data-counter
                    data-target="<?php echo number_format((int) $homeStats['pointsFor'], 0, ',', ' '); ?>"
                <?php endif; ?>
                >
                <?php echo $becMatchesAvailable ? '0' : htmlspecialchars((string) $homeStats['pointsFor']); ?>
                </p>
            </div>
            </article>
        </div>
        <div class="col-12 col-md-4">
            <article class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <p class="text-uppercase text-body-secondary mb-2">Points encaissés</p>
                <p
                class="display-6 fw-bold mb-0"
                <?php if ($becMatchesAvailable): ?>
                    data-counter
                    data-target="<?php echo number_format((int) $homeStats['pointsAgainst'], 0, ',', ' '); ?>"
                <?php endif; ?>
                >
                <?php echo $becMatchesAvailable ? '0' : htmlspecialchars((string) $homeStats['pointsAgainst']); ?>
                </p>
            </div>
            </article>
        </div>
        </div>
    </section>
<script>
    const counters = document.querySelectorAll("[data-counter]");

    function parseNumber(value) {
        const normalized = value.replace(/\s/g, "").replace(",", ".");
        return Number.parseFloat(normalized);
    }

    function formatNumber(value, template) {
        const hasSpace = template.includes(" ");
        return value.toLocaleString("fr-FR", {
            maximumFractionDigits: 0,
            useGrouping: hasSpace,
        });
    }

    function animateCounter(element) {
        const targetText = element.dataset.target || "0";
        const rawTarget = parseNumber(targetText);
        if (!Number.isFinite(rawTarget) || rawTarget < 0) {
            element.textContent = targetText;
            return;
        }

        const target = Math.floor(rawTarget);
        if (target === 0) {
            element.textContent = formatNumber(0, targetText);
            return;
        }

        let current = 0;
        const durationMs = Number.parseInt(element.dataset.duration || "2500", 10);
        const safeDuration = Number.isFinite(durationMs) && durationMs > 0 ? durationMs : 2;
        const minStepTime = 0.5;
        const stepTime = Math.max(minStepTime, Math.floor(safeDuration / Math.max(1, target)));

        const timerId = setInterval(() => {
            current += 1;
            if (current >= target) {
                current = target;
                element.textContent = formatNumber(current, targetText);
                clearInterval(timerId);
                return;
            }
            element.textContent = formatNumber(current, targetText);
        }, stepTime);
    }

    function triggerCounter(element) {
        if (element.dataset.started === "true") {
            return;
        }
        element.dataset.started = "true";
        setTimeout(() => animateCounter(element), 1000);
    }

    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        triggerCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.4 }
        );

        counters.forEach((counter) => observer.observe(counter));
    } else {
        window.addEventListener("load", () => {
            counters.forEach((counter) => triggerCounter(counter));
        });
    }
</script>

    <section aria-label="Dernières actualités" class="home-articles">
        <h2 class="fw-bold mb-4">Nos dernières actualités</h2>
            <p class="text-body-secondary mb-4">Retrouvez ci-dessous nos dernières actualités et articles récents.</p>
        <!-- Si on a au moins un article récupéré, on les affiche. -->
        <?php if (!empty($ba_bec_articles)): ?>
            <div class="home-articles-container">
                <div class="row g-4">
                    <!-- On parcourt les 3 articles aléatoires récupérés depuis la base. -->
                    <?php foreach ($ba_bec_articles as $ba_bec_article): ?>
                        <?php
                        // 1) On détermine l'image à afficher :
                        //    - si l'article a une image, on utilise celle-ci
                        //    - sinon on utilise l'image par défaut.
                        $defaultImagePath = ROOT_URL . '/src/images/image-defaut.jpeg';
                        $ba_bec_imagePath = resolve_article_image_url($ba_bec_article['urlPhotArt'] ?? null, $defaultImagePath);
                        // 2) On récupère le chapo (texte d'accroche) ou une chaîne vide si absent.
                        $chapo = $ba_bec_article['libChapoArt'] ?? '';
                        // 3) On fixe la longueur max de l'extrait affiché.
                        $maxLength = 160;
                        // 4) On tronque le chapo proprement (multibyte si disponible).
                        $excerptBase = function_exists('mb_substr') ? mb_substr($chapo, 0, $maxLength) : substr($chapo, 0, $maxLength);
                        // 5) On calcule la longueur réelle du chapo.
                        $chapoLength = function_exists('mb_strlen') ? mb_strlen($chapo) : strlen($chapo);
                        // 6) On ajoute "..." seulement si le chapo dépassait la limite.
                        $excerpt = $excerptBase . ($chapoLength > $maxLength ? '...' : '');
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <article class="home-article-card" data-hover-card>
                                <img src="<?php echo $ba_bec_imagePath; ?>"
                                    class="home-article-image mb-3"
                                    alt="<?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>">
                                <h3 class="h5 fw-bold mb-2"><?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?></h3>
                                <p class="fst-italic"><?php echo htmlspecialchars($excerpt); ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <small class="text-body-secondary">
                                        <?php echo htmlspecialchars($ba_bec_article['dtCreaArt']); ?>
                                    </small>
                                    <a href="<?php echo ROOT_URL . '/article.php?numArt=' . (int) $ba_bec_article['numArt']; ?>" class="home-article-link">Lire la suite</a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary" href="actualites.php">Voir les autres actualités</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Si aucun article n'est disponible, on affiche un message d'information. -->
            <div class="alert alert-info mb-0" role="status">
                Aucune actualité disponible pour le moment.
            </div>
        <?php endif; ?>
    </section>
</div>

<script>
    (function () {
        const lines = Array.from(document.querySelectorAll("[data-typewriter]"));
        if (!lines.length) {
            return;
        }

        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
        const speedMs = 70;
        const lineDelayMs = 350;

        const typeLine = (element) =>
            new Promise((resolve) => {
                const text = element.dataset.text || "";
                if (prefersReducedMotion) {
                    element.textContent = text;
                    element.classList.add("is-done");
                    resolve();
                    return;
                }

                let index = 0;
                element.textContent = "";
                element.classList.remove("is-done");

                const tick = () => {
                    element.textContent = text.slice(0, index);
                    if (index >= text.length) {
                        element.classList.add("is-done");
                        setTimeout(resolve, lineDelayMs);
                        return;
                    }
                    index += 1;
                    setTimeout(tick, speedMs);
                };

                tick();
            });

        (async () => {
            for (const line of lines) {
                await typeLine(line);
            }
        })();
    })();
</script>
<script src="<?php echo ROOT_URL . '/src/js/home-articles-hover.js'; ?>"></script>
<script src="<?php echo ROOT_URL . '/src/js/home-scroll-reveal.js'; ?>"></script>
<?php require_once 'footer.php'; ?>

<p></p>
