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
            <h1>Supprimer une équipe</h1>
            <p>Confirmez la suppression de <?php echo htmlspecialchars($ba_bec_equipe['libEquipe']); ?>.</p>
            <form action="<?php echo ROOT_URL . '/api/equipes/delete.php'; ?>" method="post">
                <input type="hidden" name="numEquipe" value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" />
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
    </div>
</div>
