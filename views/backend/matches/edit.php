<?php // Cette ligne contient: <?php
/* // Cette ligne contient: /*
 * Vue d'administration (édition) pour le module matches. // Cette ligne contient: * Vue d'administration (édition) pour le module matches.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur. // Cette ligne contient: * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés. // Cette ligne contient: * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
 * - L'action du formulaire cible la route de mise à jour correspondante. // Cette ligne contient: * - L'action du formulaire cible la route de mise à jour correspondante.
 */ // Cette ligne contient: */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css']; // Cette ligne contient: $pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php'; // Cette ligne contient: include '../../../header.php';

if (!isset($_GET['numMatch'])) { // Cette ligne contient: if (!isset($_GET['numMatch'])) {
    header('Location: ' . ROOT_URL . '/views/backend/matches/list.php'); // Cette ligne contient: header('Location: ' . ROOT_URL . '/views/backend/matches/list.php');
    exit; // Cette ligne contient: exit;
} // Cette ligne contient: }

sql_connect(); // Cette ligne contient: sql_connect();

$ba_bec_numMatch = (int) $_GET['numMatch']; // Cette ligne contient: $ba_bec_numMatch = (int) $_GET['numMatch'];
$ba_bec_match = null; // Cette ligne contient: $ba_bec_match = null;
if ($ba_bec_numMatch) { // Cette ligne contient: if ($ba_bec_numMatch) {
    $stmt = $DB->prepare('SELECT * FROM `MATCH` WHERE numMatch = :numMatch'); // Cette ligne contient: $stmt = $DB->prepare('SELECT * FROM `MATCH` WHERE numMatch = :numMatch');
    $stmt->execute([':numMatch' => $ba_bec_numMatch]); // Cette ligne contient: $stmt->execute([':numMatch' => $ba_bec_numMatch]);
    $ba_bec_match = $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Cette ligne contient: $ba_bec_match = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
} // Cette ligne contient: }

if (!$ba_bec_match) { // Cette ligne contient: if (!$ba_bec_match) {
    header('Location: ' . ROOT_URL . '/views/backend/matches/list.php'); // Cette ligne contient: header('Location: ' . ROOT_URL . '/views/backend/matches/list.php');
    exit; // Cette ligne contient: exit;
} // Cette ligne contient: }

$ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Cette ligne contient: $ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC');
$ba_bec_clubs = array_column( // Cette ligne contient: $ba_bec_clubs = array_column(
    sql_select('`MATCH`', 'DISTINCT clubAdversaire', "clubAdversaire <> ''", null, 'clubAdversaire ASC'), // Cette ligne contient: sql_select('`MATCH`', 'DISTINCT clubAdversaire', "clubAdversaire <> ''", null, 'clubAdversaire ASC'),
    'clubAdversaire' // Cette ligne contient: 'clubAdversaire'
); // Cette ligne contient: );
$ba_bec_defaultSaison = '2025-2026'; // Cette ligne contient: $ba_bec_defaultSaison = '2025-2026';
$ba_bec_saisons = [$ba_bec_defaultSaison]; // Cette ligne contient: $ba_bec_saisons = [$ba_bec_defaultSaison];
$ba_bec_phases = ['Saison régulière', 'Play-off', 'Play-down', 'Coupe']; // Cette ligne contient: $ba_bec_phases = ['Saison régulière', 'Play-off', 'Play-down', 'Coupe'];
$ba_bec_lieux = ['Domicile', 'Extérieur']; // Cette ligne contient: $ba_bec_lieux = ['Domicile', 'Extérieur'];

