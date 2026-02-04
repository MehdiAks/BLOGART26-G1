<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include '../../../header.php'; // contains the header and call to config.php

//Load all statuts
$ba_bec_statuts = sql_select("STATUT", "*");
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
            <h1>Statuts</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom des statuts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ba_bec_statuts as $ba_bec_statut){ ?>
                        <tr>
                            <td><?php echo($ba_bec_statut['numStat']); ?></td>
                            <td><?php echo($ba_bec_statut['libStat']); ?></td>
                            <td>
                                <a href="edit.php?numStat=<?php echo($ba_bec_statut['numStat']); ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?numStat=<?php echo($ba_bec_statut['numStat']); ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
<?php
include '../../../footer.php'; // contains the footer
