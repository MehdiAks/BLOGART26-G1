<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numMemb = ctrlSaisies($_POST['numMemb']);
$ba_bec_numArt = ctrlSaisies($_POST['numArt']);
$ba_bec_likeA = ctrlSaisies($_POST['likeA']);

// Mise à jour du like dans la base de données
sql_update(
    'LIKEART', 
    'likeA = ' . $ba_bec_likeA, 
    'numMemb = ' . $ba_bec_numMemb . ' AND numArt = ' . $ba_bec_numArt
);

// Redirection vers la liste des likes après modification
header('Location: ../../views/backend/likes/list.php');
exit();
?>

