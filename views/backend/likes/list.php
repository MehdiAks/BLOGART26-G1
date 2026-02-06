<?php // Ligne PHP : ouverture du script.
/* // Ligne PHP : /*
 * Vue d'administration (liste) pour le module likes. // Ligne PHP : * Vue d'administration (liste) pour le module likes.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées. // Ligne PHP : * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base. // Ligne PHP : * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression. // Ligne PHP : * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow. // Ligne PHP : * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections. // Ligne PHP : * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */ // Ligne PHP : */
include '../../../header.php'; // Contient le header et l'appel à config.php // Ligne PHP : include '../../../header.php'; / / Contient le header et l'appel à config.php

// Filtres et tri // Ligne PHP : / / Filtres et tri
$ba_bec_filter_numMemb = isset($_GET['numMemb']) ? trim($_GET['numMemb']) : ''; // Ligne PHP : $ba_bec_filter_numMemb = isset($_GET['numMemb']) ? trim($_GET['numMemb']) : '';
$ba_bec_filter_numArt = isset($_GET['numArt']) ? trim($_GET['numArt']) : ''; // Ligne PHP : $ba_bec_filter_numArt = isset($_GET['numArt']) ? trim($_GET['numArt']) : '';
$ba_bec_filter_likeA = isset($_GET['likeA']) ? trim($_GET['likeA']) : ''; // Ligne PHP : $ba_bec_filter_likeA = isset($_GET['likeA']) ? trim($_GET['likeA']) : '';
$ba_bec_filter_pseudo = isset($_GET['pseudo']) ? trim($_GET['pseudo']) : ''; // Ligne PHP : $ba_bec_filter_pseudo = isset($_GET['pseudo']) ? trim($_GET['pseudo']) : '';

$ba_bec_filters = []; // Ligne PHP : $ba_bec_filters = [];
if ($ba_bec_filter_numMemb !== '' && ctype_digit($ba_bec_filter_numMemb)) { // Ligne PHP : if ($ba_bec_filter_numMemb !== '' && ctype_digit($ba_bec_filter_numMemb)) {
    $ba_bec_filters[] = 'l.numMemb = ' . intval($ba_bec_filter_numMemb); // Ligne PHP : $ba_bec_filters[] = 'l.numMemb = ' . intval($ba_bec_filter_numMemb);
} // Ligne PHP : }
if ($ba_bec_filter_numArt !== '' && ctype_digit($ba_bec_filter_numArt)) { // Ligne PHP : if ($ba_bec_filter_numArt !== '' && ctype_digit($ba_bec_filter_numArt)) {
    $ba_bec_filters[] = 'l.numArt = ' . intval($ba_bec_filter_numArt); // Ligne PHP : $ba_bec_filters[] = 'l.numArt = ' . intval($ba_bec_filter_numArt);
} // Ligne PHP : }
if (in_array($ba_bec_filter_likeA, ['0', '1'], true)) { // Ligne PHP : if (in_array($ba_bec_filter_likeA, ['0', '1'], true)) {
    $ba_bec_filters[] = 'l.likeA = ' . intval($ba_bec_filter_likeA); // Ligne PHP : $ba_bec_filters[] = 'l.likeA = ' . intval($ba_bec_filter_likeA);
} // Ligne PHP : }
if ($ba_bec_filter_pseudo !== '') { // Ligne PHP : if ($ba_bec_filter_pseudo !== '') {
    $ba_bec_pseudo_safe = sql_escape($ba_bec_filter_pseudo); // Ligne PHP : $ba_bec_pseudo_safe = sql_escape($ba_bec_filter_pseudo);
    $ba_bec_filters[] = "m.pseudoMemb LIKE '%" . $ba_bec_pseudo_safe . "%'"; // Ligne PHP : $ba_bec_filters[] = "m.pseudoMemb LIKE '%" . $ba_bec_pseudo_safe . "%'";
} // Ligne PHP : }

