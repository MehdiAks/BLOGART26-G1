<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_numArt = (int) ($_POST['numArt'] ?? 0);
$ba_bec_numThem = (int) ($_POST['numThem'] ?? 0);
$ba_bec_numMotCle = array_values(array_unique(array_map('intval', (array) ($_POST['motCle'] ?? []))));
$ba_bec_article = sql_select('ARTICLE', 'urlPhotArt', 'numArt = ?', null, null, '1', [$ba_bec_numArt])[0] ?? null;
if (!$ba_bec_article || $ba_bec_numThem <= 0 || count($ba_bec_numMotCle) < 3) {
    http_response_code(400);
    exit('Article, thématique ou mots-clés invalides.');
}

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

$ba_bec_nom_image = $ba_bec_article['urlPhotArt'] ?? null;
$ba_bec_new_image = null;
if (isset($_FILES['urlPhotArt']) && ($_FILES['urlPhotArt']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
    $ba_bec_upload = upload_image($_FILES['urlPhotArt'], 'article', $ba_bec_fields['libTitrArt']);
    if (!$ba_bec_upload['success']) {
        http_response_code(400);
        exit($ba_bec_upload['error']);
    }
    $ba_bec_new_image = $ba_bec_upload['path'];
    $ba_bec_nom_image = $ba_bec_new_image;
}

$ba_bec_params = [date('Y-m-d H:i:s')];
$ba_bec_params = array_merge($ba_bec_params, array_values($ba_bec_fields), [$ba_bec_nom_image, $ba_bec_numThem, $ba_bec_numArt]);
$ba_bec_result = sql_update(
    'ARTICLE',
    'dtMajArt = ?, libTitrArt = ?, libChapoArt = ?, libAccrochArt = ?, parag1Art = ?, libSsTitr1Art = ?, parag2Art = ?, libSsTitr2Art = ?, parag3Art = ?, libConclArt = ?, urlPhotArt = ?, numThem = ?',
    'numArt = ?',
    $ba_bec_params
);
if (!$ba_bec_result['success']) {
    if ($ba_bec_new_image) {
        delete_uploaded_file($ba_bec_new_image);
    }
    flash_error();
    header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
    exit();
}
if ($ba_bec_new_image && !empty($ba_bec_article['urlPhotArt'])) {
    delete_uploaded_file($ba_bec_article['urlPhotArt']);
}

sql_delete('MOTCLEARTICLE', 'numArt = ?', [$ba_bec_numArt]);
$ba_bec_has_error = false;
foreach ($ba_bec_numMotCle as $ba_bec_mot) {
    $ba_bec_link = sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', '?, ?', [$ba_bec_numArt, $ba_bec_mot]);
    $ba_bec_has_error = $ba_bec_has_error || !$ba_bec_link['success'];
}
$ba_bec_has_error ? flash_error() : flash_success();
header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
exit();
?>
