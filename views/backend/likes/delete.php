<?php // Ligne PHP : ouverture du script.
/* // Ligne PHP : /*
 * Vue d'administration (suppression) pour le module likes. // Ligne PHP : * Vue d'administration (suppression) pour le module likes.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement. // Ligne PHP : * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher. // Ligne PHP : * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher.
 * - Le bouton principal déclenche la route de suppression côté backend. // Ligne PHP : * - Le bouton principal déclenche la route de suppression côté backend.
 * - Un lien de retour évite la suppression et renvoie vers la liste. // Ligne PHP : * - Un lien de retour évite la suppression et renvoie vers la liste.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface. // Ligne PHP : * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface.
 */ // Ligne PHP : */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Ligne PHP : require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirecmodo.php'; // Ligne PHP : require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirecmodo.php';
include '../../../header.php'; // Ligne PHP : include '../../../header.php';

if (isset($_GET['numMemb']) && isset($_GET['numArt'])) { // Ligne PHP : if (isset($_GET['numMemb']) && isset($_GET['numArt'])) {
    $ba_bec_numMemb = $_GET['numMemb']; // Ligne PHP : $ba_bec_numMemb = $_GET['numMemb'];
    $ba_bec_numArt = $_GET['numArt']; // Ligne PHP : $ba_bec_numArt = $_GET['numArt'];
    $ba_bec_likeA = sql_select("LIKEART", "likeA", "numMemb = $ba_bec_numMemb AND numArt = $ba_bec_numArt")[0]['likeA']; // Ligne PHP : $ba_bec_likeA = sql_select("LIKEART", "likeA", "numMemb = $ba_bec_numMemb AND numArt = $ba_bec_numArt")[0]['likeA'];
} // Ligne PHP : }
?> <!-- Ligne HTML : fermeture du script PHP. -->

<!-- Bootstrap form to delete a like --> <!-- Ligne HTML : <!- - Bootstrap form to delete a like - -> -->
<div class="container"> <!-- Ligne HTML : <div class="container"> -->
    <div class="row"> <!-- Ligne HTML : <div class="row"> -->
        <div class="col-md-12"> <!-- Ligne HTML : <div class="col-md-12"> -->
            <h1 class="titre text-center">Modération Like : Suppression</h1> <!-- Ligne HTML : <h1 class="titre text-center">Modération Like : Suppression</h1> -->
        </div> <!-- Ligne HTML : </div> -->
        <div class="col-md-12"> <!-- Ligne HTML : <div class="col-md-12"> -->
            <!-- Form to delete a like --> <!-- Ligne HTML : <!- - Form to delete a like - -> -->
            <form action="<?php echo ROOT_URL . '/api/likes/delete.php' ?>" method="post"> <!-- Ligne HTML : <form action="<?php echo ROOT_URL . '/api/likes/delete.php' ?>" method="post"> -->

                <div class="form-group"> <!-- Ligne HTML : <div class="form-group"> -->
                    <label for="numArt">Numéro d'article</label> <!-- Ligne HTML : <label for="numArt">Numéro d'article</label> -->
                    <input id="numArt" name="numArt" class="form-control" style="display: none" type="text" <!-- Ligne HTML : <input id="numArt" name="numArt" class="form-control" style="display: none" type="text" -->
                        value="<?php echo $ba_bec_numArt; ?>" readonly="readonly" /> <!-- Ligne HTML : value="<?php echo $ba_bec_numArt; ?>" readonly="readonly" /> -->
                    <input id="numArt" name="numArt" class="form-control" type="text" value="<?php echo $ba_bec_numArt; ?>" <!-- Ligne HTML : <input id="numArt" name="numArt" class="form-control" type="text" value="<?php echo $ba_bec_numArt; ?>" -->
                        disabled /> <!-- Ligne HTML : disabled /> -->
                </div> <!-- Ligne HTML : </div> -->
                <br> <!-- Ligne HTML : <br> -->

                <div class="form-group"> <!-- Ligne HTML : <div class="form-group"> -->
                    <label for="numMemb">Numéro Membre</label> <!-- Ligne HTML : <label for="numMemb">Numéro Membre</label> -->
                    <input id="numMemb" name="numMemb" class="form-control" style="display: none" type="text" <!-- Ligne HTML : <input id="numMemb" name="numMemb" class="form-control" style="display: none" type="text" -->
                        value="<?php echo $ba_bec_numMemb; ?>" readonly="readonly" /> <!-- Ligne HTML : value="<?php echo $ba_bec_numMemb; ?>" readonly="readonly" /> -->
                    <input id="numMemb" name="numMemb" class="form-control" type="text" value="<?php echo $ba_bec_numMemb; ?>" <!-- Ligne HTML : <input id="numMemb" name="numMemb" class="form-control" type="text" value="<?php echo $ba_bec_numMemb; ?>" -->
                        disabled /> <!-- Ligne HTML : disabled /> -->
                </div> <!-- Ligne HTML : </div> -->
                <br> <!-- Ligne HTML : <br> -->

                <div class="form-group"> <!-- Ligne HTML : <div class="form-group"> -->
                    <label for="likeA">Like/Dislike</label> <!-- Ligne HTML : <label for="likeA">Like/Dislike</label> -->
                    <input id="likeA" name="likeA" class="form-control" style="display: none" type="text" <!-- Ligne HTML : <input id="likeA" name="likeA" class="form-control" style="display: none" type="text" -->
                        value="<?php echo $ba_bec_likeA; ?>" /> <!-- Ligne HTML : value="<?php echo $ba_bec_likeA; ?>" /> -->
                    <input id="likeA" name="likeA" class="form-control" type="text" <!-- Ligne HTML : <input id="likeA" name="likeA" class="form-control" type="text" -->
                        value="<?php echo ($ba_bec_likeA == 1 ? 'Like' : 'Dislike'); ?>" disabled /> <!-- Ligne HTML : value="<?php echo ($ba_bec_likeA == 1 ? 'Like' : 'Dislike'); ?>" disabled /> -->
                </div> <!-- Ligne HTML : </div> -->
                <br> <!-- Ligne HTML : <br> -->

                <div class="form-group d-flex gap-2"> <!-- Ligne HTML : <div class="form-group d-flex gap-2"> -->
                    <button type="submit" class="btn btn-danger">Confirmer la suppression ?</button> <!-- Ligne HTML : <button type="submit" class="btn btn-danger">Confirmer la suppression ?</button> -->
                    <a href="list.php" class="btn btn-secondary">Annuler</a> <!-- Ligne HTML : <a href="list.php" class="btn btn-secondary">Annuler</a> -->
                </div> <!-- Ligne HTML : </div> -->
            </form> <!-- Ligne HTML : </form> -->
        </div> <!-- Ligne HTML : </div> -->
    </div> <!-- Ligne HTML : </div> -->
</div> <!-- Ligne HTML : </div> -->
