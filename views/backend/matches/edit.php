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
            Equipe_domicile AS teamHome,
            Equipe_exterieure AS teamAway,
            Adversaire AS opponent,
            Score_domicile AS scoreHome,
            Score_exterieur AS scoreAway,
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
                            <label for="section">Section</label>
                            <input id="section" name="section" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['section']); ?>" required />
                        </div>
                        <div class="form-group mt-2">
                            <label for="team">Équipe</label>
                            <input id="team" name="team" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['team']); ?>" required />
                        </div>
                    <?php else : ?>
                    <div class="form-group">
                        <label for="sourceId">Source ID</label>
                        <input id="sourceId" name="sourceId" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['sourceId']); ?>" required />
                    </div>
                    <?php endif; ?>
                    <div class="form-group mt-2">
                        <label for="competition">Compétition</label>
                        <input id="competition" name="competition" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['competition']); ?>" required />
                    </div>
                    <?php if ($ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group mt-2">
                            <label for="matchDay">Journée</label>
                            <input id="matchDay" name="matchDay" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['matchDay']); ?>" required />
                        </div>
                    <?php endif; ?>
                    <div class="form-group mt-2">
                        <label for="matchDate">Date</label>
                        <input id="matchDate" name="matchDate" class="form-control" type="date" value="<?php echo htmlspecialchars($ba_bec_match['matchDate']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="matchTime">Heure</label>
                        <input id="matchTime" name="matchTime" class="form-control" type="time" value="<?php echo htmlspecialchars($ba_bec_displayMatchTime); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
                    </div>
                    <div class="form-group mt-2">
                        <label for="teamHome">Équipe domicile</label>
                        <input id="teamHome" name="teamHome" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamHome']); ?>" required />
                    </div>
                    <div class="form-group mt-2">
                        <label for="teamAway">Équipe extérieur</label>
                        <input id="teamAway" name="teamAway" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['teamAway']); ?>" required />
                    </div>
                    <?php if ($ba_bec_hasBecMatchesTable) : ?>
                        <div class="form-group mt-2">
                            <label for="opponent">Adversaire</label>
                            <input id="opponent" name="opponent" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['opponent']); ?>" required />
                        </div>
                    <?php endif; ?>
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
                        <input id="location" name="location" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['location'] ?? ''); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
                    </div>
                    <div class="form-group mt-2">
                        <label for="status">Statut</label>
                        <input id="status" name="status" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_match['status'] ?? ''); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
                    </div>
                    <div class="form-group mt-2">
                        <label for="sourceUrl"><?php echo $ba_bec_hasBecMatchesTable ? 'Source' : 'Lien source'; ?></label>
                        <input id="sourceUrl" name="sourceUrl" class="form-control" type="<?php echo $ba_bec_hasBecMatchesTable ? 'text' : 'url'; ?>" value="<?php echo htmlspecialchars($ba_bec_match['sourceUrl'] ?? ''); ?>" <?php echo $ba_bec_hasBecMatchesTable ? 'required' : ''; ?> />
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