$ba_bec_currentSaison = $ba_bec_match['saison'] ?? $ba_bec_defaultSaison; // Cette ligne contient: $ba_bec_currentSaison = $ba_bec_match['saison'] ?? $ba_bec_defaultSaison;
if ($ba_bec_currentSaison !== '' && !in_array($ba_bec_currentSaison, $ba_bec_saisons, true)) { // Cette ligne contient: if ($ba_bec_currentSaison !== '' && !in_array($ba_bec_currentSaison, $ba_bec_saisons, true)) {
    $ba_bec_saisons[] = $ba_bec_currentSaison; // Cette ligne contient: $ba_bec_saisons[] = $ba_bec_currentSaison;
} // Cette ligne contient: }
$ba_bec_currentPhase = $ba_bec_match['phase'] ?? ''; // Cette ligne contient: $ba_bec_currentPhase = $ba_bec_match['phase'] ?? '';
if ($ba_bec_currentPhase !== '' && !in_array($ba_bec_currentPhase, $ba_bec_phases, true)) { // Cette ligne contient: if ($ba_bec_currentPhase !== '' && !in_array($ba_bec_currentPhase, $ba_bec_phases, true)) {
    $ba_bec_phases[] = $ba_bec_currentPhase; // Cette ligne contient: $ba_bec_phases[] = $ba_bec_currentPhase;
} // Cette ligne contient: }
$ba_bec_currentLieu = $ba_bec_match['lieuMatch'] ?? ''; // Cette ligne contient: $ba_bec_currentLieu = $ba_bec_match['lieuMatch'] ?? '';
if ($ba_bec_currentLieu !== '' && !in_array($ba_bec_currentLieu, $ba_bec_lieux, true)) { // Cette ligne contient: if ($ba_bec_currentLieu !== '' && !in_array($ba_bec_currentLieu, $ba_bec_lieux, true)) {
    $ba_bec_lieux[] = $ba_bec_currentLieu; // Cette ligne contient: $ba_bec_lieux[] = $ba_bec_currentLieu;
} // Cette ligne contient: }

function ba_bec_team_label(array $team): string // Cette ligne contient: function ba_bec_team_label(array $team): string
{ // Cette ligne contient: {
    $label = $team['nomEquipe'] ?? ''; // Cette ligne contient: $label = $team['nomEquipe'] ?? '';
    $code = $team['codeEquipe'] ?? ''; // Cette ligne contient: $code = $team['codeEquipe'] ?? '';
    return $code !== '' ? $label . ' (' . $code . ')' : $label; // Cette ligne contient: return $code !== '' ? $label . ' (' . $code . ')' : $label;
} // Cette ligne contient: }
/* Cette ligne contient: ?> */ ?>

