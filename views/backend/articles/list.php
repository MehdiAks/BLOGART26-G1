<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php'; // contains the header and call to config.php

//Load all articles
$ba_bec_articles = sql_select("ARTICLE", "*");
$ba_bec_keywords = sql_select("MOTCLE", "*");
$ba_bec_keywordsart = sql_select("MOTCLEARTICLE", "*");
$ba_bec_thematiques = sql_select("THEMATIQUE", "*");
?>

<!-- Bootstrap default layout to display all articles in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1>Articles</h1>
            <?php
            $ba_bec_flash_messages = flash_get();
            $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning'];
            ?>
            <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?>
                <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert">
                    <?php echo htmlspecialchars($ba_bec_flash['message']); ?>
                </div>
            <?php endforeach; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Titre</th>
                        <th>Chapeau</th>
                        <th>Accroche</th>
                        <th>Mots-clés</th>
                        <th>Thématique</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ba_bec_articles as $ba_bec_article) {
                        $ba_bec_numArt = $ba_bec_article['numArt']; // QUEL ARTICLE NUM EST-IL QUESTION?
                        $ba_bec_listMot = sql_select('ARTICLE
                        INNER JOIN MOTCLEARTICLE ON article.numArt = motclearticle.numArt
                        INNER JOIN motcle ON motclearticle.numMotCle = motcle.numMotCle', 'article.numArt, libMotCle', "article.numArt = '$ba_bec_numArt'");
                        ?>
                        <tr>
                            <td><?php echo $ba_bec_article['numArt']; ?></td>
                            <td><?php echo $ba_bec_article['dtCreaArt']; ?></td>
                            <td><?php echo $ba_bec_article['libTitrArt']; ?></td>
                            <td style="max-width: 400px; white-space: wrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo substr($ba_bec_article['libChapoArt'], 0, 100) . (strlen($ba_bec_article['libChapoArt']) > 100 ? '...' : ''); ?>
                            </td>
                            <td style="max-width: 400px; white-space: wrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo $ba_bec_article['libAccrochArt']; ?>
                            </td>
                            <td>
                                <?php
                                foreach ($ba_bec_keywordsart as $ba_bec_keywordart) {
                                    if ($ba_bec_keywordart['numArt'] == $ba_bec_article['numArt']) {
                                        foreach ($ba_bec_keywords as $ba_bec_keyword) {
                                            if ($ba_bec_keyword['numMotCle'] == $ba_bec_keywordart['numMotCle']) {
                                                echo $ba_bec_keyword['libMotCle'] . "<br>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($ba_bec_thematiques as $ba_bec_thematique) {
                                    if ($ba_bec_thematique['numThem'] == $ba_bec_article['numThem']) {
                                        echo $ba_bec_thematique['libThem'];
                                        break;
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <a href="edit.php?numArt=<?php echo ($ba_bec_article['numArt']); ?>"
                                    class="btn btn-primary">Edit</a>
                                <a href="delete.php?numArt=<?php echo ($ba_bec_article['numArt']); ?>"
                                    class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
