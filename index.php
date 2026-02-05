<?php
// On charge la configuration globale du site (connexion DB, constantes, etc.).
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// On prépare la liste des feuilles de style spécifiques à cette page.
$pageStyles = [
    ROOT_URL . '/src/css/style.css',
];

// On inclut l'en-tête HTML (balises <head>, menu, etc.).
require_once 'header.php';

// On ouvre la connexion à la base de données.
sql_connect();

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

$matchesStmt = $DB->prepare(
    "SELECT Section AS section,
        Equipe AS teamName,
        Date AS matchDate,
        Heure AS matchTime,
        Domicile_Exterieur AS location,
        Adversaire AS opponent
    FROM bec_matches
    WHERE Date >= CURDATE()
    ORDER BY Date ASC, Heure ASC"
);
$matchesStmt->execute();
$matches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($matches as $match) {
    $section = strtolower((string) ($match['section'] ?? ''));
    $teamName = strtolower((string) ($match['teamName'] ?? ''));
    $key = null;
    if ($section === 'féminin' || $section === 'feminin') {
        if ($teamName !== '' && (str_contains($teamName, 'sf1') || str_contains($teamName, 'sénior 1') || str_contains($teamName, 'senior 1'))) {
            $key = 'SF1';
        }
    } elseif ($section === 'masculin') {
        if ($teamName !== '' && (str_contains($teamName, 'sg1') || str_contains($teamName, 'sénior 1') || str_contains($teamName, 'senior 1'))) {
            $key = 'SG1';
        }
    }

    if ($key === null || $nextMatches[$key] !== null) {
        continue;
    }
    $location = strtolower(trim((string) ($match['location'] ?? '')));
    if ($location !== '' && !str_contains($location, 'domicile')) {
        continue;
    }

    $nextMatches[$key] = [
        'label' => $key === 'SF1' ? 'Équipe 1 Filles' : 'Équipe 1 Garçons',
        'teamHome' => $match['teamName'] ?? 'BEC',
        'teamAway' => $match['opponent'] ?? '',
        'matchDate' => $match['matchDate'],
        'matchTime' => $match['matchTime'] ?? '',
        'location' => 'Gymnase Barbey',
    ];
}
?>

