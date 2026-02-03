<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Activer l'affichage des erreurs pour le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);


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
        

if (function_exists('mb_substr')) {
    $ba_bec_libAccrochArt = mb_substr($ba_bec_libAccrochArt, 0, 100);
} else {
    $ba_bec_libAccrochArt = substr($ba_bec_libAccrochArt, 0, 100);
}

$ba_bec_numMotCle = isset($_POST['motCle']) ? (array) $_POST['motCle'] : [];
$ba_bec_urlPhotArt = "";
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

}


// Insertion dans la table ARTICLE
sql_insert(
    'ARTICLE',
    'libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numThem',
    "'$ba_bec_libTitrArt', '$ba_bec_libChapoArt', '$ba_bec_libAccrochArt', '$ba_bec_parag1Art', '$ba_bec_libSsTitr1Art', '$ba_bec_parag2Art', '$ba_bec_libSsTitr2Art', '$ba_bec_parag3Art', '$ba_bec_libConclArt', '$ba_bec_nom_image', '$ba_bec_numThem'"
);
$ba_bec_lastArt = sql_select('ARTICLE', 'numArt', null, 'numArt DESC')[0]['numArt'];



foreach ($ba_bec_numMotCle as $ba_bec_mot){
    sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', "$ba_bec_lastArt, $ba_bec_mot");
}




// Redirection après l'insertion
header('Location: ../../views/backend/articles/list.php');
exit;

?>
