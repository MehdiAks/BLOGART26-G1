<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [
    ROOT_URL . '/src/css/matches.css',
];

require_once 'header.php';

sql_connect();

$tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
$hasBecMatchesTable = (bool) $tableCheckStmt->fetchColumn();
$matchesTable = $hasBecMatchesTable ? 'bec_matches' : 'MATCH_CLUB';

$matchesQuery = '';
$lastUpdateQuery = '';

if ($matchesTable === 'bec_matches') {
    $matchesQuery = "SELECT MatchNo AS numMatch,
            Competition AS competition,
            Date AS matchDate,
            Heure AS matchTime,
            Equipe_domicile AS teamHome,
            Equipe_exterieure AS teamAway,
            Domicile_Exterieur AS location,
            Phase AS status,
            Score_domicile AS scoreHome,
            Score_exterieur AS scoreAway
        FROM {$matchesTable}
        WHERE Date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
        ORDER BY Date ASC, Heure ASC";
    $lastUpdateQuery = "SELECT MAX(Date) AS lastUpdate FROM {$matchesTable}";
} else {
    $matchesQuery = "SELECT numMatch, competition, matchDate, matchTime, teamHome, teamAway, location, status, scoreHome, scoreAway
        FROM {$matchesTable}
        WHERE matchDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
        ORDER BY matchDate ASC, matchTime ASC";
    $lastUpdateQuery = "SELECT MAX(COALESCE(dtMajMatch, dtCreaMatch)) AS lastUpdate FROM {$matchesTable}";
}

$matchesStmt = $DB->prepare($matchesQuery);
$matchesStmt->execute();
$allMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);

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

$renderMatchCard = static function (array $ba_bec_match): string {
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

    ob_start();
    ?>
    <div class="col-12">
        <article class="match-card">
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
            <div class="match-card__teams">
                <div class="match-card__team">
                    <span class="match-card__label">Domicile</span>
                    <strong><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></strong>
                </div>
                <div class="match-card__score">
                    <?php echo $score !== '' ? htmlspecialchars($score) : 'vs'; ?>
                </div>
                <div class="match-card__team">
                    <span class="match-card__label">Extérieur</span>
                    <strong><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></strong>
                </div>
            </div>
            <?php if (!empty($ba_bec_match['location'])): ?>
                <p class="match-card__location">Lieu : <?php echo htmlspecialchars($ba_bec_match['location']); ?></p>
            <?php endif; ?>

            <a href="article.html" class="btn-more">En savoir plus</a>
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
