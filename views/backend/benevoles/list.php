<?php
/*
 * Vue d'administration (liste) pour le module benevoles.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

$ba_bec_benevoles = sql_select('PERSONNEL', '*', null, null, 'nomPersonnel ASC, prenomPersonnel ASC');
$ba_bec_teams = sql_select('EQUIPE', 'numEquipe, libEquipe', null, null, 'libEquipe ASC');
$ba_bec_team_map = [];
foreach ($ba_bec_teams as $ba_bec_team) {
    $ba_bec_team_map[$ba_bec_team['numEquipe']] = $ba_bec_team['libEquipe'];
}
$ba_bec_is_missing_table = sql_is_missing_table('PERSONNEL');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Bénévoles</h1>
            <?php if ($ba_bec_is_missing_table): ?>
                <div class="alert alert-warning">
                    <div>La table PERSONNEL est manquante. Veuillez téléchargé la derniere base de donné fournis.</div>
                </div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Photo</th>
                        <th>Coach</th>
                        <th>Direction</th>
                        <th>Commission technique</th>
                        <th>Commission animation</th>
                        <th>Commission communication</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ba_bec_benevoles)): ?>
                        <?php foreach ($ba_bec_benevoles as $ba_bec_benevole): ?>
                            <tr>
                                <td><?php echo $ba_bec_benevole['numPersonnel']; ?></td>
                                <td><?php echo $ba_bec_benevole['prenomPersonnel']; ?></td>
                                <td><?php echo $ba_bec_benevole['nomPersonnel']; ?></td>
                                <td>
                                    <?php if (!empty($ba_bec_benevole['urlPhotoPersonnel'])): ?>
                                        <a href="<?php echo $ba_bec_benevole['urlPhotoPersonnel']; ?>" target="_blank" rel="noopener">Voir</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($ba_bec_benevole['estCoach'])): ?>
                                        Oui<?php if (!empty($ba_bec_benevole['numEquipeCoachee']) && !empty($ba_bec_team_map[$ba_bec_benevole['numEquipeCoachee']])): ?>
                                            (<?php echo htmlspecialchars($ba_bec_team_map[$ba_bec_benevole['numEquipeCoachee']]); ?>)
                                        <?php endif; ?>
                                    <?php else: ?>
                                        Non
                                    <?php endif; ?>
                                </td>
                                <td><?php echo !empty($ba_bec_benevole['estDirection']) ? 'Oui' : 'Non'; ?></td>
                                <td><?php echo !empty($ba_bec_benevole['estCommissionTechnique']) ? 'Oui' : 'Non'; ?></td>
                                <td><?php echo !empty($ba_bec_benevole['estCommissionAnimation']) ? 'Oui' : 'Non'; ?></td>
                                <td><?php echo !empty($ba_bec_benevole['estCommissionCommunication']) ? 'Oui' : 'Non'; ?></td>
                                <td>
                                    <a href="edit.php?numPersonnel=<?= htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numPersonnel=<?= htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Aucun bénévole trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Créer</a>
        </div>
    </div>
</div>
