<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if (isset($_GET['numMemb']) && isset($_GET['numArt'])) {
    $ba_bec_numMemb = $_GET['numMemb'];
    $ba_bec_numArt = $_GET['numArt'];
    $ba_bec_likeA = sql_select("LIKEART", "likeA", "numMemb = $ba_bec_numMemb AND numArt = $ba_bec_numArt")[0]['likeA'];
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification Like</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to edit like -->
            <form action="<?php echo ROOT_URL . '/api/likes/update.php' ?>" method="post">
                <div class="form-group">
                    <label for="numArt">Numéro d'article</label>
                    <input id="numArt" name="numArt" class="form-control" style="display: none" type="text"
                        value="<?php echo $ba_bec_numArt; ?>" />
                    <input id="numArt" name="numArt" class="form-control" type="text" value="<?php echo $ba_bec_numArt; ?>" />
                </div>
                <br>

                <div class="form-group">
                    <label for="numMemb">Numéro Membre</label>
                    <input id="numMemb" name="numMemb" class="form-control" style="display: none" type="text"
                        value="<?php echo $ba_bec_numMemb; ?>" />
                    <input id="numMemb" name="numMemb" class="form-control" type="text"
                        value="<?php echo $ba_bec_numMemb; ?>" />
                </div>
                <br>

                <div class="form-group">
                    <label for="likeA">Like/Dislike</label>
                    <select id="likeA" name="likeA" class="form-control">
                        <option value="1" <?php echo ($ba_bec_likeA == 1 ? 'selected' : ''); ?>>Like</option>
                        <option value="0" <?php echo ($ba_bec_likeA == 0 ? 'selected' : ''); ?>>Dislike</option>
                    </select>
                </div>
                <br>

                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">Retour à la liste</a>
                    <button type="submit" class="btn btn-danger">Confirmer la modification ?</button>
                </div>
            </form>
        </div>
    </div>
</div>
