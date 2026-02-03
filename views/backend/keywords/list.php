<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php'; 

//Load all statuts
$ba_bec_keywords = sql_select("MOTCLE", "*");
?>

<!-- Bootstrap default layout to display all statuts in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Mots-clés</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom des Mots-clés</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ba_bec_keywords as $ba_bec_keyword) { ?>
                        <tr>
                            <td><?php echo $ba_bec_keyword['numMotCle']; ?></td>
                            <td><?php echo $ba_bec_keyword['libMotCle']; ?></td>
                            <td>
                                <a href="edit.php?numMotCle=<?php echo($ba_bec_keyword['numMotCle']); ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?numMotCle=<?php echo($ba_bec_keyword['numMotCle']); ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
