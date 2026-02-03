<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

$ba_bec_match = null;
if (isset($_GET['numMatch'])) {
    $ba_bec_numMatch = (int) $_GET['numMatch'];
    $ba_bec_match = sql_select('MATCH_CLUB', '*', "numMatch = $ba_bec_numMatch");
    $ba_bec_match = $ba_bec_match[0] ?? null;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression match</h1>
        </div>
        <div class="col-md-12">
            <?php if ($ba_bec_match) : ?>
                <form action="<?php echo ROOT_URL . '/api/matches/delete.php' ?>" method="post">
                    <div class="form-group">
                        <label for="numMatch">ID match</label>
                        <input id="numMatch" name="numMatch" class="form-control" type="text" value="<?php echo $ba_bec_match['numMatch']; ?>" readonly />
                    </div>
                    <div class="form-group mt-2">
                        <label for="summary">Résumé</label>
                        <input id="summary" name="summary" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamHome'] . ' vs ' . $ba_bec_match['teamAway']); ?>" readonly />
                    </div>
                    <br />
                    <div class="form-group mt-2">
                        <a href="list.php" class="btn btn-primary">Retour à la liste</a>
                        <button type="submit" class="btn btn-danger">Confirmer delete ?</button>
                    </div>
                </form>
            <?php else : ?>
                <div class="alert alert-danger">Match introuvable.</div>
                <a href="list.php" class="btn btn-primary">Retour</a>
            <?php endif; ?>
        </div>
    </div>
</div>
