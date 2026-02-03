<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numMotCle = ctrlSaisies($_POST['numMotCle']);

// Vérifie si le statut est utilisé
$ba_bec_countnumMotCle = sql_select("MOTCLEARTICLE", "COUNT(*) AS total", "numMotCle = $ba_bec_numMotCle")[0]['total'];

if ($ba_bec_countnumMotCle > 0) {
    // Redirection avec message d'erreur
    header('Location: ../../views/backend/keywords/list.php?error=used');
    exit;
}

// Si le statut n'est pas utilisé, suppression
sql_delete('MOTCLE', "numMotCle = $ba_bec_numMotCle");

header('Location: ../../views/backend/keywords/list.php?success=deleted');
exit;

?>