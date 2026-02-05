<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [
    ROOT_URL . '/src/css/matches.css',
];

require_once 'header.php';

sql_connect();

$matchesQuery = "SELECT MatchNo AS numMatch,
        Competition AS competition,
        Date AS matchDate,
        Heure AS matchTime,
        Domicile_Exterieur AS location,
        Phase AS status,
        Equipe AS team,
        Adversaire AS opponent,
        Score_BEC AS scoreBec,
        Score_Adversaire AS scoreOpponent,
        Source AS sourceUrl
    FROM bec_matches
    WHERE Date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
    ORDER BY Date ASC, Heure ASC";
$lastUpdateQuery = "SELECT MAX(Date) AS lastUpdate FROM bec_matches";

$matchesStmt = $DB->prepare($matchesQuery);
$matchesStmt->execute();
$allMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
$allMatches = array_map(
    static function (array $match): array {
        $location = strtolower(trim((string) ($match['location'] ?? '')));
        $isHome = str_contains($location, 'domicile');
        $isAway = str_contains($location, 'extérieur') || str_contains($location, 'exterieur');
        $team = (string) ($match['team'] ?? '');
        $opponent = (string) ($match['opponent'] ?? '');

        $teamHome = $isAway ? $opponent : $team;
        $teamAway = $isAway ? $team : $opponent;
        $scoreHome = $match['scoreBec'];
        $scoreAway = $match['scoreOpponent'];

        if ($isAway) {
            $scoreHome = $match['scoreOpponent'];
            $scoreAway = $match['scoreBec'];
        }

        return array_merge(
            $match,
            [
                'teamHome' => $teamHome,
                'teamAway' => $teamAway,
                'scoreHome' => $scoreHome,
                'scoreAway' => $scoreAway,
            ]
        );
    },
    $allMatches
);

$seniorKeywords = [
    'senior',
    'sénior',
    'pré-nationale',
    'pre-nationale',
];
$clubIdentifiers = [
    'bec',
    'bordeaux',
    'etudiant',
];
$defaultLogoUrl = ROOT_URL . '/src/images/image-defaut.jpeg';
$becLogoUrl = ROOT_URL . '/src/images/logo/logo-bec/logo.png';
$logoDirectory = ROOT . '/src/images/logo/logo-adversaire';
$logoBaseUrl = ROOT_URL . '/src/images/logo/logo-adversaire';
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
$isSeniorMatch = static function (array $match) use ($seniorKeywords): bool {
    $haystack = strtolower(
        ($match['competition'] ?? '') . ' ' . ($match['teamHome'] ?? '') . ' ' . ($match['teamAway'] ?? '')
    );
    foreach ($seniorKeywords as $keyword) {
        if ($keyword !== '' && str_contains($haystack, $keyword)) {
            return true;
        }
    }

    return false;
};
$resolveClubTeam = static function (array $match) use ($clubIdentifiers): string {
    $home = (string) ($match['teamHome'] ?? '');
    $away = (string) ($match['teamAway'] ?? '');

    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($home, $identifier) !== false) {
            return $home;
        }
    }

    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($away, $identifier) !== false) {
            return $away;
        }
    }

    return $home !== '' ? $home : $away;
};
$resolveClubSide = static function (array $match) use ($clubIdentifiers): string {
    $location = strtolower((string) ($match['location'] ?? ''));
    if ($location !== '') {
        if (str_contains($location, 'domicile')) {
            return 'home';
        }
        if (str_contains($location, 'extérieur') || str_contains($location, 'exterieur')) {
            return 'away';
        }
    }

    $home = (string) ($match['teamHome'] ?? '');
    $away = (string) ($match['teamAway'] ?? '');
    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($home, $identifier) !== false) {
            return 'home';
        }
    }
    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($away, $identifier) !== false) {
            return 'away';
        }
    }

    return 'unknown';
};
$resolveTeamLogo = static function (string $teamName) use (
    $clubIdentifiers,
    $normalizeTeamName,
    $logoIndex,
    $defaultLogoUrl,
    $becLogoUrl,
    $seniorKeywords
): string {
    $trimmed = trim($teamName);
    if ($trimmed === '') {
        return $defaultLogoUrl;
    }

    foreach ($seniorKeywords as $keyword) {
        if ($keyword !== '' && stripos($trimmed, $keyword) !== false) {
            return $becLogoUrl;
        }
    }

    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($trimmed, $identifier) !== false) {
            return $becLogoUrl;
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

    return $defaultLogoUrl;
};
$seniorMatches = [];
foreach ($allMatches as $ba_bec_match) {
    if (!$isSeniorMatch($ba_bec_match)) {
        continue;
    }

    $teamKey = $resolveClubTeam($ba_bec_match);
    if (!array_key_exists($teamKey, $seniorMatches)) {
        $seniorMatches[$teamKey] = $ba_bec_match;
    }
}

$ba_bec_matches = array_values($seniorMatches);
if (empty($ba_bec_matches)) {
    $ba_bec_matches = $allMatches;
}

