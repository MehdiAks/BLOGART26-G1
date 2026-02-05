<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_table'])) {
    $ba_bec_table = strtoupper(trim($_POST['create_table']));
    if ($ba_bec_table === 'PERSONNEL' && sql_create_table($ba_bec_table)) {
        header('Location: list.php?table_created=PERSONNEL');
        exit;
    }
    $ba_bec_table_error = 'La création de la table a échoué. Vérifiez la connexion à la base de données.';
}

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
            <?php if (!empty($_GET['table_created'])): ?>
                <div class="alert alert-success">La table a été créée.</div>
            <?php endif; ?>
            <?php if (!empty($ba_bec_table_error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($ba_bec_table_error); ?></div>
            <?php endif; ?>
            <?php if ($ba_bec_is_missing_table): ?>
                <div class="alert alert-warning d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div>La table PERSONNEL est manquante. Vous pouvez la créer pour continuer.</div>
                    <form method="post" class="mb-0">
                        <button type="submit" name="create_table" value="PERSONNEL" class="btn btn-warning">Créer la table</button>
                    </form>
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
