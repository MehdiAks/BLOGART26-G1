<?php // Ouvre le bloc PHP pour exécuter du code serveur.
/*
 * Vue d'administration (liste) pour le module members.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale du site.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection/contrôle.
include '../../../header.php'; // Inclut l'en-tête HTML commun.



// Charger tous les membres avec leur statut
$ba_bec_members = sql_select("MEMBRE INNER JOIN STATUT ON MEMBRE.numStat = STATUT.numStat", "*"); // Récupère tous les membres avec leur statut associé.
?> <!-- Ferme le bloc PHP initial. -->

<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Démarre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Colonne pleine largeur sur écran moyen+. -->
            <div class="mb-3"> <!-- Ajoute un bloc avec marge basse. -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> <!-- Lien de retour vers le tableau de bord admin. -->
                    Retour au panneau admin <!-- Texte du bouton de retour. -->
                </a> <!-- Ferme le lien de retour. -->
            </div> <!-- Ferme le bloc de marge. -->
            <h1>Membres</h1> <!-- Titre principal de la page. -->
            <?php // Ouvre un bloc PHP pour gérer les messages flash.
            $ba_bec_flash_messages = flash_get(); // Récupère les messages flash en session.
            $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning']; // Mappe les types d'alertes aux classes Bootstrap.
            ?> <!-- Ferme le bloc PHP de préparation. -->
            <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?> <!-- Boucle sur chaque message flash. -->
                <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert"> <!-- Affiche une alerte Bootstrap selon le type. -->
                    <?php echo htmlspecialchars($ba_bec_flash['message']); ?> <!-- Affiche le texte du message en échappant le HTML. -->
                </div> <!-- Ferme l'alerte Bootstrap. -->
            <?php endforeach; ?> <!-- Termine la boucle des messages flash. -->
            <table class="table table-striped"> <!-- Démarre un tableau Bootstrap zébré. -->
                <thead> <!-- Ouvre l'en-tête du tableau. -->
                    <tr> <!-- Ouvre une ligne d'en-tête. -->
                        <th>ID</th> <!-- Colonne pour l'identifiant. -->
                        <th>Prénom</th> <!-- Colonne pour le prénom. -->
                        <th>Nom</th> <!-- Colonne pour le nom. -->
                        <th>Email</th> <!-- Colonne pour l'email. -->
                        <th>Accord RGPD</th> <!-- Colonne pour l'accord RGPD. -->
                        <th>Statut</th> <!-- Colonne pour le statut. -->
                        <th>Actions</th> <!-- Colonne pour les actions. -->
                    </tr> <!-- Ferme la ligne d'en-tête. -->
                </thead> <!-- Ferme l'en-tête du tableau. -->
                <tbody> <!-- Ouvre le corps du tableau. -->
                    <?php if (!empty($ba_bec_members)): ?> <!-- Vérifie si la liste des membres n'est pas vide. -->
                        <?php foreach ($ba_bec_members as $ba_bec_mem): ?> <!-- Boucle sur chaque membre. -->
                            <tr> <!-- Ouvre une ligne du tableau pour un membre. -->
                                <td><?php echo ($ba_bec_mem['numMemb']); ?></td> <!-- Affiche l'ID du membre. -->
                                <td><?php echo ($ba_bec_mem['prenomMemb']); ?></td> <!-- Affiche le prénom du membre. -->
                                <td><?php echo ($ba_bec_mem['nomMemb']); ?></td> <!-- Affiche le nom du membre. -->
                                <td><?php echo ($ba_bec_mem['eMailMemb']); ?></td> <!-- Affiche l'email du membre. -->
                                <td><?= $ba_bec_mem['accordMemb'] ? '✅ Oui' : '❌ Non'; ?></td> <!-- Affiche l'accord RGPD en texte/emoji. -->
                                <td><?php echo ($ba_bec_mem['libStat']); ?></td> <!-- Affiche le libellé du statut. -->
                                <td> <!-- Ouvre la cellule des actions. -->
                                    <a href="edit.php?numMemb=<?= htmlspecialchars($ba_bec_mem['numMemb']); ?>"
                                        class="btn btn-primary">Edit</a> <!-- Lien vers l'édition du membre. -->
                                    <?php if ($ba_bec_mem['numStat'] == 1): ?> <!-- Vérifie si le membre est admin. -->
                                        <button class="btn btn-danger disabled">Delete</button> <!-- Désactive la suppression pour un admin. -->
                                    <?php else: ?> <!-- Cas où le membre n'est pas admin. -->
                                        <a href="delete.php?numMemb=<?= htmlspecialchars($ba_bec_mem['numMemb']); ?>"
                                            class="btn btn-danger">Delete</a> <!-- Lien vers la suppression du membre. -->
                                    <?php endif; ?> <!-- Ferme la condition sur le statut admin. -->
                                </td> <!-- Ferme la cellule des actions. -->
                            </tr> <!-- Ferme la ligne du membre. -->
                        <?php endforeach; ?> <!-- Termine la boucle des membres. -->
                    <?php else: ?> <!-- Cas où aucun membre n'est trouvé. -->
                        <tr> <!-- Ouvre une ligne d'information. -->
                            <td colspan="7">Aucun membre trouvé</td> <!-- Affiche le message d'absence de données. -->
                        </tr> <!-- Ferme la ligne d'information. -->
                    <?php endif; ?> <!-- Ferme la condition de liste vide. -->
                </tbody> <!-- Ferme le corps du tableau. -->
            </table> <!-- Ferme le tableau. -->
            <a href="create.php" class="btn btn-success">Créer</a> <!-- Lien vers la création d'un membre. -->
        </div> <!-- Ferme la colonne. -->
    </div> <!-- Ferme la ligne. -->
</div> <!-- Ferme le conteneur. -->
