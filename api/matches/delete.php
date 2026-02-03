<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

sql_connect();
$ba_bec_tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
$ba_bec_hasBecMatchesTable = (bool) $ba_bec_tableCheckStmt->fetchColumn();

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);

if ($ba_bec_numMatch > 0) {
    if ($ba_bec_hasBecMatchesTable) {
        sql_delete('bec_matches', "MatchNo = $ba_bec_numMatch");
    } else {
        sql_delete('MATCH_CLUB', "numMatch = $ba_bec_numMatch");
    }
}

header('Location: ../../views/backend/matches/list.php');
