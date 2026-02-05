<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_numMotCle = ctrlSaisies($_POST['numMotCle']);
$ba_bec_libMotCle = ctrlSaisies($_POST['libMotCle']);

//sql_delete('STATUT', "numMotCle = $numMotCle");
$ba_bec_result = sql_update(table: 'MOTCLE', attributs: 'libMotCle = "'.$ba_bec_libMotCle.'"' , where: "numMotCle = $ba_bec_numMotCle");
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header(header: 'Location: ../../views/backend/keywords/list.php');
