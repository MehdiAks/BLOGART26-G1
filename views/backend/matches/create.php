<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php';

sql_connect();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création d'un match</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/matches/create.php' ?>" method="post">
                <div class="form-group">
                    <label for="section">Catégorie</label>
                    <select id="section" name="section" class="form-control" required>
                        <option value="" selected disabled>Sélectionner une catégorie</option>
                        <option value="SG1">SG1</option>
                        <option value="SG2">SG2</option>
                        <option value="SG3">SG3</option>
                        <option value="SG4">SG4</option>
                        <option value="SF1">SF1</option>
                        <option value="SF2">SF2</option>
                        <option value="SF3">SF3</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="competition">Compétition</label>
                    <input id="competition" name="competition" class="form-control" type="text" readonly required />
                    <small class="form-text text-muted">Prérempli selon la catégorie (national, régional, pré-régional, départemental).</small>
                </div>
                <div class="form-group mt-2 d-flex align-items-center gap-2">
                    <div class="flex-grow-1">
                        <label class="form-label">Match de coupe</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isCup" />
                            <label class="form-check-label" for="isCup">Match de coupe</label>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <label for="location">Lieu</label>
                            <div class="btn-group w-100" role="group" aria-label="Lieu du match">
                            <input type="radio" class="btn-check" name="location" id="locationHome" value="Domicile" checked required>
                            <label class="btn btn-outline-primary" for="locationHome">Domicile</label>
                            <input type="radio" class="btn-check" name="location" id="locationAway" value="Extérieur">
                            <label class="btn btn-outline-primary" for="locationAway">Extérieur</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="matchDayNumber">Journée</label>
                    <div class="input-group">
                        <span class="input-group-text">J</span>
                        <input id="matchDayNumber" class="form-control" type="number" min="1" placeholder="1" required />
                    </div>
                    <input type="hidden" id="matchDay" name="matchDay" />
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-4">
                        <label for="matchDate">Date</label>
                        <input id="matchDate" name="matchDate" class="form-control" type="date" required />
                    </div>
                    <div class="col-md-4">
                        <label for="matchTime">Heure</label>
                        <input id="matchTime" name="matchTime" class="form-control" type="time" required />
                    </div>
                    <div class="col-md-4">
                        <label for="status">Phase</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Saison régulière" selected>Saison régulière</option>
                            <option value="Playoff">Playoff</option>
                        </select>
                    </div>
                </div>
                <div class="match-create-alignment">
                    <span>Équipe à domicile</span>
                    <span>Équipe à l'extérieur</span>
                </div>
                <div class="form-group mt-2 row align-items-end" id="teamRow">
                    <div class="col-md-6" id="teamHomeColumn">
                        <label for="teamDisplay">Bordeaux Étudiant Club</label>
                        <input id="teamDisplay" name="team" class="form-control" type="text" value="Bordeaux Étudiant Club" readonly />
                    </div>
                    <div class="col-md-6" id="teamAwayColumn">
                        <label for="opponent">Équipe adverse</label>
                        <input id="opponent" name="opponent" class="form-control" type="text" placeholder="Équipe adverse" required />
                    </div>
                </div>
                <div class="form-group mt-2 row match-score-row">
                    <div class="col-md-6" id="scoreHomeColumn">
                        <label for="scoreBec">Score BEC</label>
                        <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" />
                    </div>
                    <div class="col-md-6" id="scoreAwayColumn">
                        <label for="scoreOpponent">Score adversaire</label>
                        <input id="scoreOpponent" name="scoreOpponent" class="form-control" type="number" min="0" />
                    </div>
                    <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small>
                </div>
                <div class="form-group mt-2 row">
                    <div class="col-md-4">
                        <label for="numMatch">MatchNo</label>
                        <input id="numMatch" name="numMatch" class="form-control" type="number" min="1" required />
                        <small class="form-text text-muted">Récupéré sur le site FFBB.</small>
                    </div>
                    <div class="col-md-8">
                        <label for="sourceUrl">Source</label>
                        <input id="sourceUrl" name="sourceUrl" class="form-control" type="text" required />
                        <small class="form-text text-muted">Prérempli selon la catégorie et la phase.</small>
                    </div>
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-success">Confirmer create ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const categorySelect = document.getElementById('section');
    const competitionInput = document.getElementById('competition');
    const cupCheckbox = document.getElementById('isCup');
    const locationHome = document.getElementById('locationHome');
    const locationAway = document.getElementById('locationAway');
    const teamHomeColumn = document.getElementById('teamHomeColumn');
    const teamAwayColumn = document.getElementById('teamAwayColumn');
    const scoreHomeColumn = document.getElementById('scoreHomeColumn');
    const scoreAwayColumn = document.getElementById('scoreAwayColumn');
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
            competitionInput.value = competitionLabels[category] || '';
        };

        const updateSource = () => {
            const category = categorySelect.value;
            if (!category) {
                sourceInput.value = '';
                return;
            }
            const categorySources = sourceLinks[category];
            if (!categorySources) {
                sourceInput.value = '';
                return;
            }
            if (categorySources.default) {
                sourceInput.value = categorySources.default;
                return;
            }
            const phase = statusSelect.value || 'Saison régulière';
            sourceInput.value = categorySources[phase] || '';
        };

        const updateLocationLayout = () => {
            if (locationAway.checked) {
                teamHomeColumn.classList.add('order-md-2');
                teamAwayColumn.classList.add('order-md-1');
                scoreHomeColumn.classList.add('order-md-2');
                scoreAwayColumn.classList.add('order-md-1');
            } else {
                teamHomeColumn.classList.remove('order-md-2');
                teamAwayColumn.classList.remove('order-md-1');
                scoreHomeColumn.classList.remove('order-md-2');
                scoreAwayColumn.classList.remove('order-md-1');
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
