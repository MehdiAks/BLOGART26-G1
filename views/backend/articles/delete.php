<!-- Cette ligne contient le balisage/texte : <?php -->
<?php
<!-- Cette ligne contient le balisage/texte : /* -->
/*
<!-- Cette ligne contient le balisage/texte : * Vue d'administration (suppression) pour le module articles. -->
 * Vue d'administration (suppression) pour le module articles.
<!-- Cette ligne contient le balisage/texte : * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement. -->
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
<!-- Cette ligne contient le balisage/texte : * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher. -->
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher.
<!-- Cette ligne contient le balisage/texte : * - Le bouton principal déclenche la route de suppression côté backend. -->
 * - Le bouton principal déclenche la route de suppression côté backend.
<!-- Cette ligne contient le balisage/texte : * - Un lien de retour évite la suppression et renvoie vers la liste. -->
 * - Un lien de retour évite la suppression et renvoie vers la liste.
<!-- Cette ligne contient le balisage/texte : * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface. -->
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface.
<!-- Cette ligne contient le balisage/texte : */ -->
 */
<!-- Cette ligne contient le balisage/texte : $ba_bec_articlePhoto = $ba_bec_article['urlPhotArt'] ?? ''; -->
$ba_bec_articlePhoto = $ba_bec_article['urlPhotArt'] ?? '';
<!-- Cette ligne contient le balisage/texte : $ba_bec_defaultImage = ROOT_URL . '/src/images/article.png'; -->
$ba_bec_defaultImage = ROOT_URL . '/src/images/article.png';
<!-- Cette ligne contient le balisage/texte : if (!empty($ba_bec_articlePhoto)) { -->
if (!empty($ba_bec_articlePhoto)) {
<!-- Cette ligne contient le balisage/texte : $ba_bec_photoUrl = preg_match('/^(https?:\/\/|\/)/', $ba_bec_articlePhoto) -->
    $ba_bec_photoUrl = preg_match('/^(https?:\/\/|\/)/', $ba_bec_articlePhoto)
<!-- Cette ligne contient le balisage/texte : ? $ba_bec_articlePhoto -->
        ? $ba_bec_articlePhoto
<!-- Cette ligne contient le balisage/texte : : ROOT_URL . '/src/uploads/' . $ba_bec_articlePhoto; -->
        : ROOT_URL . '/src/uploads/' . $ba_bec_articlePhoto;
<!-- Cette ligne contient le balisage/texte : } else { -->
} else {
<!-- Cette ligne contient le balisage/texte : $ba_bec_photoUrl = $ba_bec_defaultImage; -->
    $ba_bec_photoUrl = $ba_bec_defaultImage;
<!-- Cette ligne contient le balisage/texte : } -->
}
<!-- Cette ligne contient le balisage/texte : ?> -->
?>

<!-- Cette ligne contient le balisage/texte : <!- - Affichage des informations de l'article - -> -->
<!-- Affichage des informations de l'article -->
<!-- Cette ligne contient le balisage/texte : <div class="container"> -->
<div class="container">
<!-- Cette ligne contient le balisage/texte : <div class="row"> -->
    <div class="row">
<!-- Cette ligne contient le balisage/texte : <div class="col-md-12"> -->
        <div class="col-md-12">
<!-- Cette ligne contient le balisage/texte : <h1>Suppression de l'article</h1> -->
            <h1>Suppression de l'article</h1>
<!-- Cette ligne contient le balisage/texte : <p>Êtes-vous sûr de vouloir supprimer cet article ?</p> -->
            <p>Êtes-vous sûr de vouloir supprimer cet article ?</p>
<!-- Cette ligne contient le balisage/texte : </div> -->
        </div>
<!-- Cette ligne contient le balisage/texte : <div class="col-md-12"> -->
        <div class="col-md-12">
<!-- Cette ligne contient le balisage/texte : <form action="<?php echo ROOT_URL . '/public/index.php?controller=article&action=destroy'; ?>" method="post"> -->
            <form action="<?php echo ROOT_URL . '/public/index.php?controller=article&action=destroy'; ?>" method="post">
<!-- Cette ligne contient le balisage/texte : <!- - Champ caché pour l'ID de l'article - -> -->
                <!-- Champ caché pour l'ID de l'article -->
<!-- Cette ligne contient le balisage/texte : <input type="hidden" name="numArt" value="<?php echo $ba_bec_article['numArt']; ?>"> -->
                <input type="hidden" name="numArt" value="<?php echo $ba_bec_article['numArt']; ?>">
