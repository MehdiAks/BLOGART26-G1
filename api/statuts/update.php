<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numStat = ctrlSaisies($_POST['numStat']);
$ba_bec_libStat = ctrlSaisies($_POST['libStat']);

//sql_delete('STATUT', "numStat = $numStat");
$ba_bec_result = sql_update(table: 'STATUT', attributs: 'libStat = "'.$ba_bec_libStat.'"' , where: "numStat = $ba_bec_numStat");
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header(header: 'Location: ../../views/backend/statuts/list.php');

?>