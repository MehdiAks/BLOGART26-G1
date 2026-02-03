<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numCom = ctrlSaisies($_POST['numCom']);
$ba_bec_libCom = ctrlSaisies($_POST['libCom']);
$ba_bec_delLogiq = ctrlSaisies($_POST['delLogiq']);
$ba_bec_attModOK = ctrlSaisies($_POST['attModOK']);
$ba_bec_notifComKOAff = ctrlSaisies($_POST['notifComKOAff']);


//sql_delete('STATUT', "numStat = $numStat");
sql_update('comment', "libCom = '$ba_bec_libCom'", "numCom = $ba_bec_numCom");
sql_update('comment', "delLogiq = '$ba_bec_delLogiq'", "numCom = $ba_bec_numCom");
sql_update('comment', "attModOK = '$ba_bec_attModOK'", "numCom = $ba_bec_numCom");
sql_update('comment', "notifComKOAff = '$ba_bec_notifComKOAff'", "numCom = $ba_bec_numCom");

header('Location: ../../views/backend/comments/list.php');
?>
