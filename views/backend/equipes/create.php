<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

$ba_bec_clubs = sql_select('CLUB', 'nomClub', null, null, 'nomClub ASC');
$ba_bec_categories = sql_select('CATEGORIE_EQUIPE', 'libCategorie', null, null, 'libCategorie ASC');
$ba_bec_sections = sql_select('SECTION_EQUIPE', 'libSection', null, null, 'libSection ASC');
$ba_bec_niveaux = sql_select('NIVEAU_EQUIPE', 'libNiveau', null, null, 'libNiveau ASC');
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
                    <label for="codeEquipe">Code équipe</label>
                    <input id="codeEquipe" name="codeEquipe" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="libEquipe">Nom court</label>
                    <input id="libEquipe" name="libEquipe" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="libEquipeComplet">Nom complet</label>
                    <input id="libEquipeComplet" name="libEquipeComplet" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="nomClub">Club</label>
                    <input id="nomClub" name="nomClub" class="form-control" type="text" list="clubList" required />
                    <datalist id="clubList">
                        <?php foreach ($ba_bec_clubs as $ba_bec_club): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_club['nomClub']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="categorieEquipe">Catégorie</label>
                    <input id="categorieEquipe" name="categorieEquipe" class="form-control" type="text" list="categorieList" />
                    <datalist id="categorieList">
                        <?php foreach ($ba_bec_categories as $ba_bec_categorie): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_categorie['libCategorie']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="sectionEquipe">Section</label>
                    <input id="sectionEquipe" name="sectionEquipe" class="form-control" type="text" list="sectionList" />
                    <datalist id="sectionList">
                        <?php foreach ($ba_bec_sections as $ba_bec_section): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_section['libSection']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="niveauEquipe">Niveau</label>
                    <input id="niveauEquipe" name="niveauEquipe" class="form-control" type="text" list="niveauList" />
                    <datalist id="niveauList">
                        <?php foreach ($ba_bec_niveaux as $ba_bec_niveau): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_niveau['libNiveau']); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group mt-2">
                    <label for="descriptionEquipe">Description</label>
                    <textarea id="descriptionEquipe" name="descriptionEquipe" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
