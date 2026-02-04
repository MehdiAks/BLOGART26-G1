<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_table'])) {
    $ba_bec_table = strtoupper(trim($_POST['create_table']));
    if ($ba_bec_table === 'EQUIPE' && sql_create_table($ba_bec_table)) {
        header('Location: list.php?table_created=EQUIPE');
        exit;
    }
    $ba_bec_table_error = 'La création de la table a échoué. Vérifiez la connexion à la base de données.';
}

$ba_bec_equipes = sql_select('EQUIPE', '*', null, null, 'libEquipe ASC');
$ba_bec_is_missing_table = sql_is_missing_table('EQUIPE');
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
            <?php if (!empty($_GET['table_created'])): ?>
                <div class="alert alert-success">La table a été créée.</div>
            <?php endif; ?>
            <?php if (!empty($ba_bec_table_error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($ba_bec_table_error); ?></div>
            <?php endif; ?>
            <?php if ($ba_bec_is_missing_table): ?>
                <div class="alert alert-warning d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div>La table EQUIPE est manquante. Vous pouvez la créer pour continuer.</div>
                    <form method="post" class="mb-0">
                        <button type="submit" name="create_table" value="EQUIPE" class="btn btn-warning">Créer la table</button>
                    </form>
                </div>
            <?php endif; ?>
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
