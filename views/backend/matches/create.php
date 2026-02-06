<?php // Cette ligne contient: <?php
/* // Cette ligne contient: /*
 * Vue d'administration (création) pour le module matches. // Cette ligne contient: * Vue d'administration (création) pour le module matches.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier. // Cette ligne contient: * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action). // Cette ligne contient: * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation. // Cette ligne contient: * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste. // Cette ligne contient: * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue. // Cette ligne contient: * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */ // Cette ligne contient: */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
$pageStyles = [ROOT_URL . '/src/css/match-create.css']; // Cette ligne contient: $pageStyles = [ROOT_URL . '/src/css/match-create.css'];
include '../../../header.php'; // Cette ligne contient: include '../../../header.php';

sql_connect(); // Cette ligne contient: sql_connect();

$ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Cette ligne contient: $ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC');
$ba_bec_clubs = array_column( // Cette ligne contient: $ba_bec_clubs = array_column(
    sql_select('`MATCH`', 'DISTINCT clubAdversaire', "clubAdversaire <> ''", null, 'clubAdversaire ASC'), // Cette ligne contient: sql_select('`MATCH`', 'DISTINCT clubAdversaire', "clubAdversaire <> ''", null, 'clubAdversaire ASC'),
    'clubAdversaire' // Cette ligne contient: 'clubAdversaire'
); // Cette ligne contient: );
$ba_bec_defaultSaison = '2025-2026'; // Cette ligne contient: $ba_bec_defaultSaison = '2025-2026';
$ba_bec_form = [ // Cette ligne contient: $ba_bec_form = [
    'saison' => $_GET['saison'] ?? $ba_bec_defaultSaison, // Cette ligne contient: 'saison' => $_GET['saison'] ?? $ba_bec_defaultSaison,
    'phase' => $_GET['phase'] ?? '', // Cette ligne contient: 'phase' => $_GET['phase'] ?? '',
    'journee' => $_GET['journee'] ?? '', // Cette ligne contient: 'journee' => $_GET['journee'] ?? '',
    'dateMatch' => $_GET['dateMatch'] ?? '', // Cette ligne contient: 'dateMatch' => $_GET['dateMatch'] ?? '',
    'heureMatch' => $_GET['heureMatch'] ?? '', // Cette ligne contient: 'heureMatch' => $_GET['heureMatch'] ?? '',
    'lieuMatch' => $_GET['lieuMatch'] ?? 'Domicile', // Cette ligne contient: 'lieuMatch' => $_GET['lieuMatch'] ?? 'Domicile',
    'codeEquipe' => $_GET['codeEquipe'] ?? '', // Cette ligne contient: 'codeEquipe' => $_GET['codeEquipe'] ?? '',
    'clubAdversaire' => $_GET['clubAdversaire'] ?? '', // Cette ligne contient: 'clubAdversaire' => $_GET['clubAdversaire'] ?? '',
    'numeroEquipeAdverse' => $_GET['numeroEquipeAdverse'] ?? '', // Cette ligne contient: 'numeroEquipeAdverse' => $_GET['numeroEquipeAdverse'] ?? '',
    'scoreBec' => $_GET['scoreBec'] ?? '', // Cette ligne contient: 'scoreBec' => $_GET['scoreBec'] ?? '',
    'scoreAdversaire' => $_GET['scoreAdversaire'] ?? '', // Cette ligne contient: 'scoreAdversaire' => $_GET['scoreAdversaire'] ?? '',
]; // Cette ligne contient: ];

