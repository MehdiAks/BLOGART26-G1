<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);
$ba_bec_sourceId = ctrlSaisies($_POST['sourceId'] ?? '');
$ba_bec_competition = ctrlSaisies($_POST['competition'] ?? '');
$ba_bec_matchDate = ctrlSaisies($_POST['matchDate'] ?? '');
$ba_bec_matchTime = ctrlSaisies($_POST['matchTime'] ?? '');
$ba_bec_teamHome = ctrlSaisies($_POST['teamHome'] ?? '');
$ba_bec_teamAway = ctrlSaisies($_POST['teamAway'] ?? '');
$ba_bec_location = ctrlSaisies($_POST['location'] ?? '');
$ba_bec_status = ctrlSaisies($_POST['status'] ?? '');
$ba_bec_scoreHome = ctrlSaisies($_POST['scoreHome'] ?? '');
$ba_bec_scoreAway = ctrlSaisies($_POST['scoreAway'] ?? '');
$ba_bec_sourceUrl = ctrlSaisies($_POST['sourceUrl'] ?? '');

$ba_bec_matchTimeValue = $ba_bec_matchTime !== '' ? "'$ba_bec_matchTime'" : 'NULL';
$ba_bec_locationValue = $ba_bec_location !== '' ? "'$ba_bec_location'" : 'NULL';
$ba_bec_statusValue = $ba_bec_status !== '' ? "'$ba_bec_status'" : 'NULL';
$ba_bec_scoreHomeValue = $ba_bec_scoreHome !== '' ? (int) $ba_bec_scoreHome : 'NULL';
$ba_bec_scoreAwayValue = $ba_bec_scoreAway !== '' ? (int) $ba_bec_scoreAway : 'NULL';
$ba_bec_sourceUrlValue = $ba_bec_sourceUrl !== '' ? "'$ba_bec_sourceUrl'" : 'NULL';

$ba_bec_updates = "sourceId = '$ba_bec_sourceId', competition = '$ba_bec_competition', matchDate = '$ba_bec_matchDate', matchTime = $ba_bec_matchTimeValue, teamHome = '$ba_bec_teamHome', teamAway = '$ba_bec_teamAway', location = $ba_bec_locationValue, status = $ba_bec_statusValue, scoreHome = $ba_bec_scoreHomeValue, scoreAway = $ba_bec_scoreAwayValue, sourceUrl = $ba_bec_sourceUrlValue";

sql_update('MATCH_CLUB', $ba_bec_updates, "numMatch = $ba_bec_numMatch");

header('Location: ../../views/backend/matches/list.php');
