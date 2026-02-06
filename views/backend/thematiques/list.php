<?php // Ouvre le contexte PHP pour exécuter du code côté serveur.
/*
 * Vue d'administration (liste) pour le module thematiques.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utilisées par l'admin.
include '../../../header.php'; // Inclut l'en-tête HTML partagé de l'interface.

//Load all statuts
$ba_bec_thematiques = sql_select("THEMATIQUE", "*"); // Charge toutes les thématiques depuis la base.
?> <!-- Ferme le bloc PHP principal. -->

<!-- Bootstrap default layout to display all statuts in foreach -->
<div class="container"><!-- Ouvre le conteneur principal Bootstrap. -->
    <div class="row"><!-- Démarre une ligne Bootstrap pour organiser les colonnes. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le contenu principal. -->
            <div class="mb-3"><!-- Bloc avec marge basse pour le bouton. -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"><!-- Lien de retour vers le tableau de bord. -->
                    Retour au panneau admin<!-- Texte du lien de retour. -->
                </a><!-- Ferme le lien de retour. -->
            </div><!-- Ferme le bloc du bouton. -->
            <h1>Thematiques</h1><!-- Affiche le titre de la page. -->
            <?php // Ouvre un bloc PHP pour préparer les messages flash.
            $ba_bec_flash_messages = flash_get(); // Récupère les messages flash à afficher.
            $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning']; // Associe les types de messages aux classes Bootstrap.
            ?> <!-- Ferme le bloc PHP des messages flash. -->
            <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?><!-- Parcourt les messages flash. -->
                <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert"><!-- Affiche une alerte stylée selon le type. -->
                    <?php echo htmlspecialchars($ba_bec_flash['message']); ?><!-- Affiche le message en échappant le HTML. -->
                </div><!-- Ferme la zone d'alerte. -->
            <?php endforeach; ?><!-- Termine la boucle des messages flash. -->
            <table class="table table-striped"><!-- Ouvre le tableau des thématiques. -->
                <thead><!-- Ouvre l'en-tête du tableau. -->
                    <tr><!-- Ouvre la ligne d'en-tête. -->
                        <th>Id</th><!-- Colonne de l'identifiant. -->
                        <th>Nom des thematiques</th><!-- Colonne du libellé. -->
                        <th>Actions</th><!-- Colonne des actions. -->
                    </tr><!-- Ferme la ligne d'en-tête. -->
                </thead><!-- Ferme l'en-tête du tableau. -->
                <tbody><!-- Ouvre le corps du tableau. -->
                    <?php foreach ($ba_bec_thematiques as $ba_bec_thematique) { ?><!-- Parcourt chaque thématique. -->
                        <tr><!-- Ouvre la ligne pour une thématique. -->
                            <td><?php echo $ba_bec_thematique['numThem']; ?></td><!-- Affiche l'identifiant. -->
                            <td><?php echo $ba_bec_thematique['libThem']; ?></td><!-- Affiche le libellé. -->
                            <td><!-- Ouvre la colonne des actions. -->
                                <a href="edit.php?numThem=<?php echo($ba_bec_thematique['numThem']); ?>" class="btn btn-primary">Edit</a><!-- Lien vers l'édition. -->
                                <a href="delete.php?numThem=<?php echo($ba_bec_thematique['numThem']); ?>" class="btn btn-danger">Delete</a><!-- Lien vers la suppression. -->
                            </td><!-- Ferme la colonne des actions. -->
                        </tr><!-- Ferme la ligne de thématique. -->
                    <?php } ?><!-- Termine la boucle des thématiques. -->
                </tbody><!-- Ferme le corps du tableau. -->
            </table><!-- Ferme le tableau. -->
            <a href="create.php" class="btn btn-success">Create</a><!-- Lien vers la création d'une thématique. -->
        </div><!-- Ferme la colonne principale. -->
    </div><!-- Ferme la ligne Bootstrap. -->
</div><!-- Ferme le conteneur principal. -->
