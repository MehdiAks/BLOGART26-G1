<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

$ba_bec_joueur = null;
if (isset($_GET['numJoueur'])) {
    $ba_bec_numJoueur = (int) $_GET['numJoueur'];
    $ba_bec_joueur = sql_select('JOUEUR', '*', "numJoueur = '$ba_bec_numJoueur'");
    $ba_bec_joueur = $ba_bec_joueur[0] ?? null;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression joueur</h1>
        </div>
        <div class="col-md-12">
            <?php if ($ba_bec_joueur) : ?>
                <form action="<?php echo ROOT_URL . '/api/joueurs/delete.php' ?>" method="post">
                    <div class="form-group">
                        <label for="numJoueur">ID joueur</label>
                        <input id="numJoueur" name="numJoueur" class="form-control" type="text" value="<?php echo $ba_bec_joueur['numJoueur']; ?>" readonly />
                    </div>
                    <div class="form-group mt-2">
                        <label for="summary">Nom</label>
                        <input id="summary" name="summary" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['prenomJoueur'] . ' ' . $ba_bec_joueur['nomJoueur']); ?>" readonly />
                    </div>
                    <br />
                    <div class="form-group mt-2">
                        <a href="list.php" class="btn btn-primary">Retour à la liste</a>
                        <button type="submit" class="btn btn-danger">Confirmer delete ?</button>
                    </div>
                </form>
            <?php else : ?>
                <div class="alert alert-danger">Joueur introuvable.</div>
                <a href="list.php" class="btn btn-primary">Retour</a>
            <?php endif; ?>
        </div>
    </div>
</div>
