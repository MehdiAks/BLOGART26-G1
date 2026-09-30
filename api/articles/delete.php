<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$ba_bec_numArt = (int) ($_POST['numArt'] ?? 0);
$ba_bec_article = sql_select('ARTICLE', 'urlPhotArt', 'numArt = ?', null, null, '1', [$ba_bec_numArt])[0] ?? null;
if (!$ba_bec_article) {
    http_response_code(404);
    exit('Article introuvable.');
}

$ba_bec_motcle_result = sql_delete('MOTCLEARTICLE', 'numArt = ?', [$ba_bec_numArt]);
$ba_bec_delete_result = sql_delete('ARTICLE', 'numArt = ?', [$ba_bec_numArt]);
if ($ba_bec_delete_result['success'] && !empty($ba_bec_article['urlPhotArt'])) {
    delete_uploaded_file($ba_bec_article['urlPhotArt']);
}
if ($ba_bec_motcle_result['success'] && $ba_bec_delete_result['success']) {
    flash_success();
} elseif (!empty($ba_bec_motcle_result['constraint']) || !empty($ba_bec_delete_result['constraint'])) {
    flash_delete_impossible('Suppression impossible : cet article est utilisé dans d’autres données.');
} else {
    flash_error();
}
header('Location: ' . ROOT_URL . '/public/index.php?controller=article&action=list');
exit();
?>
