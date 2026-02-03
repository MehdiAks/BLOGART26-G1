<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création d'un match</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/matches/create.php' ?>" method="post">
                <div class="form-group">
                    <label for="sourceId">Source ID (optionnel)</label>
                    <input id="sourceId" name="sourceId" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="competition">Compétition</label>
                    <input id="competition" name="competition" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="matchDate">Date</label>
                    <input id="matchDate" name="matchDate" class="form-control" type="date" required />
                </div>
                <div class="form-group mt-2">
                    <label for="matchTime">Heure</label>
                    <input id="matchTime" name="matchTime" class="form-control" type="time" />
                </div>
                <div class="form-group mt-2">
                    <label for="teamHome">Équipe domicile</label>
                    <input id="teamHome" name="teamHome" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="teamAway">Équipe extérieur</label>
                    <input id="teamAway" name="teamAway" class="form-control" type="text" required />
                </div>
                <div class="form-group mt-2">
                    <label for="scoreHome">Score domicile</label>
                    <input id="scoreHome" name="scoreHome" class="form-control" type="number" min="0" />
                </div>
                <div class="form-group mt-2">
                    <label for="scoreAway">Score extérieur</label>
                    <input id="scoreAway" name="scoreAway" class="form-control" type="number" min="0" />
                </div>
                <div class="form-group mt-2">
                    <label for="location">Lieu</label>
                    <input id="location" name="location" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="status">Statut</label>
                    <input id="status" name="status" class="form-control" type="text" />
                </div>
                <div class="form-group mt-2">
                    <label for="sourceUrl">Lien source</label>
                    <input id="sourceUrl" name="sourceUrl" class="form-control" type="url" />
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
