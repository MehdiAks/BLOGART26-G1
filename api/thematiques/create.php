<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libThem = ctrlSaisies($_POST['libThem'] ?? '');

if ($ba_bec_libThem === '') {
    http_response_code(400);
    echo "Le libellé de la thématique est requis.";
    exit;
}

$ba_bec_result = sql_insert('THEMATIQUE', 'libThem', "'$ba_bec_libThem'");
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header('Location: ../../views/backend/thematiques/list.php');
