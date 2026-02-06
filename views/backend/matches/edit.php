<?php
/*
 * Vue d'administration (édition) pour le module matches.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
 * - L'action du formulaire cible la route de mise à jour correspondante.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php';

if (!isset($_GET['numMatch'])) {
    header('Location: ' . ROOT_URL . '/views/backend/matches/list.php');
    exit;
}

sql_connect();

$ba_bec_numMatch = (int) $_GET['numMatch'];
$ba_bec_match = null;
if ($ba_bec_numMatch) {
    $stmt = $DB->prepare('SELECT * FROM `MATCH` WHERE numMatch = :numMatch');
    $stmt->execute([':numMatch' => $ba_bec_numMatch]);
    $ba_bec_match = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

if (!$ba_bec_match) {
    header('Location: ' . ROOT_URL . '/views/backend/matches/list.php');
    exit;
}

$ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC');

function ba_bec_team_label(array $team): string
{
    $label = $team['nomEquipe'] ?? '';
    $code = $team['codeEquipe'] ?? '';
    return $code !== '' ? $label . ' (' . $code . ')' : $label;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modifier un match</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/matches/update.php' ?>" method="post">
                <input type="hidden" name="numMatch" value="<?php echo htmlspecialchars((string) $ba_bec_match['numMatch']); ?>" />
                <div class="form-group">
                    <label for="saison">Saison</label>
                    <input id="saison" name="saison" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['saison'] ?? ''); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="phase">Phase</label>
                    <input id="phase" name="phase" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['phase'] ?? ''); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="journee">Journée</label>
                    <input id="journee" name="journee" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['journee'] ?? ''); ?>" required />
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-4">
                        <label for="dateMatch">Date</label>
                        <input id="dateMatch" name="dateMatch" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['dateMatch'] ?? ''); ?>" required />
                    </div>
                    <div class="col-md-4">
                        <label for="heureMatch">Heure</label>
                        <input id="heureMatch" name="heureMatch" class="form-control" type="time" value="<?php echo htmlspecialchars($ba_bec_match['heureMatch'] ?? ''); ?>" />
                    </div>
                    <div class="col-md-4">
                        <label for="lieuMatch">Lieu</label>
                        <input id="lieuMatch" name="lieuMatch" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['lieuMatch'] ?? ''); ?>" />
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="codeEquipe">Équipe du club (BEC)</label>
                    <select id="codeEquipe" name="codeEquipe" class="form-control" required>
                        <option value="" disabled>Sélectionner l'équipe BEC</option>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>"
                                <?php echo ($ba_bec_match['codeEquipe'] ?? '') === $ba_bec_equipe['codeEquipe'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="clubAdversaire">Club adverse</label>
                    <input id="clubAdversaire" name="clubAdversaire" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['clubAdversaire'] ?? ''); ?>" required />
                </div>
                <div class="form-group mt-2">
                    <label for="numeroEquipeAdverse">Équipe adverse (1/2/3/4…)</label>
                    <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" value="<?php echo htmlspecialchars($ba_bec_match['numEquipeAdverse'] ?? ''); ?>" />
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-6">
                        <label for="scoreBec">Score BEC</label>
                        <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreBec'] ?? ''); ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="scoreAdversaire">Score adverse</label>
                        <input id="scoreAdversaire" name="scoreAdversaire" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreAdversaire'] ?? ''); ?>" />
                    </div>
                </div>
                <div class="form-group mt-3">
                    <a href="list.php" class="btn btn-primary">Annuler</a>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
