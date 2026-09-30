<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$ba_bec_numJoueur = (int) ($_POST['numJoueur'] ?? 0);
$ba_bec_joueur = sql_select('JOUEUR', 'urlPhotoJoueur', 'numJoueur = ?', null, null, '1', [$ba_bec_numJoueur])[0] ?? null;
if ($ba_bec_joueur) {
    $ba_bec_result = sql_delete('JOUEUR', 'numJoueur = ?', [$ba_bec_numJoueur]);
    if ($ba_bec_result['success'] && !empty($ba_bec_joueur['urlPhotoJoueur'])) {
        delete_uploaded_file($ba_bec_joueur['urlPhotoJoueur']);
    }
}
header('Location: ../../views/backend/joueurs/list.php');
exit();
?>
