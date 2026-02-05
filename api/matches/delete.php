<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

sql_connect();

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);
if ($ba_bec_numMatch > 0) {
    $deleteStmt = $DB->prepare('DELETE FROM `MATCH` WHERE numMatch = :numMatch');
    $deleteStmt->execute([':numMatch' => $ba_bec_numMatch]);
}

header('Location: ../../views/backend/matches/list.php');
