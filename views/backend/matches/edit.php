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
            <h1>Modifier un match</h1>
        </div>
        <div class="col-md-12">
            <?php if ($ba_bec_match) : ?>
                <form action="<?php echo ROOT_URL . '/api/matches/update.php' ?>" method="post">
                    <input type="hidden" name="numMatch" value="<?php echo $ba_bec_match['numMatch']; ?>" />
                    <div class="form-group">
                        <label for="sourceId">Source ID</label>
                        <input id="sourceId" name="sourceId" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['sourceId']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="competition">Compétition</label>
                        <input id="competition" name="competition" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['competition']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="matchDate">Date</label>
                        <input id="matchDate" name="matchDate" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['matchDate']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="matchTime">Heure</label>
                        <input id="matchTime" name="matchTime" class="form-control" type="time" value="<?php echo htmlspecialchars($ba_bec_match['matchTime'] ?? ''); ?>" />
                    </div>
                    <div class="form-group mt-2">
                        <label for="teamHome">Équipe domicile</label>
                        <input id="teamHome" name="teamHome" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamHome']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="teamAway">Équipe extérieur</label>
                        <input id="teamAway" name="teamAway" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamAway']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="scoreHome">Score domicile</label>
                        <input id="scoreHome" name="scoreHome" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreHome'] ?? ''); ?>" />
                    </div>
                    <div class="form-group mt-2">
                        <label for="scoreAway">Score extérieur</label>
                        <input id="scoreAway" name="scoreAway" class="form-control" type="number" min="0" value="<?php echo htmlspecialchars($ba_bec_match['scoreAway'] ?? ''); ?>" />
                    </div>
                    <div class="form-group mt-2">
                        <label for="location">Lieu</label>
                        <input id="location" name="location" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['location'] ?? ''); ?>" />
                    </div>
                    <div class="form-group mt-2">
                        <label for="status">Statut</label>
                        <input id="status" name="status" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['status'] ?? ''); ?>" />
                    </div>
                    <div class="form-group mt-2">
                        <label for="sourceUrl">Lien source</label>
                        <input id="sourceUrl" name="sourceUrl" class="form-control" type="url" value="<?php echo htmlspecialchars($ba_bec_match['sourceUrl'] ?? ''); ?>" />
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
