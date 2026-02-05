<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numStat = ctrlSaisies($_POST['numStat']);

// Vérifie si le statut est utilisé
$ba_bec_countnumStat = sql_select("MEMBRE", "COUNT(*) AS total", "numStat = $ba_bec_numStat")[0]['total'];

if ($ba_bec_countnumStat > 0) {
    // Redirection avec message d'erreur
    flash_delete_impossible();
    header('Location: ../../views/backend/statuts/list.php');
    exit;
}

// Si le statut n'est pas utilisé, suppression
$ba_bec_result = sql_delete('STATUT', "numStat = $ba_bec_numStat");
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header('Location: ../../views/backend/statuts/list.php');
exit;

?>
