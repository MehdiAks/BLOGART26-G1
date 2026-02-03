<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libThem = ctrlSaisies($_POST['libThem']);

sql_insert('THEMATIQUE', 'libThem', "'$ba_bec_libThem'");


header('Location: ../../views/backend/thematiques/list.php');