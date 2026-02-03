<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libMotCle = ctrlSaisies($_POST['libMotCle']);

sql_insert('MOTCLE', 'libMotCle', "'$ba_bec_libMotCle'");


header('Location: ../../views/backend/keywords/list.php');