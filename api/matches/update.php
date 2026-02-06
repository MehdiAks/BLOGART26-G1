<?php
/*
 * Endpoint API: api/matches/update.php
 * Rôle: met à jour un(e) matche existant(e).
 *
 * Déroulé détaillé:
 * 1) Charge la configuration applicative et les helpers (session/DB/sanitisation).
 * 2) Récupère les paramètres POST (et éventuellement FILES) puis les nettoie via ctrlSaisies.
 * 3) Valide les contraintes métier (champs obligatoires, types, formats, tailles).
 * 4) Exécute la requête SQL adaptée (INSERT/UPDATE/DELETE) avec les valeurs préparées.
 * 5) Gère le feedback (flash/session/erreur) et redirige l'utilisateur vers l'écran cible.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

sql_connect();

$ba_bec_numMatch = (int) ($_POST['numMatch'] ?? 0);
$ba_bec_numSaison = (int) ($_POST['numSaison'] ?? 0);
$ba_bec_numCompetition = (int) ($_POST['numCompetition'] ?? 0);
$ba_bec_numPhase = (int) ($_POST['numPhase'] ?? 0);
$ba_bec_numJournee = (int) ($_POST['numJournee'] ?? 0);
$ba_bec_dateMatch = ctrlSaisies($_POST['dateMatch'] ?? '');
$ba_bec_heureMatch = ctrlSaisies($_POST['heureMatch'] ?? '');
$ba_bec_lieuMatch = ctrlSaisies($_POST['lieuMatch'] ?? '');
$ba_bec_numEquipeBec = (int) ($_POST['numEquipeBec'] ?? 0);
$ba_bec_becCote = ctrlSaisies($_POST['becCote'] ?? '');
$ba_bec_nomEquipeAdverse = ctrlSaisies($_POST['nomEquipeAdverse'] ?? '');
$ba_bec_numeroEquipeAdverse = (int) ($_POST['numeroEquipeAdverse'] ?? 0);
$ba_bec_scoreHome = ctrlSaisies($_POST['scoreHome'] ?? '');
$ba_bec_scoreAway = ctrlSaisies($_POST['scoreAway'] ?? '');

if ($ba_bec_numMatch <= 0 || $ba_bec_numSaison <= 0 || $ba_bec_numCompetition <= 0 || $ba_bec_dateMatch === '' || $ba_bec_numEquipeBec <= 0 || $ba_bec_nomEquipeAdverse === '') {
    header('Location: ../../views/backend/matches/edit.php?numMatch=' . $ba_bec_numMatch . '&error=missing');
    exit;
}

if (!in_array($ba_bec_becCote, ['domicile', 'exterieur'], true)) {
    header('Location: ../../views/backend/matches/edit.php?numMatch=' . $ba_bec_numMatch . '&error=team_conflict');
    exit;
}

$ba_bec_numPhaseValue = $ba_bec_numPhase > 0 ? $ba_bec_numPhase : null;
$ba_bec_numJourneeValue = $ba_bec_numJournee > 0 ? $ba_bec_numJournee : null;
$ba_bec_heureValue = $ba_bec_heureMatch !== '' ? $ba_bec_heureMatch : null;
$ba_bec_lieuValue = $ba_bec_lieuMatch !== '' ? $ba_bec_lieuMatch : null;
$ba_bec_scoreHomeValue = $ba_bec_scoreHome !== '' ? (int) $ba_bec_scoreHome : null;
$ba_bec_scoreAwayValue = $ba_bec_scoreAway !== '' ? (int) $ba_bec_scoreAway : null;
$ba_bec_numeroEquipeAdverseValue = $ba_bec_numeroEquipeAdverse > 0 ? $ba_bec_numeroEquipeAdverse : null;

$matchStmt = $DB->prepare(
    'UPDATE `MATCH`
        SET numSaison = :numSaison,
            numCompetition = :numCompetition,
            numPhase = :numPhase,
            numJournee = :numJournee,
            dateMatch = :dateMatch,
            heureMatch = :heureMatch,
            lieuMatch = :lieuMatch
      WHERE numMatch = :numMatch'
);
$matchStmt->execute([
    ':numSaison' => $ba_bec_numSaison,
    ':numCompetition' => $ba_bec_numCompetition,
    ':numPhase' => $ba_bec_numPhaseValue,
    ':numJournee' => $ba_bec_numJourneeValue,
    ':dateMatch' => $ba_bec_dateMatch,
    ':heureMatch' => $ba_bec_heureValue,
    ':lieuMatch' => $ba_bec_lieuValue,
    ':numMatch' => $ba_bec_numMatch,
]);

$participantStmt = $DB->prepare(
    'UPDATE MATCH_PARTICIPANT
        SET numEquipe = :numEquipe,
            score = :score,
            nomEquipeAdverse = :nomEquipeAdverse,
            numeroEquipeAdverse = :numeroEquipeAdverse
      WHERE numMatch = :numMatch AND cote = :cote'
);

$ba_bec_becScore = $ba_bec_becCote === 'domicile' ? $ba_bec_scoreHomeValue : $ba_bec_scoreAwayValue;
$ba_bec_opponentScore = $ba_bec_becCote === 'domicile' ? $ba_bec_scoreAwayValue : $ba_bec_scoreHomeValue;

$participantStmt->execute([
    ':numEquipe' => $ba_bec_numEquipeBec,
    ':score' => $ba_bec_becScore,
    ':nomEquipeAdverse' => null,
    ':numeroEquipeAdverse' => null,
    ':numMatch' => $ba_bec_numMatch,
    ':cote' => $ba_bec_becCote,
]);

if ($participantStmt->rowCount() === 0) {
    $insertStmt = $DB->prepare(
        'INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
         VALUES (:numMatch, :numEquipe, :cote, :score, :nomEquipeAdverse, :numeroEquipeAdverse)'
    );
    $insertStmt->execute([
        ':numMatch' => $ba_bec_numMatch,
        ':numEquipe' => $ba_bec_numEquipeBec,
        ':cote' => $ba_bec_becCote,
        ':score' => $ba_bec_becScore,
        ':nomEquipeAdverse' => null,
        ':numeroEquipeAdverse' => null,
    ]);
}

$participantStmt->execute([
    ':numEquipe' => null,
    ':score' => $ba_bec_opponentScore,
    ':nomEquipeAdverse' => $ba_bec_nomEquipeAdverse,
    ':numeroEquipeAdverse' => $ba_bec_numeroEquipeAdverseValue,
    ':numMatch' => $ba_bec_numMatch,
    ':cote' => $ba_bec_becCote === 'domicile' ? 'exterieur' : 'domicile',
]);

if ($participantStmt->rowCount() === 0) {
    $insertStmt = $DB->prepare(
        'INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
         VALUES (:numMatch, :numEquipe, :cote, :score, :nomEquipeAdverse, :numeroEquipeAdverse)'
    );
    $insertStmt->execute([
        ':numMatch' => $ba_bec_numMatch,
        ':numEquipe' => null,
        ':cote' => $ba_bec_becCote === 'domicile' ? 'exterieur' : 'domicile',
        ':score' => $ba_bec_opponentScore,
        ':nomEquipeAdverse' => $ba_bec_nomEquipeAdverse,
        ':numeroEquipeAdverse' => $ba_bec_numeroEquipeAdverseValue,
    ]);
}

header('Location: ../../views/backend/matches/list.php');
