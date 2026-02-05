<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numArt = ctrlSaisies($_POST['numArt']);

// Récupérer le chemin de l'image associée à l'article avant de supprimer l'article
$ba_bec_article = sql_select("ARTICLE", "urlPhotArt", "numArt = '$ba_bec_numArt'")[0];
$ba_bec_ancienneImage = $ba_bec_article['urlPhotArt'];

// Spécifier le chemin du dossier des images
$ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/';

// Supprimer l'image du serveur si elle existe
if ($ba_bec_ancienneImage && file_exists($ba_bec_uploadDir . $ba_bec_ancienneImage)) {
    unlink($ba_bec_uploadDir . $ba_bec_ancienneImage);
}

// Supprimer les mots-clés associés à l'article
$ba_bec_motcle_result = sql_delete('MOTCLEARTICLE', "numArt = '$ba_bec_numArt'");

// Supprimer l'article de la base de données
$ba_bec_delete_result = sql_delete('ARTICLE', "numArt = '$ba_bec_numArt'");

// Redirection après la suppression
if ($ba_bec_motcle_result['success'] && $ba_bec_delete_result['success']) {
    flash_success();
} else {
    flash_error();
}
header('Location: ../../views/backend/articles/list.php');
exit;
?>
