<?php // Ligne PHP : ouverture du script.
/* // Ligne PHP : /*
 * Vue d'administration (création) pour le module likes. // Ligne PHP : * Vue d'administration (création) pour le module likes.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier. // Ligne PHP : * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action). // Ligne PHP : * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation. // Ligne PHP : * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste. // Ligne PHP : * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue. // Ligne PHP : * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */ // Ligne PHP : */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Ligne PHP : require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirecmodo.php'; // Ligne PHP : require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirecmodo.php';
include '../../../header.php'; // Ligne PHP : include '../../../header.php';

$ba_bec_articles = sql_select("ARTICLE", "numArt, libTitrArt", null, null, "numArt ASC"); // Ligne PHP : $ba_bec_articles = sql_select("ARTICLE", "numArt, libTitrArt", null, null, "numArt ASC");
$ba_bec_members = sql_select("MEMBRE", "numMemb, pseudoMemb", null, null, "numMemb ASC"); // Ligne PHP : $ba_bec_members = sql_select("MEMBRE", "numMemb, pseudoMemb", null, null, "numMemb ASC");

$ba_bec_articleIdToTitle = []; // Ligne PHP : $ba_bec_articleIdToTitle = [];
$ba_bec_articleTitleToId = []; // Ligne PHP : $ba_bec_articleTitleToId = [];
foreach ($ba_bec_articles as $ba_bec_article) { // Ligne PHP : foreach ($ba_bec_articles as $ba_bec_article) {
    $ba_bec_articleIdToTitle[$ba_bec_article['numArt']] = $ba_bec_article['libTitrArt']; // Ligne PHP : $ba_bec_articleIdToTitle[$ba_bec_article['numArt']] = $ba_bec_article['libTitrArt'];
    $ba_bec_articleTitleToId[$ba_bec_article['libTitrArt']] = $ba_bec_article['numArt']; // Ligne PHP : $ba_bec_articleTitleToId[$ba_bec_article['libTitrArt']] = $ba_bec_article['numArt'];
} // Ligne PHP : }

$ba_bec_memberIdToPseudo = []; // Ligne PHP : $ba_bec_memberIdToPseudo = [];
$ba_bec_memberPseudoToId = []; // Ligne PHP : $ba_bec_memberPseudoToId = [];
foreach ($ba_bec_members as $ba_bec_member) { // Ligne PHP : foreach ($ba_bec_members as $ba_bec_member) {
    $ba_bec_memberIdToPseudo[$ba_bec_member['numMemb']] = $ba_bec_member['pseudoMemb']; // Ligne PHP : $ba_bec_memberIdToPseudo[$ba_bec_member['numMemb']] = $ba_bec_member['pseudoMemb'];
    $ba_bec_memberPseudoToId[$ba_bec_member['pseudoMemb']] = $ba_bec_member['numMemb']; // Ligne PHP : $ba_bec_memberPseudoToId[$ba_bec_member['pseudoMemb']] = $ba_bec_member['numMemb'];
} // Ligne PHP : }
?> <!-- Ligne HTML : fermeture du script PHP. -->

<!-- Bootstrap form to create a new like --> <!-- Ligne HTML : <!- - Bootstrap form to create a new like - -> -->
<div class="container"> <!-- Ligne HTML : <div class="container"> -->
    <div class="row"> <!-- Ligne HTML : <div class="row"> -->
        <div class="col-md-12"> <!-- Ligne HTML : <div class="col-md-12"> -->
            <h1>Création Nouveau Like</h1> <!-- Ligne HTML : <h1>Création Nouveau Like</h1> -->
        </div> <!-- Ligne HTML : </div> -->
        <div class="col-md-12"> <!-- Ligne HTML : <div class="col-md-12"> -->
            <!-- Form to create a new like --> <!-- Ligne HTML : <!- - Form to create a new like - -> -->
            <form action="<?php echo ROOT_URL . '/api/likes/create.php' ?>" method="post"> <!-- Ligne HTML : <form action="<?php echo ROOT_URL . '/api/likes/create.php' ?>" method="post"> -->
                <div class="form-group"> <!-- Ligne HTML : <div class="form-group"> -->
                    <label for="numArt">Article</label> <!-- Ligne HTML : <label for="numArt">Article</label> -->
                    <input id="numArt" name="numArt" class="form-control" type="text" placeholder="ID article (ex: 42)" required /> <!-- Ligne HTML : <input id="numArt" name="numArt" class="form-control" type="text" placeholder="ID article (ex: 42)" required /> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="form-group"> <!-- Ligne HTML : <div class="form-group"> -->
                    <label for="numMemb">Numéro d'utilisateur</label> <!-- Ligne HTML : <label for="numMemb">Numéro d'utilisateur</label> -->
                    <input id="numMemb" name="numMemb" class="form-control" type="text" placeholder="ID utilisateur (ex: 7)" required /> <!-- Ligne HTML : <input id="numMemb" name="numMemb" class="form-control" type="text" placeholder="ID utilisateur (ex: 7)" required /> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="form-group"> <!-- Ligne HTML : <div class="form-group"> -->
                    <label for="likeA">Like / Dislike</label> <!-- Ligne HTML : <label for="likeA">Like / Dislike</label> -->
                    <div class="form-check form-switch"> <!-- Ligne HTML : <div class="form-check form-switch"> -->
                        <input type="hidden" name="likeA" value="0" /> <!-- Ligne HTML : <input type="hidden" name="likeA" value="0" /> -->
                        <input class="form-check-input" type="checkbox" id="likeA" name="likeA" value="1" checked /> <!-- Ligne HTML : <input class="form-check-input" type="checkbox" id="likeA" name="likeA" value="1" checked /> -->
                        <label class="form-check-label" for="likeA">Like (désactiver pour dislike)</label> <!-- Ligne HTML : <label class="form-check-label" for="likeA">Like (désactiver pour dislike)</label> -->
                    </div> <!-- Ligne HTML : </div> -->
                </div> <!-- Ligne HTML : </div> -->
                <br /> <!-- Ligne HTML : <br /> -->
                <div class="form-group mt-2"> <!-- Ligne HTML : <div class="form-group mt-2"> -->
                    <a href="list.php" class="btn btn-primary">Annuler</a> <!-- Ligne HTML : <a href="list.php" class="btn btn-primary">Annuler</a> -->
                    <button type="submit" class="btn btn-success">Confirmer Create</button> <!-- Ligne HTML : <button type="submit" class="btn btn-success">Confirmer Create</button> -->
                </div> <!-- Ligne HTML : </div> -->
            </form> <!-- Ligne HTML : </form> -->
        </div> <!-- Ligne HTML : </div> -->
    </div> <!-- Ligne HTML : </div> -->
