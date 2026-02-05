<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

$ba_bec_match = null;
if (isset($_GET['numMatch'])) {
    $ba_bec_numMatch = (int) $_GET['numMatch'];
    if ($ba_bec_numMatch > 0) {
        $stmt = $DB->prepare(
            "SELECT m.numMatch,
                    home_team.libEquipe AS teamHome,
                    away_team.libEquipe AS teamAway
             FROM `MATCH` m
             LEFT JOIN MATCH_PARTICIPANT home_part ON m.numMatch = home_part.numMatch AND home_part.cote = 'domicile'
             LEFT JOIN MATCH_PARTICIPANT away_part ON m.numMatch = away_part.numMatch AND away_part.cote = 'exterieur'
             LEFT JOIN EQUIPE home_team ON home_part.numEquipe = home_team.numEquipe
             LEFT JOIN EQUIPE away_team ON away_part.numEquipe = away_team.numEquipe
             WHERE m.numMatch = :numMatch"
        );
        $stmt->execute([':numMatch' => $ba_bec_numMatch]);
        $ba_bec_match = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression match</h1>
        </div>
        <div class="col-md-12">
            <?php if ($ba_bec_match) : ?>
                <?php
                $ba_bec_teamHome = $ba_bec_match['teamHome'] ?? 'Domicile';
                $ba_bec_teamAway = $ba_bec_match['teamAway'] ?? 'Extérieur';
                $ba_bec_summary = $ba_bec_teamHome . ' vs ' . $ba_bec_teamAway;
                ?>
                <form action="<?php echo ROOT_URL . '/api/matches/delete.php' ?>" method="post">
                    <div class="form-group">
                        <label for="numMatch">ID match</label>
                        <input id="numMatch" name="numMatch" class="form-control" type="text" value="<?php echo $ba_bec_match['numMatch']; ?>" readonly />
                    </div>
                    <div class="form-group mt-2">
                        <label for="summary">Résumé</label>
                        <input id="summary" name="summary" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_summary); ?>" readonly />
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
