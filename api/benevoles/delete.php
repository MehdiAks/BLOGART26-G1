<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$ba_bec_num = (int) ($_POST['numPersonnel'] ?? 0);
$ba_bec_personnel = sql_select('PERSONNEL', 'urlPhotoPersonnel', 'numPersonnel = ?', null, null, '1', [$ba_bec_num])[0] ?? null;
if ($ba_bec_personnel) {
    $ba_bec_result = sql_delete('PERSONNEL', 'numPersonnel = ?', [$ba_bec_num]);
    if ($ba_bec_result['success'] && !empty($ba_bec_personnel['urlPhotoPersonnel'])) delete_uploaded_file($ba_bec_personnel['urlPhotoPersonnel']);
}
header('Location: ../../views/backend/benevoles/list.php');
exit();
?>
