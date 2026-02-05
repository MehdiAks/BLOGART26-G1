<?php
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
$ba_bec_numEquipeHome = (int) ($_POST['numEquipeHome'] ?? 0);
$ba_bec_numEquipeAway = (int) ($_POST['numEquipeAway'] ?? 0);
$ba_bec_scoreHome = ctrlSaisies($_POST['scoreHome'] ?? '');
$ba_bec_scoreAway = ctrlSaisies($_POST['scoreAway'] ?? '');

if ($ba_bec_numMatch <= 0 || $ba_bec_numSaison <= 0 || $ba_bec_numCompetition <= 0 || $ba_bec_dateMatch === '' || $ba_bec_numEquipeHome <= 0 || $ba_bec_numEquipeAway <= 0) {
    header('Location: ../../views/backend/matches/edit.php?numMatch=' . $ba_bec_numMatch . '&error=missing');
    exit;
}

if ($ba_bec_numEquipeHome === $ba_bec_numEquipeAway) {
    header('Location: ../../views/backend/matches/edit.php?numMatch=' . $ba_bec_numMatch . '&error=team_conflict');
    exit;
}

$ba_bec_numPhaseValue = $ba_bec_numPhase > 0 ? $ba_bec_numPhase : null;
$ba_bec_numJourneeValue = $ba_bec_numJournee > 0 ? $ba_bec_numJournee : null;
$ba_bec_heureValue = $ba_bec_heureMatch !== '' ? $ba_bec_heureMatch : null;
$ba_bec_lieuValue = $ba_bec_lieuMatch !== '' ? $ba_bec_lieuMatch : null;
$ba_bec_scoreHomeValue = $ba_bec_scoreHome !== '' ? (int) $ba_bec_scoreHome : null;
$ba_bec_scoreAwayValue = $ba_bec_scoreAway !== '' ? (int) $ba_bec_scoreAway : null;

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
            score = :score
      WHERE numMatch = :numMatch AND cote = :cote'
);

$participantStmt->execute([
    ':numEquipe' => $ba_bec_numEquipeHome,
    ':score' => $ba_bec_scoreHomeValue,
    ':numMatch' => $ba_bec_numMatch,
    ':cote' => 'domicile',
]);

if ($participantStmt->rowCount() === 0) {
    $insertStmt = $DB->prepare(
        'INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score)
         VALUES (:numMatch, :numEquipe, :cote, :score)'
    );
    $insertStmt->execute([
        ':numMatch' => $ba_bec_numMatch,
        ':numEquipe' => $ba_bec_numEquipeHome,
        ':cote' => 'domicile',
        ':score' => $ba_bec_scoreHomeValue,
    ]);
}

$participantStmt->execute([
    ':numEquipe' => $ba_bec_numEquipeAway,
    ':score' => $ba_bec_scoreAwayValue,
    ':numMatch' => $ba_bec_numMatch,
    ':cote' => 'exterieur',
]);

if ($participantStmt->rowCount() === 0) {
    $insertStmt = $DB->prepare(
        'INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score)
         VALUES (:numMatch, :numEquipe, :cote, :score)'
    );
    $insertStmt->execute([
        ':numMatch' => $ba_bec_numMatch,
        ':numEquipe' => $ba_bec_numEquipeAway,
        ':cote' => 'exterieur',
        ':score' => $ba_bec_scoreAwayValue,
    ]);
}

header('Location: ../../views/backend/matches/list.php');
