<?php
/*
 * Vue d'administration (création) pour le module matches.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php';

sql_connect();

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
            <h1>Création d'un match</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/matches/create.php' ?>" method="post">
                <div class="form-group">
                    <label for="saison">Saison</label>
                    <input id="saison" name="saison" class="form-control" type="text" placeholder="Ex: 2025-2026" required />
                </div>
                <div class="form-group mt-2">
                    <label for="phase">Phase</label>
                    <input id="phase" name="phase" class="form-control" type="text" placeholder="Ex: Saison régulière" required />
                </div>
                <div class="form-group mt-2">
                    <label for="journee">Journée</label>
                    <input id="journee" name="journee" class="form-control" type="text" placeholder="Ex: J3" required />
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-4">
                        <label for="dateMatch">Date</label>
                        <input id="dateMatch" name="dateMatch" class="form-control" type="date" placeholder="JJ/MM/AAAA" required />
                    </div>
                    <div class="col-md-4">
                        <label for="heureMatch">Heure</label>
                        <input id="heureMatch" name="heureMatch" class="form-control" type="time" placeholder="HH:MM" />
                    </div>
                    <div class="col-md-4">
                        <label for="lieuMatch">Lieu</label>
                        <input id="lieuMatch" name="lieuMatch" class="form-control" type="text" placeholder="Domicile, Extérieur, Gymnase..." />
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="codeEquipe">Équipe du club (BEC)</label>
                    <select id="codeEquipe" name="codeEquipe" class="form-control" required>
                        <option value="" selected disabled>Sélectionner l'équipe BEC</option>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>">
                                <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="clubAdversaire">Club adverse</label>
                    <input id="clubAdversaire" name="clubAdversaire" class="form-control" type="text" placeholder="Nom du club adverse" required />
                </div>
                <div class="form-group mt-2">
                    <label for="numeroEquipeAdverse">Équipe adverse (1/2/3/4…)</label>
                    <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" placeholder="1" />
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-6">
                        <label for="scoreBec">Score BEC</label>
                        <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" placeholder="Score (ex: 75)" />
                    </div>
                    <div class="col-md-6">
                        <label for="scoreAdversaire">Score adverse</label>
                        <input id="scoreAdversaire" name="scoreAdversaire" class="form-control" type="number" min="0" placeholder="Score (ex: 68)" />
                    </div>
                    <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small>
                </div>
                <div class="form-group mt-3">
                    <a href="list.php" class="btn btn-primary">Annuler</a>
                    <button type="submit" class="btn btn-success">Créer le match</button>
                </div>
            </form>
        </div>
    </div>
</div>
