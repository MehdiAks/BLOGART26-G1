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

$ba_bec_participantsStmt = $DB->prepare('SELECT numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse FROM MATCH_PARTICIPANT WHERE numMatch = :numMatch');
$ba_bec_participantsStmt->execute([':numMatch' => $ba_bec_numMatch]);
$ba_bec_participants = $ba_bec_participantsStmt->fetchAll(PDO::FETCH_ASSOC);

$ba_bec_home = null;
$ba_bec_away = null;
$ba_bec_becParticipant = null;
$ba_bec_opponentParticipant = null;
foreach ($ba_bec_participants as $participant) {
    if ($participant['cote'] === 'domicile') {
        $ba_bec_home = $participant;
    } elseif ($participant['cote'] === 'exterieur') {
        $ba_bec_away = $participant;
    }

    $hasOpponentData = empty($participant['numEquipe']) || !empty($participant['nomEquipeAdverse']) || !empty($participant['numeroEquipeAdverse']);
    if ($hasOpponentData && !$ba_bec_opponentParticipant) {
        $ba_bec_opponentParticipant = $participant;
    } elseif (!$hasOpponentData && !$ba_bec_becParticipant) {
        $ba_bec_becParticipant = $participant;
    }
}

$ba_bec_seasons = sql_select('SAISON', 'numSaison, libSaison, estCourante', null, null, 'dateDebut DESC');
$ba_bec_competitions = sql_select('COMPETITION', 'numCompetition, libCompetition, numSaison', null, null, 'libCompetition ASC');
$ba_bec_phases = sql_select('PHASE_COMPETITION', 'numPhase, libPhase, numCompetition', null, null, 'ordrePhase ASC');
$ba_bec_journees = sql_select('JOURNEE', 'numJournee, libJournee, numeroJournee, numPhase', null, null, 'numeroJournee ASC');
$ba_bec_equipes = sql_select('EQUIPE', 'numEquipe, libEquipe, libEquipeComplet, codeEquipe', null, null, 'libEquipe ASC');
$ba_bec_clubs = sql_select('CLUB', 'nomClub', null, null, 'nomClub ASC');
$ba_bec_allowedPhases = ['Phase régulière', 'Phase playoff', 'Phase playdown'];

$ba_bec_equipesById = [];
foreach ($ba_bec_equipes as $ba_bec_equipe) {
    $ba_bec_equipesById[$ba_bec_equipe['numEquipe']] = $ba_bec_equipe;
}