$ba_bec_saisons = [$ba_bec_defaultSaison]; // Cette ligne contient: $ba_bec_saisons = [$ba_bec_defaultSaison];
$ba_bec_phases = ['Saison régulière', 'Play-off', 'Play-down', 'Coupe']; // Cette ligne contient: $ba_bec_phases = ['Saison régulière', 'Play-off', 'Play-down', 'Coupe'];
$ba_bec_lieux = ['Domicile', 'Extérieur']; // Cette ligne contient: $ba_bec_lieux = ['Domicile', 'Extérieur'];

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
            <h1>Création d'un match</h1> <!-- Cette ligne contient: <h1>Création d'un match</h1> -->
        </div> <!-- Cette ligne contient: </div> -->
        <div class="col-md-12"> <!-- Cette ligne contient: <div class="col-md-12"> -->
            <form action="<?php echo ROOT_URL . '/api/matches/create.php' /* Cette ligne contient: <form action="<?php echo ROOT_URL . '/api/matches/create.php' ?>" method="post"> */ ?>" method="post">
                <div class="form-group"> <!-- Cette ligne contient: <div class="form-group"> -->
                    <label for="saison">Saison</label> <!-- Cette ligne contient: <label for="saison">Saison</label> -->
                    <select id="saison" name="saison" class="form-control" required> <!-- Cette ligne contient: <select id="saison" name="saison" class="form-control" required> -->
                        <?php foreach ($ba_bec_saisons as $ba_bec_saison): /* Cette ligne contient: <?php foreach ($ba_bec_saisons as $ba_bec_saison): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_saison); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_saison); ?>" */ ?>"
                                <?php echo $ba_bec_form['saison'] === $ba_bec_saison ? 'selected' : ''; /* Cette ligne contient: <?php echo $ba_bec_form['saison'] === $ba_bec_saison ? 'selected' : ''; ?>> */ ?>>
                                <?php echo htmlspecialchars($ba_bec_saison); /* Cette ligne contient: <?php echo htmlspecialchars($ba_bec_saison); ?> */ ?>
                            </option> <!-- Cette ligne contient: </option> -->
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </select> <!-- Cette ligne contient: </select> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                    <label for="phase">Phase</label> <!-- Cette ligne contient: <label for="phase">Phase</label> -->
                    <select id="phase" name="phase" class="form-control" required> <!-- Cette ligne contient: <select id="phase" name="phase" class="form-control" required> -->
                        <option value="" disabled <?php echo $ba_bec_form['phase'] === '' ? 'selected' : ''; /* Cette ligne contient: <option value="" disabled <?php echo $ba_bec_form['phase'] === '' ? 'selected' : ''; ?>>Sélectionner une phase</option> */ ?>>Sélectionner une phase</option>
                        <?php foreach ($ba_bec_phases as $ba_bec_phase): /* Cette ligne contient: <?php foreach ($ba_bec_phases as $ba_bec_phase): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_phase); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_phase); ?>" */ ?>"
                                <?php echo $ba_bec_form['phase'] === $ba_bec_phase ? 'selected' : ''; /* Cette ligne contient: <?php echo $ba_bec_form['phase'] === $ba_bec_phase ? 'selected' : ''; ?>> */ ?>>
                                <?php echo htmlspecialchars($ba_bec_phase); /* Cette ligne contient: <?php echo htmlspecialchars($ba_bec_phase); ?> */ ?>
                            </option> <!-- Cette ligne contient: </option> -->
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </select> <!-- Cette ligne contient: </select> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                    <label for="journee">Journée</label> <!-- Cette ligne contient: <label for="journee">Journée</label> -->
                    <input id="journee" name="journee" class="form-control" type="text" placeholder="Ex: J3" value="<?php echo htmlspecialchars($ba_bec_form['journee']); /* Cette ligne contient: <input id="journee" name="journee" class="form-control" type="text" placeholder="Ex: J3" value="<?php echo htmlspecialchars($ba_bec_form['journee']); ?>" required /> */ ?>" required />
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2 row"> <!-- Cette ligne contient: <div class="form-group mt-2 row"> -->
                    <div class="col-md-4"> <!-- Cette ligne contient: <div class="col-md-4"> -->
                        <label for="dateMatch">Date</label> <!-- Cette ligne contient: <label for="dateMatch">Date</label> -->
                        <input id="dateMatch" name="dateMatch" class="form-control" type="date" placeholder="JJ/MM/AAAA" value="<?php echo htmlspecialchars($ba_bec_form['dateMatch']); /* Cette ligne contient: <input id="dateMatch" name="dateMatch" class="form-control" type="date" placeholder="JJ/MM/AAAA" value="<?php echo htmlspecialchars($ba_bec_form['dateMatch']); ?>" required /> */ ?>" required />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="col-md-4"> <!-- Cette ligne contient: <div class="col-md-4"> -->
                        <label for="heureMatch">Heure</label> <!-- Cette ligne contient: <label for="heureMatch">Heure</label> -->
                        <input id="heureMatch" name="heureMatch" class="form-control" type="time" placeholder="HH:MM" value="<?php echo htmlspecialchars($ba_bec_form['heureMatch']); /* Cette ligne contient: <input id="heureMatch" name="heureMatch" class="form-control" type="time" placeholder="HH:MM" value="<?php echo htmlspecialchars($ba_bec_form['heureMatch']); ?>" /> */ ?>" />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="col-md-4"> <!-- Cette ligne contient: <div class="col-md-4"> -->
                        <label for="lieuMatch">Lieu</label> <!-- Cette ligne contient: <label for="lieuMatch">Lieu</label> -->
                        <select id="lieuMatch" name="lieuMatch" class="form-control" required> <!-- Cette ligne contient: <select id="lieuMatch" name="lieuMatch" class="form-control" required> -->
                            <?php foreach ($ba_bec_lieux as $ba_bec_lieu): /* Cette ligne contient: <?php foreach ($ba_bec_lieux as $ba_bec_lieu): ?> */ ?>
                                <option value="<?php echo htmlspecialchars($ba_bec_lieu); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_lieu); ?>" */ ?>"
                                    <?php echo $ba_bec_form['lieuMatch'] === $ba_bec_lieu ? 'selected' : ''; /* Cette ligne contient: <?php echo $ba_bec_form['lieuMatch'] === $ba_bec_lieu ? 'selected' : ''; ?>> */ ?>>
                                    <?php echo htmlspecialchars($ba_bec_lieu); /* Cette ligne contient: <?php echo htmlspecialchars($ba_bec_lieu); ?> */ ?>
                                </option> <!-- Cette ligne contient: </option> -->
                            <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                        </select> <!-- Cette ligne contient: </select> -->
                    </div> <!-- Cette ligne contient: </div> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <label for="codeEquipe">Équipe du club (BEC)</label> <!-- Cette ligne contient: <label for="codeEquipe">Équipe du club (BEC)</label> -->
                    <select id="codeEquipe" name="codeEquipe" class="form-control" required> <!-- Cette ligne contient: <select id="codeEquipe" name="codeEquipe" class="form-control" required> -->
                        <option value="" disabled <?php echo $ba_bec_form['codeEquipe'] === '' ? 'selected' : ''; /* Cette ligne contient: <option value="" disabled <?php echo $ba_bec_form['codeEquipe'] === '' ? 'selected' : ''; ?>>Sélectionner l'équipe BEC</option> */ ?>>Sélectionner l'équipe BEC</option>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): /* Cette ligne contient: <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>" */ ?>"
                                <?php echo $ba_bec_form['codeEquipe'] === $ba_bec_equipe['codeEquipe'] ? 'selected' : ''; /* Cette ligne contient: <?php echo $ba_bec_form['codeEquipe'] === $ba_bec_equipe['codeEquipe'] ? 'selected' : ''; ?>> */ ?>>
                                <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); /* Cette ligne contient: <?php echo htmlspecialchars(ba_bec_team_label($ba_bec_equipe)); ?> */ ?>
                            </option> <!-- Cette ligne contient: </option> -->
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </select> <!-- Cette ligne contient: </select> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <label for="clubAdversaire">Club adverse</label> <!-- Cette ligne contient: <label for="clubAdversaire">Club adverse</label> -->
                    <input id="clubAdversaire" name="clubAdversaire" class="form-control" type="text" placeholder="Nom du club adverse" value="<?php echo htmlspecialchars($ba_bec_form['clubAdversaire']); /* Cette ligne contient: <input id="clubAdversaire" name="clubAdversaire" class="form-control" type="text" placeholder="Nom du club adverse" value="<?php echo htmlspecialchars($ba_bec_form['clubAdversaire']); ?>" list="clubAdversaireSuggestions" required /> */ ?>" list="clubAdversaireSuggestions" required />
                    <datalist id="clubAdversaireSuggestions"> <!-- Cette ligne contient: <datalist id="clubAdversaireSuggestions"> -->
                        <?php foreach ($ba_bec_clubs as $ba_bec_club): /* Cette ligne contient: <?php foreach ($ba_bec_clubs as $ba_bec_club): ?> */ ?>
                            <option value="<?php echo htmlspecialchars($ba_bec_club); /* Cette ligne contient: <option value="<?php echo htmlspecialchars($ba_bec_club); ?>"></option> */ ?>"></option>
                        <?php endforeach; /* Cette ligne contient: <?php endforeach; ?> */ ?>
                    </datalist> <!-- Cette ligne contient: </datalist> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                    <label for="numeroEquipeAdverse">Équipe adverse (1/2/3/4…)</label> <!-- Cette ligne contient: <label for="numeroEquipeAdverse">Équipe adverse (1/2/3/4…)</label> -->
                    <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" placeholder="1" value="<?php echo htmlspecialchars($ba_bec_form['numeroEquipeAdverse']); /* Cette ligne contient: <input id="numeroEquipeAdverse" name="numeroEquipeAdverse" class="form-control" type="number" min="1" step="1" placeholder="1" value="<?php echo htmlspecialchars($ba_bec_form['numeroEquipeAdverse']); ?>" /> */ ?>" />
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-2 row"> <!-- Cette ligne contient: <div class="form-group mt-2 row"> -->
                    <div class="col-md-6"> <!-- Cette ligne contient: <div class="col-md-6"> -->
                        <label for="scoreBec">Score BEC</label> <!-- Cette ligne contient: <label for="scoreBec">Score BEC</label> -->
                        <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" placeholder="Score (ex: 75)" value="<?php echo htmlspecialchars($ba_bec_form['scoreBec']); /* Cette ligne contient: <input id="scoreBec" name="scoreBec" class="form-control" type="number" min="0" placeholder="Score (ex: 75)" value="<?php echo htmlspecialchars($ba_bec_form['scoreBec']); ?>" /> */ ?>" />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="col-md-6"> <!-- Cette ligne contient: <div class="col-md-6"> -->
                        <label for="scoreAdversaire">Score adverse</label> <!-- Cette ligne contient: <label for="scoreAdversaire">Score adverse</label> -->
                        <input id="scoreAdversaire" name="scoreAdversaire" class="form-control" type="number" min="0" placeholder="Score (ex: 68)" value="<?php echo htmlspecialchars($ba_bec_form['scoreAdversaire']); /* Cette ligne contient: <input id="scoreAdversaire" name="scoreAdversaire" class="form-control" type="number" min="0" placeholder="Score (ex: 68)" value="<?php echo htmlspecialchars($ba_bec_form['scoreAdversaire']); ?>" /> */ ?>" />
                    </div> <!-- Cette ligne contient: </div> -->
                    <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small> <!-- Cette ligne contient: <small class="form-text text-muted">Laisser vide si le match n'a pas encore eu lieu.</small> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <div class="form-check"> <!-- Cette ligne contient: <div class="form-check"> -->
                        <input id="createRetour" name="createRetour" class="form-check-input" type="checkbox" value="1" /> <!-- Cette ligne contient: <input id="createRetour" name="createRetour" class="form-check-input" type="checkbox" value="1" /> -->
                        <label class="form-check-label" for="createRetour">Créer le match retour</label> <!-- Cette ligne contient: <label class="form-check-label" for="createRetour">Créer le match retour</label> -->
                    </div> <!-- Cette ligne contient: </div> -->
                </div> <!-- Cette ligne contient: </div> -->
                <div class="form-group mt-3"> <!-- Cette ligne contient: <div class="form-group mt-3"> -->
                    <a href="list.php" class="btn btn-primary">Annuler</a> <!-- Cette ligne contient: <a href="list.php" class="btn btn-primary">Annuler</a> -->
                    <button type="submit" class="btn btn-success">Créer le match</button> <!-- Cette ligne contient: <button type="submit" class="btn btn-success">Créer le match</button> -->
                </div> <!-- Cette ligne contient: </div> -->
            </form> <!-- Cette ligne contient: </form> -->
        </div> <!-- Cette ligne contient: </div> -->
    </div> <!-- Cette ligne contient: </div> -->
</div> <!-- Cette ligne contient: </div> -->
