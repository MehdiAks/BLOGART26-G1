<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

$ba_bec_equipes = sql_select('EQUIPE', '*', null, null, 'libEquipe ASC');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Équipes</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Section</th>
                        <th>Niveau</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ba_bec_equipes)): ?>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                            <tr>
                                <td><?php echo $ba_bec_equipe['numEquipe']; ?></td>
                                <td><?php echo $ba_bec_equipe['libEquipe']; ?></td>
                                <td><?php echo $ba_bec_equipe['categorieEquipe'] ?: '-'; ?></td>
                                <td><?php echo $ba_bec_equipe['sectionEquipe'] ?: '-'; ?></td>
                                <td><?php echo $ba_bec_equipe['niveauEquipe'] ?: '-'; ?></td>
                                <td>
                                    <a href="edit.php?numEquipe=<?= htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numEquipe=<?= htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Aucune équipe trouvée</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Créer</a>
        </div>
    </div>
</div>
