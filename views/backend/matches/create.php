<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php';

sql_connect();

$ba_bec_seasons = sql_select('SAISON', 'numSaison, libSaison, estCourante', null, null, 'dateDebut DESC');
$ba_bec_competitions = sql_select('COMPETITION', 'numCompetition, libCompetition, numSaison', null, null, 'libCompetition ASC');
$ba_bec_phases = sql_select('PHASE_COMPETITION', 'numPhase, libPhase, numCompetition', null, null, 'ordrePhase ASC');
$ba_bec_journees = sql_select('JOURNEE', 'numJournee, libJournee, numeroJournee, numPhase', null, null, 'numeroJournee ASC');
$ba_bec_equipes = sql_select('EQUIPE', 'numEquipe, libEquipe, libEquipeComplet, codeEquipe', null, null, 'libEquipe ASC');

$ba_bec_currentSeason = null;
foreach ($ba_bec_seasons as $ba_bec_season) {
    if (!empty($ba_bec_season['estCourante'])) {
        $ba_bec_currentSeason = $ba_bec_season['numSaison'];
        break;
    }
}

function ba_bec_team_label(array $team): string
{
    $label = $team['libEquipeComplet'] ?? '';
    if ($label === '') {
        $label = $team['libEquipe'] ?? '';
    }
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
                    <label for="numSaison">Saison</label>
                    <select id="numSaison" name="numSaison" class="form-control" required>
                        <option value="" selected disabled>Sélectionner une saison</option>
                        <?php foreach ($ba_bec_seasons as $ba_bec_season): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_season['numSaison']); ?>"
                                <?php echo ($ba_bec_currentSeason == $ba_bec_season['numSaison']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ba_bec_season['libSaison']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="numCompetition">Compétition</label>
                    <select id="numCompetition" name="numCompetition" class="form-control" required>
                        <option value="" selected disabled>Sélectionner une compétition</option>
                        <?php foreach ($ba_bec_competitions as $ba_bec_competition): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_competition['numCompetition']); ?>" data-season="<?php echo htmlspecialchars($ba_bec_competition['numSaison']); ?>">
                                <?php echo htmlspecialchars($ba_bec_competition['libCompetition']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="numPhase">Phase</label>
                    <select id="numPhase" name="numPhase" class="form-control">
                        <option value="">Sélectionner une phase (optionnel)</option>
                        <?php foreach ($ba_bec_phases as $ba_bec_phase): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_phase['numPhase']); ?>" data-competition="<?php echo htmlspecialchars($ba_bec_phase['numCompetition']); ?>">
                                <?php echo htmlspecialchars($ba_bec_phase['libPhase']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="numJournee">Journée</label>
                    <select id="numJournee" name="numJournee" class="form-control">
                        <option value="">Sélectionner une journée (optionnel)</option>
                        <?php foreach ($ba_bec_journees as $ba_bec_journee): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_journee['numJournee']); ?>" data-phase="<?php echo htmlspecialchars($ba_bec_journee['numPhase']); ?>">
                                <?php
                                $journeeLabel = $ba_bec_journee['libJournee'] ?? '';
                                if ($journeeLabel === '' && !empty($ba_bec_journee['numeroJournee'])) {
                                    $journeeLabel = 'J' . $ba_bec_journee['numeroJournee'];
                                }
                                echo htmlspecialchars($journeeLabel ?: 'Journée');
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-4">
                        <label for="dateMatch">Date</label>
                        <input id="dateMatch" name="dateMatch" class="form-control" type="date" required />
                    </div>
                    <div class="col-md-4">
                        <label for="heureMatch">Heure</label>
                        <input id="heureMatch" name="heureMatch" class="form-control" type="time" />
                    </div>
                    <div class="col-md-4">
                        <label for="lieuMatch">Lieu</label>
                        <input id="lieuMatch" name="lieuMatch" class="form-control" type="text" placeholder="Gymnase, salle..." />
                    </div>
                </div>
                <div class="form-group mt-3 row">
                    <div class="col-md-6">
                        <label for="numEquipeHome">Équipe à domicile</label>
                        <select id="numEquipeHome" name="numEquipeHome" class="form-control" required>
                            <option value="" selected disabled>Sélectionner l'équipe domicile</option>
                            <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>">
                                    <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="numEquipeAway">Équipe à l'extérieur</label>
                        <select id="numEquipeAway" name="numEquipeAway" class="form-control" required>
                            <option value="" selected disabled>Sélectionner l'équipe extérieure</option>
                            <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>">
                                    <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-6">
                        <label for="scoreHome">Score domicile</label>
                        <input id="scoreHome" name="scoreHome" class="form-control" type="number" min="0" />
                    </div>
                    <div class="col-md-6">
                        <label for="scoreAway">Score extérieur</label>
                        <input id="scoreAway" name="scoreAway" class="form-control" type="number" min="0" />
                    </div>
                    <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small>
                </div>
                <div class="form-group mt-3">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-success">Créer le match</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const seasonSelect = document.getElementById('numSaison');
        const competitionSelect = document.getElementById('numCompetition');
        const phaseSelect = document.getElementById('numPhase');
        const journeeSelect = document.getElementById('numJournee');

        const filterOptions = (select, attribute, value) => {
            Array.from(select.options).forEach((option) => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }
                const dataValue = option.dataset[attribute] || '';
                option.hidden = value && dataValue !== value;
            });
        };

        seasonSelect.addEventListener('change', () => {
            filterOptions(competitionSelect, 'season', seasonSelect.value);
            competitionSelect.value = '';
            filterOptions(phaseSelect, 'competition', '');
            phaseSelect.value = '';
            filterOptions(journeeSelect, 'phase', '');
            journeeSelect.value = '';
        });

        competitionSelect.addEventListener('change', () => {
            filterOptions(phaseSelect, 'competition', competitionSelect.value);
            phaseSelect.value = '';
            filterOptions(journeeSelect, 'phase', '');
            journeeSelect.value = '';
        });

        phaseSelect.addEventListener('change', () => {
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
            journeeSelect.value = '';
        });
    })();
</script>
