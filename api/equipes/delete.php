<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numEquipe = ctrlSaisies($_POST['numEquipe'] ?? '');

    if ($ba_bec_numEquipe !== '') {
        sql_delete('EQUIPE', "numEquipe = '$ba_bec_numEquipe'");
    }

    header('Location: ../../views/backend/equipes/list.php');
    exit();
}

?>