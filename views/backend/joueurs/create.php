<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/joueurs/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Ajouter un joueur</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/joueurs/create.php'; ?>" method="post">
                <div class="form-group">
                    <label for="prenomJoueur">Prénom</label>
                    <input id="prenomJoueur" name="prenomJoueur" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="nomJoueur">Nom</label>
                    <input id="nomJoueur" name="nomJoueur" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="posteJoueur">Poste</label>
                    <input id="posteJoueur" name="posteJoueur" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="urlPhotoJoueur">URL photo</label>
                    <input id="urlPhotoJoueur" name="urlPhotoJoueur" class="form-control" type="url" />
                </div>
                <div class="form-group mt-2">
                    <label for="anneeArrivee">Année d'arrivée</label>
                    <input id="anneeArrivee" name="anneeArrivee" class="form-control" type="number" min="1900" max="2100" />
                </div>
                <div class="form-group mt-2">
                    <label for="dateNaissance">Date de naissance</label>
                    <input id="dateNaissance" name="dateNaissance" class="form-control" type="date" />
                </div>
                <div class="form-group mt-2">
                    <label for="clubsPrecedents">Clubs précédents</label>
                    <textarea id="clubsPrecedents" name="clubsPrecedents" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
