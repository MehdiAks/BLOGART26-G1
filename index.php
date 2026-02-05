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

$becLogo = ROOT_URL . '/src/images/logo/logo-bec/logo.png';
$defaultTeamLogo = ROOT_URL . '/src/images/logo/logo-bec/logo.png';
$logoDirectory = ROOT . '/src/images/logo/logo-adversaire';
$logoBaseUrl = ROOT_URL . '/src/images/logo/logo-adversaire';
$clubIdentifiers = [
    'bec',
    'bordeaux',
    'etudiant',
];
$normalizeTeamName = static function (string $name): string {
    $normalized = trim($name);
    if ($normalized === '') {
        return '';
    }
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $normalized);
    if ($transliterated !== false) {
        $normalized = $transliterated;
    }
    $normalized = preg_replace('/[^a-zA-Z0-9]+/', '_', $normalized);
    $normalized = preg_replace('/_+/', '_', (string) $normalized);
    return strtoupper(trim((string) $normalized, '_'));
};
$logoIndex = [];
if (is_dir($logoDirectory)) {
    foreach (scandir($logoDirectory) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $path = $logoDirectory . '/' . $file;
        if (!is_file($path)) {
            continue;
        }
        $baseName = pathinfo($file, PATHINFO_FILENAME);
        $normalized = $normalizeTeamName($baseName);
        if ($normalized !== '') {
            $logoIndex[$normalized] = $logoBaseUrl . '/' . rawurlencode($file);
        }
    }
}
$resolveTeamLogo = static function (?string $teamName) use (
    $becLogo,
    $defaultTeamLogo,
    $clubIdentifiers,
    $normalizeTeamName,
    $logoIndex
): string {
    $trimmed = trim((string) $teamName);
    if ($trimmed === '') {
        return $defaultTeamLogo;
    }
    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($trimmed, $identifier) !== false) {
            return $becLogo;
        }
    }
    $normalized = $normalizeTeamName($trimmed);
    if ($normalized !== '' && array_key_exists($normalized, $logoIndex)) {
        return $logoIndex[$normalized];
    }
    if ($normalized !== '') {
        foreach ($logoIndex as $key => $url) {
            if (str_contains($normalized, $key) || str_contains($key, $normalized)) {
                return $url;
            }
        }
    }
    return $defaultTeamLogo;
};

$matches = [];
try {
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
} catch (PDOException $exception) {
    $becMatchesAvailable = false;
}

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
        'logoHome' => $resolveTeamLogo($match['teamName'] ?? ''),
        'logoAway' => $resolveTeamLogo($match['opponent'] ?? ''),
        'matchDate' => $match['matchDate'],
        'matchTime' => $match['matchTime'] ?? '',
        'location' => 'Gymnase Barbey',
    ];
}

$homeStats = [];
if ($becMatchesAvailable) {
    try {
        $homeStatsStmt = $DB->prepare(
            "SELECT
                SUM(CASE
                    WHEN LOWER(TRIM(Domicile_Exterieur)) LIKE '%domicile%' THEN COALESCE(Score_Bec, 0)
                    ELSE 0
                END) AS pointsFor,
                SUM(CASE
                    WHEN LOWER(TRIM(Domicile_Exterieur)) LIKE '%domicile%' THEN COALESCE(Score_Adversaire, 0)
                    ELSE 0
                END) AS pointsAgainst,
                SUM(CASE
                    WHEN LOWER(TRIM(Domicile_Exterieur)) LIKE '%domicile%'
                        AND Score_Bec IS NOT NULL AND Score_Bec <> ''
                        AND Score_Adversaire IS NOT NULL AND Score_Adversaire <> ''
                        THEN 1
                    ELSE 0
                END) AS homeMatchCount
            FROM bec_matches"
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
    <section class="home-section mb-5">
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

    <section class="home-section mb-5">
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
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <?php if ($match): ?>
                                    <span class="badge <?php echo $match['badge']; ?> mb-2">
                                        <?php echo htmlspecialchars($match['label']); ?>
                                    </span>
                                    <div class="home-match-logos mb-3">
                                        <div class="home-match-logo">
                                            <img src="<?php echo htmlspecialchars($match['logoHome']); ?>" alt="<?php echo htmlspecialchars($match['teamHome']); ?>">
                                        </div>
                                        <span class="home-match-vs">VS</span>
                                        <div class="home-match-logo">
                                            <img src="<?php echo htmlspecialchars($match['logoAway']); ?>" alt="<?php echo htmlspecialchars($match['teamAway']); ?>">
                                        </div>
                                    </div>
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
            <?php endif; ?>
        </div>
    </section>

    <section class="home-section mb-5">
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
        const target = parseNumber(targetText);
        if (!Number.isFinite(target) || target < 0) {
            element.textContent = targetText;
            return;
        }

        let current = 0;
        const durationMs = Number.parseInt(element.dataset.duration || "1500", 10);
        const stepTime = 20;
        const steps = Math.max(1, Math.floor(durationMs / stepTime));
        const increment = Math.max(1, Math.ceil(target / steps));

        const timerId = setInterval(() => {
            current += increment;
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