$ba_bec_sort_key = isset($_GET['sort']) ? $_GET['sort'] : 'user'; // Ligne PHP : $ba_bec_sort_key = isset($_GET['sort']) ? $_GET['sort'] : 'user';
$ba_bec_dir = isset($_GET['dir']) ? strtolower($_GET['dir']) : 'asc'; // Ligne PHP : $ba_bec_dir = isset($_GET['dir']) ? strtolower($_GET['dir']) : 'asc';
$ba_bec_sort_map = [ // Ligne PHP : $ba_bec_sort_map = [
    'user' => 'm.pseudoMemb', // Ligne PHP : 'user' => 'm.pseudoMemb',
    'article' => 'l.numArt', // Ligne PHP : 'article' => 'l.numArt',
    'type' => 'l.likeA', // Ligne PHP : 'type' => 'l.likeA',
]; // Ligne PHP : ];
if (!isset($ba_bec_sort_map[$ba_bec_sort_key])) { // Ligne PHP : if (!isset($ba_bec_sort_map[$ba_bec_sort_key])) {
    $ba_bec_sort_key = 'user'; // Ligne PHP : $ba_bec_sort_key = 'user';
} // Ligne PHP : }
if (!in_array($ba_bec_dir, ['asc', 'desc'], true)) { // Ligne PHP : if (!in_array($ba_bec_dir, ['asc', 'desc'], true)) {
    $ba_bec_dir = 'asc'; // Ligne PHP : $ba_bec_dir = 'asc';
} // Ligne PHP : }

$ba_bec_where = $ba_bec_filters ? implode(' AND ', $ba_bec_filters) : null; // Ligne PHP : $ba_bec_where = $ba_bec_filters ? implode(' AND ', $ba_bec_filters) : null;
$ba_bec_order = $ba_bec_sort_map[$ba_bec_sort_key] . ' ' . $ba_bec_dir . ', l.numArt ASC'; // Ligne PHP : $ba_bec_order = $ba_bec_sort_map[$ba_bec_sort_key] . ' ' . $ba_bec_dir . ', l.numArt ASC';

// Récupérer les likes avec jointures pour éviter les requêtes N+1 // Ligne PHP : / / Récupérer les likes avec jointures pour éviter les requêtes N+1
$ba_bec_likes = sql_select( // Ligne PHP : $ba_bec_likes = sql_select(
    'LIKEART l LEFT JOIN MEMBRE m ON l.numMemb = m.numMemb LEFT JOIN ARTICLE a ON l.numArt = a.numArt', // Ligne PHP : 'LIKEART l LEFT JOIN MEMBRE m ON l.numMemb = m.numMemb LEFT JOIN ARTICLE a ON l.numArt = a.numArt',
    'l.numMemb, l.numArt, l.likeA, m.pseudoMemb, a.libTitrArt', // Ligne PHP : 'l.numMemb, l.numArt, l.likeA, m.pseudoMemb, a.libTitrArt',
    $ba_bec_where, // Ligne PHP : $ba_bec_where,
    null, // Ligne PHP : null,
    $ba_bec_order // Ligne PHP : $ba_bec_order
); // Ligne PHP : );
?> <!-- Ligne HTML : fermeture du script PHP. -->

<!-- Inclusion du CSS --> <!-- Ligne HTML : <!- - Inclusion du CSS - -> -->
<link rel="stylesheet" href="/../../src/css/style.css"> <!-- Ligne HTML : <link rel="stylesheet" href="/../../src/css/style.css"> -->

