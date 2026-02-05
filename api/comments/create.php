<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libCom = ctrlSaisies($_POST['libCom']);
$ba_bec_numArt = ctrlSaisies($_POST['numArt']);
$ba_bec_numMemb = ctrlSaisies($_POST['numMemb']);


sql_insert('comment', 'libCom, numArt, numMemb', "'$ba_bec_libCom', '$ba_bec_numArt', '$ba_bec_numMemb'");


header('Location: ../../views/backend/comments/list.php');

?>