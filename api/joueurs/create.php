<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_surnom = ctrlSaisies($_POST['surnomJoueur'] ?? '');
$ba_bec_prenom = ctrlSaisies($_POST['prenomJoueur'] ?? '');
$ba_bec_nom = ctrlSaisies($_POST['nomJoueur'] ?? '');
$ba_bec_equipe = ctrlSaisies($_POST['codeEquipe'] ?? '');
$ba_bec_poste = (int) ($_POST['posteJoueur'] ?? 0);
$ba_bec_numero = trim((string) ($_POST['numeroMaillot'] ?? ''));
$ba_bec_naissance = ctrlSaisies($_POST['dateNaissance'] ?? '');
$ba_bec_recrutement = ctrlSaisies($_POST['dateRecrutement'] ?? '');
$ba_bec_clubs = $_POST['clubsPrecedents'] ?? '';
$ba_bec_clubs = is_array($ba_bec_clubs) ? implode(', ', array_filter(array_map('trim', $ba_bec_clubs), 'strlen')) : trim((string) $ba_bec_clubs);
$ba_bec_clubs = ctrlSaisies($ba_bec_clubs);
$ba_bec_errors = [];
if ($ba_bec_surnom === '' || $ba_bec_prenom === '' || $ba_bec_nom === '' || $ba_bec_equipe === '' || $ba_bec_poste <= 0) {
    $ba_bec_errors[] = 'Les informations obligatoires du joueur sont incomplètes.';
}
$ba_bec_photo = null;
if (isset($_FILES['photoJoueur']) && ($_FILES['photoJoueur']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
    $ba_bec_upload = upload_image($_FILES['photoJoueur'], 'photos-joueurs', $ba_bec_nom . '-' . $ba_bec_prenom);
    if ($ba_bec_upload['success']) {
        $ba_bec_photo = $ba_bec_upload['path'];
    } else {
        $ba_bec_errors[] = $ba_bec_upload['error'];
    }
}
if (empty($ba_bec_errors)) {
    try {
        global $DB;
        $ba_bec_stmt = $DB->prepare('INSERT INTO JOUEUR (surnomJoueur, prenomJoueur, nomJoueur, urlPhotoJoueur, dateNaissance, codeEquipe, posteJoueur, numeroMaillot, dateRecrutement, clubsPrecedents) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $ba_bec_stmt->execute([$ba_bec_surnom, $ba_bec_prenom, $ba_bec_nom, $ba_bec_photo, $ba_bec_naissance !== '' ? $ba_bec_naissance : null, $ba_bec_equipe, $ba_bec_poste, $ba_bec_numero !== '' ? (int) $ba_bec_numero : null, $ba_bec_recrutement !== '' ? $ba_bec_recrutement : null, $ba_bec_clubs !== '' ? $ba_bec_clubs : null]);
    } catch (PDOException $ba_bec_exception) {
        if ($ba_bec_photo) {
            delete_uploaded_file($ba_bec_photo);
        }
        error_log('Erreur création joueur: ' . $ba_bec_exception->getMessage());
        http_response_code(400);
        exit('Impossible de créer ce joueur.');
    }
    header('Location: ../../views/backend/joueurs/list.php');
    exit();
}
http_response_code(400);
if ($ba_bec_photo) {
    delete_uploaded_file($ba_bec_photo);
}
foreach ($ba_bec_errors as $ba_bec_error) {
    echo e($ba_bec_error) . "\n";
}
?>
