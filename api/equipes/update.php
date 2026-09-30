<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_num = (int) ($_POST['numEquipe'] ?? 0);
$ba_bec_existing = sql_select('EQUIPE', 'photoDLequipe, photoStaff', 'numEquipe = ?', null, null, '1', [$ba_bec_num])[0] ?? null;
$ba_bec_code = ctrlSaisies($_POST['codeEquipe'] ?? '');
$ba_bec_nom = ctrlSaisies($_POST['nomEquipe'] ?? '');
$ba_bec_club = ctrlSaisies($_POST['club'] ?? '');
$ba_bec_categorie = ctrlSaisies($_POST['categorie'] ?? '');
$ba_bec_section = ctrlSaisies($_POST['section'] ?? '');
$ba_bec_niveau = ctrlSaisies($_POST['niveau'] ?? '');
$ba_bec_description = ctrlSaisies($_POST['descriptionEquipe'] ?? '');
if (!$ba_bec_existing || $ba_bec_code === '' || $ba_bec_nom === '' || $ba_bec_club === '') {
    http_response_code(400);
    exit('Équipe invalide.');
}
$ba_bec_photoEquipe = $ba_bec_existing['photoDLequipe'] ?? null;
$ba_bec_photoStaff = $ba_bec_existing['photoStaff'] ?? null;
$ba_bec_newEquipe = null;
$ba_bec_newStaff = null;
foreach (['photoDLequipe' => 'equipe', 'photoStaff' => 'staff'] as $ba_bec_key => $ba_bec_suffix) {
    if (isset($_FILES[$ba_bec_key]) && ($_FILES[$ba_bec_key]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $ba_bec_upload = upload_image($_FILES[$ba_bec_key], 'photos-equipes', $ba_bec_nom . '-' . $ba_bec_suffix);
        if (!$ba_bec_upload['success']) {
            if ($ba_bec_newEquipe) delete_uploaded_file($ba_bec_newEquipe);
            if ($ba_bec_newStaff) delete_uploaded_file($ba_bec_newStaff);
            http_response_code(400);
            exit($ba_bec_upload['error']);
        }
        if ($ba_bec_key === 'photoDLequipe') {
            $ba_bec_newEquipe = $ba_bec_upload['path'];
            $ba_bec_photoEquipe = $ba_bec_newEquipe;
        } else {
            $ba_bec_newStaff = $ba_bec_upload['path'];
            $ba_bec_photoStaff = $ba_bec_newStaff;
        }
    }
}
try {
    global $DB;
    $ba_bec_stmt = $DB->prepare('UPDATE EQUIPE SET codeEquipe = ?, nomEquipe = ?, club = ?, categorie = ?, section = ?, niveau = ?, descriptionEquipe = ?, photoDLequipe = ?, photoStaff = ? WHERE numEquipe = ?');
    $ba_bec_stmt->execute([$ba_bec_code, $ba_bec_nom, $ba_bec_club, $ba_bec_categorie !== '' ? $ba_bec_categorie : 'Non renseigné', $ba_bec_section !== '' ? $ba_bec_section : 'Non renseigné', $ba_bec_niveau !== '' ? $ba_bec_niveau : 'Non renseigné', $ba_bec_description !== '' ? $ba_bec_description : null, $ba_bec_photoEquipe, $ba_bec_photoStaff, $ba_bec_num]);
} catch (PDOException $ba_bec_exception) {
    if ($ba_bec_newEquipe) delete_uploaded_file($ba_bec_newEquipe);
    if ($ba_bec_newStaff) delete_uploaded_file($ba_bec_newStaff);
    error_log('Erreur modification équipe: ' . $ba_bec_exception->getMessage());
    http_response_code(400);
    exit('Impossible de modifier cette équipe.');
}
if ($ba_bec_newEquipe && !empty($ba_bec_existing['photoDLequipe'])) delete_uploaded_file($ba_bec_existing['photoDLequipe']);
if ($ba_bec_newStaff && !empty($ba_bec_existing['photoStaff'])) delete_uploaded_file($ba_bec_existing['photoStaff']);
header('Location: ../../views/backend/equipes/list.php');
exit();
?>
