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
        WHERE Date >= CURDATE()
        ORDER BY Date ASC, Heure ASC";
    $lastUpdateQuery = "SELECT MAX(Date) AS lastUpdate FROM {$matchesTable}";
} else {
    $matchesQuery = "SELECT numMatch, competition, matchDate, matchTime, teamHome, teamAway, location, status, scoreHome, scoreAway
        FROM {$matchesTable}
        WHERE matchDate >= CURDATE()
        ORDER BY matchDate ASC, matchTime ASC";
    $lastUpdateQuery = "SELECT MAX(COALESCE(dtMajMatch, dtCreaMatch)) AS lastUpdate FROM {$matchesTable}";
}

$matchesStmt = $DB->prepare($matchesQuery);
$matchesStmt->execute();
$ba_bec_matches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);

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
$seniorMatches = [];
foreach ($ba_bec_matches as $ba_bec_match) {
    if (!$isSeniorMatch($ba_bec_match)) {
        continue;
    }

    $teamKey = $resolveClubTeam($ba_bec_match);
    if (!array_key_exists($teamKey, $seniorMatches)) {
        $seniorMatches[$teamKey] = $ba_bec_match;
    }
}

$ba_bec_matches = array_values($seniorMatches);

$lastUpdateStmt = $DB->query($lastUpdateQuery);
$lastUpdateRow = $lastUpdateStmt->fetch(PDO::FETCH_ASSOC);
$lastUpdate = $lastUpdateRow['lastUpdate'] ?? null;
?>

<main class="container py-5">
    <section class="matches-hero">
        <p class="matches-hero__eyebrow">Calendrier</p>
        <h1 class="matches-hero__title">Les prochains matchs des équipes seniors</h1>
        <p class="matches-hero__text">
            Retrouvez ici le prochain match de chaque équipe senior du club. Les données sont synchronisées depuis le
            calendrier FFBB et enregistrées sur le serveur pour un affichage rapide.
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
        <?php if (!empty($ba_bec_matches)): ?>
            <div class="row g-4">
                <?php foreach ($ba_bec_matches as $ba_bec_match): ?>
                    <?php
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
                                <?php if (!empty($ba_bec_match['status'])): ?>
                                    <span class="match-card__status"><?php echo htmlspecialchars($ba_bec_match['status']); ?></span>
                                <?php endif; ?>
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
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light border matches-empty" role="status">
                Aucun match n'est disponible pour le moment. Les données seront ajoutées après la synchronisation FFBB.
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
require_once 'footer.php';
?>
