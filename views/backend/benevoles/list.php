<?php // Démarre l'exécution du script en mode PHP.
/*
 * Vue d'administration (liste) pour le module benevoles.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection.
include '../../../header.php'; // Inclut l'en-tête HTML partagé.

$ba_bec_benevoles = sql_select('PERSONNEL', '*', null, null, 'nomPersonnel ASC, prenomPersonnel ASC'); // Récupère tous les bénévoles triés par nom et prénom.
$ba_bec_teams = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Récupère toutes les équipes triées par nom.
$ba_bec_team_map = []; // Initialise un tableau associatif pour le mapping code -> nom d'équipe.
foreach ($ba_bec_teams as $ba_bec_team) { // Parcourt chaque équipe récupérée.
    $ba_bec_team_map[$ba_bec_team['codeEquipe']] = $ba_bec_team['nomEquipe']; // Associe le code d'équipe à son nom.
}
$ba_bec_is_missing_table = sql_is_missing_table('PERSONNEL'); // Vérifie si la table PERSONNEL manque en base.
?>

<!-- Ouvre le conteneur principal Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap pour la grille. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur pour le contenu. -->
        <div class="col-md-12">
            <!-- Ouvre un bloc avec marge basse pour le lien de retour. -->
            <div class="mb-3">
                <!-- Ouvre un lien vers le tableau de bord admin. -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    <!-- Affiche le texte du lien de retour. -->
                    Retour au panneau admin
                <!-- Ferme le lien de retour. -->
                </a>
            <!-- Ferme le bloc de marge basse. -->
            </div>
            <!-- Affiche le titre principal de la page. -->
            <h1>Bénévoles</h1>
            <!-- Démarre un test PHP pour afficher un avertissement si la table manque. -->
            <?php if ($ba_bec_is_missing_table): ?>
                <!-- Ouvre une alerte Bootstrap de type warning. -->
                <div class="alert alert-warning">
                    <!-- Affiche le message d'avertissement sur la table manquante. -->
                    <div>La table PERSONNEL est manquante. Veuillez téléchargé la derniere base de donné fournis.</div>
                <!-- Ferme l'alerte warning. -->
                </div>
            <!-- Termine le test PHP d'alerte. -->
            <?php endif; ?>
            <!-- Ouvre le tableau Bootstrap listant les bénévoles. -->
            <table class="table table-striped">
                <!-- Ouvre l'en-tête du tableau. -->
                <thead>
                    <!-- Ouvre une ligne d'en-tête. -->
                    <tr>
                        <!-- Colonne pour l'identifiant. -->
                        <th>ID</th>
                        <!-- Colonne pour le prénom. -->
                        <th>Prénom</th>
                        <!-- Colonne pour le nom. -->
                        <th>Nom</th>
                        <!-- Colonne pour la photo. -->
                        <th>Photo</th>
                        <!-- Colonne pour l'indicateur staff équipe. -->
                        <th>Staff équipe</th>
                        <!-- Colonne pour l'indicateur direction. -->
                        <th>Direction</th>
                        <!-- Colonne pour l'indicateur commission technique. -->
                        <th>Commission technique</th>
                        <!-- Colonne pour l'indicateur commission animation. -->
                        <th>Commission animation</th>
                        <!-- Colonne pour l'indicateur commission communication. -->
                        <th>Commission communication</th>
                        <!-- Colonne pour les actions. -->
                        <th>Actions</th>
                    <!-- Ferme la ligne d'en-tête. -->
                    </tr>
                <!-- Ferme l'en-tête du tableau. -->
                </thead>
                <!-- Ouvre le corps du tableau. -->
                <tbody>
                    <!-- Démarre un test PHP pour savoir si des bénévoles existent. -->
                    <?php if (!empty($ba_bec_benevoles)): ?>
                        <!-- Démarre la boucle PHP sur la liste des bénévoles. -->
                        <?php foreach ($ba_bec_benevoles as $ba_bec_benevole): ?>
                            <!-- Ouvre une ligne pour un bénévole. -->
                            <tr>
                                <!-- Affiche l'identifiant du bénévole. -->
                                <td><?php echo $ba_bec_benevole['numPersonnel']; ?></td>
                                <!-- Affiche le prénom du bénévole. -->
                                <td><?php echo $ba_bec_benevole['prenomPersonnel']; ?></td>
                                <!-- Affiche le nom du bénévole. -->
                                <td><?php echo $ba_bec_benevole['nomPersonnel']; ?></td>
                                <!-- Ouvre la cellule photo. -->
                                <td>
                                    <!-- Démarre un test PHP pour savoir si une photo existe. -->
                                    <?php if (!empty($ba_bec_benevole['urlPhotoPersonnel'])): ?>
                                        <!-- Affiche un lien vers la photo dans un nouvel onglet. -->
                                        <a href="<?php echo $ba_bec_benevole['urlPhotoPersonnel']; ?>" target="_blank" rel="noopener">Voir</a>
                                    <!-- Sinon affiche un tiret si pas de photo. -->
                                    <?php else: ?>
                                        -
                                    <!-- Termine le test PHP sur la photo. -->
                                    <?php endif; ?>
                                <!-- Ferme la cellule photo. -->
                                </td>
                                <!-- Ouvre la cellule staff équipe. -->
                                <td>
                                    <!-- Démarre un test PHP pour savoir si le bénévole est staff équipe. -->
                                    <?php if (!empty($ba_bec_benevole['estStaffEquipe'])): ?>
                                        <!-- Affiche Oui si staff équipe. -->
                                        Oui
                                        <!-- Démarre un test PHP pour afficher l'équipe si elle est renseignée. -->
                                        <?php if (!empty($ba_bec_benevole['numEquipeStaff']) && !empty($ba_bec_team_map[$ba_bec_benevole['numEquipeStaff']])): ?>
                                            <!-- Affiche le nom de l'équipe associée. -->
                                            (<?php echo htmlspecialchars($ba_bec_team_map[$ba_bec_benevole['numEquipeStaff']]); ?>)
                                        <!-- Termine le test PHP sur l'équipe. -->
                                        <?php endif; ?>
                                        <!-- Démarre un test PHP pour afficher le rôle staff équipe. -->
                                        <?php if (!empty($ba_bec_benevole['roleStaffEquipe'])): ?>
                                            <!-- Affiche le rôle staff équipe. -->
                                            - <?php echo htmlspecialchars($ba_bec_benevole['roleStaffEquipe']); ?>
                                        <!-- Termine le test PHP sur le rôle staff équipe. -->
                                        <?php endif; ?>
                                    <!-- Sinon affiche Non si pas staff équipe. -->
                                    <?php else: ?>
                                        Non
                                    <!-- Termine le test PHP staff équipe. -->
                                    <?php endif; ?>
                                <!-- Ferme la cellule staff équipe. -->
                                </td>
                                <!-- Ouvre la cellule direction. -->
                                <td>
                                    <!-- Démarre un test PHP pour savoir si le bénévole est en direction. -->
                                    <?php if (!empty($ba_bec_benevole['estDirection'])): ?>
                                        <!-- Affiche Oui si direction, puis affiche le poste si présent. -->
                                        Oui<?php if (!empty($ba_bec_benevole['posteDirection'])): ?>
                                            <!-- Affiche le poste en direction. -->
                                            (<?php echo htmlspecialchars($ba_bec_benevole['posteDirection']); ?>)
                                        <!-- Termine le test PHP sur le poste direction. -->
                                        <?php endif; ?>
                                    <!-- Sinon affiche Non si pas en direction. -->
                                    <?php else: ?>
                                        Non
                                    <!-- Termine le test PHP direction. -->
                                    <?php endif; ?>
                                <!-- Ferme la cellule direction. -->
                                </td>
                                <!-- Ouvre la cellule commission technique. -->
                                <td>
                                    <!-- Démarre un test PHP pour savoir si commission technique. -->
                                    <?php if (!empty($ba_bec_benevole['estCommissionTechnique'])): ?>
                                        <!-- Affiche Oui si commission technique, puis le poste si présent. -->
                                        Oui<?php if (!empty($ba_bec_benevole['posteCommissionTechnique'])): ?>
                                            <!-- Affiche le poste commission technique. -->
                                            (<?php echo htmlspecialchars($ba_bec_benevole['posteCommissionTechnique']); ?>)
                                        <!-- Termine le test PHP du poste commission technique. -->
                                        <?php endif; ?>
                                    <!-- Sinon affiche Non si pas commission technique. -->
                                    <?php else: ?>
                                        Non
                                    <!-- Termine le test PHP commission technique. -->
                                    <?php endif; ?>
                                <!-- Ferme la cellule commission technique. -->
                                </td>
                                <!-- Ouvre la cellule commission animation. -->
                                <td>
                                    <!-- Démarre un test PHP pour savoir si commission animation. -->
                                    <?php if (!empty($ba_bec_benevole['estCommissionAnimation'])): ?>
                                        <!-- Affiche Oui si commission animation, puis le poste si présent. -->
                                        Oui<?php if (!empty($ba_bec_benevole['posteCommissionAnimation'])): ?>
                                            <!-- Affiche le poste commission animation. -->
                                            (<?php echo htmlspecialchars($ba_bec_benevole['posteCommissionAnimation']); ?>)
                                        <!-- Termine le test PHP du poste commission animation. -->
                                        <?php endif; ?>
                                    <!-- Sinon affiche Non si pas commission animation. -->
                                    <?php else: ?>
                                        Non
                                    <!-- Termine le test PHP commission animation. -->
                                    <?php endif; ?>
                                <!-- Ferme la cellule commission animation. -->
                                </td>
                                <!-- Ouvre la cellule commission communication. -->
                                <td>
                                    <!-- Démarre un test PHP pour savoir si commission communication. -->
                                    <?php if (!empty($ba_bec_benevole['estCommissionCommunication'])): ?>
                                        <!-- Affiche Oui si commission communication, puis le poste si présent. -->
                                        Oui<?php if (!empty($ba_bec_benevole['posteCommissionCommunication'])): ?>
                                            <!-- Affiche le poste commission communication. -->
                                            (<?php echo htmlspecialchars($ba_bec_benevole['posteCommissionCommunication']); ?>)
                                        <!-- Termine le test PHP du poste commission communication. -->
                                        <?php endif; ?>
                                    <!-- Sinon affiche Non si pas commission communication. -->
                                    <?php else: ?>
                                        Non
                                    <!-- Termine le test PHP commission communication. -->
                                    <?php endif; ?>
                                <!-- Ferme la cellule commission communication. -->
                                </td>
                                <!-- Ouvre la cellule des actions. -->
                                <td>
                                    <!-- Lien vers la page d'édition avec l'identifiant du bénévole. -->
                                    <a href="edit.php?numPersonnel=<?= htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" class="btn btn-primary">Edit</a>
                                    <!-- Lien vers la page de suppression avec l'identifiant du bénévole. -->
                                    <a href="delete.php?numPersonnel=<?= htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" class="btn btn-danger">Delete</a>
                                <!-- Ferme la cellule des actions. -->
                                </td>
                            <!-- Ferme la ligne du bénévole. -->
                            </tr>
                        <!-- Termine la boucle PHP des bénévoles. -->
                        <?php endforeach; ?>
                    <!-- Sinon affiche une ligne si aucun bénévole. -->
                    <?php else: ?>
                        <!-- Ouvre une ligne pour l'absence de résultats. -->
                        <tr>
                            <!-- Cellule pleine largeur qui indique l'absence de bénévoles. -->
                            <td colspan="10">Aucun bénévole trouvé</td>
                        <!-- Ferme la ligne d'absence de résultats. -->
                        </tr>
                    <!-- Termine le test PHP de présence de bénévoles. -->
                    <?php endif; ?>
                <!-- Ferme le corps du tableau. -->
                </tbody>
            <!-- Ferme le tableau. -->
            </table>
            <!-- Lien vers la page de création d'un bénévole. -->
            <a href="create.php" class="btn btn-success">Créer</a>
        <!-- Ferme la colonne du contenu. -->
        </div>
    <!-- Ferme la ligne Bootstrap. -->
    </div>
<!-- Ferme le conteneur principal. -->
</div>
