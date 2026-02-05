<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numEquipe = (int) ($_POST['numEquipe'] ?? 0);

    if ($ba_bec_numEquipe > 0) {
        sql_delete('EQUIPE', "numEquipe = '$ba_bec_numEquipe'");
    }

    header('Location: ../../views/backend/equipes/list.php');
    exit();
}
?>