</div> <!-- Ligne HTML : </div> -->

<script> <!-- Ligne HTML : ouverture de la balise script. -->
    const articleIdToTitle = <?php echo json_encode($ba_bec_articleIdToTitle); ?>; // Ligne JS : const articleIdToTitle = <?php echo json_encode($ba_bec_articleIdToTitle); ?>;
    const articleTitleToId = <?php echo json_encode($ba_bec_articleTitleToId); ?>; // Ligne JS : const articleTitleToId = <?php echo json_encode($ba_bec_articleTitleToId); ?>;
    const memberIdToPseudo = <?php echo json_encode($ba_bec_memberIdToPseudo); ?>; // Ligne JS : const memberIdToPseudo = <?php echo json_encode($ba_bec_memberIdToPseudo); ?>;
    const memberPseudoToId = <?php echo json_encode($ba_bec_memberPseudoToId); ?>; // Ligne JS : const memberPseudoToId = <?php echo json_encode($ba_bec_memberPseudoToId); ?>;

    const articleIdInput = document.getElementById('numArt'); // Ligne JS : const articleIdInput = document.getElementById('numArt');
    const articleTitleInput = document.getElementById('libTitrArt'); // Ligne JS : const articleTitleInput = document.getElementById('libTitrArt');
    const memberIdInput = document.getElementById('numMemb'); // Ligne JS : const memberIdInput = document.getElementById('numMemb');
    const memberPseudoInput = document.getElementById('pseudoMemb'); // Ligne JS : const memberPseudoInput = document.getElementById('pseudoMemb');

    articleIdInput.addEventListener('input', () => { // Ligne JS : articleIdInput.addEventListener('input', () => {
        const title = articleIdToTitle[articleIdInput.value]; // Ligne JS : const title = articleIdToTitle[articleIdInput.value];
        if (title) { // Ligne JS : if (title) {
            articleTitleInput.value = title; // Ligne JS : articleTitleInput.value = title;
        } else if (articleIdInput.value === '') { // Ligne JS : } else if (articleIdInput.value === '') {
            articleTitleInput.value = ''; // Ligne JS : articleTitleInput.value = '';
        } // Ligne JS : }
    }); // Ligne JS : });

    articleTitleInput.addEventListener('input', () => { // Ligne JS : articleTitleInput.addEventListener('input', () => {
        const id = articleTitleToId[articleTitleInput.value]; // Ligne JS : const id = articleTitleToId[articleTitleInput.value];
        if (id) { // Ligne JS : if (id) {
            articleIdInput.value = id; // Ligne JS : articleIdInput.value = id;
        } else if (articleTitleInput.value === '') { // Ligne JS : } else if (articleTitleInput.value === '') {
            articleIdInput.value = ''; // Ligne JS : articleIdInput.value = '';
        } // Ligne JS : }
    }); // Ligne JS : });

    memberIdInput.addEventListener('input', () => { // Ligne JS : memberIdInput.addEventListener('input', () => {
        const pseudo = memberIdToPseudo[memberIdInput.value]; // Ligne JS : const pseudo = memberIdToPseudo[memberIdInput.value];
        if (pseudo) { // Ligne JS : if (pseudo) {
            memberPseudoInput.value = pseudo; // Ligne JS : memberPseudoInput.value = pseudo;
        } else if (memberIdInput.value === '') { // Ligne JS : } else if (memberIdInput.value === '') {
            memberPseudoInput.value = ''; // Ligne JS : memberPseudoInput.value = '';
        } // Ligne JS : }
    }); // Ligne JS : });

    memberPseudoInput.addEventListener('input', () => { // Ligne JS : memberPseudoInput.addEventListener('input', () => {
        const id = memberPseudoToId[memberPseudoInput.value]; // Ligne JS : const id = memberPseudoToId[memberPseudoInput.value];
        if (id) { // Ligne JS : if (id) {
            memberIdInput.value = id; // Ligne JS : memberIdInput.value = id;
        } else if (memberPseudoInput.value === '') { // Ligne JS : } else if (memberPseudoInput.value === '') {
            memberIdInput.value = ''; // Ligne JS : memberIdInput.value = '';
        } // Ligne JS : }
    }); // Ligne JS : });
</script> <!-- Ligne HTML : fermeture de la balise script. -->
