<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();
$ba_bec_tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
$ba_bec_hasBecMatchesTable = (bool) $ba_bec_tableCheckStmt->fetchColumn();

$ba_bec_match = null;
if (isset($_GET['numMatch'])) {
    $ba_bec_numMatch = (int) $_GET['numMatch'];
    if ($ba_bec_hasBecMatchesTable) {
        $ba_bec_match = sql_select(
            'bec_matches',
            "MatchNo AS numMatch,
            Section AS section,
            Equipe AS team,
            Competition AS competition,
            Phase AS status,
            Journee AS matchDay,
            Date AS matchDate,
            Heure AS matchTime,
            Domicile_Exterieur AS location,
            Adversaire AS opponent,
            Score_BEC AS scoreBec,
            Score_Adversaire AS scoreOpponent,
            Source AS sourceUrl",
            "MatchNo = $ba_bec_numMatch"
        );
    } else {
        $ba_bec_match = sql_select('MATCH_CLUB', '*', "numMatch = $ba_bec_numMatch");
    }
    $ba_bec_match = $ba_bec_match[0] ?? null;
}

$ba_bec_displayMatchTime = '';
if (!empty($ba_bec_match['matchTime'])) {
    $ba_bec_timestamp = strtotime($ba_bec_match['matchTime']);
    $ba_bec_displayMatchTime = $ba_bec_timestamp !== false ? date('H:i', $ba_bec_timestamp) : $ba_bec_match['matchTime'];
}

$ba_bec_matchDayNumber = '';
if (!empty($ba_bec_match['matchDay'])) {
    $ba_bec_matchDayNumber = ltrim((string) $ba_bec_match['matchDay'], 'Jj');
}

