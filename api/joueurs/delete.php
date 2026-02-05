<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numJoueur = (int) ($_POST['numJoueur'] ?? 0);

    if ($ba_bec_numJoueur > 0) {
        sql_delete('JOUEUR', "numJoueur = '$ba_bec_numJoueur'");
    }

    header('Location: ../../views/backend/joueurs/list.php');
    exit();
}
?>
