<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_fields = [];
foreach (['libTitrArt', 'libChapoArt', 'libAccrochArt', 'parag1Art', 'libSsTitr1Art', 'parag2Art', 'libSsTitr2Art', 'parag3Art', 'libConclArt'] as $ba_bec_field) {
    $ba_bec_fields[$ba_bec_field] = ctrlSaisies($_POST[$ba_bec_field] ?? '');
    if (!isValidBbcodeContent($ba_bec_fields[$ba_bec_field])) {
        http_response_code(400);
        exit('Le contenu contient du BBCode non autorisé.');
    }
}
$ba_bec_fields['libAccrochArt'] = function_exists('mb_substr')
    ? mb_substr($ba_bec_fields['libAccrochArt'], 0, 100)
    : substr($ba_bec_fields['libAccrochArt'], 0, 100);
$ba_bec_numThem = (int) ($_POST['numThem'] ?? 0);
$ba_bec_numMotCle = array_values(array_unique(array_map('intval', (array) ($_POST['motCle'] ?? []))));
if ($ba_bec_numThem <= 0 || count($ba_bec_numMotCle) < 3) {
    http_response_code(400);
    exit('Thématique ou mots-clés invalides.');
}

$ba_bec_nom_image = null;
if (isset($_FILES['urlPhotArt']) && ($_FILES['urlPhotArt']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
    $ba_bec_upload = upload_image($_FILES['urlPhotArt'], 'article', $ba_bec_fields['libTitrArt']);
    if (!$ba_bec_upload['success']) {
        http_response_code(400);
        exit($ba_bec_upload['error']);
    }
    $ba_bec_nom_image = $ba_bec_upload['path'];
}

$ba_bec_values = array_values($ba_bec_fields);
$ba_bec_values[] = $ba_bec_nom_image;
$ba_bec_values[] = $ba_bec_numThem;
$ba_bec_insert_result = sql_insert(
    'ARTICLE',
    'libTitrArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numThem',
    '?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?',
    $ba_bec_values
);
if (!$ba_bec_insert_result['success']) {
    if ($ba_bec_nom_image) {
        delete_uploaded_file($ba_bec_nom_image);
    }
    flash_error();
    header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
    exit();
}
$ba_bec_lastArt = (int) $ba_bec_insert_result['id'];
$ba_bec_has_error = false;
foreach ($ba_bec_numMotCle as $ba_bec_mot) {
    $ba_bec_link = sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', '?, ?', [$ba_bec_lastArt, $ba_bec_mot]);
    $ba_bec_has_error = $ba_bec_has_error || !$ba_bec_link['success'];
}
$ba_bec_has_error ? flash_error() : flash_success();
header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
exit();
?>
