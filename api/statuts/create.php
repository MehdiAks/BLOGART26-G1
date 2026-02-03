<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libStat = ctrlSaisies($_POST['libStat']);

$ba_bec_currentMax = sql_select('STATUT', 'MAX(numStat) AS maxStat');
$ba_bec_nextNumStat = 1;
if (!empty($ba_bec_currentMax) && isset($ba_bec_currentMax[0]['maxStat'])) {
    $ba_bec_nextNumStat = (int)$ba_bec_currentMax[0]['maxStat'] + 1;
}

sql_insert('STATUT', 'numStat, libStat', "'$ba_bec_nextNumStat', '$ba_bec_libStat'");


header('Location: ../../views/backend/statuts/list.php');
