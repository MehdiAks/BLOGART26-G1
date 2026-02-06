<!-- Cette ligne contient le balisage/texte : <!- - -->
<!--
<!-- Cette ligne contient le balisage/texte : /* -->
    /*
<!-- Cette ligne contient le balisage/texte : * Vue d'administration (liste) pour le module articles. -->
     * Vue d'administration (liste) pour le module articles.
<!-- Cette ligne contient le balisage/texte : * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées. -->
     * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
<!-- Cette ligne contient le balisage/texte : * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base. -->
     * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
<!-- Cette ligne contient le balisage/texte : * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression. -->
     * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
<!-- Cette ligne contient le balisage/texte : * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow. -->
     * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
<!-- Cette ligne contient le balisage/texte : * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections. -->
     * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
<!-- Cette ligne contient le balisage/texte : */ -->
     */
<!-- Cette ligne contient le balisage/texte : - -> -->
-->
<!-- Cette ligne contient le balisage/texte : <!- - Bootstrap default layout to display all articles in foreach - -> -->
<!-- Bootstrap default layout to display all articles in foreach -->
<!-- Cette ligne contient le balisage/texte : <div class="container"> -->
<div class="container">
<!-- Cette ligne contient le balisage/texte : <div class="row"> -->
    <div class="row">
<!-- Cette ligne contient le balisage/texte : <div class="col-md-12"> -->
        <div class="col-md-12">
<!-- Cette ligne contient le balisage/texte : <div class="mb-3"> -->
            <div class="mb-3">
<!-- Cette ligne contient le balisage/texte : <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
<!-- Cette ligne contient le balisage/texte : Retour au panneau admin -->
                    Retour au panneau admin
<!-- Cette ligne contient le balisage/texte : </a> -->
                </a>
<!-- Cette ligne contient le balisage/texte : </div> -->
            </div>
<!-- Cette ligne contient le balisage/texte : <h1>Articles</h1> -->
            <h1>Articles</h1>
<!-- Cette ligne contient le balisage/texte : <?php -->
            <?php
<!-- Cette ligne contient le balisage/texte : $ba_bec_flash_messages = flash_get(); -->
            $ba_bec_flash_messages = flash_get();
<!-- Cette ligne contient le balisage/texte : $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning']; -->
            $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning'];
<!-- Cette ligne contient le balisage/texte : ?> -->
            ?>
<!-- Cette ligne contient le balisage/texte : <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?> -->
            <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?>
<!-- Cette ligne contient le balisage/texte : <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert"> -->
                <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert">
<!-- Cette ligne contient le balisage/texte : <?php echo htmlspecialchars($ba_bec_flash['message']); ?> -->
                    <?php echo htmlspecialchars($ba_bec_flash['message']); ?>
<!-- Cette ligne contient le balisage/texte : </div> -->
                </div>
<!-- Cette ligne contient le balisage/texte : <?php endforeach; ?> -->
            <?php endforeach; ?>
<!-- Cette ligne contient le balisage/texte : <table class="table table-striped"> -->
            <table class="table table-striped">
<!-- Cette ligne contient le balisage/texte : <thead> -->
                <thead>
<!-- Cette ligne contient le balisage/texte : <tr> -->
                    <tr>
<!-- Cette ligne contient le balisage/texte : <th>Id</th> -->
                        <th>Id</th>
<!-- Cette ligne contient le balisage/texte : <th>Date</th> -->
                        <th>Date</th>
<!-- Cette ligne contient le balisage/texte : <th>Titre</th> -->
                        <th>Titre</th>
<!-- Cette ligne contient le balisage/texte : <th>Chapeau</th> -->
                        <th>Chapeau</th>
<!-- Cette ligne contient le balisage/texte : <th>Accroche</th> -->
                        <th>Accroche</th>
<!-- Cette ligne contient le balisage/texte : <th>Mots-clés</th> -->
                        <th>Mots-clés</th>
<!-- Cette ligne contient le balisage/texte : <th>Thématique</th> -->
                        <th>Thématique</th>
<!-- Cette ligne contient le balisage/texte : <th>Actions</th> -->
                        <th>Actions</th>
<!-- Cette ligne contient le balisage/texte : </tr> -->
                    </tr>
<!-- Cette ligne contient le balisage/texte : </thead> -->
                </thead>
<!-- Cette ligne contient le balisage/texte : <tbody> -->
                <tbody>
