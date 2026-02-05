<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';



if(isset($_GET['numThem'])){
    $ba_bec_numThem = $_GET['numThem'];
    $ba_bec_libThem = sql_select("THEMATIQUE", "libThem", "numThem = $ba_bec_numThem")[0]['libThem'];
}

?> 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Thematique</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/thematiques/update.php' ?>" method="post">
                <div class="form-group">
                    <label for="libThem">Nom de Thematique </label>
                    <input id="numThem" name="numThem" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numThem); ?>" readonly="readonly" />
                    <input id="libThem" name="libThem" class="form-control" type="text"
                        value="<?php echo($ba_bec_libThem); ?>" placeholder="Nom de la thématique..."/>
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">Annuler</a>
                    <button type="submit" class="btn btn-danger">Confirmer Edit ?</button>
                </div>
            </form>
        </div>
    </div>
</div>
