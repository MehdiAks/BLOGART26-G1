<?php
/*
 * Vue d'administration pour le module comments.
 * - Ce gabarit présente l'interface HTML d'une action backend sans logique métier.
 * - Les liens ou formulaires pointent vers les routes correspondantes du contrôleur.
 * - Les sections structurent l'écran pour faciliter la navigation et la saisie.
 * - Les classes utilitaires s'occupent de la mise en page et de la hiérarchie visuelle.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirecmodo.php';
include '../../../header.php';

if(isset($_GET['numCom'])){
    $ba_bec_numCom = (int) $_GET['numCom'];
    $ba_bec_currentCom = sql_select('COMMENT c INNER JOIN MEMBRE m ON c.numMemb = m.numMemb INNER JOIN ARTICLE a ON c.numArt = a.numArt', 'c.*, m.pseudoMemb, a.libTitrArt, a.parag1Art', 'c.numCom = ?', null, null, '1', [$ba_bec_numCom])[0] ?? [];
    foreach ($ba_bec_currentCom as $ba_bec_key => $ba_bec_value) {
        ${'ba_bec_' . $ba_bec_key} = e($ba_bec_value);
    }
}
?>

<!-- Bootstrap form to create a new statut -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="titre text-center">Contrôle commentaire en attente : à valider</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/comments/update.php' ?>" method="post">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="libTitrArt"><h2>Titre de l'article</h2></label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" value="<?php echo ($ba_bec_libTitrArt); ?>" readonly="readonly"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="pseudoMemb" for="dtCreaCom"><h2>Information commentaire</h2></label>
                    <p><u>Nom d'utilisateur :</u></p>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value="<?php echo ($ba_bec_pseudoMemb); ?>" readonly="readonly" />
                    <br>
                    <p><u>Date de création :</u></p>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="dtCreaCom" name="dtCreaCom" class="form-control" type="text" value="<?php echo ($ba_bec_dtCreaCom); ?>" readonly="readonly" />
                </div>
                <br>

                <div class="form-group">
                    <label for="libCom"><h2>Contenu du commentaire</h2></label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <textarea id="libCom" name="libCom" class="form-control" rows="6"><?php echo ($ba_bec_libCom); ?></textarea>
                </div>
                <br>

                <div class="form-group"></div>
                    <label for="attModOK"><h2>Validation du commentaire</h2></label> 
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <br>
                        <label>
                                <input type="radio" name="attModOK" value="1" <?php echo ($ba_bec_attModOK == 1) ? 'checked' : ''; ?>> Valider le commentaire
                        </label>
                        <br>
                        <label>
                                <input type="radio" name="attModOK" value="0" <?php echo ($ba_bec_attModOK == 0) ? 'checked' : ''; ?>> Refuser le commentaire
                        </label>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label for="parag1Art"><h2>Raison du refus</h2></label>
                    <p>A remplir seulement si le commentaire est refusé</p>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <textarea id="notifComKOAff" name="notifComKOAff" class="form-control" rows="10"><?php echo ($ba_bec_notifComKOAff); ?></textarea>
                </div>
                <br>
                <br>
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Envoie Control</button>
                </div>
            </form>
            <br>
            <br>
        </div>
    </div>
</div>
