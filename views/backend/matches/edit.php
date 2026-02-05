<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php';

$ba_bec_numMatch = (int) ($_GET['numMatch'] ?? 0);
if ($ba_bec_numMatch <= 0) {
    header('Location: list.php');
    exit;
}

sql_connect();

$ba_bec_matchStmt = $DB->prepare('SELECT * FROM `MATCH` WHERE numMatch = :numMatch');
$ba_bec_matchStmt->execute([':numMatch' => $ba_bec_numMatch]);
$ba_bec_match = $ba_bec_matchStmt->fetch(PDO::FETCH_ASSOC);

if (!$ba_bec_match) {
    header('Location: list.php');
    exit;
}

$ba_bec_participantsStmt = $DB->prepare('SELECT numEquipe, cote, score FROM MATCH_PARTICIPANT WHERE numMatch = :numMatch');
$ba_bec_participantsStmt->execute([':numMatch' => $ba_bec_numMatch]);
$ba_bec_participants = $ba_bec_participantsStmt->fetchAll(PDO::FETCH_ASSOC);

$ba_bec_home = null;
$ba_bec_away = null;
foreach ($ba_bec_participants as $participant) {
    if ($participant['cote'] === 'domicile') {
        $ba_bec_home = $participant;
    } elseif ($participant['cote'] === 'exterieur') {
        $ba_bec_away = $participant;
    }
}

$ba_bec_seasons = sql_select('SAISON', 'numSaison, libSaison, estCourante', null, null, 'dateDebut DESC');
$ba_bec_competitions = sql_select('COMPETITION', 'numCompetition, libCompetition, numSaison', null, null, 'libCompetition ASC');
$ba_bec_phases = sql_select('PHASE_COMPETITION', 'numPhase, libPhase, numCompetition', null, null, 'ordrePhase ASC');
$ba_bec_journees = sql_select('JOURNEE', 'numJournee, libJournee, numeroJournee, numPhase', null, null, 'numeroJournee ASC');
$ba_bec_equipes = sql_select('EQUIPE', 'numEquipe, libEquipe, libEquipeComplet, codeEquipe', null, null, 'libEquipe ASC');

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
            <h1>Modifier un match</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/matches/update.php' ?>" method="post">
                <input type="hidden" name="numMatch" value="<?php echo htmlspecialchars($ba_bec_numMatch); ?>" />
                <div class="form-group">
                    <label for="numSaison">Saison</label>
                    <select id="numSaison" name="numSaison" class="form-control" required>
                        <option value="" disabled>Sélectionner une saison</option>
                        <?php foreach ($ba_bec_seasons as $ba_bec_season): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_season['numSaison']); ?>"
                                <?php echo ($ba_bec_match['numSaison'] == $ba_bec_season['numSaison']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ba_bec_season['libSaison']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="numCompetition">Compétition</label>
                    <select id="numCompetition" name="numCompetition" class="form-control" required>
                        <option value="" disabled>Sélectionner une compétition</option>
                        <?php foreach ($ba_bec_competitions as $ba_bec_competition): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_competition['numCompetition']); ?>" data-season="<?php echo htmlspecialchars($ba_bec_competition['numSaison']); ?>"
                                <?php echo ($ba_bec_match['numCompetition'] == $ba_bec_competition['numCompetition']) ? 'selected' : ''; ?>>
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
                            <option value="<?php echo htmlspecialchars($ba_bec_phase['numPhase']); ?>" data-competition="<?php echo htmlspecialchars($ba_bec_phase['numCompetition']); ?>"
                                <?php echo ($ba_bec_match['numPhase'] == $ba_bec_phase['numPhase']) ? 'selected' : ''; ?>>
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
                            <option value="<?php echo htmlspecialchars($ba_bec_journee['numJournee']); ?>" data-phase="<?php echo htmlspecialchars($ba_bec_journee['numPhase']); ?>"
                                <?php echo ($ba_bec_match['numJournee'] == $ba_bec_journee['numJournee']) ? 'selected' : ''; ?>>
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
                        <input id="dateMatch" name="dateMatch" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['dateMatch']); ?>" required />
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
                <div class="form-group mt-3 row">
                    <div class="col-md-6">
                        <label for="numEquipeHome">Équipe à domicile</label>
                        <select id="numEquipeHome" name="numEquipeHome" class="form-control" required>
                            <option value="" disabled>Sélectionner l'équipe domicile</option>
                            <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>"
                                    <?php echo ($ba_bec_home && $ba_bec_home['numEquipe'] == $ba_bec_equipe['numEquipe']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="numEquipeAway">Équipe à l'extérieur</label>
                        <select id="numEquipeAway" name="numEquipeAway" class="form-control" required>
                            <option value="" disabled>Sélectionner l'équipe extérieure</option>
                            <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>"
                                    <?php echo ($ba_bec_away && $ba_bec_away['numEquipe'] == $ba_bec_equipe['numEquipe']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-6">
                        <label for="scoreHome">Score domicile</label>
                        <input id="scoreHome" name="scoreHome" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_home['score'] ?? ''); ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="scoreAway">Score extérieur</label>
                        <input id="scoreAway" name="scoreAway" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_away['score'] ?? ''); ?>" />
                    </div>
                    <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small>
                </div>
                <div class="form-group mt-3">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
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
            filterOptions(phaseSelect, 'competition', competitionSelect.value);
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
        });

        competitionSelect.addEventListener('change', () => {
            filterOptions(phaseSelect, 'competition', competitionSelect.value);
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
        });

        phaseSelect.addEventListener('change', () => {
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
        });
    })();
</script>
