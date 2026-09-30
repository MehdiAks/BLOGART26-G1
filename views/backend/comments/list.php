<?php
/*
 * Vue d'administration (liste) pour le module comments.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirecmodo.php';
$pageTitle = 'Commentaires · Administration';
include '../../../header.php'; // contains the header and call to config.php

//Load all statuts
$ba_bec_coms = sql_select("COMMENT", "*");
$ba_bec_articles = sql_select("ARTICLE", "*");
$ba_bec_membres = sql_select("MEMBRE", "*");
if(isset($_GET['numCom'])){
    $ba_bec_numCom = (int) $_GET['numCom'];
    $ba_bec_currentCom = sql_select('COMMENT c INNER JOIN MEMBRE m ON c.numMemb = m.numMemb INNER JOIN ARTICLE a ON c.numArt = a.numArt', 'c.*, m.pseudoMemb, a.libTitrArt, a.parag1Art', 'c.numCom = ?', null, null, '1', [$ba_bec_numCom])[0] ?? [];
    foreach ($ba_bec_currentCom as $ba_bec_key => $ba_bec_value) {
        ${'ba_bec_' . $ba_bec_key} = $ba_bec_value;
    }
}
$ba_bec_coms = sql_select("COMMENT c INNER JOIN ARTICLE a ON c.numArt = a.numArt
                                   INNER JOIN MEMBRE m ON c.numMemb = m.numMemb",
                        "c.numCom, c.dtCreaCom, c.libCom, c.dtModCom, c.delLogiq, c.attModOK, c.notifComKOAff, c.numArt, c.numMemb, a.libTitrArt, m.pseudoMemb");


                       
?>

<!-- Bootstrap default layout to display all statuts in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="admin-back-link">← Tableau de bord</a>
            </div>
            <table class="table table-striped">
    <div class="row">
        <h1 class="titre text-start" style="margin: 2rem 10rem 2rem 10rem;">Commentaires en attente</h1>
                <thead>
                    <tr>
                        <th>Titre Article</th>
                        <th>Nom d'utilisateur</th>
                        <th>Date</th>
                        <th>Contenu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                        <?php  foreach($ba_bec_coms as $ba_bec_com ){ 
                            if ($ba_bec_com['attModOK'] == 0 && $ba_bec_com['delLogiq'] == 0){?> 
                                <?php ?> 
                                    <tr>
                                        <td><?php echo e($ba_bec_com['libTitrArt']); ?></td>
                                        <td><?php echo e($ba_bec_com['pseudoMemb']); ?></td>
                                        <td><?php echo e(format_date_fr($ba_bec_com['dtCreaCom'], true)); ?></td>
                                        <td><?php echo e($ba_bec_com['libCom']); ?></td>
                                        <td>
                                            <a href="edit - ATTENTE MODIFICATION.php?numCom=<?php echo (int) $ba_bec_com['numCom']; ?>" class="btn btn-warning">Modifier</a>
                                        </td>
                                        <td>
                                            <a href="edit - CONTROLLER MODIFICATION.php?numCom=<?php echo (int) $ba_bec_com['numCom']; ?>" class="btn btn-primary">Controller</a>
                                        </td>
                                        

                                    </tr>
                        <?php }} ?>
                </tbody>
                
            </table>
            
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
    <div class="row">
        <h1 class="titre text-start" style="margin: 2rem 10rem 2rem 10rem;">Commentaires contrôlés</h1>

                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Dernière modif</th>
                        <th>Contenu</th>
                        <th>Publication</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php  foreach($ba_bec_coms as $ba_bec_com){ 
                            if ($ba_bec_com['attModOK'] == 1 && $ba_bec_com['delLogiq'] == 0){?> 
                                <?php ?> <tr>
                                    <td><?php echo e($ba_bec_com['pseudoMemb']); ?></td>

                                    <td><?php echo e(format_date_fr($ba_bec_com['dtModCom'], true)); ?></td>
                                    <td><?php echo e($ba_bec_com['libCom']); ?></td>
                                    <td><?php echo e(format_date_fr($ba_bec_com['dtCreaCom'], true)); ?></td>
                                    <td>
                                        <a href="edit - CONTROLLER MODIFICATION.php?numCom=<?php echo (int) $ba_bec_com['numCom']; ?>" class="btn btn-warning">Modifier</a>
                                    </td>
                                    

                                </tr>
                        <?php }} ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
    <div class="row">
        <h1 class="titre text-start" style="margin: 2rem 10rem 2rem 10rem;">suppression logique</h1>

                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>date suppr logique</th>
                        <th>Contenu</th>
                        <th>Publication</th>
                        <th>Raison refus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <?php  foreach($ba_bec_coms as $ba_bec_com){ 
                            if ($ba_bec_com['attModOK'] == 0 && $ba_bec_com['delLogiq'] == 1){?> 
                                <?php ?> <tr>
                                    <td><?php echo e($ba_bec_com['pseudoMemb']); ?></td>
                                    <td><?php echo e(format_date_fr($ba_bec_com['dtModCom'], true)); ?></td>
                                    <td><?php echo e($ba_bec_com['libCom']); ?></td>
                                    <td><?php echo e(format_date_fr($ba_bec_com['dtCreaCom'], true)); ?></td>
                                    <td><?php echo e($ba_bec_com['notifComKOAff']); ?></td>
                                    <td>
                                        <a href="edit - SUPPRESION.php?numCom=<?php echo (int) $ba_bec_com['numCom']; ?>" class="btn btn-warning">Modifier</a>
                                    </td>
                                    

                                </tr>
                        <?php }} ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
    <div class="row">
        <h1 class="titre text-start" style="margin: 2rem 10rem 2rem 10rem;">suppression physique</h1>

                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Date suppr logique</th>
                        <th>Contenu</th>
                        <th>Publication</th>
                        <th>Raison refus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <?php  foreach($ba_bec_coms as $ba_bec_com){ 
                            if ($ba_bec_com['delLogiq'] == 1){?> 
                                <?php ?> <tr>
                                    <td><?php echo e($ba_bec_com['pseudoMemb']); ?></td>
                                    <td><?php echo e(format_date_fr($ba_bec_com['dtModCom'], true)); ?></td>
                                    <td><?php echo e($ba_bec_com['libCom']); ?></td>
                                    <td><?php echo e(format_date_fr($ba_bec_com['dtCreaCom'], true)); ?></td>
                                    <td><?php echo e($ba_bec_com['notifComKOAff']); ?></td>
                                    <td>
                                        <a href="delete.php?numCom=<?php echo (int) $ba_bec_com['numCom']; ?>" class="btn btn-danger">Supprimer</a>
                                    </td>
                                    

                                </tr>
                        <?php }} ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<div class="col-md-2" style="margin: 0.5rem 1rem;">
    <a href="create.php" class="btn btn-success">Create</a>
</div>