<!-- Cette ligne contient le balisage/texte : <?php foreach ($ba_bec_articles as $ba_bec_article) { -->
                    <?php foreach ($ba_bec_articles as $ba_bec_article) {
<!-- Cette ligne contient le balisage/texte : ?> -->
                        ?>
<!-- Cette ligne contient le balisage/texte : <tr> -->
                        <tr>
<!-- Cette ligne contient le balisage/texte : <td><?php echo $ba_bec_article['numArt']; ?></td> -->
                            <td><?php echo $ba_bec_article['numArt']; ?></td>
<!-- Cette ligne contient le balisage/texte : <td><?php echo $ba_bec_article['dtCreaArt']; ?></td> -->
                            <td><?php echo $ba_bec_article['dtCreaArt']; ?></td>
<!-- Cette ligne contient le balisage/texte : <td><?php echo $ba_bec_article['libTitrArt']; ?></td> -->
                            <td><?php echo $ba_bec_article['libTitrArt']; ?></td>
<!-- Cette ligne contient le balisage/texte : <td style="max-width: 400px; white-space: wrap; overflow: hidden; text-overflow: ellipsis;"> -->
                            <td style="max-width: 400px; white-space: wrap; overflow: hidden; text-overflow: ellipsis;">
<!-- Cette ligne contient le balisage/texte : <?php echo substr($ba_bec_article['libChapoArt'], 0, 100) . (strlen($ba_bec_article['libChapoArt']) > 100 ? '...' : ''); ?> -->
                                <?php echo substr($ba_bec_article['libChapoArt'], 0, 100) . (strlen($ba_bec_article['libChapoArt']) > 100 ? '...' : ''); ?>
<!-- Cette ligne contient le balisage/texte : </td> -->
                            </td>
<!-- Cette ligne contient le balisage/texte : <td style="max-width: 400px; white-space: wrap; overflow: hidden; text-overflow: ellipsis;"> -->
                            <td style="max-width: 400px; white-space: wrap; overflow: hidden; text-overflow: ellipsis;">
<!-- Cette ligne contient le balisage/texte : <?php echo $ba_bec_article['libAccrochArt']; ?> -->
                                <?php echo $ba_bec_article['libAccrochArt']; ?>
<!-- Cette ligne contient le balisage/texte : </td> -->
                            </td>
<!-- Cette ligne contient le balisage/texte : <td> -->
                            <td>
<!-- Cette ligne contient le balisage/texte : <?php -->
                                <?php
<!-- Cette ligne contient le balisage/texte : foreach ($ba_bec_keywordsart as $ba_bec_keywordart) { -->
                                foreach ($ba_bec_keywordsart as $ba_bec_keywordart) {
<!-- Cette ligne contient le balisage/texte : if ($ba_bec_keywordart['numArt'] == $ba_bec_article['numArt']) { -->
                                    if ($ba_bec_keywordart['numArt'] == $ba_bec_article['numArt']) {
<!-- Cette ligne contient le balisage/texte : foreach ($ba_bec_keywords as $ba_bec_keyword) { -->
                                        foreach ($ba_bec_keywords as $ba_bec_keyword) {
<!-- Cette ligne contient le balisage/texte : if ($ba_bec_keyword['numMotCle'] == $ba_bec_keywordart['numMotCle']) { -->
                                            if ($ba_bec_keyword['numMotCle'] == $ba_bec_keywordart['numMotCle']) {
<!-- Cette ligne contient le balisage/texte : echo $ba_bec_keyword['libMotCle'] . "<br>"; -->
                                                echo $ba_bec_keyword['libMotCle'] . "<br>";
<!-- Cette ligne contient le balisage/texte : } -->
                                            }
<!-- Cette ligne contient le balisage/texte : } -->
                                        }
<!-- Cette ligne contient le balisage/texte : } -->
                                    }
<!-- Cette ligne contient le balisage/texte : } -->
                                }
<!-- Cette ligne contient le balisage/texte : ?> -->
                                ?>
<!-- Cette ligne contient le balisage/texte : </td> -->
                            </td>
<!-- Cette ligne contient le balisage/texte : <td> -->
                            <td>
<!-- Cette ligne contient le balisage/texte : <?php -->
                                <?php
<!-- Cette ligne contient le balisage/texte : foreach ($ba_bec_thematiques as $ba_bec_thematique) { -->
                                foreach ($ba_bec_thematiques as $ba_bec_thematique) {
<!-- Cette ligne contient le balisage/texte : if ($ba_bec_thematique['numThem'] == $ba_bec_article['numThem']) { -->
                                    if ($ba_bec_thematique['numThem'] == $ba_bec_article['numThem']) {
<!-- Cette ligne contient le balisage/texte : echo $ba_bec_thematique['libThem']; -->
                                        echo $ba_bec_thematique['libThem'];
<!-- Cette ligne contient le balisage/texte : break; -->
                                        break;
<!-- Cette ligne contient le balisage/texte : } -->
                                    }
<!-- Cette ligne contient le balisage/texte : } -->
                                }
<!-- Cette ligne contient le balisage/texte : ?> -->
                                ?>
<!-- Cette ligne contient le balisage/texte : </td> -->
                            </td>
<!-- Cette ligne contient le balisage/texte : <td> -->
                            <td>
<!-- Cette ligne contient le balisage/texte : <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=edit&numArt=' . $ba_bec_article['numArt']; ?>" -->
                                <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=edit&numArt=' . $ba_bec_article['numArt']; ?>"
<!-- Cette ligne contient le balisage/texte : class="btn btn-primary">Edit</a> -->
                                    class="btn btn-primary">Edit</a>
<!-- Cette ligne contient le balisage/texte : <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=delete&numArt=' . $ba_bec_article['numArt']; ?>" -->
                                <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=delete&numArt=' . $ba_bec_article['numArt']; ?>"
<!-- Cette ligne contient le balisage/texte : class="btn btn-danger">Delete</a> -->
                                    class="btn btn-danger">Delete</a>
<!-- Cette ligne contient le balisage/texte : </td> -->
                            </td>
<!-- Cette ligne contient le balisage/texte : </tr> -->
                        </tr>
<!-- Cette ligne contient le balisage/texte : <?php } ?> -->
                    <?php } ?>
<!-- Cette ligne contient le balisage/texte : </tbody> -->
                </tbody>
<!-- Cette ligne contient le balisage/texte : </table> -->
            </table>
<!-- Cette ligne contient le balisage/texte : <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=create'; ?>" class="btn btn-success">Create</a> -->
            <a href="<?php echo ROOT_URL . '/public/index.php?controller=article&action=create'; ?>" class="btn btn-success">Create</a>
<!-- Cette ligne contient le balisage/texte : </div> -->
        </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
    </div>
<!-- Cette ligne contient le balisage/texte : </div> -->
</div>