<!-- Cette ligne contient le balisage/texte : <?php -->
                <?php
<!-- Cette ligne contient le balisage/texte : $ba_bec_urlPhotArt = $ba_bec_article['urlPhotArt'] ?? ''; -->
                $ba_bec_urlPhotArt = $ba_bec_article['urlPhotArt'] ?? '';
<!-- Cette ligne contient le balisage/texte : $ba_bec_photoUrl = ''; -->
                $ba_bec_photoUrl = '';
<!-- Cette ligne contient le balisage/texte : if (!empty($ba_bec_urlPhotArt)) { -->
                if (!empty($ba_bec_urlPhotArt)) {
<!-- Cette ligne contient le balisage/texte : $ba_bec_photoUrl = preg_match('/^(https?:\\/\\/|\\/)/', $ba_bec_urlPhotArt) -->
                    $ba_bec_photoUrl = preg_match('/^(https?:\\/\\/|\\/)/', $ba_bec_urlPhotArt)
<!-- Cette ligne contient le balisage/texte : ? $ba_bec_urlPhotArt -->
                        ? $ba_bec_urlPhotArt
<!-- Cette ligne contient le balisage/texte : : ROOT_URL . '/src/uploads/' . $ba_bec_urlPhotArt; -->
                        : ROOT_URL . '/src/uploads/' . $ba_bec_urlPhotArt;
<!-- Cette ligne contient le balisage/texte : } -->
                }
<!-- Cette ligne contient le balisage/texte : ?> -->
                ?>

<!-- Cette ligne contient le balisage/texte : <!- - Titre de l'article - -> -->
                <!-- Titre de l'article -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="libTitrArt">Titre</label> -->
                    <label for="libTitrArt">Titre</label>
<!-- Cette ligne contient le balisage/texte : <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" -->
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libTitrArt']; ?>" disabled> -->
                        value="<?php echo $ba_bec_article['libTitrArt']; ?>" disabled>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Date de création - -> -->
                <!-- Date de création -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="dtCreaArt">Date de création</label> -->
                    <label for="dtCreaArt">Date de création</label>
<!-- Cette ligne contient le balisage/texte : <input id="dtCreaArt" name="dtCreaArt" class="form-control" type="text" -->
                    <input id="dtCreaArt" name="dtCreaArt" class="form-control" type="text"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['dtCreaArt']; ?>" disabled> -->
                        value="<?php echo $ba_bec_article['dtCreaArt']; ?>" disabled>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Chapeau - -> -->
                <!-- Chapeau -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="libChapoArt">Chapeau</label> -->
                    <label for="libChapoArt">Chapeau</label>
<!-- Cette ligne contient le balisage/texte : <textarea id="libChapoArt" name="libChapoArt" class="form-control" -->
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control"
<!-- Cette ligne contient le balisage/texte : disabled><?php echo $ba_bec_article['libChapoArt']; ?></textarea> -->
                        disabled><?php echo $ba_bec_article['libChapoArt']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Accroche - -> -->
                <!-- Accroche -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="libAccrochArt">Accroche</label> -->
                    <label for="libAccrochArt">Accroche</label>
<!-- Cette ligne contient le balisage/texte : <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text" -->
                    <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libAccrochArt']; ?>" disabled> -->
                        value="<?php echo $ba_bec_article['libAccrochArt']; ?>" disabled>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Paragraphes - -> -->
                <!-- Paragraphes -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="parag1Art">Paragraphe 1</label> -->
                    <label for="parag1Art">Paragraphe 1</label>
<!-- Cette ligne contient le balisage/texte : <textarea id="parag1Art" name="parag1Art" class="form-control" -->
                    <textarea id="parag1Art" name="parag1Art" class="form-control"
<!-- Cette ligne contient le balisage/texte : disabled><?php echo $ba_bec_article['parag1Art']; ?></textarea> -->
                        disabled><?php echo $ba_bec_article['parag1Art']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="libSsTitr1Art">Sous-titre 1</label> -->
                    <label for="libSsTitr1Art">Sous-titre 1</label>
<!-- Cette ligne contient le balisage/texte : <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text" -->
                    <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libSsTitr1Art']; ?>" disabled> -->
                        value="<?php echo $ba_bec_article['libSsTitr1Art']; ?>" disabled>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="parag2Art">Paragraphe 2</label> -->
                    <label for="parag2Art">Paragraphe 2</label>
<!-- Cette ligne contient le balisage/texte : <textarea id="parag2Art" name="parag2Art" class="form-control" -->
                    <textarea id="parag2Art" name="parag2Art" class="form-control"
