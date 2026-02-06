<?php // Cette ligne contient: <?php
/* // Cette ligne contient: /*
 * Vue d'administration (suppression) pour le module matches. // Cette ligne contient: * Vue d'administration (suppression) pour le module matches.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement. // Cette ligne contient: * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
 */ // Cette ligne contient: */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php'; // Cette ligne contient: include '../../../header.php';

sql_connect(); // Cette ligne contient: sql_connect();

$ba_bec_match = null; // Cette ligne contient: $ba_bec_match = null;
if (isset($_GET['numMatch'])) { // Cette ligne contient: if (isset($_GET['numMatch'])) {
    $ba_bec_numMatch = (int) $_GET['numMatch']; // Cette ligne contient: $ba_bec_numMatch = (int) $_GET['numMatch'];
    $stmt = $DB->prepare('SELECT m.*, e.nomEquipe FROM `MATCH` m INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe WHERE m.numMatch = :numMatch'); // Cette ligne contient: $stmt = $DB->prepare('SELECT m.*, e.nomEquipe FROM `MATCH` m INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe WHERE m.numMatch = :numMatch');
    $stmt->execute([':numMatch' => $ba_bec_numMatch]); // Cette ligne contient: $stmt->execute([':numMatch' => $ba_bec_numMatch]);
    $ba_bec_match = $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Cette ligne contient: $ba_bec_match = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
} // Cette ligne contient: }
/* Cette ligne contient: ?> */ ?>

<div class="container"> <!-- Cette ligne contient: <div class="container"> -->
    <div class="row"> <!-- Cette ligne contient: <div class="row"> -->
        <div class="col-md-12"> <!-- Cette ligne contient: <div class="col-md-12"> -->
            <h1>Suppression match</h1> <!-- Cette ligne contient: <h1>Suppression match</h1> -->
        </div> <!-- Cette ligne contient: </div> -->
        <div class="col-md-12"> <!-- Cette ligne contient: <div class="col-md-12"> -->
            <?php if ($ba_bec_match) : /* Cette ligne contient: <?php if ($ba_bec_match) : ?> */ ?>
                <form action="<?php echo ROOT_URL . '/api/matches/delete.php' /* Cette ligne contient: <form action="<?php echo ROOT_URL . '/api/matches/delete.php' ?>" method="post"> */ ?>" method="post">
                    <div class="form-group"> <!-- Cette ligne contient: <div class="form-group"> -->
                        <label for="numMatch">ID match</label> <!-- Cette ligne contient: <label for="numMatch">ID match</label> -->
                        <input id="numMatch" name="numMatch" class="form-control" type="text" value="<?php echo htmlspecialchars((string) $ba_bec_match['numMatch']); /* Cette ligne contient: <input id="numMatch" name="numMatch" class="form-control" type="text" value="<?php echo htmlspecialchars((string) $ba_bec_match['numMatch']); ?>" readonly /> */ ?>" readonly />
                    </div> <!-- Cette ligne contient: </div> -->
                    <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                        <label for="summary">Résumé</label> <!-- Cette ligne contient: <label for="summary">Résumé</label> -->
                        <input id="summary" name="summary" class="form-control" type="text" <!-- Cette ligne contient: <input id="summary" name="summary" class="form-control" type="text" -->
                            value="<?php echo htmlspecialchars(($ba_bec_match['nomEquipe'] ?? 'BEC') . ' vs ' . ($ba_bec_match['clubAdversaire'] ?? 'Adversaire')); /* Cette ligne contient: value="<?php echo htmlspecialchars(($ba_bec_match['nomEquipe'] ?? 'BEC') . ' vs ' . ($ba_bec_match['clubAdversaire'] ?? 'Adversaire')); ?>" readonly /> */ ?>" readonly />
                    </div> <!-- Cette ligne contient: </div> -->
                    <br /> <!-- Cette ligne contient: <br /> -->
                    <div class="form-group mt-2"> <!-- Cette ligne contient: <div class="form-group mt-2"> -->
                        <a href="list.php" class="btn btn-primary">Retour à la liste</a> <!-- Cette ligne contient: <a href="list.php" class="btn btn-primary">Retour à la liste</a> -->
                        <button type="submit" class="btn btn-danger">Confirmer delete ?</button> <!-- Cette ligne contient: <button type="submit" class="btn btn-danger">Confirmer delete ?</button> -->
                    </div> <!-- Cette ligne contient: </div> -->
                </form> <!-- Cette ligne contient: </form> -->
            <?php else : /* Cette ligne contient: <?php else : ?> */ ?>
                <div class="alert alert-danger">Match introuvable.</div> <!-- Cette ligne contient: <div class="alert alert-danger">Match introuvable.</div> -->
                <a href="list.php" class="btn btn-primary">Retour</a> <!-- Cette ligne contient: <a href="list.php" class="btn btn-primary">Retour</a> -->
            <?php endif; /* Cette ligne contient: <?php endif; ?> */ ?>
        </div> <!-- Cette ligne contient: </div> -->
    </div> <!-- Cette ligne contient: </div> -->
</div> <!-- Cette ligne contient: </div> -->
