<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numMemb = ctrlSaisies($_POST['numMemb']);
$ba_bec_numArt = ctrlSaisies($_POST['numArt']);

// Suppression du like dans la base de données
sql_delete('LIKEART', "numMemb = $ba_bec_numMemb AND numArt = $ba_bec_numArt");

// Redirection vers la liste des likes après suppression
header('Location: ../../views/backend/likes/list.php');
exit();
?>