<!-- Cette ligne contient le balisage/texte : disabled><?php echo $ba_bec_article['parag2Art']; ?></textarea> -->
                        disabled><?php echo $ba_bec_article['parag2Art']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="libSsTitr2Art">Sous-titre 2</label> -->
                    <label for="libSsTitr2Art">Sous-titre 2</label>
<!-- Cette ligne contient le balisage/texte : <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text" -->
                    <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text"
<!-- Cette ligne contient le balisage/texte : value="<?php echo $ba_bec_article['libSsTitr2Art']; ?>" disabled> -->
                        value="<?php echo $ba_bec_article['libSsTitr2Art']; ?>" disabled>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="parag3Art">Paragraphe 3</label> -->
                    <label for="parag3Art">Paragraphe 3</label>
<!-- Cette ligne contient le balisage/texte : <textarea id="parag3Art" name="parag3Art" class="form-control" -->
                    <textarea id="parag3Art" name="parag3Art" class="form-control"
<!-- Cette ligne contient le balisage/texte : disabled><?php echo $ba_bec_article['parag3Art']; ?></textarea> -->
                        disabled><?php echo $ba_bec_article['parag3Art']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Conclusion - -> -->
                <!-- Conclusion -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="libConclArt">Conclusion</label> -->
                    <label for="libConclArt">Conclusion</label>
<!-- Cette ligne contient le balisage/texte : <textarea id="libConclArt" name="libConclArt" class="form-control" -->
                    <textarea id="libConclArt" name="libConclArt" class="form-control"
<!-- Cette ligne contient le balisage/texte : disabled><?php echo $ba_bec_article['libConclArt']; ?></textarea> -->
                        disabled><?php echo $ba_bec_article['libConclArt']; ?></textarea>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Image - -> -->
                <!-- Image -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="image">Image</label> -->
                    <label for="image">Image</label>
<!-- Cette ligne contient le balisage/texte : <img src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" -->
                    <img src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>"
<!-- Cette ligne contient le balisage/texte : alt="Image de l'article" style="max-width: 200px;"> -->
                        alt="Image de l'article" style="max-width: 200px;">
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Thématique - -> -->
                <!-- Thématique -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="numThem">Thématique</label> -->
                    <label for="numThem">Thématique</label>
<!-- Cette ligne contient le balisage/texte : <select id="numThem" name="numThem" class="form-control" disabled> -->
                    <select id="numThem" name="numThem" class="form-control" disabled>
<!-- Cette ligne contient le balisage/texte : <option value="<?php echo $ba_bec_thematique['numThem']; ?>"><?php echo $ba_bec_thematique['libThem']; ?> -->
                        <option value="<?php echo $ba_bec_thematique['numThem']; ?>"><?php echo $ba_bec_thematique['libThem']; ?>
<!-- Cette ligne contient le balisage/texte : </option> -->
                        </option>
<!-- Cette ligne contient le balisage/texte : </select> -->
                    </select>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Mots-clés - -> -->
                <!-- Mots-clés -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group"> -->
                <div class="form-group">
<!-- Cette ligne contient le balisage/texte : <label for="keywords">Mots-clés</label> -->
                    <label for="keywords">Mots-clés</label>
<!-- Cette ligne contient le balisage/texte : <input id="keywords" name="keywords" class="form-control" type="text" -->
                    <input id="keywords" name="keywords" class="form-control" type="text"
<!-- Cette ligne contient le balisage/texte : value="<?php echo implode(', ', $ba_bec_keywordsList); ?>" disabled> -->
                        value="<?php echo implode(', ', $ba_bec_keywordsList); ?>" disabled>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>

<!-- Cette ligne contient le balisage/texte : <!- - Boutons de confirmation - -> -->
                <!-- Boutons de confirmation -->
<!-- Cette ligne contient le balisage/texte : <div class="form-group mt-2"> -->
                <div class="form-group mt-2">
<!-- Cette ligne contient le balisage/texte : <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=list'; ?>" class="btn btn-primary">Retour à la liste</a> -->
                    <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=list'; ?>" class="btn btn-primary">Retour à la liste</a>
<!-- Cette ligne contient le balisage/texte : <button type="submit" class="btn btn-danger">Confirmer la suppression</button> -->
                    <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>
<!-- Cette ligne contient le balisage/texte : </form> -->
            </form>
<!-- Cette ligne contient le balisage/texte : </div> -->
        </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
    </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
</div>
