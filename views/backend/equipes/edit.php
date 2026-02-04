<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if (!isset($_GET['numEquipe'])) {
    header('Location: ' . ROOT_URL . '/views/backend/equipes/list.php');
    exit();
}

$ba_bec_numEquipe = $_GET['numEquipe'];
$ba_bec_equipe = sql_select('EQUIPE', '*', "numEquipe = '$ba_bec_numEquipe'");
$ba_bec_equipe = $ba_bec_equipe[0] ?? null;

if (!$ba_bec_equipe) {
    header('Location: ' . ROOT_URL . '/views/backend/equipes/list.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Modifier une équipe</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/equipes/update.php'; ?>" method="post">
                <input type="hidden" name="numEquipe" value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" />
                <div class="form-group">
                    <label for="libEquipe">Nom de l'équipe</label>
                    <input id="libEquipe" name="libEquipe" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_equipe['libEquipe']); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="categorieEquipe">Catégorie</label>
                    <input id="categorieEquipe" name="categorieEquipe" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_equipe['categorieEquipe'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="sectionEquipe">Section</label>
                    <input id="sectionEquipe" name="sectionEquipe" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_equipe['sectionEquipe'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="niveauEquipe">Niveau</label>
                    <input id="niveauEquipe" name="niveauEquipe" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_equipe['niveauEquipe'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
