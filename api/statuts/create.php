<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libStat = ctrlSaisies($_POST['libStat']);

sql_insert('STATUT', 'libStat', "'$ba_bec_libStat'");


header('Location: ../../views/backend/statuts/list.php');