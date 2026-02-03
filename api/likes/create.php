<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Nettoyer les données
$ba_bec_numMemb = ctrlSaisies($_POST['numMemb']);
$ba_bec_numArt = ctrlSaisies($_POST['numArt']);
$ba_bec_likeA = ctrlSaisies($_POST['likeA']);

// Validation de likeA
if ($ba_bec_likeA !== "1" && $ba_bec_likeA !== "0") {
    die("Erreur : valeur de like invalide.");
}
$ba_bec_likeA = (int)$ba_bec_likeA;

// Vérifier l'existence du like
$ba_bec_existingLike = sql_select('LIKEART', '*', "numMemb = $ba_bec_numMemb AND numArt = $ba_bec_numArt");

if ($ba_bec_existingLike) {
    sql_update('LIKEART', "likeA = $ba_bec_likeA", "numMemb = $ba_bec_numMemb AND numArt = $ba_bec_numArt");
} else {
    sql_insert('LIKEART', 'numMemb, numArt, likeA', "$ba_bec_numMemb, $ba_bec_numArt, $ba_bec_likeA");
}

// Redirection personnalisée
$ba_bec_redirectUrl = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : '../../views/backend/likes/list.php';
header("Location: $ba_bec_redirectUrl");
exit();
?>