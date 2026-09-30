<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_num = (int) ($_POST['numPersonnel'] ?? 0);
$ba_bec_existing = sql_select('PERSONNEL', 'urlPhotoPersonnel', 'numPersonnel = ?', null, null, '1', [$ba_bec_num])[0] ?? null;
$ba_bec_prenom = ctrlSaisies($_POST['prenomPersonnel'] ?? '');
$ba_bec_nom = ctrlSaisies($_POST['nomPersonnel'] ?? '');
$ba_bec_staff = !empty($_POST['estStaffEquipe']) ? 1 : 0;
$ba_bec_equipe = ctrlSaisies($_POST['numEquipeStaff'] ?? '');
$ba_bec_role = ctrlSaisies($_POST['roleStaffEquipe'] ?? '');
$ba_bec_direction = !empty($_POST['estDirection']) ? 1 : 0;
$ba_bec_posteDirection = ctrlSaisies($_POST['posteDirection'] ?? '');
$ba_bec_technique = !empty($_POST['estCommissionTechnique']) || $ba_bec_staff ? 1 : 0;
$ba_bec_posteTechnique = ctrlSaisies($_POST['posteCommissionTechnique'] ?? '');
$ba_bec_animation = !empty($_POST['estCommissionAnimation']) ? 1 : 0;
$ba_bec_posteAnimation = ctrlSaisies($_POST['posteCommissionAnimation'] ?? '');
$ba_bec_communication = !empty($_POST['estCommissionCommunication']) ? 1 : 0;
$ba_bec_posteCommunication = ctrlSaisies($_POST['posteCommissionCommunication'] ?? '');
$ba_bec_errors = [];
if (!$ba_bec_existing || $ba_bec_prenom === '' || $ba_bec_nom === '') $ba_bec_errors[] = 'Bénévole invalide.';
if ($ba_bec_staff && ($ba_bec_equipe === '' || $ba_bec_role === '')) $ba_bec_errors[] = 'L’équipe et le rôle sont obligatoires pour le staff.';
if ($ba_bec_direction && $ba_bec_posteDirection === '') $ba_bec_errors[] = 'Le poste en direction est obligatoire.';
if ($ba_bec_technique && !$ba_bec_staff && $ba_bec_posteTechnique === '') $ba_bec_errors[] = 'Le poste en commission technique est obligatoire.';
if ($ba_bec_animation && $ba_bec_posteAnimation === '') $ba_bec_errors[] = 'Le poste en commission animation est obligatoire.';
if ($ba_bec_communication && $ba_bec_posteCommunication === '') $ba_bec_errors[] = 'Le poste en commission communication est obligatoire.';
if ($ba_bec_errors) {
    http_response_code(400);
    foreach ($ba_bec_errors as $ba_bec_error) echo e($ba_bec_error) . "\n";
    exit();
}
$ba_bec_photo = $ba_bec_existing['urlPhotoPersonnel'] ?? null;
$ba_bec_newPhoto = null;
if (isset($_FILES['photoPersonnel']) && ($_FILES['photoPersonnel']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
    $ba_bec_upload = upload_image($_FILES['photoPersonnel'], 'photos-benevoles', $ba_bec_nom . '-' . $ba_bec_prenom);
    if (!$ba_bec_upload['success']) {
        http_response_code(400);
        exit($ba_bec_upload['error']);
    }
    $ba_bec_newPhoto = '/src/uploads/' . $ba_bec_upload['path'];
    $ba_bec_photo = $ba_bec_newPhoto;
}
$ba_bec_result = sql_update(
    'PERSONNEL',
    'prenomPersonnel = ?, nomPersonnel = ?, urlPhotoPersonnel = ?, estStaffEquipe = ?, numEquipeStaff = ?, roleStaffEquipe = ?, estDirection = ?, posteDirection = ?, estCommissionTechnique = ?, posteCommissionTechnique = ?, estCommissionAnimation = ?, posteCommissionAnimation = ?, estCommissionCommunication = ?, posteCommissionCommunication = ?',
    'numPersonnel = ?',
    [$ba_bec_prenom, $ba_bec_nom, $ba_bec_photo, $ba_bec_staff, $ba_bec_staff ? $ba_bec_equipe : null, $ba_bec_staff ? $ba_bec_role : null, $ba_bec_direction, $ba_bec_direction ? $ba_bec_posteDirection : null, $ba_bec_technique, $ba_bec_technique ? $ba_bec_posteTechnique : null, $ba_bec_animation, $ba_bec_animation ? $ba_bec_posteAnimation : null, $ba_bec_communication, $ba_bec_communication ? $ba_bec_posteCommunication : null, $ba_bec_num]
);
if ($ba_bec_newPhoto && $ba_bec_result['success'] && !empty($ba_bec_existing['urlPhotoPersonnel'])) delete_uploaded_file($ba_bec_existing['urlPhotoPersonnel']);
if ($ba_bec_newPhoto && !$ba_bec_result['success']) delete_uploaded_file($ba_bec_newPhoto);
$ba_bec_result['success'] ? flash_success() : flash_error();
header('Location: ../../views/backend/benevoles/list.php');
exit();
?>
