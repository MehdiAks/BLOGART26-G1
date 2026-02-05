<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if (!isset($_GET['numPersonnel'])) {
    header('Location: ' . ROOT_URL . '/views/backend/benevoles/list.php');
    exit();
}

$ba_bec_numPersonnel = $_GET['numPersonnel'];
$ba_bec_benevole = sql_select('PERSONNEL', '*', "numPersonnel = '$ba_bec_numPersonnel'");
$ba_bec_benevole = $ba_bec_benevole[0] ?? null;

if (!$ba_bec_benevole) {
    header('Location: ' . ROOT_URL . '/views/backend/benevoles/list.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/benevoles/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Modifier un bénévole</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/benevoles/update.php'; ?>" method="post">
                <input type="hidden" name="numPersonnel" value="<?php echo htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" />
                <div class="form-group">
                    <label for="prenomPersonnel">Prénom</label>
                    <input id="prenomPersonnel" name="prenomPersonnel" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_benevole['prenomPersonnel']); ?>"
                        placeholder="Prénom (ex: Léa)" required />
                </div>
                <div class="form-group mt-2">
                    <label for="nomPersonnel">Nom</label>
                    <input id="nomPersonnel" name="nomPersonnel" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_benevole['nomPersonnel']); ?>"
                        placeholder="Nom (ex: Martin)" required />
                </div>
                <div class="form-group mt-2">
                    <label for="urlPhotoPersonnel">URL photo</label>
                    <input id="urlPhotoPersonnel" name="urlPhotoPersonnel" class="form-control" type="url"
                        value="<?php echo htmlspecialchars($ba_bec_benevole['urlPhotoPersonnel'] ?? ''); ?>"
                        placeholder="URL de la photo (https://...)" />
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
