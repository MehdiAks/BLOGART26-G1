<?php
// Ouvre le bloc PHP.
/*
 * Vue d'administration (liste) pour le module keywords.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
// Charge le fichier de configuration principal.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Charge le fichier de redirection utilitaire.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
// Inclut l'en-tête commun du site.
include '../../../header.php';

// Charge tous les mots-clés depuis la base de données.
$ba_bec_keywords = sql_select("MOTCLE", "*");
// Ferme le bloc PHP.
?>

<!-- Décrit le commentaire HTML : début du layout Bootstrap. -->
<!-- Bootstrap default layout to display all statuts in foreach -->
<!-- Ouvre un conteneur Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur. -->
        <div class="col-md-12">
            <!-- Ouvre un conteneur de marge basse. -->
            <div class="mb-3">
                <!-- Ouvre un lien vers le tableau de bord admin. -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    <!-- Texte du lien de retour. -->
                    Retour au panneau admin
                <!-- Ferme le lien. -->
                </a>
            <!-- Ferme le conteneur de marge. -->
            </div>
            <!-- Titre principal de la page. -->
            <h1>Mots-clés</h1>
            <!-- Ouvre un bloc PHP. -->
            <?php
            // Récupère les messages flash.
            $ba_bec_flash_messages = flash_get();
            // Définit la correspondance des types d'alertes Bootstrap.
            $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning'];
            // Ferme le bloc PHP.
            ?>
            <!-- Ouvre une boucle foreach sur les messages flash. -->
            <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?>
                <!-- Ouvre un conteneur d'alerte Bootstrap. -->
                <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert">
                    <!-- Affiche le message flash en échappant le HTML. -->
                    <?php echo htmlspecialchars($ba_bec_flash['message']); ?>
                <!-- Ferme le conteneur d'alerte. -->
                </div>
            <!-- Ferme la boucle foreach. -->
            <?php endforeach; ?>
            <!-- Ouvre le tableau Bootstrap. -->
            <table class="table table-striped">
                <!-- Ouvre l'en-tête du tableau. -->
                <thead>
                    <!-- Ouvre une ligne d'en-tête. -->
                    <tr>
                        <!-- Colonne pour l'identifiant. -->
                        <th>Id</th>
                        <!-- Colonne pour le nom du mot-clé. -->
                        <th>Nom des Mots-clés</th>
                        <!-- Colonne pour les actions. -->
                        <th>Actions</th>
                    <!-- Ferme la ligne d'en-tête. -->
                    </tr>
                <!-- Ferme l'en-tête du tableau. -->
                </thead>
                <!-- Ouvre le corps du tableau. -->
                <tbody>
                    <!-- Ouvre une boucle foreach sur les mots-clés. -->
                    <?php foreach ($ba_bec_keywords as $ba_bec_keyword) { ?>
                        <!-- Ouvre une ligne de données. -->
                        <tr>
                            <!-- Affiche l'identifiant du mot-clé. -->
                            <td><?php echo $ba_bec_keyword['numMotCle']; ?></td>
                            <!-- Affiche le libellé du mot-clé. -->
                            <td><?php echo $ba_bec_keyword['libMotCle']; ?></td>
                            <!-- Ouvre la cellule des actions. -->
                            <td>
                                <!-- Lien vers la page d'édition du mot-clé. -->
                                <a href="edit.php?numMotCle=<?php echo($ba_bec_keyword['numMotCle']); ?>" class="btn btn-primary">Edit</a>
                                <!-- Lien vers la page de suppression du mot-clé. -->
                                <a href="delete.php?numMotCle=<?php echo($ba_bec_keyword['numMotCle']); ?>" class="btn btn-danger">Delete</a>
                            <!-- Ferme la cellule des actions. -->
                            </td>
                        <!-- Ferme la ligne de données. -->
                        </tr>
                    <!-- Ferme la boucle foreach. -->
                    <?php } ?>
                <!-- Ferme le corps du tableau. -->
                </tbody>
            <!-- Ferme le tableau. -->
            </table>
            <!-- Lien vers la page de création d'un mot-clé. -->
            <a href="create.php" class="btn btn-success">Create</a>
        <!-- Ferme la colonne. -->
        </div>
    <!-- Ferme la ligne. -->
    </div>
<!-- Ferme le conteneur. -->
</div>
