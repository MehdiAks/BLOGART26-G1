<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

sql_connect();
$ba_bec_tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
if ($ba_bec_tableCheckStmt->fetchColumn()) {
    header('Location: ../../views/backend/matches/list.php');
    exit;
}

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);

if ($ba_bec_numMatch > 0) {
    sql_delete('MATCH_CLUB', "numMatch = $ba_bec_numMatch");
}

header('Location: ../../views/backend/matches/list.php');