$ba_bec_isCup = !empty($ba_bec_match['competition']) && strtolower(trim((string) $ba_bec_match['competition'])) === 'coupe';
$ba_bec_locationValue = strtolower(trim((string) ($ba_bec_match['location'] ?? '')));
$ba_bec_isAway = str_contains($ba_bec_locationValue, 'extérieur') || str_contains($ba_bec_locationValue, 'exterieur');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modifier un match</h1>
        </div>
        <div class="col-md-12">
            <?php if ($ba_bec_match) : ?>
                <form action="<?php echo ROOT_URL . '/api/matches/update.php' ?>" method="post">
                    <input type="hidden" name="numMatch" value="<?php echo $ba_bec_match['numMatch']; ?>" />
                    <?php if ($ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group">
                            <label for="section">Catégorie</label>
                            <select id="section" name="section" class="form-control" required>
                                <option value="" disabled>Sélectionner une catégorie</option>
                                <option value="SG1" <?php echo $ba_bec_match['section'] === 'SG1' ? 'selected' : ''; ?>>SG1</option>
                                <option value="SG2" <?php echo $ba_bec_match['section'] === 'SG2' ? 'selected' : ''; ?>>SG2</option>
                                <option value="SG3" <?php echo $ba_bec_match['section'] === 'SG3' ? 'selected' : ''; ?>>SG3</option>
                                <option value="SG4" <?php echo $ba_bec_match['section'] === 'SG4' ? 'selected' : ''; ?>>SG4</option>
                                <option value="SF1" <?php echo $ba_bec_match['section'] === 'SF1' ? 'selected' : ''; ?>>SF1</option>
                                <option value="SF2" <?php echo $ba_bec_match['section'] === 'SF2' ? 'selected' : ''; ?>>SF2</option>
                                <option value="SF3" <?php echo $ba_bec_match['section'] === 'SF3' ? 'selected' : ''; ?>>SF3</option>
                            </select>
                        </div>
                    <?php else : ?>
                    <div class="form-group">
                        <label for="sourceId">Source ID</label>
                        <input id="sourceId" name="sourceId" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['sourceId']); ?>" required />
                    </div>
                    <?php endif; ?>
                    <?php if (!$ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group mt-2">
                            <label for="location">Lieu</label>
                            <input id="location" name="location" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['location'] ?? ''); ?>" />
                        </div>
                        <div class="form-group mt-2">
                            <label for="status">Statut</label>
                            <input id="status" name="status" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['status'] ?? ''); ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="form-group mt-2">
                        <label for="competition">Compétition</label>
                        <input id="competition" name="competition" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['competition']); ?>" readonly required />
                        <small class="form-text text-muted">Prérempli selon la catégorie (national, régional, pré-régional, départemental).</small>
                    </div>
                    <?php if ($ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group mt-2 d-flex align-items-center gap-2">
                            <div class="flex-grow-1">
                                <label class="form-label">Match de coupe</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="isCup" <?php echo $ba_bec_isCup ? 'checked' : ''; ?> />
                                    <label class="form-check-label" for="isCup">Match de coupe</label>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <label for="location">Lieu</label>
                                <div class="btn-group w-100" role="group" aria-label="Lieu du match">
                                    <input type="radio" class="btn-check" name="location" id="locationHome" value="Domicile" <?php echo $ba_bec_isAway ? '' : 'checked'; ?> required>
                                    <label class="btn btn-outline-primary" for="locationHome">Domicile</label>
                                    <input type="radio" class="btn-check" name="location" id="locationAway" value="Extérieur" <?php echo $ba_bec_isAway ? 'checked' : ''; ?>>
                                    <label class="btn btn-outline-primary" for="locationAway">Extérieur</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group mt-2">
                        <label for="matchDayNumber">Journée</label>
                        <div class="input-group">
                            <span class="input-group-text">J</span>
                            <input id="matchDayNumber" class="form-control" type="number" min="1" placeholder="1" value="<?php echo htmlspecialchars($ba_bec_matchDayNumber); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
                        </div>
                        <input type="hidden" id="matchDay" name="matchDay" value="<?php echo htmlspecialchars($ba_bec_match['matchDay']); ?>" />
                    </div>
                    <div class="form-group mt-2 row">
                        <div class="<?php echo $ba_bec_hasBecMatchesTable ? 'col-md-4' : 'col-md-6'; ?>">
                            <label for="matchDate">Date</label>
                            <input id="matchDate" name="matchDate" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['matchDate']); ?>" required />
                        </div>
                        <div class="<?php echo $ba_bec_hasBecMatchesTable ? 'col-md-4' : 'col-md-6'; ?>">
                            <label for="matchTime">Heure</label>
                            <input id="matchTime" name="matchTime" class="form-control" type="time" value="<?php echo htmlspecialchars($ba_bec_displayMatchTime); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
                        </div>
                        <?php if ($ba_bec_hasBecMatchesTable) : ?>
                            <div class="col-md-4">
                                <label for="status">Phase</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="Saison régulière" <?php echo ($ba_bec_match['status'] ?? '') === 'Saison régulière' ? 'selected' : ''; ?>>Saison régulière</option>
                                    <option value="Playoff" <?php echo ($ba_bec_match['status'] ?? '') === 'Playoff' ? 'selected' : ''; ?>>Playoff</option>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group mt-2 row align-items-end" id="teamRow">
                            <div class="col-md-6" id="teamHomeColumn">
                                <label for="teamDisplay">Bordeaux Étudiant Club</label>
                                <input id="teamDisplay" name="team" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['team'] ?? 'Bordeaux Étudiant Club'); ?>" readonly />
                            </div>
                            <div class="col-md-6" id="teamAwayColumn">
                                <label for="opponent">Équipe adverse</label>
                                <input id="opponent" name="opponent" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['opponent']); ?>" placeholder="Équipe adverse" required />
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="form-group mt-2">
                            <label for="teamHome">Équipe domicile</label>
                            <input id="teamHome" name="teamHome" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamHome']); ?>" required />
                        </div>
                        <div class="form-group mt-2">
                            <label for="teamAway">Équipe extérieur</label>
                            <input id="teamAway" name="teamAway" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamAway']); ?>" required />
                        </div>
                    <?php endif; ?>
                    <?php if ($ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group mt-2 row">
                            <div class="col-md-6">
                                <label for="scoreBec">Score BEC</label>
                                <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreBec'] ?? ''); ?>" />
                            </div>
                            <div class="col-md-6">
                                <label for="scoreOpponent">Score adversaire</label>
                                <input id="scoreOpponent" name="scoreOpponent" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreOpponent'] ?? ''); ?>" />
                            </div>
                            <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small>
                        </div>
                    <?php else : ?>
                        <div class="form-group mt-2">
                            <label for="scoreHome">Score domicile</label>
                            <input id="scoreHome" name="scoreHome" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreHome'] ?? ''); ?>" />
                        </div>
                        <div class="form-group mt-2">
                            <label for="scoreAway">Score extérieur</label>
                            <input id="scoreAway" name="scoreAway" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreAway'] ?? ''); ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="form-group mt-2 row">
                        <?php if ($ba_bec_hasBecMatchesTable) : ?>
                            <div class="col-md-4">
                                <label for="numMatchDisplay">MatchNo</label>
                                <input id="numMatchDisplay" class="form-control" type="number" value="<?php echo htmlspecialchars($ba_bec_match['numMatch']); ?>" readonly />
                                <small class="form-text text-muted">Récupéré sur le site FFBB.</small>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-8">
                            <label for="sourceUrl"><?php echo $ba_bec_hasBecMatchesTable ? 'Source' : 'Lien source'; ?></label>
                            <input id="sourceUrl" name="sourceUrl" class="form-control" type="<?php echo $ba_bec_hasBecMatchesTable ? 'text' : 'url'; ?>" value="<?php echo htmlspecialchars($ba_bec_match['sourceUrl'] ?? ''); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
                            <?php if ($ba_bec_hasBecMatchesTable) : ?>
                                <small class="form-text text-muted">Prérempli selon la catégorie et la phase.</small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <br />
                    <div class="form-group mt-2">
                        <a href="list.php" class="btn btn-primary">List</a>
                        <button type="submit" class="btn btn-success">Confirmer edit ?</button>
                    </div>
                </form>
            <?php else : ?>
                <div class="alert alert-danger">Match introuvable.</div>
                <a href="list.php" class="btn btn-primary">Retour</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($ba_bec_hasBecMatchesTable && $ba_bec_match) : ?>
    <script>
        const categorySelect = document.getElementById('section');
        const competitionInput = document.getElementById('competition');
        const cupCheckbox = document.getElementById('isCup');
        const locationHome = document.getElementById('locationHome');
        const locationAway = document.getElementById('locationAway');
        const teamHomeColumn = document.getElementById('teamHomeColumn');
        const teamAwayColumn = document.getElementById('teamAwayColumn');
        const matchDayNumber = document.getElementById('matchDayNumber');
        const matchDayInput = document.getElementById('matchDay');
        const statusSelect = document.getElementById('status');
        const sourceInput = document.getElementById('sourceUrl');

        const competitionLabels = {
            SF1: 'National 3 Féminine',
            SF2: 'Pré-Nationale Féminine',
            SF3: 'Pré-Régionale Féminine',
            SG1: 'Pré-Nationale Masculine',
            SG2: 'Régionale Masculine 2',
            SG3: 'Départementale Masculine 3',
            SG4: 'Départementale Masculine 4'
        };

        const sourceLinks = {
            SG1: {
                default: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'
            },
            SG2: {
                default: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'
            },
            SG3: {
                'Saison régulière': 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647',
                Playoff: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'
            },
            SG4: {
                'Saison régulière': 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778',
                Playoff: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'
            },
            SF1: {
                default: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'
            },
            SF2: {
                default: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'
            },
            SF3: {
                default: 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'
            }
        };

        const updateCompetition = () => {
            if (cupCheckbox.checked) {
                competitionInput.value = 'Coupe';
                return;
            }
            const category = categorySelect.value;
            competitionInput.value = competitionLabels[category] || competitionInput.value;
        };

        const updateSource = () => {
            const category = categorySelect.value;
            if (!category) {
                return;
            }
            const categorySources = sourceLinks[category];
            if (!categorySources) {
                return;
            }
            if (categorySources.default) {
                sourceInput.value = categorySources.default;
                return;
            }
            const phase = statusSelect.value || 'Saison régulière';
            sourceInput.value = categorySources[phase] || sourceInput.value;
        };

        const updateLocationLayout = () => {
            if (locationAway.checked) {
                teamHomeColumn.classList.add('order-md-2');
                teamAwayColumn.classList.add('order-md-1');
            } else {
                teamHomeColumn.classList.remove('order-md-2');
                teamAwayColumn.classList.remove('order-md-1');
            }
        };

        const updateMatchDay = () => {
            const value = matchDayNumber.value.trim();
            matchDayInput.value = value ? `J${value}` : '';
        };

        categorySelect.addEventListener('change', () => {
            updateCompetition();
            updateSource();
        });
        cupCheckbox.addEventListener('change', updateCompetition);
        statusSelect.addEventListener('change', updateSource);
        locationHome.addEventListener('change', updateLocationLayout);
        locationAway.addEventListener('change', updateLocationLayout);
        matchDayNumber.addEventListener('input', updateMatchDay);

        updateCompetition();
        updateSource();
        updateLocationLayout();
        updateMatchDay();
    </script>
<?php endif; ?>
