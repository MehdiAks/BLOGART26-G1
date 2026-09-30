<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

$ba_bec_numJoueur = (int) ($_POST['numJoueur'] ?? 0);
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
$ba_bec_current = sql_select('JOUEUR', 'urlPhotoJoueur', 'numJoueur = ?', null, null, '1', [$ba_bec_numJoueur])[0] ?? null;
if (!$ba_bec_current || $ba_bec_surnom === '' || $ba_bec_prenom === '' || $ba_bec_nom === '' || $ba_bec_equipe === '' || $ba_bec_poste <= 0) {
    http_response_code(400);
    exit('Les informations du joueur sont invalides.');
}
$ba_bec_photo = $ba_bec_current['urlPhotoJoueur'] ?? null;
$ba_bec_newPhoto = null;
if (isset($_FILES['photoJoueur']) && ($_FILES['photoJoueur']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
    $ba_bec_upload = upload_image($_FILES['photoJoueur'], 'photos-joueurs', $ba_bec_nom . '-' . $ba_bec_prenom);
    if (!$ba_bec_upload['success']) {
        http_response_code(400);
        exit($ba_bec_upload['error']);
    }
    $ba_bec_newPhoto = $ba_bec_upload['path'];
    $ba_bec_photo = $ba_bec_newPhoto;
}
try {
    global $DB;
    $ba_bec_stmt = $DB->prepare('UPDATE JOUEUR SET surnomJoueur = ?, prenomJoueur = ?, nomJoueur = ?, urlPhotoJoueur = ?, dateNaissance = ?, codeEquipe = ?, posteJoueur = ?, numeroMaillot = ?, dateRecrutement = ?, clubsPrecedents = ? WHERE numJoueur = ?');
    $ba_bec_stmt->execute([$ba_bec_surnom, $ba_bec_prenom, $ba_bec_nom, $ba_bec_photo, $ba_bec_naissance !== '' ? $ba_bec_naissance : null, $ba_bec_equipe, $ba_bec_poste, $ba_bec_numero !== '' ? (int) $ba_bec_numero : null, $ba_bec_recrutement !== '' ? $ba_bec_recrutement : null, $ba_bec_clubs !== '' ? $ba_bec_clubs : null, $ba_bec_numJoueur]);
} catch (PDOException $ba_bec_exception) {
    if ($ba_bec_newPhoto) {
        delete_uploaded_file($ba_bec_newPhoto);
    }
    error_log('Erreur modification joueur: ' . $ba_bec_exception->getMessage());
    http_response_code(400);
    exit('Impossible de modifier ce joueur.');
}
if ($ba_bec_newPhoto && !empty($ba_bec_current['urlPhotoJoueur'])) {
    delete_uploaded_file($ba_bec_current['urlPhotoJoueur']);
}
$ba_bec_teams = $_POST['teams'] ?? [];
$ba_bec_teams = is_array($ba_bec_teams) ? array_values(array_filter(array_map('strval', $ba_bec_teams), 'strlen')) : [];
$ba_bec_redirect = '../../views/backend/joueurs/list.php' . (!empty($ba_bec_teams) ? '?' . http_build_query(['teams' => $ba_bec_teams]) : '');
header('Location: ' . $ba_bec_redirect);
exit();
?>
