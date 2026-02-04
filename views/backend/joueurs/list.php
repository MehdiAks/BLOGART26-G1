<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

$ba_bec_joueurs = sql_select('JOUEUR', '*', null, null, 'nomJoueur ASC, prenomJoueur ASC');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Joueurs</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Numéro</th>
                        <th>Poste</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ba_bec_joueurs)): ?>
                        <?php foreach ($ba_bec_joueurs as $ba_bec_joueur): ?>
                            <tr>
                                <td><?php echo $ba_bec_joueur['numJoueur']; ?></td>
                                <td><?php echo $ba_bec_joueur['prenomJoueur']; ?></td>
                                <td><?php echo $ba_bec_joueur['nomJoueur']; ?></td>
                                <td><?php echo $ba_bec_joueur['numMaillot'] ?? '-'; ?></td>
                                <td><?php echo $ba_bec_joueur['posteJoueur'] ?: '-'; ?></td>
                                <td>
                                    <?php if (!empty($ba_bec_joueur['urlPhotoJoueur'])): ?>
                                        <?php
                                        $ba_bec_photo = $ba_bec_joueur['urlPhotoJoueur'];
                                        $ba_bec_photoUrl = preg_match('/^(https?:\\/\\/|\\/)/', $ba_bec_photo)
                                            ? $ba_bec_photo
                                            : ROOT_URL . '/src/uploads/' . $ba_bec_photo;
                                        ?>
                                        <a href="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" target="_blank" rel="noopener">Voir</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?numJoueur=<?= htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numJoueur=<?= htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Aucun joueur trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Créer</a>
        </div>
    </div>
</div>
