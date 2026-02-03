<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);

if ($ba_bec_numMatch > 0) {
    sql_delete('MATCH_CLUB', "numMatch = $ba_bec_numMatch");
}

header('Location: ../../views/backend/matches/list.php');
