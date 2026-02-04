<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_libEquipe = ctrlSaisies($_POST['libEquipe'] ?? '');
    $ba_bec_categorieEquipe = ctrlSaisies($_POST['categorieEquipe'] ?? '');
    $ba_bec_sectionEquipe = ctrlSaisies($_POST['sectionEquipe'] ?? '');
    $ba_bec_niveauEquipe = ctrlSaisies($_POST['niveauEquipe'] ?? '');

    $ba_bec_errors = [];

    if ($ba_bec_libEquipe === '') {
        $ba_bec_errors[] = 'Le nom de l\'équipe est obligatoire.';
    }

    if (empty($ba_bec_errors)) {
        $ba_bec_categorieValue = $ba_bec_categorieEquipe !== '' ? "'$ba_bec_categorieEquipe'" : 'NULL';
        $ba_bec_sectionValue = $ba_bec_sectionEquipe !== '' ? "'$ba_bec_sectionEquipe'" : 'NULL';
        $ba_bec_niveauValue = $ba_bec_niveauEquipe !== '' ? "'$ba_bec_niveauEquipe'" : 'NULL';

        sql_insert(
            'EQUIPE',
            'libEquipe, categorieEquipe, sectionEquipe, niveauEquipe',
            "'$ba_bec_libEquipe', $ba_bec_categorieValue, $ba_bec_sectionValue, $ba_bec_niveauValue"
        );
        header('Location: ../../views/backend/equipes/list.php');
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
            <a href="<?php echo ROOT_URL . '/views/backend/equipes/create.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
