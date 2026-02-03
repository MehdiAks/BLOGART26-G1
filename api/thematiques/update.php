<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numThem = ctrlSaisies($_POST['numThem']);
$ba_bec_libThem = ctrlSaisies($_POST['libThem']);

//sql_delete('STATUT', "numStat = $numStat");
sql_update(table: 'THEMATIQUE', attributs: 'libThem = "'.$ba_bec_libThem.'"' , where: "numThem = $ba_bec_numThem");


header(header: 'Location: ../../views/backend/thematiques/list.php');
