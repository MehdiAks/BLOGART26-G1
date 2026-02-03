<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

sql_connect();
$ba_bec_tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
$ba_bec_hasBecMatchesTable = (bool) $ba_bec_tableCheckStmt->fetchColumn();

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);
$ba_bec_sourceId = ctrlSaisies($_POST['sourceId'] ?? '');
$ba_bec_section = ctrlSaisies($_POST['section'] ?? '');
$ba_bec_team = ctrlSaisies($_POST['team'] ?? '');
$ba_bec_competition = ctrlSaisies($_POST['competition'] ?? '');
$ba_bec_matchDay = ctrlSaisies($_POST['matchDay'] ?? '');
$ba_bec_matchDate = ctrlSaisies($_POST['matchDate'] ?? '');
$ba_bec_matchTime = ctrlSaisies($_POST['matchTime'] ?? '');
$ba_bec_teamHome = ctrlSaisies($_POST['teamHome'] ?? '');
$ba_bec_teamAway = ctrlSaisies($_POST['teamAway'] ?? '');
$ba_bec_opponent = ctrlSaisies($_POST['opponent'] ?? '');
$ba_bec_location = ctrlSaisies($_POST['location'] ?? '');
$ba_bec_status = ctrlSaisies($_POST['status'] ?? '');
$ba_bec_scoreHome = ctrlSaisies($_POST['scoreHome'] ?? '');
$ba_bec_scoreAway = ctrlSaisies($_POST['scoreAway'] ?? '');
$ba_bec_sourceUrl = ctrlSaisies($_POST['sourceUrl'] ?? '');

if (!$ba_bec_hasBecMatchesTable && $ba_bec_sourceId === '') {
    $ba_bec_sourceId = sha1($ba_bec_competition . '|' . $ba_bec_matchDate . '|' . $ba_bec_matchTime . '|' . $ba_bec_teamHome . '|' . $ba_bec_teamAway . '|' . uniqid('', true));
}

$ba_bec_matchTimeValue = $ba_bec_matchTime !== '' ? "'$ba_bec_matchTime'" : 'NULL';
$ba_bec_scoreHomeValue = $ba_bec_scoreHome !== '' ? (int) $ba_bec_scoreHome : 'NULL';
$ba_bec_scoreAwayValue = $ba_bec_scoreAway !== '' ? (int) $ba_bec_scoreAway : 'NULL';

if ($ba_bec_hasBecMatchesTable) {
    $ba_bec_columns = 'Section, Equipe, Competition, Phase, Journee, Date, Heure, Domicile_Exterieur, Equipe_domicile, Equipe_exterieure, Adversaire, Score_domicile, Score_exterieur, MatchNo, Source';
    $ba_bec_values = "'$ba_bec_section', '$ba_bec_team', '$ba_bec_competition', '$ba_bec_status', '$ba_bec_matchDay', '$ba_bec_matchDate', '$ba_bec_matchTime', '$ba_bec_location', '$ba_bec_teamHome', '$ba_bec_teamAway', '$ba_bec_opponent', $ba_bec_scoreHomeValue, $ba_bec_scoreAwayValue, $ba_bec_numMatch, '$ba_bec_sourceUrl'";
    sql_insert('bec_matches', $ba_bec_columns, $ba_bec_values);
} else {
    $ba_bec_locationValue = $ba_bec_location !== '' ? "'$ba_bec_location'" : 'NULL';
    $ba_bec_statusValue = $ba_bec_status !== '' ? "'$ba_bec_status'" : 'NULL';
    $ba_bec_sourceUrlValue = $ba_bec_sourceUrl !== '' ? "'$ba_bec_sourceUrl'" : 'NULL';
    $ba_bec_columns = 'sourceId, competition, matchDate, matchTime, teamHome, teamAway, location, status, scoreHome, scoreAway, sourceUrl';
    $ba_bec_values = "'$ba_bec_sourceId', '$ba_bec_competition', '$ba_bec_matchDate', $ba_bec_matchTimeValue, '$ba_bec_teamHome', '$ba_bec_teamAway', $ba_bec_locationValue, $ba_bec_statusValue, $ba_bec_scoreHomeValue, $ba_bec_scoreAwayValue, $ba_bec_sourceUrlValue";
    sql_insert('MATCH_CLUB', $ba_bec_columns, $ba_bec_values);
}

header('Location: ../../views/backend/matches/list.php');
