<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

$ba_bec_teams = sql_select('EQUIPE', 'numEquipe, libEquipe', null, null, 'libEquipe ASC');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/benevoles/list.php'; ?>" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
            <h1>Ajouter un bénévole</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/benevoles/create.php'; ?>" method="post">
                <div class="form-group">
                    <label for="prenomPersonnel">Prénom</label>
                    <input id="prenomPersonnel" name="prenomPersonnel" class="form-control" type="text"
                        placeholder="Prénom (ex: Léa)" required />
                </div>
                <div class="form-group mt-2">
                    <label for="nomPersonnel">Nom</label>
                    <input id="nomPersonnel" name="nomPersonnel" class="form-control" type="text"
                        placeholder="Nom (ex: Martin)" required />
                </div>
                <div class="form-group mt-2">
                    <label for="urlPhotoPersonnel">URL photo</label>
                    <input id="urlPhotoPersonnel" name="urlPhotoPersonnel" class="form-control" type="url"
                        placeholder="URL de la photo (https://...)" />
                </div>
                <div class="form-group mt-3">
                    <label class="form-label d-block">Rôles</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="estCoach" name="estCoach" value="1" />
                        <label class="form-check-label" for="estCoach">Coach</label>
                    </div>
                    <div class="mt-2">
                        <label for="numEquipeCoachee" class="form-label">Équipe coachée</label>
                        <select id="numEquipeCoachee" name="numEquipeCoachee" class="form-select">
                            <option value="">Sélectionner une équipe</option>
                            <?php foreach ($ba_bec_teams as $ba_bec_team): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_team['numEquipe']); ?>">
                                    <?php echo htmlspecialchars($ba_bec_team['libEquipe']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estDirection" name="estDirection" value="1" />
                        <label class="form-check-label" for="estDirection">Direction</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estCommissionTechnique" name="estCommissionTechnique" value="1" />
                        <label class="form-check-label" for="estCommissionTechnique">Commission technique</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estCommissionAnimation" name="estCommissionAnimation" value="1" />
                        <label class="form-check-label" for="estCommissionAnimation">Commission animation</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estCommissionCommunication" name="estCommissionCommunication" value="1" />
                        <label class="form-check-label" for="estCommissionCommunication">Commission communication</label>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
