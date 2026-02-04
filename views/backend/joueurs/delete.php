<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if (!isset($_GET['numJoueur'])) {
    header('Location: ' . ROOT_URL . '/views/backend/joueurs/list.php');
    exit();
}

$ba_bec_numJoueur = $_GET['numJoueur'];
$ba_bec_joueur = sql_select('JOUEUR', '*', "numJoueur = '$ba_bec_numJoueur'");
$ba_bec_joueur = $ba_bec_joueur[0] ?? null;

if (!$ba_bec_joueur) {
    header('Location: ' . ROOT_URL . '/views/backend/joueurs/list.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/joueurs/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Supprimer un joueur</h1>
            <p>Confirmez la suppression de <?php echo htmlspecialchars($ba_bec_joueur['prenomJoueur'] . ' ' . $ba_bec_joueur['nomJoueur']); ?>.</p>
            <form action="<?php echo ROOT_URL . '/api/joueurs/delete.php'; ?>" method="post">
                <input type="hidden" name="numJoueur" value="<?php echo htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" />
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
    </div>
</div>