$homeMatches = [];
$awayMatches = [];
foreach ($ba_bec_matches as $ba_bec_match) {
    $side = $resolveClubSide($ba_bec_match);
    if ($side === 'away') {
        $awayMatches[] = $ba_bec_match;
    } else {
        $homeMatches[] = $ba_bec_match;
    }
}

$lastUpdateStmt = $DB->query($lastUpdateQuery);
$lastUpdateRow = $lastUpdateStmt->fetch(PDO::FETCH_ASSOC);
$lastUpdate = $lastUpdateRow['lastUpdate'] ?? null;

$renderMatchCard = static function (array $ba_bec_match) use ($resolveTeamLogo): string {
    $matchDate = new DateTime($ba_bec_match['matchDate']);
    $displayDate = $matchDate->format('d/m/Y');
    $displayTime = '';
    if (!empty($ba_bec_match['matchTime'])) {
        $matchTime = new DateTime($ba_bec_match['matchTime']);
        $displayTime = $matchTime->format('H:i');
    }
    $score = '';
    if ($ba_bec_match['scoreHome'] !== null && $ba_bec_match['scoreAway'] !== null) {
        $score = (int) $ba_bec_match['scoreHome'] . ' - ' . (int) $ba_bec_match['scoreAway'];
    }
    $homeLogo = $resolveTeamLogo((string) ($ba_bec_match['teamHome'] ?? ''));
    $awayLogo = $resolveTeamLogo((string) ($ba_bec_match['teamAway'] ?? ''));

    ob_start();
    ?>
    <div class="col-12">
        <article class="match-card" style="--match-home-logo: url('<?php echo htmlspecialchars($homeLogo); ?>'); --match-away-logo: url('<?php echo htmlspecialchars($awayLogo); ?>');">
            <header class="match-card__header">
                <div>
                    <p class="match-card__competition"><?php echo htmlspecialchars($ba_bec_match['competition']); ?></p>
                    <p class="match-card__date">
                        <?php echo htmlspecialchars($displayDate); ?>
                        <?php if ($displayTime !== ''): ?>
                            <span>• <?php echo htmlspecialchars($displayTime); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </header>
                    <div class="wrapper">
                        <div class="match-card__team">
                            <span>Domicile</span>
                            <img class="match-card__logo" src="<?php echo htmlspecialchars($homeLogo); ?>" alt="<?php echo htmlspecialchars($ba_bec_match['teamHome']); ?>" loading="lazy">
                            <strong><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></strong>
                        </div>
                        <div class="match-card__score">
                            <?php echo $score !== '' ? htmlspecialchars($score) : 'vs'; ?>
                        </div>
                        <div class="match-card__team">
                            <span>Extérieur</span>
                            <img class="match-card__logo" src="<?php echo htmlspecialchars($awayLogo); ?>" alt="<?php echo htmlspecialchars($ba_bec_match['teamAway']); ?>" loading="lazy">
                            <strong><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></strong>
                        </div>
                    </div>
            <?php if (!empty($ba_bec_match['location'])): ?>
                <p class="match-card__location">Lieu : <?php echo htmlspecialchars($ba_bec_match['location']); ?></p>
            <?php endif; ?>

            <?php if (!empty($ba_bec_match['sourceUrl'])): ?>
                <a href="<?php echo htmlspecialchars($ba_bec_match['sourceUrl']); ?>" class="btn-more" target="_blank" rel="noopener noreferrer">En savoir plus</a>
            <?php else: ?>
                <span class="btn-more disabled" aria-disabled="true">En savoir plus</span>
            <?php endif; ?>
        </article>
    </div>
    <?php

    return (string) ob_get_clean();
};
?>

<main class="container py-5">
    <section class="matches-hero">
        <p class="matches-hero__eyebrow">Calendrier</p>
        <h1 class="matches-hero__title">Les prochains matchs des équipes seniors</h1>
        <p class="matches-hero__text">
            Retrouvez ici le prochain match de chaque équipe senior du club, affiché selon la date du jour.
        </p>
        <div class="matches-hero__meta">
            <span class="matches-hero__source">
                Source :
                <a href="https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024" target="_blank" rel="noopener noreferrer">
                    FFBB Nouvelle-Aquitaine
                </a>
            </span>
            <?php if (!empty($lastUpdate)): ?>
                <span class="matches-hero__update">Dernière mise à jour : <?php echo htmlspecialchars($lastUpdate); ?></span>
            <?php endif; ?>
        </div>
    </section>

    <section class="matches-list" aria-live="polite">
        <?php if (!empty($homeMatches) || !empty($awayMatches)): ?>
            <?php if (!empty($homeMatches)): ?>
                <div class="mb-5">
                    <h2 class="matches-list__title">Matchs à domicile</h2>
                    <div class="row g-4">
                        <?php foreach ($homeMatches as $ba_bec_match): ?>
                            <?php echo $renderMatchCard($ba_bec_match); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($awayMatches)): ?>
                <div>
                    <h2 class="matches-list__title">Matchs à l'extérieur</h2>
                    <div class="row g-4">
                        <?php foreach ($awayMatches as $ba_bec_match): ?>
                            <?php echo $renderMatchCard($ba_bec_match); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-light border matches-empty" role="status">
                Aucun match n'est disponible pour le moment.
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
require_once 'footer.php';
?>
