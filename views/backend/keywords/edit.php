<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if(isset($_GET['numMotCle'])){
    $ba_bec_numMotCle = $_GET['numMotCle'];
    $ba_bec_libMotCle = sql_select("MOTCLE", "libMotCle", "numMotCle = $ba_bec_numMotCle")[0]['libMotCle'];
}

?> 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1> Mot-Clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/keywords/update.php' ?>" method="post">
                <div class="form-group">
                    <label for="libMotCle">Nom du mots-clés</label>
                    <input id="numMotCle" name="numMotCle" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numMotCle); ?>" readonly="readonly" />
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($ba_bec_libMotCle); ?>"/>
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
