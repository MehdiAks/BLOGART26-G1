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
            <h1 class="titre text-center">Commentaire contrôlé : modifier</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/comments/update.php' ?>" method="post">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="numArt">Numéro D'article</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="numArt" name="numArt" class="form-control" type="text" value="<?php echo ($ba_bec_numArt); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="numCom">Numéro Commentaire</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="numCom" name="numCom" class="form-control" type="text" value="<?php echo ($ba_bec_numCom); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="pseudoMemb">Pseudo Membre</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value="<?php echo ($ba_bec_pseudoMemb); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="libTitrArt">Titre Article</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" value="<?php echo ($ba_bec_libTitrArt); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="parag1Art">Accroche paragraphe 1</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="parag1Art" name="parag1Art" class="form-control" type="text" value="<?php echo ($ba_bec_parag1Art); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="dtCreaCom">Date création commentaire</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="dtCreaCom" name="dtCreaCom" class="form-control" type="text" value="<?php echo ($ba_bec_dtCreaCom); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="dtModCom">Date modération commentaire</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo ($ba_bec_numCom); ?>" readonly="readonly" />
                    <input id="dtModCom" name="dtModCom" class="form-control" type="text" value="<?php echo ($ba_bec_dtModCom); ?>"/>
                </div>
                <br>

                <div class="form-group">
                    <label for="libCom">Commentaire à valider/validé</label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo htmlspecialchars($ba_bec_numCom); ?>" readonly="readonly" />
                    <textarea id="libCom" name="libCom" class="form-control" rows="10"><?php echo ($ba_bec_libCom); ?></textarea>
                </div>
                <br>

                <div class="form-group">
                    <label for="attModOK"><strong>En tant que modérateur, je valide le commentaire du membre :</strong></label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo htmlspecialchars($ba_bec_numCom); ?>" readonly="readonly" />
                    <div>
                        <label>
                                <input type="radio" name="attModOK" value="1" <?php echo ($ba_bec_attModOK == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                        <label>
                                <input type="radio" name="attModOK" value="0" <?php echo ($ba_bec_attModOK == 0) ? 'checked' : ''; ?>> Non
                        </label>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label for="notifComKOAff"><strong>Si non, en voici les raisons :</strong></label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo htmlspecialchars($ba_bec_numCom); ?>" readonly="readonly" />
                    <textarea id="notifComKOAff" name="notifComKOAff" class="form-control" rows="10"><?php echo ($ba_bec_notifComKOAff); ?></textarea>
                    <p>Vous pouvez ajouter une notification de rejet du post (propos difammatoires, injures, vulgarité,...)</p>
                </div>

                <div class="form-group">
                    <label for="delLogiq"><strong>En tant que modérateur, je souhaite que le post ne soit pas/plus affiché (suppression logique) :</strong></label>
                    <input id="numCom" name="numCom" class="form-control" style="display: none" type="text" value="<?php echo htmlspecialchars($ba_bec_numCom); ?>" readonly="readonly" />
                    <div>
                        <label>
                                <input type="radio" name="delLogiq" value="1" <?php echo ($ba_bec_delLogiq == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                        <label>
                                <input type="radio" name="delLogiq" value="0" <?php echo ($ba_bec_delLogiq == 0) ? 'checked' : ''; ?>> Non
                        </label>
                    </div>
                </div>
                <br>
                <br>
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">Edit</a>
                    <button type="submit" class="btn btn-warning">Confirmer Edit ?</button>
                </div>
            </form>
            <br>
            <br>
        </div>
    </div>
</div>
