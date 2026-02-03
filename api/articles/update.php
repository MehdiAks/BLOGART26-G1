<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Activer l'affichage des erreurs pour le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupération des données du formulaire
$ba_bec_dtMajArt = date("Y-m-d H:i:s");
$ba_bec_libTitrArt = ctrlSaisies($_POST['libTitrArt']);
$ba_bec_libChapoArt = ctrlSaisies($_POST['libChapoArt']);
$ba_bec_libAccrochArt = ctrlSaisies($_POST['libAccrochArt']);
$ba_bec_parag1Art = ctrlSaisies($_POST['parag1Art']);
$ba_bec_libSsTitr1Art = ctrlSaisies($_POST['libSsTitr1Art']);
$ba_bec_parag2Art = ctrlSaisies($_POST['parag2Art']);
$ba_bec_libSsTitr2Art = ctrlSaisies($_POST['libSsTitr2Art']);
$ba_bec_parag3Art = ctrlSaisies($_POST['parag3Art']);
$ba_bec_libConclArt = ctrlSaisies($_POST['libConclArt']);
$ba_bec_numThem = ctrlSaisies($_POST['numThem']);
$ba_bec_numArt = ctrlSaisies($_POST['numArt']);
$ba_bec_numMotCle = $_POST['motCle'];

// Récupérer l'ancienne image de l'article
$ba_bec_article = sql_select("ARTICLE", "urlPhotArt", "numArt = '$ba_bec_numArt'")[0];
$ba_bec_ancienneImage = $ba_bec_article['urlPhotArt'];

// Gestion de l'image
if (isset($_FILES['urlPhotArt']) && $_FILES['urlPhotArt']['error'] === 0) {
    $ba_bec_tmpName = $_FILES['urlPhotArt']['tmp_name'];
    $ba_bec_name = $_FILES['urlPhotArt']['name'];
    $ba_bec_size = $_FILES['urlPhotArt']['size'];

    // Vérification de la taille de l'image
    if ($ba_bec_size > 10000000) {
        die("Le fichier est trop volumineux.");
    }

    // Vérification des dimensions de l'image
    list($ba_bec_width, $ba_bec_height) = getimagesize($ba_bec_tmpName);
    if ($ba_bec_width > 5000 || $ba_bec_height > 5000) {
        die("L'image est trop grande.");
    }

    // Définir un nom unique pour l'image
    $ba_bec_nom_image = time() . '_' . $ba_bec_name;
    $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/';
    $ba_bec_destination = $ba_bec_uploadDir . $ba_bec_nom_image;

    if (!move_uploaded_file($ba_bec_tmpName, $ba_bec_destination)) {
        die("Erreur lors de l'upload de l'image.");
    }

    // Supprimer l'ancienne image du serveur si elle existe et n'est pas celle par défaut
    if ($ba_bec_ancienneImage && file_exists($ba_bec_uploadDir . $ba_bec_ancienneImage)) {
        unlink($ba_bec_uploadDir . $ba_bec_ancienneImage);
    }

} else {
    // Si aucune nouvelle image n'est téléchargée, conserver l'image existante
    $ba_bec_nom_image = $ba_bec_ancienneImage;
}

// Variables pour la mise à jour de l'article
$ba_bec_set_art = "dtMajArt = '$ba_bec_dtMajArt',
libTitrArt = '$ba_bec_libTitrArt',
libChapoArt = '$ba_bec_libChapoArt', 
libAccrochArt = '$ba_bec_libAccrochArt',
parag1Art = '$ba_bec_parag1Art', 
libSsTitr1Art = '$ba_bec_libSsTitr1Art',
parag2Art = '$ba_bec_parag2Art',
libSsTitr2Art = '$ba_bec_libSsTitr2Art',
parag3Art = '$ba_bec_parag3Art',
libConclArt = '$ba_bec_libConclArt', 
urlPhotArt = '$ba_bec_nom_image', 
numThem = '$ba_bec_numThem'";

$ba_bec_where_num = "numArt = '$ba_bec_numArt'";
$ba_bec_table_art = "ARTICLE";

// Mise à jour de l'article
sql_update($ba_bec_table_art, $ba_bec_set_art, $ba_bec_where_num);

// Suppression des mots-clés existants et réinsertion des nouveaux mots-clés
sql_delete('MOTCLEARTICLE', $ba_bec_where_num);
foreach ($ba_bec_numMotCle as $ba_bec_mot) {
    sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', "$ba_bec_numArt, $ba_bec_mot");
}

// Redirection après la mise à jour
header('Location: ../../views/backend/articles/list.php');
exit;
?>
