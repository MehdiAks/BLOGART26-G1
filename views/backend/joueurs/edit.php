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
            <h1>Modifier un joueur</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/joueurs/update.php'; ?>" method="post">
                <input type="hidden" name="numJoueur" value="<?php echo htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" />
                <div class="form-group">
                    <label for="prenomJoueur">Prénom</label>
                    <input id="prenomJoueur" name="prenomJoueur" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['prenomJoueur']); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="nomJoueur">Nom</label>
                    <input id="nomJoueur" name="nomJoueur" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['nomJoueur']); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="posteJoueur">Poste</label>
                    <input id="posteJoueur" name="posteJoueur" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['posteJoueur'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="urlPhotoJoueur">URL photo</label>
                    <input id="urlPhotoJoueur" name="urlPhotoJoueur" class="form-control" type="url" value="<?php echo htmlspecialchars($ba_bec_joueur['urlPhotoJoueur'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="anneeArrivee">Année d'arrivée</label>
                    <input id="anneeArrivee" name="anneeArrivee" class="form-control" type="number" min="1900" max="2100" value="<?php echo htmlspecialchars($ba_bec_joueur['anneeArrivee'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="dateNaissance">Date de naissance</label>
                    <input id="dateNaissance" name="dateNaissance" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_joueur['dateNaissance'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2">
                    <label for="clubsPrecedents">Clubs précédents</label>
                    <textarea id="clubsPrecedents" name="clubsPrecedents" class="form-control" rows="3"><?php echo htmlspecialchars($ba_bec_joueur['clubsPrecedents'] ?? ''); ?></textarea>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
