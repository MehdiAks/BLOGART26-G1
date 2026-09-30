<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_code = ctrlSaisies($_POST['codeEquipe'] ?? '');
$ba_bec_nom = ctrlSaisies($_POST['nomEquipe'] ?? '');
$ba_bec_club = ctrlSaisies($_POST['club'] ?? '');
$ba_bec_categorie = ctrlSaisies($_POST['categorie'] ?? '');
$ba_bec_section = ctrlSaisies($_POST['section'] ?? '');
$ba_bec_niveau = ctrlSaisies($_POST['niveau'] ?? '');
$ba_bec_description = ctrlSaisies($_POST['descriptionEquipe'] ?? '');
$ba_bec_errors = [];
if ($ba_bec_code === '' || $ba_bec_nom === '' || $ba_bec_club === '') $ba_bec_errors[] = 'Le code, le nom et le club sont obligatoires.';
$ba_bec_photoEquipe = null;
$ba_bec_photoStaff = null;
foreach (['photoDLequipe' => 'equipe', 'photoStaff' => 'staff'] as $ba_bec_key => $ba_bec_suffix) {
    if (isset($_FILES[$ba_bec_key]) && ($_FILES[$ba_bec_key]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $ba_bec_upload = upload_image($_FILES[$ba_bec_key], 'photos-equipes', $ba_bec_nom . '-' . $ba_bec_suffix);
        if (!$ba_bec_upload['success']) $ba_bec_errors[] = $ba_bec_upload['error'];
        elseif ($ba_bec_key === 'photoDLequipe') $ba_bec_photoEquipe = $ba_bec_upload['path'];
        else $ba_bec_photoStaff = $ba_bec_upload['path'];
    }
}
if (!empty($ba_bec_errors)) {
    if ($ba_bec_photoEquipe) delete_uploaded_file($ba_bec_photoEquipe);
    if ($ba_bec_photoStaff) delete_uploaded_file($ba_bec_photoStaff);
    http_response_code(400);
    foreach ($ba_bec_errors as $ba_bec_error) echo e($ba_bec_error) . "\n";
    exit();
}
try {
    global $DB;
    $ba_bec_stmt = $DB->prepare('INSERT INTO EQUIPE (codeEquipe, nomEquipe, club, categorie, section, niveau, descriptionEquipe, photoDLequipe, photoStaff) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $ba_bec_stmt->execute([$ba_bec_code, $ba_bec_nom, $ba_bec_club, $ba_bec_categorie !== '' ? $ba_bec_categorie : 'Non renseigné', $ba_bec_section !== '' ? $ba_bec_section : 'Non renseigné', $ba_bec_niveau !== '' ? $ba_bec_niveau : 'Non renseigné', $ba_bec_description !== '' ? $ba_bec_description : null, $ba_bec_photoEquipe, $ba_bec_photoStaff]);
} catch (PDOException $ba_bec_exception) {
    if ($ba_bec_photoEquipe) delete_uploaded_file($ba_bec_photoEquipe);
    if ($ba_bec_photoStaff) delete_uploaded_file($ba_bec_photoStaff);
    error_log('Erreur création équipe: ' . $ba_bec_exception->getMessage());
    http_response_code(400);
    exit('Impossible de créer cette équipe.');
}
header('Location: ../../views/backend/equipes/list.php');
exit();
?>
