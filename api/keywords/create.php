<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libMotCle = ctrlSaisies($_POST['libMotCle'] ?? '');

if ($ba_bec_libMotCle === '') {
    http_response_code(400);
    echo "Le nom du mot-clé est requis.";
    exit;
}

$ba_bec_nextNumMotCle = sql_select('MOTCLE', 'COALESCE(MAX(numMotCle), 0) + 1 AS nextNumMotCle');
$ba_bec_numMotCle = $ba_bec_nextNumMotCle[0]['nextNumMotCle'];

$ba_bec_result = sql_insert('MOTCLE', 'numMotCle, libMotCle', "$ba_bec_numMotCle, '$ba_bec_libMotCle'");
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header('Location: ../../views/backend/keywords/list.php');

?>