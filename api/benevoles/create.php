<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_prenomPersonnel = ctrlSaisies($_POST['prenomPersonnel'] ?? '');
    $ba_bec_nomPersonnel = ctrlSaisies($_POST['nomPersonnel'] ?? '');
    $ba_bec_urlPhotoPersonnel = ctrlSaisies($_POST['urlPhotoPersonnel'] ?? '');

    $ba_bec_errors = [];

    if ($ba_bec_prenomPersonnel === '' || $ba_bec_nomPersonnel === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }

    if (empty($ba_bec_errors)) {
        $ba_bec_currentMax = sql_select('PERSONNEL', 'MAX(numPersonnel) AS maxPersonnel');
        $ba_bec_nextNumPersonnel = 1;
        if (!empty($ba_bec_currentMax) && isset($ba_bec_currentMax[0]['maxPersonnel'])) {
            $ba_bec_nextNumPersonnel = (int) $ba_bec_currentMax[0]['maxPersonnel'] + 1;
        }
        $ba_bec_photoValue = $ba_bec_urlPhotoPersonnel !== '' ? "'$ba_bec_urlPhotoPersonnel'" : 'NULL';
        sql_insert(
            'PERSONNEL',
            'numPersonnel, prenomPersonnel, nomPersonnel, urlPhotoPersonnel',
            "'$ba_bec_nextNumPersonnel', '$ba_bec_prenomPersonnel', '$ba_bec_nomPersonnel', $ba_bec_photoValue"
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
