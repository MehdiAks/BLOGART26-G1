<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
require_once '../../functions/equipe_stats.php';

sql_connect();

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);
$ba_bec_section = ctrlSaisies($_POST['section'] ?? '');
$ba_bec_team = ctrlSaisies($_POST['team'] ?? '');
$ba_bec_competition = ctrlSaisies($_POST['competition'] ?? '');
$ba_bec_matchDay = ctrlSaisies($_POST['matchDay'] ?? '');
$ba_bec_matchDate = ctrlSaisies($_POST['matchDate'] ?? '');
$ba_bec_matchTime = ctrlSaisies($_POST['matchTime'] ?? '');
$ba_bec_opponent = ctrlSaisies($_POST['opponent'] ?? '');
$ba_bec_location = ctrlSaisies($_POST['location'] ?? '');
$ba_bec_status = ctrlSaisies($_POST['status'] ?? '');
$ba_bec_scoreBec = ctrlSaisies($_POST['scoreBec'] ?? '');
$ba_bec_scoreOpponent = ctrlSaisies($_POST['scoreOpponent'] ?? '');
$ba_bec_sourceUrl = ctrlSaisies($_POST['sourceUrl'] ?? '');

$ba_bec_scoreBecValue = $ba_bec_scoreBec !== '' ? (int) $ba_bec_scoreBec : 'NULL';
$ba_bec_scoreOpponentValue = $ba_bec_scoreOpponent !== '' ? (int) $ba_bec_scoreOpponent : 'NULL';

$ba_bec_numEquipe = ba_bec_resolve_equipe_id_from_section($ba_bec_section);
$ba_bec_numEquipeValue = $ba_bec_numEquipe !== null ? (int) $ba_bec_numEquipe : 'NULL';
$ba_bec_columns = 'Section, numEquipe, Equipe, Competition, Phase, Journee, Date, Heure, Domicile_Exterieur, Adversaire, Score_BEC, Score_Adversaire, MatchNo, Source';
$ba_bec_values = "'$ba_bec_section', $ba_bec_numEquipeValue, '$ba_bec_team', '$ba_bec_competition', '$ba_bec_status', '$ba_bec_matchDay', '$ba_bec_matchDate', '$ba_bec_matchTime', '$ba_bec_location', '$ba_bec_opponent', $ba_bec_scoreBecValue, $ba_bec_scoreOpponentValue, $ba_bec_numMatch, '$ba_bec_sourceUrl'";
sql_insert('bec_matches', $ba_bec_columns, $ba_bec_values);

ba_bec_update_equipe_points($ba_bec_numEquipe);

header('Location: ../../views/backend/matches/list.php');

?>