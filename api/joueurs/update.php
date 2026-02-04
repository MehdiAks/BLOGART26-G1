<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_posteChoices = [
    'Poste 1 : meneur (point guard)',
    'Poste 2 : arrière (shooting guard)',
    'Poste 3 : ailier (small forward)',
    'Poste 4 : ailier fort (power forward)',
    'Poste 5 : pivot (center)',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_numJoueur = ctrlSaisies($_POST['numJoueur'] ?? '');
    $ba_bec_prenomJoueur = ctrlSaisies($_POST['prenomJoueur'] ?? '');
    $ba_bec_nomJoueur = ctrlSaisies($_POST['nomJoueur'] ?? '');
    $ba_bec_posteJoueur = ctrlSaisies($_POST['posteJoueur'] ?? '');
    $ba_bec_photoActuelle = ctrlSaisies($_POST['photoActuelle'] ?? '');
    $ba_bec_numeroMaillot = ctrlSaisies($_POST['numeroMaillot'] ?? '');
    $ba_bec_numEquipe = ctrlSaisies($_POST['numEquipe'] ?? '');
    $ba_bec_anneeArrivee = ctrlSaisies($_POST['anneeArrivee'] ?? '');
    $ba_bec_dateNaissance = ctrlSaisies($_POST['dateNaissance'] ?? '');
    $ba_bec_errors = [];
    $ba_bec_clubsPrecedentsInput = $_POST['clubsPrecedents'] ?? '';
    if (is_array($ba_bec_clubsPrecedentsInput)) {
        $ba_bec_clubsList = array_values(array_filter(array_map('trim', $ba_bec_clubsPrecedentsInput), 'strlen'));
        $ba_bec_clubsPrecedents = ctrlSaisies(implode("\n", $ba_bec_clubsList));
    } else {
        $ba_bec_clubsPrecedents = ctrlSaisies($ba_bec_clubsPrecedentsInput);
    }
    $ba_bec_nom_image = null;
    if (isset($_FILES['photoJoueur']) && $_FILES['photoJoueur']['error'] === 0) {
        $ba_bec_tmpName = $_FILES['photoJoueur']['tmp_name'];
        $ba_bec_name = $_FILES['photoJoueur']['name'];
        $ba_bec_size = $_FILES['photoJoueur']['size'];

        if ($ba_bec_size > 10000000) {
            $ba_bec_errors[] = "Le fichier est trop volumineux.";
        } else {
            $ba_bec_dimensions = getimagesize($ba_bec_tmpName);
            if ($ba_bec_dimensions === false) {
                $ba_bec_errors[] = "Le fichier n'est pas une image valide.";
            } else {
                $ba_bec_nom_image = time() . '_' . basename($ba_bec_name);
                $ba_bec_uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/';
                $ba_bec_destination = $ba_bec_uploadDir . $ba_bec_nom_image;
                if (!move_uploaded_file($ba_bec_tmpName, $ba_bec_destination)) {
                    $ba_bec_errors[] = "Erreur lors de l'upload de l'image.";
                }
            }
        }
    }

    if ($ba_bec_numJoueur === '' || $ba_bec_prenomJoueur === '' || $ba_bec_nomJoueur === '') {
        $ba_bec_errors[] = 'Le prénom et le nom sont obligatoires.';
    }
    if ($ba_bec_numEquipe === '' || !is_numeric($ba_bec_numEquipe)) {
        $ba_bec_errors[] = 'Veuillez sélectionner une équipe valide.';
    }
    if ($ba_bec_posteJoueur !== '' && !in_array($ba_bec_posteJoueur, $ba_bec_posteChoices, true)) {
        $ba_bec_errors[] = 'Veuillez sélectionner un poste valide.';
    }

    if (empty($ba_bec_errors)) {
        $ba_bec_posteValue = $ba_bec_posteJoueur !== '' ? "'$ba_bec_posteJoueur'" : 'NULL';
        $ba_bec_photoFinale = $ba_bec_nom_image !== null ? $ba_bec_nom_image : $ba_bec_photoActuelle;
        $ba_bec_photoValue = $ba_bec_photoFinale !== '' ? "'$ba_bec_photoFinale'" : 'NULL';
        $ba_bec_numeroValue = $ba_bec_numeroMaillot !== '' ? "'$ba_bec_numeroMaillot'" : 'NULL';
        $ba_bec_anneeValue = $ba_bec_anneeArrivee !== '' ? "'$ba_bec_anneeArrivee'" : 'NULL';
        $ba_bec_dateValue = $ba_bec_dateNaissance !== '' ? "'$ba_bec_dateNaissance'" : 'NULL';
        $ba_bec_clubsValue = $ba_bec_clubsPrecedents !== '' ? "'$ba_bec_clubsPrecedents'" : 'NULL';

        $ba_bec_updates = "prenomJoueur = '$ba_bec_prenomJoueur', nomJoueur = '$ba_bec_nomJoueur', urlPhotoJoueur = $ba_bec_photoValue, posteJoueur = $ba_bec_posteValue, numMaillot = $ba_bec_numeroValue, anneeArrivee = $ba_bec_anneeValue, clubsPrecedents = $ba_bec_clubsValue, dateNaissance = $ba_bec_dateValue";
        sql_update('JOUEUR', $ba_bec_updates, "numJoueur = '$ba_bec_numJoueur'");
        sql_delete('EQUIPE_JOUEUR', "numJoueur = '$ba_bec_numJoueur'");
        if ($ba_bec_numEquipe !== '' && is_numeric($ba_bec_numEquipe)) {
            sql_insert('EQUIPE_JOUEUR', 'numEquipe, numJoueur', "'$ba_bec_numEquipe', '$ba_bec_numJoueur'");
        }
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
            <a href="<?php echo ROOT_URL . '/views/backend/joueurs/list.php'; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
