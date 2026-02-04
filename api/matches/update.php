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

$ba_bec_previousEquipeId = null;
if ($ba_bec_numMatch) {
    $ba_bec_matchStmt = $DB->prepare('SELECT numEquipe FROM bec_matches WHERE MatchNo = :matchNo LIMIT 1');
    $ba_bec_matchStmt->execute([':matchNo' => $ba_bec_numMatch]);
    $ba_bec_previousEquipeId = $ba_bec_matchStmt->fetchColumn();
    $ba_bec_previousEquipeId = $ba_bec_previousEquipeId !== false ? (int) $ba_bec_previousEquipeId : null;
}

$ba_bec_numEquipe = ba_bec_resolve_equipe_id_from_section($ba_bec_section);
$ba_bec_numEquipeValue = $ba_bec_numEquipe !== null ? (int) $ba_bec_numEquipe : 'NULL';
$ba_bec_updates = "Section = '$ba_bec_section', numEquipe = $ba_bec_numEquipeValue, Equipe = '$ba_bec_team', Competition = '$ba_bec_competition', Phase = '$ba_bec_status', Journee = '$ba_bec_matchDay', Date = '$ba_bec_matchDate', Heure = '$ba_bec_matchTime', Domicile_Exterieur = '$ba_bec_location', Adversaire = '$ba_bec_opponent', Score_BEC = $ba_bec_scoreBecValue, Score_Adversaire = $ba_bec_scoreOpponentValue, Source = '$ba_bec_sourceUrl'";
sql_update('bec_matches', $ba_bec_updates, "MatchNo = $ba_bec_numMatch");

ba_bec_update_equipe_points($ba_bec_numEquipe);
if ($ba_bec_previousEquipeId !== null && $ba_bec_previousEquipeId !== $ba_bec_numEquipe) {
    ba_bec_update_equipe_points($ba_bec_previousEquipeId);
}

header('Location: ../../views/backend/matches/list.php');
