<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numJoueur = ctrlSaisies($_POST['numJoueur'] ?? '');

    if ($ba_bec_numJoueur !== '') {
        sql_delete('JOUEUR', "numJoueur = '$ba_bec_numJoueur'");
    }

    header('Location: ../../views/backend/joueurs/list.php');
    exit();
}
