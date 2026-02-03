<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numCom = ctrlSaisies($_POST['numCom']);

sql_delete('comment', "numCom = $ba_bec_numCom");


header('Location: ../../views/backend/comments/list.php'); 