$ba_bec_becParticipant = $ba_bec_becParticipant ?? $ba_bec_home;
$ba_bec_opponentParticipant = $ba_bec_opponentParticipant ?? $ba_bec_away;
$ba_bec_becCote = $ba_bec_becParticipant['cote'] ?? 'domicile';
$ba_bec_becEquipeId = $ba_bec_becParticipant['numEquipe'] ?? 0;
$ba_bec_nomEquipeAdverse = $ba_bec_opponentParticipant['nomEquipeAdverse'] ?? '';
if ($ba_bec_nomEquipeAdverse === '' && !empty($ba_bec_opponentParticipant['numEquipe']) && isset($ba_bec_equipesById[$ba_bec_opponentParticipant['numEquipe']])) {
    $ba_bec_nomEquipeAdverse = ba_bec_team_label($ba_bec_equipesById[$ba_bec_opponentParticipant['numEquipe']]);
}
$ba_bec_numeroEquipeAdverse = $ba_bec_opponentParticipant['numeroEquipeAdverse'] ?? '';

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
                            <option value="<?php echo htmlspecialchars($ba_bec_competition['numCompetition']); ?>" data-season="<?php echo htmlspecialchars($ba_bec_competition['numSaison']); ?>" data-label="<?php echo htmlspecialchars($ba_bec_competition['libCompetition']); ?>"
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
                            <?php if (!in_array($ba_bec_phase['libPhase'], $ba_bec_allowedPhases, true)) {
                                continue;
                            } ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_phase['numPhase']); ?>" data-competition="<?php echo htmlspecialchars($ba_bec_phase['numCompetition']); ?>" data-label="<?php echo htmlspecialchars($ba_bec_phase['libPhase']); ?>"
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
                <div class="form-group mt-3">
                    <label for="numEquipeBec">Équipe du club (BEC)</label>
                    <select id="numEquipeBec" name="numEquipeBec" class="form-control" required>
                        <option value="" disabled>Sélectionner l'équipe BEC</option>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" data-code="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe'] ?? ''); ?>" data-label="<?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>"
                                <?php echo ($ba_bec_becEquipeId == $ba_bec_equipe['numEquipe']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label>Lieu du BEC</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="becCote" id="becCoteHome" value="domicile"
                                <?php echo ($ba_bec_becCote === 'domicile') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="becCoteHome">Domicile</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="becCote" id="becCoteAway" value="exterieur"
                                <?php echo ($ba_bec_becCote === 'exterieur') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="becCoteAway">Extérieur</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3 row">
                    <div class="col-md-6">
                        <label for="equipeHomeDisplay">Équipe à domicile</label>
                        <input id="equipeHomeDisplay" class="form-control" type="text" list="clubsList" required />
                    </div>
                    <div class="col-md-6">
                        <label for="equipeAwayDisplay">Équipe à l'extérieur</label>
                        <input id="equipeAwayDisplay" class="form-control" type="text" list="clubsList" required />
                    </div>
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-6">
                        <label for="numeroEquipeAdverse">Équipe du club adverse (1/2/3/4…)</label>
                        <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" value="<?php echo htmlspecialchars($ba_bec_numeroEquipeAdverse); ?>" placeholder="1" />
                        <small class="form-text text-muted">Indiquez le numéro d'équipe adverse (ex: 1 pour l'équipe 1).</small>
                    </div>
                </div>
                <input type="hidden" id="nomEquipeAdverse" name="nomEquipeAdverse" value="<?php echo htmlspecialchars($ba_bec_nomEquipeAdverse); ?>" />
                <datalist id="clubsList">
                    <?php foreach ($ba_bec_clubs as $ba_bec_club): ?>
                        <option value="<?php echo htmlspecialchars($ba_bec_club['nomClub']); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
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
        const becSelect = document.getElementById('numEquipeBec');
        const becCoteInputs = document.querySelectorAll('input[name="becCote"]');
        const homeDisplay = document.getElementById('equipeHomeDisplay');
        const awayDisplay = document.getElementById('equipeAwayDisplay');
        const nomEquipeAdverseInput = document.getElementById('nomEquipeAdverse');
        const defaultPhaseLabel = 'Phase régulière';

        const competitionDefaults = {
            SF1: 'National 3',
            SF2: 'Prénational',
            SF3: 'Prérégional',
            SG1: 'Prénational',
            SG2: 'Régional 2',
            SG3: 'Départemental 3',
            SG4: 'Départemental 4',
        };

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

        const getSelectedOptionLabel = (select) => {
            const option = select.options[select.selectedIndex];
            return option ? option.dataset.label || option.textContent.trim() : '';
        };

        const findOptionByLabel = (select, label) => Array.from(select.options)
            .find((option) => option.value && (option.dataset.label || option.textContent.trim()) === label);

        const updatePhaseDefault = () => {
            filterOptions(phaseSelect, 'competition', competitionSelect.value);
            const phaseOption = findOptionByLabel(phaseSelect, defaultPhaseLabel);
            if (phaseOption) {
                phaseSelect.value = phaseOption.value;
                filterOptions(journeeSelect, 'phase', phaseSelect.value);
                journeeSelect.value = '';
            }
        };

        const updateBecAssignment = (preserveOpponent = false) => {
            const becOption = becSelect.options[becSelect.selectedIndex];
            if (!becOption || !becOption.value) {
                homeDisplay.readOnly = false;
                awayDisplay.readOnly = false;
                return;
            }
            const becLabel = becOption ? becOption.dataset.label || becOption.textContent.trim() : '';
            const becCote = document.querySelector('input[name="becCote"]:checked')?.value || 'domicile';
            const opponentValue = nomEquipeAdverseInput.value;
            if (becCote === 'domicile') {
                homeDisplay.value = becLabel;
                homeDisplay.readOnly = true;
                awayDisplay.readOnly = false;
                if (!preserveOpponent || awayDisplay.value === '') {
                    awayDisplay.value = opponentValue;
                }
                nomEquipeAdverseInput.value = awayDisplay.value;
            } else {
                awayDisplay.value = becLabel;
                awayDisplay.readOnly = true;
                homeDisplay.readOnly = false;
                if (!preserveOpponent || homeDisplay.value === '') {
                    homeDisplay.value = opponentValue;
                }
                nomEquipeAdverseInput.value = homeDisplay.value;
            }
        };

        const updateCompetitionDefault = () => {
            const becOption = becSelect.options[becSelect.selectedIndex];
            if (!becOption) {
                return;
            }
            const teamCode = becOption.dataset.code || '';
            const defaultCompetition = competitionDefaults[teamCode];
            if (!defaultCompetition) {
                return;
            }
            const currentLabel = getSelectedOptionLabel(competitionSelect);
            if (currentLabel === 'Coupe') {
                return;
            }
            const option = findOptionByLabel(competitionSelect, defaultCompetition);
            if (option) {
                competitionSelect.value = option.value;
                updatePhaseDefault();
            }
        };

        seasonSelect.addEventListener('change', () => {
            filterOptions(competitionSelect, 'season', seasonSelect.value);
            filterOptions(phaseSelect, 'competition', competitionSelect.value);
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
        });

        competitionSelect.addEventListener('change', () => {
            filterOptions(phaseSelect, 'competition', competitionSelect.value);
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
            updatePhaseDefault();
        });

        phaseSelect.addEventListener('change', () => {
            filterOptions(journeeSelect, 'phase', phaseSelect.value);
        });

        becSelect.addEventListener('change', () => {
            updateBecAssignment();
            updateCompetitionDefault();
        });

        becCoteInputs.forEach((input) => {
            input.addEventListener('change', () => {
                updateBecAssignment();
            });
        });

        [homeDisplay, awayDisplay].forEach((input) => {
            input.addEventListener('input', () => {
                const becCote = document.querySelector('input[name="becCote"]:checked')?.value || 'domicile';
                nomEquipeAdverseInput.value = becCote === 'domicile' ? awayDisplay.value : homeDisplay.value;
            });
        });

        updateBecAssignment(true);
    })();
</script>
