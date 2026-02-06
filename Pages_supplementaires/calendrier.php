<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $pageStyles = [
$pageStyles = [
// Cette ligne contient: ROOT_URL . '/src/css/matches.css',
    ROOT_URL . '/src/css/matches.css',
// Cette ligne contient: ];
];
// Ligne vide pour aération.

// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
// Ligne vide pour aération.

// Cette ligne contient: sql_connect();
sql_connect();
// Ligne vide pour aération.

// Cette ligne contient: $becMatchesAvailable = true;
$becMatchesAvailable = true;
// Ligne vide pour aération.

// Cette ligne contient: $logoDirectory = $_SERVER['DOCUMENT_ROOT'] . '/src/images/logo/logo-adversaire';
$logoDirectory = $_SERVER['DOCUMENT_ROOT'] . '/src/images/logo/logo-adversaire';
// Cette ligne contient: $logoWebBase = ROOT_URL . '/src/images/logo/logo-adversaire';
$logoWebBase = ROOT_URL . '/src/images/logo/logo-adversaire';
// Cette ligne contient: $becLogoUrl = ROOT_URL . '/src/images/logo/logo-bec/logo.png';
$becLogoUrl = ROOT_URL . '/src/images/logo/logo-bec/logo.png';
// Cette ligne contient: $defaultLogoUrl = ROOT_URL . '/src/images/logo/team-default.svg';
$defaultLogoUrl = ROOT_URL . '/src/images/logo/team-default.svg';
// Ligne vide pour aération.

// Cette ligne contient: $normalizeClubKey = static function (string $name): string {
$normalizeClubKey = static function (string $name): string {
// Cette ligne contient: $name = trim($name);
    $name = trim($name);
// Cette ligne contient: if ($name === '') {
    if ($name === '') {
// Cette ligne contient: return '';
        return '';
// Cette ligne contient: }
    }
// Cette ligne contient: $name = preg_replace('/\s+\d+$/', '', $name);
    $name = preg_replace('/\s+\d+$/', '', $name);
// Cette ligne contient: $name = preg_replace('/\s+/', ' ', $name);
    $name = preg_replace('/\s+/', ' ', $name);
// Cette ligne contient: $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
// Cette ligne contient: if ($transliterated !== false) {
    if ($transliterated !== false) {
// Cette ligne contient: $name = $transliterated;
        $name = $transliterated;
// Cette ligne contient: }
    }
// Cette ligne contient: $name = strtoupper($name);
    $name = strtoupper($name);
// Cette ligne contient: $name = preg_replace('/[^A-Z0-9]+/', '_', $name);
    $name = preg_replace('/[^A-Z0-9]+/', '_', $name);
// Cette ligne contient: return trim($name, '_');
    return trim($name, '_');
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $buildLogoMap = static function () use ($logoDirectory, $logoWebBase, $normalizeClubKey): array {
$buildLogoMap = static function () use ($logoDirectory, $logoWebBase, $normalizeClubKey): array {
// Cette ligne contient: static $logoMap = null;
    static $logoMap = null;
// Cette ligne contient: if (is_array($logoMap)) {
    if (is_array($logoMap)) {
// Cette ligne contient: return $logoMap;
        return $logoMap;
// Cette ligne contient: }
    }
// Cette ligne contient: $logoMap = [];
    $logoMap = [];
// Cette ligne contient: if (!is_dir($logoDirectory)) {
    if (!is_dir($logoDirectory)) {
// Cette ligne contient: return $logoMap;
        return $logoMap;
// Cette ligne contient: }
    }
// Cette ligne contient: $files = glob($logoDirectory . '/*.{png,PNG,jpg,JPG,jpeg,JPEG,avif,AVIF,webp,WEBP,svg,SVG}', GLOB_BRACE) ?: [];
    $files = glob($logoDirectory . '/*.{png,PNG,jpg,JPG,jpeg,JPEG,avif,AVIF,webp,WEBP,svg,SVG}', GLOB_BRACE) ?: [];
// Cette ligne contient: foreach ($files as $file) {
    foreach ($files as $file) {
// Cette ligne contient: $baseName = pathinfo($file, PATHINFO_FILENAME);
        $baseName = pathinfo($file, PATHINFO_FILENAME);
// Cette ligne contient: $key = $normalizeClubKey($baseName);
        $key = $normalizeClubKey($baseName);
// Cette ligne contient: if ($key === '' || isset($logoMap[$key])) {
        if ($key === '' || isset($logoMap[$key])) {
// Cette ligne contient: continue;
            continue;
// Cette ligne contient: }
        }
// Cette ligne contient: $logoMap[$key] = $logoWebBase . '/' . basename($file);
        $logoMap[$key] = $logoWebBase . '/' . basename($file);
// Cette ligne contient: }
    }
// Cette ligne contient: return $logoMap;
    return $logoMap;
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $resolveClubLogo = static function (?string $clubName) use ($normalizeClubKey, $buildLogoMap, $defaultLogoUrl): string {
$resolveClubLogo = static function (?string $clubName) use ($normalizeClubKey, $buildLogoMap, $defaultLogoUrl): string {
// Cette ligne contient: $key = $normalizeClubKey((string) $clubName);
    $key = $normalizeClubKey((string) $clubName);
// Cette ligne contient: if ($key === '') {
    if ($key === '') {
// Cette ligne contient: return $defaultLogoUrl;
        return $defaultLogoUrl;
// Cette ligne contient: }
    }
// Cette ligne contient: $logoMap = $buildLogoMap();
    $logoMap = $buildLogoMap();
// Cette ligne contient: return $logoMap[$key] ?? $defaultLogoUrl;
    return $logoMap[$key] ?? $defaultLogoUrl;
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $resolveTeamLogo = static function (string $teamName, string $becTeamName) use ($normalizeClubKey, $resolveClubLogo, $becLogoUrl): string {
$resolveTeamLogo = static function (string $teamName, string $becTeamName) use ($normalizeClubKey, $resolveClubLogo, $becLogoUrl): string {
// Cette ligne contient: $normalizedTeam = $normalizeClubKey($teamName);
    $normalizedTeam = $normalizeClubKey($teamName);
// Cette ligne contient: $normalizedBec = $normalizeClubKey($becTeamName);
    $normalizedBec = $normalizeClubKey($becTeamName);
// Cette ligne contient: if ($normalizedTeam !== '' && $normalizedTeam === $normalizedBec) {
    if ($normalizedTeam !== '' && $normalizedTeam === $normalizedBec) {
// Cette ligne contient: return $becLogoUrl;
        return $becLogoUrl;
// Cette ligne contient: }
    }
// Cette ligne contient: return $resolveClubLogo($teamName);
    return $resolveClubLogo($teamName);
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $matchesQuery = "SELECT
$matchesQuery = "SELECT
// Cette ligne contient: m.numMatch AS numMatch,
        m.numMatch AS numMatch,
// Cette ligne contient: m.dateMatch AS matchDate,
        m.dateMatch AS matchDate,
// Cette ligne contient: m.heureMatch AS matchTime,
        m.heureMatch AS matchTime,
// Cette ligne contient: m.lieuMatch AS location,
        m.lieuMatch AS location,
// Cette ligne contient: m.scoreBec AS scoreBec,
        m.scoreBec AS scoreBec,
// Cette ligne contient: m.scoreAdversaire AS scoreAdversaire,
        m.scoreAdversaire AS scoreAdversaire,
// Cette ligne contient: m.clubAdversaire AS clubAdversaire,
        m.clubAdversaire AS clubAdversaire,
// Cette ligne contient: m.numEquipeAdverse AS numEquipeAdverse,
        m.numEquipeAdverse AS numEquipeAdverse,
// Cette ligne contient: e.nomEquipe AS teamName
        e.nomEquipe AS teamName
// Cette ligne contient: FROM `MATCH` m
    FROM `MATCH` m
// Cette ligne contient: INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
    INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
// Cette ligne contient: WHERE m.dateMatch BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
    WHERE m.dateMatch BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
// Cette ligne contient: ORDER BY m.dateMatch ASC, m.heureMatch ASC";
    ORDER BY m.dateMatch ASC, m.heureMatch ASC";
// Cette ligne contient: $lastUpdateQuery = "SELECT MAX(dateMatch) AS lastUpdate FROM `MATCH`";
$lastUpdateQuery = "SELECT MAX(dateMatch) AS lastUpdate FROM `MATCH`";
// Ligne vide pour aération.

// Cette ligne contient: $allMatches = [];
$allMatches = [];
// Cette ligne contient: try {
try {
// Cette ligne contient: $matchesStmt = $DB->prepare($matchesQuery);
    $matchesStmt = $DB->prepare($matchesQuery);
// Cette ligne contient: $matchesStmt->execute();
    $matchesStmt->execute();
// Cette ligne contient: $allMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
    $allMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
// Cette ligne contient: } catch (PDOException $exception) {
} catch (PDOException $exception) {
// Cette ligne contient: $becMatchesAvailable = false;
    $becMatchesAvailable = false;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $resolveMatchSide = static function (string $location): string {
$resolveMatchSide = static function (string $location): string {
// Cette ligne contient: $location = strtolower(trim($location));
    $location = strtolower(trim($location));
// Cette ligne contient: if ($location === '') {
    if ($location === '') {
// Cette ligne contient: return 'home';
        return 'home';
// Cette ligne contient: }
    }
// Cette ligne contient: if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
    if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
// Cette ligne contient: return 'away';
        return 'away';
// Cette ligne contient: }
    }
// Cette ligne contient: if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
    if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
// Cette ligne contient: return 'home';
        return 'home';
// Cette ligne contient: }
    }
// Cette ligne contient: return 'home';
    return 'home';
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $buildOpponent = static function (array $match): string {
$buildOpponent = static function (array $match): string {
// Cette ligne contient: $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
    $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
// Cette ligne contient: if (!empty($match['numEquipeAdverse'])) {
    if (!empty($match['numEquipeAdverse'])) {
// Cette ligne contient: $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
        $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
// Cette ligne contient: }
    }
// Cette ligne contient: return $opponent !== '' ? $opponent : 'Adversaire';
    return $opponent !== '' ? $opponent : 'Adversaire';
// Cette ligne contient: };
};
// Ligne vide pour aération.

// Cette ligne contient: $homeMatches = [];
$homeMatches = [];
// Cette ligne contient: $awayMatches = [];
$awayMatches = [];
// Cette ligne contient: foreach ($allMatches as $ba_bec_match) {
foreach ($allMatches as $ba_bec_match) {
// Cette ligne contient: $side = $resolveMatchSide((string) ($ba_bec_match['location'] ?? ''));
    $side = $resolveMatchSide((string) ($ba_bec_match['location'] ?? ''));
// Cette ligne contient: $opponent = $buildOpponent($ba_bec_match);
    $opponent = $buildOpponent($ba_bec_match);
// Cette ligne contient: $isHome = $side !== 'away';
    $isHome = $side !== 'away';
// Cette ligne contient: $ba_bec_match['teamHome'] = $isHome ? ($ba_bec_match['teamName'] ?? 'BEC') : $opponent;
    $ba_bec_match['teamHome'] = $isHome ? ($ba_bec_match['teamName'] ?? 'BEC') : $opponent;
// Cette ligne contient: $ba_bec_match['teamAway'] = $isHome ? $opponent : ($ba_bec_match['teamName'] ?? 'BEC');
    $ba_bec_match['teamAway'] = $isHome ? $opponent : ($ba_bec_match['teamName'] ?? 'BEC');
// Cette ligne contient: $ba_bec_match['scoreHome'] = $isHome ? ($ba_bec_match['scoreBec'] ?? null) : ($ba_bec_match['scoreAdversaire'] ?? null);
    $ba_bec_match['scoreHome'] = $isHome ? ($ba_bec_match['scoreBec'] ?? null) : ($ba_bec_match['scoreAdversaire'] ?? null);
// Cette ligne contient: $ba_bec_match['scoreAway'] = $isHome ? ($ba_bec_match['scoreAdversaire'] ?? null) : ($ba_bec_match['scoreBec'] ?? null);
    $ba_bec_match['scoreAway'] = $isHome ? ($ba_bec_match['scoreAdversaire'] ?? null) : ($ba_bec_match['scoreBec'] ?? null);
// Cette ligne contient: if ($side === 'away') {
    if ($side === 'away') {
// Cette ligne contient: $awayMatches[] = $ba_bec_match;
        $awayMatches[] = $ba_bec_match;
// Cette ligne contient: } else {
    } else {
// Cette ligne contient: $homeMatches[] = $ba_bec_match;
        $homeMatches[] = $ba_bec_match;
// Cette ligne contient: }
    }
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $lastUpdate = null;
$lastUpdate = null;
// Cette ligne contient: if ($becMatchesAvailable) {
if ($becMatchesAvailable) {
// Cette ligne contient: try {
    try {
// Cette ligne contient: $lastUpdateStmt = $DB->query($lastUpdateQuery);
        $lastUpdateStmt = $DB->query($lastUpdateQuery);
// Cette ligne contient: $lastUpdateRow = $lastUpdateStmt->fetch(PDO::FETCH_ASSOC);
        $lastUpdateRow = $lastUpdateStmt->fetch(PDO::FETCH_ASSOC);
// Cette ligne contient: $lastUpdate = $lastUpdateRow['lastUpdate'] ?? null;
        $lastUpdate = $lastUpdateRow['lastUpdate'] ?? null;
// Cette ligne contient: } catch (PDOException $exception) {
    } catch (PDOException $exception) {
// Cette ligne contient: $becMatchesAvailable = false;
        $becMatchesAvailable = false;
// Cette ligne contient: }
    }
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $renderMatchCard = static function (array $ba_bec_match) use ($resolveTeamLogo): string {
$renderMatchCard = static function (array $ba_bec_match) use ($resolveTeamLogo): string {
// Cette ligne contient: $matchDate = new DateTime($ba_bec_match['matchDate']);
    $matchDate = new DateTime($ba_bec_match['matchDate']);
// Cette ligne contient: $displayDate = $matchDate->format('d/m/Y');
    $displayDate = $matchDate->format('d/m/Y');
// Cette ligne contient: $displayTime = '';
    $displayTime = '';
// Cette ligne contient: if (!empty($ba_bec_match['matchTime'])) {
    if (!empty($ba_bec_match['matchTime'])) {
// Cette ligne contient: $matchTime = new DateTime($ba_bec_match['matchTime']);
        $matchTime = new DateTime($ba_bec_match['matchTime']);
// Cette ligne contient: $displayTime = $matchTime->format('H:i');
        $displayTime = $matchTime->format('H:i');
// Cette ligne contient: }
    }
// Cette ligne contient: $score = '';
    $score = '';
// Cette ligne contient: if ($ba_bec_match['scoreHome'] !== null && $ba_bec_match['scoreAway'] !== null) {
    if ($ba_bec_match['scoreHome'] !== null && $ba_bec_match['scoreAway'] !== null) {
// Cette ligne contient: $score = (int) $ba_bec_match['scoreHome'] . ' - ' . (int) $ba_bec_match['scoreAway'];
        $score = (int) $ba_bec_match['scoreHome'] . ' - ' . (int) $ba_bec_match['scoreAway'];
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: $homeLogo = $resolveTeamLogo($ba_bec_match['teamHome'], $ba_bec_match['teamName'] ?? '');
    $homeLogo = $resolveTeamLogo($ba_bec_match['teamHome'], $ba_bec_match['teamName'] ?? '');
// Cette ligne contient: $awayLogo = $resolveTeamLogo($ba_bec_match['teamAway'], $ba_bec_match['teamName'] ?? '');
    $awayLogo = $resolveTeamLogo($ba_bec_match['teamAway'], $ba_bec_match['teamName'] ?? '');
// Ligne vide pour aération.

// Cette ligne contient: ob_start();
    ob_start();
// Cette ligne contient: ?>
    ?>
<!-- Cette ligne contient: <div class="col-12"> -->
    <div class="col-12">
<!-- Cette ligne contient: <article class="match-card" style="- -match-home-logo: url('<?php echo htmlspecialchars($homeLogo); ?>'); - -match-away-logo: url('<?php echo htmlspecialchars($awayLogo); ?>');"> -->
        <article class="match-card" style="--match-home-logo: url('<?php echo htmlspecialchars($homeLogo); ?>'); --match-away-logo: url('<?php echo htmlspecialchars($awayLogo); ?>');">
<!-- Cette ligne contient: <header class="match-card__header"> -->
            <header class="match-card__header">
<!-- Cette ligne contient: <div> -->
                <div>
<!-- Cette ligne contient: <p class="match-card__competition"><?php echo htmlspecialchars($ba_bec_match['teamName'] ?? 'Match'); ?></p> -->
                    <p class="match-card__competition"><?php echo htmlspecialchars($ba_bec_match['teamName'] ?? 'Match'); ?></p>
<!-- Cette ligne contient: <p class="match-card__date"> -->
                    <p class="match-card__date">
<!-- Cette ligne contient: <?php echo htmlspecialchars($displayDate); ?> -->
                        <?php echo htmlspecialchars($displayDate); ?>
<!-- Cette ligne contient: <?php if ($displayTime !== ''): ?> -->
                        <?php if ($displayTime !== ''): ?>
<!-- Cette ligne contient: <span>• <?php echo htmlspecialchars($displayTime); ?></span> -->
                            <span>• <?php echo htmlspecialchars($displayTime); ?></span>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
<!-- Cette ligne contient: </p> -->
                    </p>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </header> -->
            </header>
<!-- Cette ligne contient: <div class="wrapper"> -->
            <div class="wrapper">
<!-- Cette ligne contient: <div class="match-card__team"> -->
                <div class="match-card__team">
<!-- Cette ligne contient: <span>Domicile</span> -->
                    <span>Domicile</span>
<!-- Cette ligne contient: <img class="match-card__logo" src="<?php echo htmlspecialchars($homeLogo); ?>" alt="Logo <?php echo htmlspecialchars($ba_bec_match['teamHome']); ?>"> -->
                    <img class="match-card__logo" src="<?php echo htmlspecialchars($homeLogo); ?>" alt="Logo <?php echo htmlspecialchars($ba_bec_match['teamHome']); ?>">
<!-- Cette ligne contient: <strong><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></strong> -->
                    <strong><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></strong>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <div class="match-card__score"> -->
                <div class="match-card__score">
<!-- Cette ligne contient: <?php echo $score !== '' ? htmlspecialchars($score) : 'vs'; ?> -->
                    <?php echo $score !== '' ? htmlspecialchars($score) : 'vs'; ?>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <div class="match-card__team"> -->
                <div class="match-card__team">
<!-- Cette ligne contient: <span>Extérieur</span> -->
                    <span>Extérieur</span>
<!-- Cette ligne contient: <img class="match-card__logo" src="<?php echo htmlspecialchars($awayLogo); ?>" alt="Logo <?php echo htmlspecialchars($ba_bec_match['teamAway']); ?>"> -->
                    <img class="match-card__logo" src="<?php echo htmlspecialchars($awayLogo); ?>" alt="Logo <?php echo htmlspecialchars($ba_bec_match['teamAway']); ?>">
<!-- Cette ligne contient: <strong><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></strong> -->
                    <strong><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></strong>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <?php if (!empty($ba_bec_match['location'])): ?> -->
            <?php if (!empty($ba_bec_match['location'])): ?>
<!-- Cette ligne contient: <p class="match-card__location">Lieu : <?php echo htmlspecialchars($ba_bec_match['location']); ?></p> -->
                <p class="match-card__location">Lieu : <?php echo htmlspecialchars($ba_bec_match['location']); ?></p>
<!-- Cette ligne contient: <?php endif; ?> -->
            <?php endif; ?>
<!-- Cette ligne contient: </article> -->
        </article>
<!-- Cette ligne contient: </div> -->
    </div>
<!-- Cette ligne contient: <?php -->
    <?php
// Ligne vide pour aération.

// Cette ligne contient: return (string) ob_get_clean();
    return (string) ob_get_clean();
// Cette ligne contient: };
};
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <main class="container py-5"> -->
<main class="container py-5">
<!-- Cette ligne contient: <section class="matches-hero"> -->
    <section class="matches-hero">
<!-- Cette ligne contient: <p class="matches-hero__eyebrow">Calendrier</p> -->
        <p class="matches-hero__eyebrow">Calendrier</p>
<!-- Cette ligne contient: <h1 class="matches-hero__title">Les prochains matchs des équipes seniors</h1> -->
        <h1 class="matches-hero__title">Les prochains matchs des équipes seniors</h1>
<!-- Cette ligne contient: <p class="matches-hero__text"> -->
        <p class="matches-hero__text">
<!-- Cette ligne contient: Retrouvez ici le prochain match de chaque équipe senior du club, affiché selon la date du jour. -->
            Retrouvez ici le prochain match de chaque équipe senior du club, affiché selon la date du jour.
<!-- Cette ligne contient: </p> -->
        </p>
<!-- Cette ligne contient: <div class="matches-hero__meta"> -->
        <div class="matches-hero__meta">
<!-- Cette ligne contient: <?php if ($becMatchesAvailable && !empty($lastUpdate)): ?> -->
            <?php if ($becMatchesAvailable && !empty($lastUpdate)): ?>
<!-- Cette ligne contient: <span class="matches-hero__update">Dernière mise à jour : <?php echo htmlspecialchars($lastUpdate); ?></span> -->
                <span class="matches-hero__update">Dernière mise à jour : <?php echo htmlspecialchars($lastUpdate); ?></span>
<!-- Cette ligne contient: <?php endif; ?> -->
            <?php endif; ?>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </section> -->
    </section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="matches-list" aria-live="polite"> -->
    <section class="matches-list" aria-live="polite">
<!-- Cette ligne contient: <?php if (!$becMatchesAvailable): ?> -->
        <?php if (!$becMatchesAvailable): ?>
<!-- Cette ligne contient: <div class="alert alert-light border matches-empty" role="status"> -->
            <div class="alert alert-light border matches-empty" role="status">
<!-- Cette ligne contient: Le calendrier n'est pas disponible pour le moment. -->
                Le calendrier n'est pas disponible pour le moment.
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <?php elseif (!empty($homeMatches) || !empty($awayMatches)): ?> -->
        <?php elseif (!empty($homeMatches) || !empty($awayMatches)): ?>
<!-- Cette ligne contient: <?php if (!empty($homeMatches)): ?> -->
            <?php if (!empty($homeMatches)): ?>
<!-- Cette ligne contient: <div class="mb-5"> -->
                <div class="mb-5">
<!-- Cette ligne contient: <h2 class="matches-list__title">Matchs à domicile</h2> -->
                    <h2 class="matches-list__title">Matchs à domicile</h2>
<!-- Cette ligne contient: <div class="row g-4"> -->
                    <div class="row g-4">
<!-- Cette ligne contient: <?php foreach ($homeMatches as $ba_bec_match): ?> -->
                        <?php foreach ($homeMatches as $ba_bec_match): ?>
<!-- Cette ligne contient: <?php echo $renderMatchCard($ba_bec_match); ?> -->
                            <?php echo $renderMatchCard($ba_bec_match); ?>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                        <?php endforeach; ?>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <?php endif; ?> -->
            <?php endif; ?>
<!-- Cette ligne contient: <?php if (!empty($awayMatches)): ?> -->
            <?php if (!empty($awayMatches)): ?>
<!-- Cette ligne contient: <div> -->
                <div>
<!-- Cette ligne contient: <h2 class="matches-list__title">Matchs à l'extérieur</h2> -->
                    <h2 class="matches-list__title">Matchs à l'extérieur</h2>
<!-- Cette ligne contient: <div class="row g-4"> -->
                    <div class="row g-4">
<!-- Cette ligne contient: <?php foreach ($awayMatches as $ba_bec_match): ?> -->
                        <?php foreach ($awayMatches as $ba_bec_match): ?>
<!-- Cette ligne contient: <?php echo $renderMatchCard($ba_bec_match); ?> -->
                            <?php echo $renderMatchCard($ba_bec_match); ?>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                        <?php endforeach; ?>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <?php endif; ?> -->
            <?php endif; ?>
<!-- Cette ligne contient: <?php else: ?> -->
        <?php else: ?>
<!-- Cette ligne contient: <div class="alert alert-light border matches-empty" role="status"> -->
            <div class="alert alert-light border matches-empty" role="status">
<!-- Cette ligne contient: Aucun match n'est disponible pour le moment. -->
                Aucun match n'est disponible pour le moment.
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <?php endif; ?> -->
        <?php endif; ?>
<!-- Cette ligne contient: </section> -->
    </section>
<!-- Cette ligne contient: </main> -->
</main>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
// Cette ligne contient: ?>
?>
