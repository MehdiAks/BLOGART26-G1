<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numPersonnel = ctrlSaisies($_POST['numPersonnel'] ?? '');
    $ba_bec_prenomPersonnel = ctrlSaisies($_POST['prenomPersonnel'] ?? '');
    $ba_bec_nomPersonnel = ctrlSaisies($_POST['nomPersonnel'] ?? '');
    $ba_bec_urlPhotoPersonnel = ctrlSaisies($_POST['urlPhotoPersonnel'] ?? '');
    $ba_bec_estCoach = !empty($_POST['estCoach']) ? 1 : 0;
    $ba_bec_numEquipeCoachee = ctrlSaisies($_POST['numEquipeCoachee'] ?? '');
    $ba_bec_estDirection = !empty($_POST['estDirection']) ? 1 : 0;
    $ba_bec_estCommissionTechnique = !empty($_POST['estCommissionTechnique']) ? 1 : 0;
    $ba_bec_estCommissionAnimation = !empty($_POST['estCommissionAnimation']) ? 1 : 0;
    $ba_bec_estCommissionCommunication = !empty($_POST['estCommissionCommunication']) ? 1 : 0;

    $ba_bec_errors = [];

    if ($ba_bec_numPersonnel === '' || $ba_bec_prenomPersonnel === '' || $ba_bec_nomPersonnel === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }

    if ($ba_bec_estCoach && $ba_bec_numEquipeCoachee === '') {
        $ba_bec_errors[] = 'Veuillez sélectionner une équipe coachée.';
    }

    if (empty($ba_bec_errors)) {
        if ($ba_bec_estCoach) {
            $ba_bec_estCommissionTechnique = 1;
        }
        $ba_bec_photoValue = $ba_bec_urlPhotoPersonnel !== '' ? "'$ba_bec_urlPhotoPersonnel'" : 'NULL';
        $ba_bec_equipeValue = $ba_bec_numEquipeCoachee !== '' ? "'" . (int) $ba_bec_numEquipeCoachee . "'" : 'NULL';
        if (!$ba_bec_estCoach) {
            $ba_bec_equipeValue = 'NULL';
        }
        $ba_bec_updates = "prenomPersonnel = '$ba_bec_prenomPersonnel', nomPersonnel = '$ba_bec_nomPersonnel', urlPhotoPersonnel = $ba_bec_photoValue, estCoach = '$ba_bec_estCoach', numEquipeCoachee = $ba_bec_equipeValue, estDirection = '$ba_bec_estDirection', estCommissionTechnique = '$ba_bec_estCommissionTechnique', estCommissionAnimation = '$ba_bec_estCommissionAnimation', estCommissionCommunication = '$ba_bec_estCommissionCommunication'";
        sql_update('PERSONNEL', $ba_bec_updates, "numPersonnel = '$ba_bec_numPersonnel'");
        header('Location: ../../views/backend/benevoles/list.php');
        exit();
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($ba_bec_errors ?? [])): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($ba_bec_errors as $ba_bec_error): ?>
                            <li><?= $ba_bec_error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <a href="<?php echo ROOT_URL . '/views/backend/benevoles/list.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
