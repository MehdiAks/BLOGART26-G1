<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$ba_bec_num = (int) ($_POST['numEquipe'] ?? 0);
$ba_bec_team = sql_select('EQUIPE', 'photoDLequipe, photoStaff', 'numEquipe = ?', null, null, '1', [$ba_bec_num])[0] ?? null;
$ba_bec_result = $ba_bec_team ? sql_delete('EQUIPE', 'numEquipe = ?', [$ba_bec_num]) : ['success' => false];
if ($ba_bec_result['success']) {
    if (!empty($ba_bec_team['photoDLequipe'])) delete_uploaded_file($ba_bec_team['photoDLequipe']);
    if (!empty($ba_bec_team['photoStaff'])) delete_uploaded_file($ba_bec_team['photoStaff']);
    flash_success();
} elseif (!empty($ba_bec_result['constraint'])) {
    flash_delete_impossible('Suppression impossible : cette équipe est utilisée dans d’autres tables.');
} else {
    flash_error();
}
header('Location: ../../views/backend/equipes/list.php');
exit();
?>
