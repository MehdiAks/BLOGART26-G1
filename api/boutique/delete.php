<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_num = (int) ($_POST['numArtBoutique'] ?? 0);

    if ($ba_bec_num > 0) {
        $ba_bec_article = sql_select('boutique', 'urlPhotoArtBoutique', 'numArtBoutique = ?', null, null, '1', [$ba_bec_num])[0] ?? null;
        $ba_bec_result = sql_delete('boutique', 'numArtBoutique = ?', [$ba_bec_num]);
        if ($ba_bec_result['success'] && $ba_bec_article) {
            $ba_bec_images = json_decode((string) $ba_bec_article['urlPhotoArtBoutique'], true);
            $ba_bec_image = is_array($ba_bec_images)
                ? (string) ($ba_bec_images[0] ?? '')
                : (string) $ba_bec_article['urlPhotoArtBoutique'];
            if ($ba_bec_image !== '') {
                delete_uploaded_file($ba_bec_image);
            }
        }
    }

    header('Location: ../../views/backend/boutique/list.php');
    exit();
}
