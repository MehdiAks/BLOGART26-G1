<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_prenomJoueur = ctrlSaisies($_POST['prenomJoueur'] ?? '');
    $ba_bec_nomJoueur = ctrlSaisies($_POST['nomJoueur'] ?? '');
    $ba_bec_posteJoueur = ctrlSaisies($_POST['posteJoueur'] ?? '');
    $ba_bec_urlPhotoJoueur = ctrlSaisies($_POST['urlPhotoJoueur'] ?? '');
    $ba_bec_anneeArrivee = ctrlSaisies($_POST['anneeArrivee'] ?? '');
    $ba_bec_dateNaissance = ctrlSaisies($_POST['dateNaissance'] ?? '');
    $ba_bec_clubsPrecedents = ctrlSaisies($_POST['clubsPrecedents'] ?? '');

    $ba_bec_errors = [];

    if ($ba_bec_prenomJoueur === '' || $ba_bec_nomJoueur === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }

    if (empty($ba_bec_errors)) {
        $ba_bec_posteValue = $ba_bec_posteJoueur !== '' ? "'$ba_bec_posteJoueur'" : 'NULL';
        $ba_bec_photoValue = $ba_bec_urlPhotoJoueur !== '' ? "'$ba_bec_urlPhotoJoueur'" : 'NULL';
        $ba_bec_anneeValue = $ba_bec_anneeArrivee !== '' ? "'$ba_bec_anneeArrivee'" : 'NULL';
        $ba_bec_dateValue = $ba_bec_dateNaissance !== '' ? "'$ba_bec_dateNaissance'" : 'NULL';
        $ba_bec_clubsValue = $ba_bec_clubsPrecedents !== '' ? "'$ba_bec_clubsPrecedents'" : 'NULL';

        sql_insert(
            'JOUEUR',
            'prenomJoueur, nomJoueur, urlPhotoJoueur, posteJoueur, anneeArrivee, clubsPrecedents, dateNaissance',
            "'$ba_bec_prenomJoueur', '$ba_bec_nomJoueur', $ba_bec_photoValue, $ba_bec_posteValue, $ba_bec_anneeValue, $ba_bec_clubsValue, $ba_bec_dateValue"
        );
        header('Location: ../../views/backend/joueurs/list.php');
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
            <a href="<?php echo ROOT_URL . '/views/backend/joueurs/create.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
