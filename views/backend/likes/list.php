<?php
include '../../../header.php'; // Contient le header et l'appel à config.php

// Récupérer tous les membres et les likes
$ba_bec_membres = sql_select("membre", "*");
$ba_bec_likes = sql_select("likeart", "*");

if (isset($_GET['numMemb'])) {
    $ba_bec_numMemb = intval($_GET['numMemb']); // Sécuriser l'entrée
    $ba_bec_result = sql_select("membre", "pseudoMemb", "numMemb = $ba_bec_numMemb");
    if (!empty($ba_bec_result)) {
        $ba_bec_pseudoMemb = $ba_bec_result[0]['pseudoMemb'];
    } else {
        $ba_bec_pseudoMemb = "Inconnu"; // Si aucun membre trouvé
    }
}
?>

<!-- Inclusion du CSS -->
<link rel="stylesheet" href="/../../src/css/style.css">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Gestion des likes</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>ID Article</th>
                        <th>Type de Like</th> <!-- Nouvelle colonne pour afficher le type de like -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ba_bec_likes as $ba_bec_like) { 
                        // Récupérer le nom d'utilisateur du membre
                        $ba_bec_numMemb = intval($ba_bec_like['numMemb']);
                        $ba_bec_membreData = sql_select("membre", "pseudoMemb", "numMemb = $ba_bec_numMemb");
                        $ba_bec_pseudoMemb = !empty($ba_bec_membreData) ? $ba_bec_membreData[0]['pseudoMemb'] : "Inconnu";
                        
                        // Vérification de la valeur de likeA pour afficher "Like" ou "Dislike"
                        $ba_bec_typeLike = $ba_bec_like['likeA'] == 1 ? 'Like' : 'Dislike'; 
                    ?>
                        <tr>
                            <td><?php echo ($ba_bec_pseudoMemb); ?></td>
                            <td><?php echo ($ba_bec_like['numArt']); ?></td>
                            <td><?php echo ($ba_bec_typeLike); ?></td> <!-- Affichage du type de like -->
                            <td>
                                <a href="edit.php?numArt=<?php echo ($ba_bec_like['numArt']); ?>&numMemb=<?php echo ($ba_bec_like['numMemb']); ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?numArt=<?php echo ($ba_bec_like['numArt']); ?>&numMemb=<?php echo ($ba_bec_like['numMemb']); ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
