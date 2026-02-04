<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/equipe_stats.php';

sql_connect();
$ba_bec_tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
$ba_bec_hasBecMatchesTable = (bool) $ba_bec_tableCheckStmt->fetchColumn();

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);

if ($ba_bec_numMatch > 0) {
    if ($ba_bec_hasBecMatchesTable) {
        $ba_bec_matchStmt = $DB->prepare('SELECT numEquipe FROM bec_matches WHERE MatchNo = :matchNo LIMIT 1');
        $ba_bec_matchStmt->execute([':matchNo' => $ba_bec_numMatch]);
        $ba_bec_numEquipe = $ba_bec_matchStmt->fetchColumn();
        $ba_bec_numEquipe = $ba_bec_numEquipe !== false ? (int) $ba_bec_numEquipe : null;

        sql_delete('bec_matches', "MatchNo = $ba_bec_numMatch");

        ba_bec_update_equipe_points($ba_bec_numEquipe);
    } else {
        sql_delete('MATCH_CLUB', "numMatch = $ba_bec_numMatch");
    }
}

header('Location: ../../views/backend/matches/list.php');
