<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

if (isset($_POST['create_table'])) {
    $ba_bec_table = strtoupper(trim((string) ($_POST['create_table'] ?? '')));
    if ($ba_bec_table === 'EQUIPE' && sql_create_table($ba_bec_table)) {
        header('Location: list.php?table_created=EQUIPE');
        exit;
    }
}

$ba_bec_is_missing_table = sql_is_missing_table('EQUIPE');
$ba_bec_equipes = [];
if (!$ba_bec_is_missing_table) {
    $teamsStmt = $DB->prepare(
        'SELECT e.numEquipe, e.codeEquipe, e.libEquipe, e.libEquipeComplet,
                c.nomClub, ce.libCategorie, se.libSection, ne.libNiveau
         FROM EQUIPE e
         INNER JOIN CLUB c ON e.numClub = c.numClub
         INNER JOIN CATEGORIE_EQUIPE ce ON e.numCategorie = ce.numCategorie
         INNER JOIN SECTION_EQUIPE se ON e.numSection = se.numSection
         INNER JOIN NIVEAU_EQUIPE ne ON e.numNiveau = ne.numNiveau
         ORDER BY e.libEquipe ASC'
    );
    $teamsStmt->execute();
    $ba_bec_equipes = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/create.php'; ?>" class="btn btn-success">
                    Ajouter une équipe
                </a>
            </div>

            <?php if ($ba_bec_is_missing_table) : ?>
                <div class="alert alert-warning d-flex justify-content-between align-items-center">
                    <div>La table EQUIPE est manquante. Vous pouvez la créer pour continuer.</div>
                    <form method="post">
                        <button type="submit" name="create_table" value="EQUIPE" class="btn btn-warning">Créer la table</button>
                    </form>
                </div>
            <?php endif; ?>

            <h1>Liste des équipes</h1>
            <?php if (empty($ba_bec_equipes)) : ?>
                <div class="alert alert-info">Aucune équipe trouvée.</div>
            <?php else : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Club</th>
                            <th>Catégorie</th>
                            <th>Section</th>
                            <th>Niveau</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['libEquipeComplet'] ?: $ba_bec_equipe['libEquipe']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['nomClub']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['libCategorie']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['libSection']); ?></td>
                                <td><?php echo htmlspecialchars($ba_bec_equipe['libNiveau']); ?></td>
                                <td>
                                    <a href="edit.php?numEquipe=<?php echo $ba_bec_equipe['numEquipe']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numEquipe=<?php echo $ba_bec_equipe['numEquipe']; ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
