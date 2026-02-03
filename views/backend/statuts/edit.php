<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';



if (isset($_GET['numStat'])) {
    $ba_bec_numStat = $_GET['numStat'];
    $ba_bec_libStat = sql_select("STATUT", "libStat", "numStat = $ba_bec_numStat")[0]['libStat'];
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1> Statut</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/statuts/update.php' ?>" method="post">
                <div class="form-group">
                    <label for="libStat">Nom du statut</label>
                    <input id="numStat" name="numStat" class="form-control" style="display: none" type="text"
                        value="<?php echo ($ba_bec_numStat); ?>" readonly="readonly" />
                    <input id="libStat" name="libStat" class="form-control" type="text"
                        value="<?php echo ($ba_bec_libStat); ?>" />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-danger">Confirmer Edit ?</button>
                </div>
            </form>
        </div>
    </div>
</div>
