<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Ajouter une équipe</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/equipes/create.php'; ?>" method="post">
                <div class="form-group">
                    <label for="libEquipe">Nom de l'équipe</label>
                    <input id="libEquipe" name="libEquipe" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="categorieEquipe">Catégorie</label>
                    <input id="categorieEquipe" name="categorieEquipe" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="sectionEquipe">Section</label>
                    <input id="sectionEquipe" name="sectionEquipe" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="niveauEquipe">Niveau</label>
                    <input id="niveauEquipe" name="niveauEquipe" class="form-control" type="text" />
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
