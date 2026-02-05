<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if ($ba_bec_prenomPersonnel === '' || $ba_bec_nomPersonnel === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }

    if ($ba_bec_estCoach && $ba_bec_numEquipeCoachee === '') {
        $ba_bec_errors[] = 'Veuillez sélectionner une équipe coachée.';
    }

    if (empty($ba_bec_errors)) {
        if ($ba_bec_estCoach) {
            $ba_bec_estCommissionTechnique = 1;
        }
        $ba_bec_currentMax = sql_select('PERSONNEL', 'MAX(numPersonnel) AS maxPersonnel');
        $ba_bec_nextNumPersonnel = 1;
        if (!empty($ba_bec_currentMax) && isset($ba_bec_currentMax[0]['maxPersonnel'])) {
            $ba_bec_nextNumPersonnel = (int) $ba_bec_currentMax[0]['maxPersonnel'] + 1;
        }
        $ba_bec_photoValue = $ba_bec_urlPhotoPersonnel !== '' ? "'$ba_bec_urlPhotoPersonnel'" : 'NULL';
        $ba_bec_equipeValue = $ba_bec_numEquipeCoachee !== '' ? "'" . (int) $ba_bec_numEquipeCoachee . "'" : 'NULL';
        if (!$ba_bec_estCoach) {
            $ba_bec_equipeValue = 'NULL';
        }
        sql_insert(
            'PERSONNEL',
            'numPersonnel, prenomPersonnel, nomPersonnel, urlPhotoPersonnel, estCoach, numEquipeCoachee, estDirection, estCommissionTechnique, estCommissionAnimation, estCommissionCommunication',
            "'$ba_bec_nextNumPersonnel', '$ba_bec_prenomPersonnel', '$ba_bec_nomPersonnel', $ba_bec_photoValue, '$ba_bec_estCoach', $ba_bec_equipeValue, '$ba_bec_estDirection', '$ba_bec_estCommissionTechnique', '$ba_bec_estCommissionAnimation', '$ba_bec_estCommissionCommunication'"
        );
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
            <a href="<?php echo ROOT_URL . '/views/backend/benevoles/create.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