<div class="container"> <!-- Ligne HTML : <div class="container"> -->
    <div class="row"> <!-- Ligne HTML : <div class="row"> -->
        <div class="col-md-12"> <!-- Ligne HTML : <div class="col-md-12"> -->
            <div class="mb-3"> <!-- Ligne HTML : <div class="mb-3"> -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> <!-- Ligne HTML : <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> -->
                    Retour au panneau admin <!-- Ligne HTML : Retour au panneau admin -->
                </a> <!-- Ligne HTML : </a> -->
            </div> <!-- Ligne HTML : </div> -->
            <h1>Gestion des likes</h1> <!-- Ligne HTML : <h1>Gestion des likes</h1> -->
            <form method="get" class="row g-3 mb-3"> <!-- Ligne HTML : <form method="get" class="row g-3 mb-3"> -->
                <div class="col-md-3"> <!-- Ligne HTML : <div class="col-md-3"> -->
                    <label for="numMemb" class="form-label">ID Membre</label> <!-- Ligne HTML : <label for="numMemb" class="form-label">ID Membre</label> -->
                    <input type="text" name="numMemb" id="numMemb" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filter_numMemb, ENT_QUOTES, 'UTF-8'); ?>"> <!-- Ligne HTML : <input type="text" name="numMemb" id="numMemb" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filter_numMemb, ENT_QUOTES, 'UTF-8'); ?>"> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="col-md-3"> <!-- Ligne HTML : <div class="col-md-3"> -->
                    <label for="numArt" class="form-label">ID Article</label> <!-- Ligne HTML : <label for="numArt" class="form-label">ID Article</label> -->
                    <input type="text" name="numArt" id="numArt" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filter_numArt, ENT_QUOTES, 'UTF-8'); ?>"> <!-- Ligne HTML : <input type="text" name="numArt" id="numArt" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filter_numArt, ENT_QUOTES, 'UTF-8'); ?>"> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="col-md-3"> <!-- Ligne HTML : <div class="col-md-3"> -->
                    <label for="likeA" class="form-label">Type de like</label> <!-- Ligne HTML : <label for="likeA" class="form-label">Type de like</label> -->
                    <select name="likeA" id="likeA" class="form-select"> <!-- Ligne HTML : <select name="likeA" id="likeA" class="form-select"> -->
                        <option value="">Tous</option> <!-- Ligne HTML : <option value="">Tous</option> -->
                        <option value="1" <?php echo $ba_bec_filter_likeA === '1' ? 'selected' : ''; ?>>Like</option> <!-- Ligne HTML : <option value="1" <?php echo $ba_bec_filter_likeA === '1' ? 'selected' : ''; ?>>Like</option> -->
                        <option value="0" <?php echo $ba_bec_filter_likeA === '0' ? 'selected' : ''; ?>>Dislike</option> <!-- Ligne HTML : <option value="0" <?php echo $ba_bec_filter_likeA === '0' ? 'selected' : ''; ?>>Dislike</option> -->
                    </select> <!-- Ligne HTML : </select> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="col-md-3"> <!-- Ligne HTML : <div class="col-md-3"> -->
                    <label for="pseudo" class="form-label">Pseudo</label> <!-- Ligne HTML : <label for="pseudo" class="form-label">Pseudo</label> -->
                    <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filter_pseudo, ENT_QUOTES, 'UTF-8'); ?>"> <!-- Ligne HTML : <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?php echo htmlspecialchars($ba_bec_filter_pseudo, ENT_QUOTES, 'UTF-8'); ?>"> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="col-md-3"> <!-- Ligne HTML : <div class="col-md-3"> -->
                    <label for="sort" class="form-label">Trier par</label> <!-- Ligne HTML : <label for="sort" class="form-label">Trier par</label> -->
                    <select name="sort" id="sort" class="form-select"> <!-- Ligne HTML : <select name="sort" id="sort" class="form-select"> -->
                        <option value="user" <?php echo $ba_bec_sort_key === 'user' ? 'selected' : ''; ?>>Utilisateur</option> <!-- Ligne HTML : <option value="user" <?php echo $ba_bec_sort_key === 'user' ? 'selected' : ''; ?>>Utilisateur</option> -->
                        <option value="article" <?php echo $ba_bec_sort_key === 'article' ? 'selected' : ''; ?>>Article</option> <!-- Ligne HTML : <option value="article" <?php echo $ba_bec_sort_key === 'article' ? 'selected' : ''; ?>>Article</option> -->
                        <option value="type" <?php echo $ba_bec_sort_key === 'type' ? 'selected' : ''; ?>>Type</option> <!-- Ligne HTML : <option value="type" <?php echo $ba_bec_sort_key === 'type' ? 'selected' : ''; ?>>Type</option> -->
                    </select> <!-- Ligne HTML : </select> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="col-md-3"> <!-- Ligne HTML : <div class="col-md-3"> -->
                    <label for="dir" class="form-label">Direction</label> <!-- Ligne HTML : <label for="dir" class="form-label">Direction</label> -->
                    <select name="dir" id="dir" class="form-select"> <!-- Ligne HTML : <select name="dir" id="dir" class="form-select"> -->
                        <option value="asc" <?php echo $ba_bec_dir === 'asc' ? 'selected' : ''; ?>>Ascendant</option> <!-- Ligne HTML : <option value="asc" <?php echo $ba_bec_dir === 'asc' ? 'selected' : ''; ?>>Ascendant</option> -->
                        <option value="desc" <?php echo $ba_bec_dir === 'desc' ? 'selected' : ''; ?>>Descendant</option> <!-- Ligne HTML : <option value="desc" <?php echo $ba_bec_dir === 'desc' ? 'selected' : ''; ?>>Descendant</option> -->
                    </select> <!-- Ligne HTML : </select> -->
                </div> <!-- Ligne HTML : </div> -->
                <div class="col-12"> <!-- Ligne HTML : <div class="col-12"> -->
                    <button type="submit" class="btn btn-primary">Filtrer</button> <!-- Ligne HTML : <button type="submit" class="btn btn-primary">Filtrer</button> -->
                    <a href="list.php" class="btn btn-secondary">Réinitialiser</a> <!-- Ligne HTML : <a href="list.php" class="btn btn-secondary">Réinitialiser</a> -->
                </div> <!-- Ligne HTML : </div> -->
            </form> <!-- Ligne HTML : </form> -->
            <table class="table table-striped"> <!-- Ligne HTML : <table class="table table-striped"> -->
                <thead> <!-- Ligne HTML : <thead> -->
                    <tr> <!-- Ligne HTML : <tr> -->
                        <th>Nom d'utilisateur</th> <!-- Ligne HTML : <th>Nom d'utilisateur</th> -->
                        <th>ID Article</th> <!-- Ligne HTML : <th>ID Article</th> -->
                        <th>Type de Like</th> <!-- Nouvelle colonne pour afficher le type de like --> <!-- Ligne HTML : <th>Type de Like</th> <!- - Nouvelle colonne pour afficher le type de like - -> -->
                        <th>Actions</th> <!-- Ligne HTML : <th>Actions</th> -->
                    </tr> <!-- Ligne HTML : </tr> -->
                </thead> <!-- Ligne HTML : </thead> -->
                <tbody> <!-- Ligne HTML : <tbody> -->
                    <?php foreach ($ba_bec_likes as $ba_bec_like) { // Ligne PHP : ouverture du script.
                        $ba_bec_pseudoMemb = $ba_bec_like['pseudoMemb'] ?? 'Inconnu'; // Ligne PHP : $ba_bec_pseudoMemb = $ba_bec_like['pseudoMemb'] ?? 'Inconnu';
                        $ba_bec_libTitrArt = $ba_bec_like['libTitrArt'] ?? 'Sans titre'; // Ligne PHP : $ba_bec_libTitrArt = $ba_bec_like['libTitrArt'] ?? 'Sans titre';
                        $ba_bec_typeLike = $ba_bec_like['likeA'] == 1 ? 'Like' : 'Dislike'; // Ligne PHP : $ba_bec_typeLike = $ba_bec_like['likeA'] == 1 ? 'Like' : 'Dislike';
                    ?> <!-- Ligne HTML : fermeture du script PHP. -->
                        <tr> <!-- Ligne HTML : <tr> -->
                            <td><?php echo htmlspecialchars($ba_bec_pseudoMemb, ENT_QUOTES, 'UTF-8'); ?></td> <!-- Ligne HTML : <td><?php echo htmlspecialchars($ba_bec_pseudoMemb, ENT_QUOTES, 'UTF-8'); ?></td> -->
                            <td> <!-- Ligne HTML : <td> -->
                                <?php echo htmlspecialchars($ba_bec_like['numArt'], ENT_QUOTES, 'UTF-8'); ?> <!-- Ligne HTML : <?php echo htmlspecialchars($ba_bec_like['numArt'], ENT_QUOTES, 'UTF-8'); ?> -->
                                <span class="text-muted">- <?php echo htmlspecialchars($ba_bec_libTitrArt, ENT_QUOTES, 'UTF-8'); ?></span> <!-- Ligne HTML : <span class="text-muted">- <?php echo htmlspecialchars($ba_bec_libTitrArt, ENT_QUOTES, 'UTF-8'); ?></span> -->
                            </td> <!-- Ligne HTML : </td> -->
                            <td><?php echo ($ba_bec_typeLike); ?></td> <!-- Affichage du type de like --> <!-- Ligne HTML : <td><?php echo ($ba_bec_typeLike); ?></td> <!- - Affichage du type de like - -> -->
                            <td> <!-- Ligne HTML : <td> -->
                                <a href="edit.php?numArt=<?php echo ($ba_bec_like['numArt']); ?>&numMemb=<?php echo ($ba_bec_like['numMemb']); ?>" class="btn btn-primary">Edit</a> <!-- Ligne HTML : <a href="edit.php?numArt=<?php echo ($ba_bec_like['numArt']); ?>&numMemb=<?php echo ($ba_bec_like['numMemb']); ?>" class="btn btn-primary">Edit</a> -->
                                <a href="delete.php?numArt=<?php echo ($ba_bec_like['numArt']); ?>&numMemb=<?php echo ($ba_bec_like['numMemb']); ?>" class="btn btn-danger">Delete</a> <!-- Ligne HTML : <a href="delete.php?numArt=<?php echo ($ba_bec_like['numArt']); ?>&numMemb=<?php echo ($ba_bec_like['numMemb']); ?>" class="btn btn-danger">Delete</a> -->
                            </td> <!-- Ligne HTML : </td> -->
                        </tr> <!-- Ligne HTML : </tr> -->
                    <?php } ?> <!-- Ligne HTML : <?php } ?> -->
                </tbody> <!-- Ligne HTML : </tbody> -->
            </table> <!-- Ligne HTML : </table> -->
            <a href="create.php" class="btn btn-success">Create</a> <!-- Ligne HTML : <a href="create.php" class="btn btn-success">Create</a> -->
        </div> <!-- Ligne HTML : </div> -->
    </div> <!-- Ligne HTML : </div> -->
</div> <!-- Ligne HTML : </div> -->
