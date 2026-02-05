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
$ba_bec_teams = sql_select('EQUIPE', 'numEquipe, libEquipe', null, null, 'libEquipe ASC');

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
            <form action="<?php echo ROOT_URL . '/api/benevoles/update.php'; ?>" method="post" enctype="multipart/form-data">
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
                    <label for="photoPersonnel">Photo</label>
                    <input id="photoPersonnel" name="photoPersonnel" class="form-control" type="file" accept="image/*" />
                </div>
                <div class="form-group mt-3">
                    <label class="form-label d-block">Rôles</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="estCoach" name="estCoach" value="1" <?php echo !empty($ba_bec_benevole['estCoach']) ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="estCoach">Coach</label>
                    </div>
                    <div class="mt-2">
                        <label for="numEquipeCoachee" class="form-label">Équipe coachée</label>
                        <select id="numEquipeCoachee" name="numEquipeCoachee" class="form-select">
                            <option value="">Sélectionner une équipe</option>
                            <?php foreach ($ba_bec_teams as $ba_bec_team): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_team['numEquipe']); ?>" <?php echo ((int) ($ba_bec_benevole['numEquipeCoachee'] ?? 0) === (int) $ba_bec_team['numEquipe']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ba_bec_team['libEquipe']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estDirection" name="estDirection" value="1" <?php echo !empty($ba_bec_benevole['estDirection']) ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="estDirection">Direction</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estCommissionTechnique" name="estCommissionTechnique" value="1" <?php echo !empty($ba_bec_benevole['estCommissionTechnique']) ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="estCommissionTechnique">Commission technique</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estCommissionAnimation" name="estCommissionAnimation" value="1" <?php echo !empty($ba_bec_benevole['estCommissionAnimation']) ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="estCommissionAnimation">Commission animation</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="estCommissionCommunication" name="estCommissionCommunication" value="1" <?php echo !empty($ba_bec_benevole['estCommissionCommunication']) ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="estCommissionCommunication">Commission communication</label>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
