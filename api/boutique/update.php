<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_parse_to_json = static function (string $value): string {
    $items = array_values(array_filter(array_map('trim', explode(',', $value)), 'strlen'));
    return json_encode($items, JSON_UNESCAPED_UNICODE);
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_num = (int) ($_POST['numArtBoutique'] ?? 0);
    $ba_bec_lib = ctrlSaisies($_POST['libArtBoutique'] ?? '');
    $ba_bec_desc = ctrlSaisies($_POST['descArtBoutique'] ?? '');
    $ba_bec_couleurs = ctrlSaisies($_POST['couleursArtBoutique'] ?? '');
    $ba_bec_tailles = ctrlSaisies($_POST['taillesArtBoutique'] ?? '');
    $ba_bec_prix_adulte = (float) ($_POST['prixAdulteArtBoutique'] ?? 0);
    $ba_bec_prix_enfant_raw = trim((string) ($_POST['prixEnfantArtBoutique'] ?? ''));
    $ba_bec_prix_enfant = $ba_bec_prix_enfant_raw !== '' ? (float) $ba_bec_prix_enfant_raw : null;
    $ba_bec_photo = ctrlSaisies($_POST['urlPhotoArtBoutique'] ?? '');
    $ba_bec_categorie = ctrlSaisies($_POST['categorieArtBoutique'] ?? '');
    $ba_bec_current = $ba_bec_num > 0
        ? (sql_select('boutique', 'urlPhotoArtBoutique', 'numArtBoutique = ?', null, null, '1', [$ba_bec_num])[0] ?? null)
        : null;
    $ba_bec_uploadProvided = isset($_FILES['photoArtBoutique'])
        && ($_FILES['photoArtBoutique']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    $ba_bec_upload = $ba_bec_uploadProvided
        ? upload_image($_FILES['photoArtBoutique'], 'photos-boutiques', $ba_bec_lib)
        : ['success' => false, 'path' => null, 'error' => null];
    if ($ba_bec_uploadProvided && !$ba_bec_upload['success']) {
        http_response_code(400);
        exit($ba_bec_upload['error']);
    }
    $ba_bec_uploaded_photo = $ba_bec_upload['success'] ? '/src/uploads/' . $ba_bec_upload['path'] : null;

    if ($ba_bec_uploaded_photo !== null) {
        $ba_bec_photo = $ba_bec_uploaded_photo;
    }

    if ($ba_bec_current && $ba_bec_lib !== '' && $ba_bec_categorie !== '' && $ba_bec_prix_adulte >= 0) {
        $ba_bec_json_couleurs = $ba_bec_parse_to_json($ba_bec_couleurs);
        $ba_bec_json_tailles = $ba_bec_parse_to_json($ba_bec_tailles);
        $ba_bec_json_photo = json_encode($ba_bec_photo !== '' ? [$ba_bec_photo] : [], JSON_UNESCAPED_UNICODE);
        $ba_bec_result = sql_update(
            'boutique',
            'libArtBoutique = ?, descArtBoutique = ?, couleursArtBoutique = ?, taillesArtBoutique = ?, prixAdulteArtBoutique = ?, prixEnfantArtBoutique = ?, urlPhotoArtBoutique = ?, categorieArtBoutique = ?',
            'numArtBoutique = ?',
            [$ba_bec_lib, $ba_bec_desc !== '' ? $ba_bec_desc : null, $ba_bec_json_couleurs, $ba_bec_json_tailles, number_format($ba_bec_prix_adulte, 2, '.', ''), $ba_bec_prix_enfant !== null ? number_format($ba_bec_prix_enfant, 2, '.', '') : null, $ba_bec_json_photo, $ba_bec_categorie, $ba_bec_num]
        );
        if (!$ba_bec_result['success'] && $ba_bec_uploaded_photo !== null) {
            delete_uploaded_file($ba_bec_uploaded_photo);
        } elseif ($ba_bec_result['success'] && $ba_bec_uploaded_photo !== null && $ba_bec_current) {
            $ba_bec_oldImages = json_decode((string) $ba_bec_current['urlPhotoArtBoutique'], true);
            $ba_bec_oldImage = is_array($ba_bec_oldImages)
                ? (string) ($ba_bec_oldImages[0] ?? '')
                : (string) $ba_bec_current['urlPhotoArtBoutique'];
            if ($ba_bec_oldImage !== '') {
                delete_uploaded_file($ba_bec_oldImage);
            }
        }
    } elseif ($ba_bec_uploaded_photo !== null) {
        delete_uploaded_file($ba_bec_uploaded_photo);
    }

    header('Location: ../../views/backend/boutique/list.php');
    exit();
}
