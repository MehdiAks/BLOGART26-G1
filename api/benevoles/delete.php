<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numPersonnel = ctrlSaisies($_POST['numPersonnel'] ?? '');

    if ($ba_bec_numPersonnel !== '') {
        sql_delete('PERSONNEL', "numPersonnel = '$ba_bec_numPersonnel'");
    }

    header('Location: ../../views/backend/benevoles/list.php');
    exit();
}

?>