<div id="carouselExampleAutoplaying" class="carousel slide home-carousel full-bleed mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-1.webp'; ?>" class="d-block w-100"
                alt="Première image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-2.webp'; ?>" class="d-block w-100"
                alt="Deuxième image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-3.webp'; ?>" class="d-block w-100"
                alt="Troisième image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-4.webp'; ?>" class="d-block w-100"
                alt="Quatrime image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-5.webp'; ?>" class="d-block w-100"
                alt="Cinquième image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-6.webp'; ?>" class="d-block w-100"
                alt="Sixieme image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-7.webp'; ?>" class="d-block w-100"
                alt="Septime image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-8.webp'; ?>" class="d-block w-100"
                alt="huitieme image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-9.webp'; ?>" class="d-block w-100"
                alt="neuvieme image du carrousel">
        </div>
        <div class="carousel-item">
            <img src="<?php echo ROOT_URL . '/src/images/background/background-index-10.webp'; ?>" class="d-block w-100"
                alt="dixieme image du carrousel">

    </div>
    <div class="home-carousel-title text-center">
        <h2 class="fw-semibold mb-0">Bordeaux étudiant club</h2>
        <h3 class="fw-light mb-0">Basket-ball</h3>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class="container py-5">
    <section class="home-section mb-5">
        <h1 class="mb-3">Bienvenue au BEC</h1>
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

    <section class="home-section mb-5">
        <h2 class="mb-4">Nos prochains matchs à Barbey !</h2>
        <p class="text-body-secondary mb-4">Retrouvez nos équipes à domicile, à Barbey.</p>
        <div class="row g-4">
            <?php
            $matchCards = [
                $nextMatches['SG1'] ? array_merge($nextMatches['SG1'], ['badge' => 'text-bg-primary']) : null,
                $nextMatches['SF1'] ? array_merge($nextMatches['SF1'], ['badge' => 'text-bg-danger']) : null,
            ];
            ?>
            <?php foreach ($matchCards as $match): ?>
                <div class="col-12 col-lg-6">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <?php if ($match): ?>
                                <span class="badge <?php echo $match['badge']; ?> mb-2">
                                    <?php echo htmlspecialchars($match['label']); ?>
                                </span>
                                <h3 class="h5 mb-2">
                                    <?php echo htmlspecialchars($match['teamHome']); ?> vs. <?php echo htmlspecialchars($match['teamAway']); ?>
                                </h3>
                                <p class="mb-1">
                                    <strong><?php echo htmlspecialchars($formatMatchDate($match['matchDate'])); ?></strong>
                                    <?php if ($formatMatchTime($match['matchTime']) !== ''): ?>
                                        • <?php echo htmlspecialchars($formatMatchTime($match['matchTime'])); ?>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-0 text-body-secondary"><?php echo htmlspecialchars($match['location']); ?></p>
                            <?php else: ?>
                                <span class="badge text-bg-secondary mb-2">Match à venir</span>
                                <h3 class="h5 mb-2">Planning en cours</h3>
                                <p class="mb-1 text-body-secondary">Nous publierons bientôt les prochains matchs à Barbey.</p>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section aria-label="Dernières actualités" class="home-articles">
        <h2 class="mb-4">Nos dernières actualités</h2>
            <p class="text-body-secondary mb-4">Retrouvez ci-dessous nos dernières actualités et articles récents.</p>
        <!-- Si on a au moins un article récupéré, on les affiche. -->
        <?php if (!empty($ba_bec_articles)): ?>
            <div class="d-flex flex-column gap-4">
                <!-- On parcourt les 3 articles aléatoires récupérés depuis la base. -->
                <?php foreach ($ba_bec_articles as $index => $ba_bec_article): ?>
                    <?php
                    // 1) On détermine l'image à afficher :
                    //    - si l'article a une image, on utilise celle-ci
                    //    - sinon on utilise l'image par défaut.
                    $defaultImagePath = ROOT_URL . '/src/images/image-defaut.jpeg';
                    $uploadPath = !empty($ba_bec_article['urlPhotArt'])
                        ? $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . $ba_bec_article['urlPhotArt']
                        : '';
                    $ba_bec_imagePath = (!empty($ba_bec_article['urlPhotArt']) && file_exists($uploadPath))
                        ? ROOT_URL . '/src/uploads/' . htmlspecialchars($ba_bec_article['urlPhotArt'])
                        : $defaultImagePath;
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
                    $isMiddleArticle = $index === 1;
                    $imageOrderClass = $isMiddleArticle ? 'order-md-2' : 'order-md-1';
                    $contentOrderClass = $isMiddleArticle ? 'order-md-1' : 'order-md-2';
                    ?>
                    <article class="card w-100 home-article-card">
                        <div class="row g-3 h-100 align-items-center">
                            <div class="col-md-4 <?php echo $imageOrderClass; ?>">
                                <div class="ratio ratio-1x1">
                                    <img src="<?php echo $ba_bec_imagePath; ?>"
                                        class="img-fluid object-fit-cover w-100 h-100 home-article-image"
                                        alt="<?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>">
                                </div>
                            </div>
                            <div class="col-md-8 <?php echo $contentOrderClass; ?>">
                                <div class="card-body d-flex flex-column h-100">
                                    <h3 class="card-title h4 mb-2"><?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?></h3>
                                    <p class="card-text fst-italic"><?php echo htmlspecialchars($excerpt); ?></p>
                                    <p class="card-text mt-auto">
                                        <small class="text-body-secondary">
                                            <?php echo htmlspecialchars($ba_bec_article['dtCreaArt']); ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="mt-4">
                <a class="btn btn-primary" href="actualites.php">Voir les autres actualités</a>
            </div>
        <?php else: ?>
            <!-- Si aucun article n'est disponible, on affiche un message d'information. -->
            <div class="alert alert-info mb-0" role="status">
                Aucune actualité disponible pour le moment.
            </div>
        <?php endif; ?>
    </section>
</div>

<?php require_once 'footer.php'; ?>

<p></p>