<div class="container"> <!-- Cette ligne contient: <div class="container"> -->
    <div class="row"> <!-- Cette ligne contient: <div class="row"> -->
        <div class="col-md-12"> <!-- Cette ligne contient: <div class="col-md-12"> -->
            <h1>Modifier un match</h1> <!-- Cette ligne contient: <h1>Modifier un match</h1> -->
        </div> <!-- Cette ligne contient: </div> -->
        <div class="col-md-12"> <!-- Cette ligne contient: <div class="col-md-12"> -->
            <form action="<?php echo ROOT_URL . '/api/matches/update.php' /* Cette ligne contient: <form action="<?php echo ROOT_URL . '/api/matches/update.php' ?>" method="post"> */ ?>" method="post">
                <input type="hidden" name="numMatch" value="<?php echo htmlspecialchars((string) $ba_bec_match['numMatch']); /* Cette ligne contient: <input type="hidden" name="numMatch" value="<?php echo htmlspecialchars((string) $ba_bec_match['numMatch']); ?>" /> */ ?>" />
                <div class="form-group"> <!-- Cette ligne contient: <div class="form-group"> -->
                    <label for="saison">Saison</label> <!-- Cette ligne contient: <label for="saison">Saison</label> -->
                    <select id="saison" name="saison" class="form-control" required> <!-- Cette ligne contient: <select id="saison" name="saison" class="form-control" required> -->
                        <?php foreach ($ba_bec_saisons as $ba_bec_saison): /* Cette ligne contient: <?php foreach ($ba_bec_saisons as $ba_bec_saison): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_saison); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_saison); ?>" */ ?>"
                                <?php echo ($ba_bec_match['saison'] ?? $ba_bec_defaultSaison) === $ba_bec_saison ? 'selected' : ''; /* Cette ligne contient: <?php echo ($ba_bec_match['saison'] ?? $ba_bec_defaultSaison) === $ba_bec_saison ? 'selected' : ''; ?>> */ ?>>
                                <?php echo htmlspecialchars($ba_bec_saison); /* Cette ligne contient: <?php echo htmlspecialchars($ba_bec_saison); ?> */ ?>
                            </option> <!-- Cette ligne contient: </option> -->
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </select> <!-- Cette ligne contient: </select> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                    <label for="phase">Phase</label> <!-- Cette ligne contient: <label for="phase">Phase</label> -->
                    <select id="phase" name="phase" class="form-control" required> <!-- Cette ligne contient: <select id="phase" name="phase" class="form-control" required> -->
                        <?php foreach ($ba_bec_phases as $ba_bec_phase): /* Cette ligne contient: <?php foreach ($ba_bec_phases as $ba_bec_phase): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_phase); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_phase); ?>" */ ?>"
                                <?php echo ($ba_bec_match['phase'] ?? '') === $ba_bec_phase ? 'selected' : ''; /* Cette ligne contient: <?php echo ($ba_bec_match['phase'] ?? '') === $ba_bec_phase ? 'selected' : ''; ?>> */ ?>>
                                <?php echo htmlspecialchars($ba_bec_phase); /* Cette ligne contient: <?php echo htmlspecialchars($ba_bec_phase); ?> */ ?>
                            </option> <!-- Cette ligne contient: </option> -->
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </select> <!-- Cette ligne contient: </select> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                    <label for="journee">Journée</label> <!-- Cette ligne contient: <label for="journee">Journée</label> -->
                    <input id="journee" name="journee" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['journee'] ?? ''); /* Cette ligne contient: <input id="journee" name="journee" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['journee'] ?? ''); ?>" required /> */ ?>" required />
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2 row"> <!-- Cette ligne contient: <div class="form-group mt-2 row"> -->
                    <div class="col-md-4"> <!-- Cette ligne contient: <div class="col-md-4"> -->
                        <label for="dateMatch">Date</label> <!-- Cette ligne contient: <label for="dateMatch">Date</label> -->
                        <input id="dateMatch" name="dateMatch" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['dateMatch'] ?? ''); /* Cette ligne contient: <input id="dateMatch" name="dateMatch" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['dateMatch'] ?? ''); ?>" required /> */ ?>" required />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="col-md-4"> <!-- Cette ligne contient: <div class="col-md-4"> -->
                        <label for="heureMatch">Heure</label> <!-- Cette ligne contient: <label for="heureMatch">Heure</label> -->
                        <input id="heureMatch" name="heureMatch" class="form-control" type="time" value="<?php echo htmlspecialchars($ba_bec_match['heureMatch'] ?? ''); /* Cette ligne contient: <input id="heureMatch" name="heureMatch" class="form-control" type="time" value="<?php echo htmlspecialchars($ba_bec_match['heureMatch'] ?? ''); ?>" /> */ ?>" />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="col-md-4"> <!-- Cette ligne contient: <div class="col-md-4"> -->
                        <label for="lieuMatch">Lieu</label> <!-- Cette ligne contient: <label for="lieuMatch">Lieu</label> -->
                        <select id="lieuMatch" name="lieuMatch" class="form-control" required> <!-- Cette ligne contient: <select id="lieuMatch" name="lieuMatch" class="form-control" required> -->
                            <?php foreach ($ba_bec_lieux as $ba_bec_lieu): /* Cette ligne contient: <?php foreach ($ba_bec_lieux as $ba_bec_lieu): ?> */ ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_lieu); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_lieu); ?>" */ ?>"
                                    <?php echo ($ba_bec_match['lieuMatch'] ?? '') === $ba_bec_lieu ? 'selected' : ''; /* Cette ligne contient: <?php echo ($ba_bec_match['lieuMatch'] ?? '') === $ba_bec_lieu ? 'selected' : ''; ?>> */ ?>>
                                    <?php echo htmlspecialchars($ba_bec_lieu); /* Cette ligne contient: <?php echo htmlspecialchars($ba_bec_lieu); ?> */ ?>
                                </option> <!-- Cette ligne contient: </option> -->
                            <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                        </select> <!-- Cette ligne contient: </select> -->
                    </div> <!-- Cette ligne contient: </div> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <label for="codeEquipe">Équipe du club (BEC)</label> <!-- Cette ligne contient: <label for="codeEquipe">Équipe du club (BEC)</label> -->
                    <select id="codeEquipe" name="codeEquipe" class="form-control" required> <!-- Cette ligne contient: <select id="codeEquipe" name="codeEquipe" class="form-control" required> -->
                        <option value="" disabled>Sélectionner l'équipe BEC</option> <!-- Cette ligne contient: <option value="" disabled>Sélectionner l'équipe BEC</option> -->
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): /* Cette ligne contient: <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>" */ ?>"
                                <?php echo ($ba_bec_match['codeEquipe'] ?? '') === $ba_bec_equipe['codeEquipe'] ? 'selected' : ''; /* Cette ligne contient: <?php echo ($ba_bec_match['codeEquipe'] ?? '') === $ba_bec_equipe['codeEquipe'] ? 'selected' : ''; ?>> */ ?>>
                                <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); /* Cette ligne contient: <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?> */ ?>
                            </option> <!-- Cette ligne contient: </option> -->
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </select> <!-- Cette ligne contient: </select> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <label for="clubAdversaire">Club adverse</label> <!-- Cette ligne contient: <label for="clubAdversaire">Club adverse</label> -->
                    <input id="clubAdversaire" name="clubAdversaire" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['clubAdversaire'] ?? ''); /* Cette ligne contient: <input id="clubAdversaire" name="clubAdversaire" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['clubAdversaire'] ?? ''); ?>" list="clubAdversaireSuggestions" required /> */ ?>" list="clubAdversaireSuggestions" required />
                    <datalist id="clubAdversaireSuggestions"> <!-- Cette ligne contient: <datalist id="clubAdversaireSuggestions"> -->
                        <?php foreach ($ba_bec_clubs as $ba_bec_club): /* Cette ligne contient: <?php foreach ($ba_bec_clubs as $ba_bec_club): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_club); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_club); ?>"></option> */ ?>"></option>
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </datalist> <!-- Cette ligne contient: </datalist> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                    <label for="numeroEquipeAdverse">Équipe adverse (1/2/3/4…)</label> <!-- Cette ligne contient: <label for="numeroEquipeAdverse">Équipe adverse (1/2/3/4…)</label> -->
                    <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" value="<?php echo htmlspecialchars($ba_bec_match['numEquipeAdverse'] ?? ''); /* Cette ligne contient: <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" value="<?php echo htmlspecialchars($ba_bec_match['numEquipeAdverse'] ?? ''); ?>" /> */ ?>" />
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2 row"> <!-- Cette ligne contient: <div class="form-group mt-2 row"> -->
                    <div class="col-md-6"> <!-- Cette ligne contient: <div class="col-md-6"> -->
                        <label for="scoreBec">Score BEC</label> <!-- Cette ligne contient: <label for="scoreBec">Score BEC</label> -->
                        <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreBec'] ?? ''); /* Cette ligne contient: <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreBec'] ?? ''); ?>" /> */ ?>" />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="col-md-6"> <!-- Cette ligne contient: <div class="col-md-6"> -->
                        <label for="scoreAdversaire">Score adverse</label> <!-- Cette ligne contient: <label for="scoreAdversaire">Score adverse</label> -->
                        <input id="scoreAdversaire" name="scoreAdversaire" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreAdversaire'] ?? ''); /* Cette ligne contient: <input id="scoreAdversaire" name="scoreAdversaire" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreAdversaire'] ?? ''); ?>" /> */ ?>" />
                    </div> <!-- Cette ligne contient: </div> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <a href="list.php" class="btn btn-primary">Annuler</a> <!-- Cette ligne contient: <a href="list.php" class="btn btn-primary">Annuler</a> -->
                    <button type="submit" class="btn btn-success">Enregistrer</button> <!-- Cette ligne contient: <button type="submit" class="btn btn-success">Enregistrer</button> -->
                </div> <!-- Cette ligne contient: </div> -->
            </form> <!-- Cette ligne contient: </form> -->
        </div> <!-- Cette ligne contient: </div> -->
    </div> <!-- Cette ligne contient: </div> -->
</div> <!-- Cette ligne contient: </div> -->
