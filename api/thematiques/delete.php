<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numThem = ctrlSaisies($_POST['numThem']);

// Vérifie si le statut est utilisé
$ba_bec_countnumThem = sql_select("ARTICLE", "COUNT(*) AS total", "numThem = $ba_bec_numThem")[0]['total'];
if ($ba_bec_countnumThem > 0) {
    // Redirection avec message d'erreur
    flash_delete_impossible();
    header('Location: ../../views/backend/thematiques/list.php');
    exit;
}

// Si le statut n'est pas utilisé, suppression
$ba_bec_result = sql_delete('THEMATIQUE', "numThem = $ba_bec_numThem");
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header('Location: ../../views/backend/thematiques/list.php');
exit;

?>
