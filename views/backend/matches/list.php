<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();
$ba_bec_tableCheckStmt = $DB->query("SHOW TABLES LIKE 'bec_matches'");
$ba_bec_hasBecMatchesTable = (bool) $ba_bec_tableCheckStmt->fetchColumn();

$ba_bec_showAll = ($_GET['show'] ?? '') === 'all';
$ba_bec_perPage = (int) ($_GET['per_page'] ?? 10);
$ba_bec_allowedPerPage = [10, 20, 50];
if (!in_array($ba_bec_perPage, $ba_bec_allowedPerPage, true)) {
    $ba_bec_perPage = 10;
}
$ba_bec_page = max(1, (int) ($_GET['page'] ?? 1));
$ba_bec_offset = ($ba_bec_page - 1) * $ba_bec_perPage;

$ba_bec_where = $ba_bec_showAll ? null : '(scoreHome IS NULL OR scoreAway IS NULL)';
$ba_bec_order = 'matchDate ASC, matchTime ASC';
$ba_bec_limit = $ba_bec_offset . ', ' . $ba_bec_perPage;

$ba_bec_select = '*';
$ba_bec_table = 'MATCH_CLUB';
if ($ba_bec_hasBecMatchesTable) {
    $ba_bec_table = 'bec_matches';
    $ba_bec_select = "MatchNo AS numMatch, Competition AS competition, Date AS matchDate, Heure AS matchTime, Equipe_domicile AS teamHome, Equipe_exterieure AS teamAway, Domicile_Exterieur AS location, Phase AS status, Score_domicile AS scoreHome, Score_exterieur AS scoreAway";
    $ba_bec_where = $ba_bec_showAll ? null : '(Score_domicile IS NULL OR Score_exterieur IS NULL)';
    $ba_bec_order = 'Date ASC, Heure ASC';
}

$ba_bec_matches = sql_select($ba_bec_table, $ba_bec_select, $ba_bec_where, null, $ba_bec_order, $ba_bec_limit);
$ba_bec_totalRow = sql_select($ba_bec_table, 'COUNT(*) AS total', $ba_bec_where);
$ba_bec_total = $ba_bec_totalRow[0]['total'] ?? 0;
$ba_bec_hasNextPage = ($ba_bec_offset + $ba_bec_perPage) < $ba_bec_total;

$ba_bec_queryBase = [
    'show' => $ba_bec_showAll ? 'all' : 'pending',
    'per_page' => $ba_bec_perPage,
];
$ba_bec_nextQuery = array_merge($ba_bec_queryBase, ['page' => $ba_bec_page + 1]);

$ba_bec_pendingLabel = $ba_bec_showAll ? 'Tous les matchs' : 'Matchs sans score';
$ba_bec_actionsDisabled = $ba_bec_hasBecMatchesTable;
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $ba_bec_pendingLabel; ?></h1>
            <p>Affichage : <?php echo (int) $ba_bec_total; ?> match(s) au total.</p>
            <div class="mb-3">
                <?php if ($ba_bec_showAll) : ?>
                    <a href="list.php" class="btn btn-secondary">Afficher uniquement les matchs sans score</a>
                <?php else : ?>
                    <a href="list.php?show=all&per_page=<?php echo $ba_bec_perPage; ?>" class="btn btn-secondary">Afficher tous les matchs</a>
                <?php endif; ?>
                <?php if ($ba_bec_actionsDisabled) : ?>
                    <button class="btn btn-success" disabled>Create</button>
                <?php else : ?>
                    <a href="create.php" class="btn btn-success">Create</a>
                <?php endif; ?>
            </div>
            <?php if ($ba_bec_actionsDisabled) : ?>
                <div class="alert alert-info">
                    Les actions de création, modification et suppression sont désactivées pour la table bec_matches.
                </div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Compétition</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Domicile</th>
                        <th>Extérieur</th>
                        <th>Score</th>
                        <th>Lieu</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ba_bec_matches as $ba_bec_match) { ?>
                        <tr>
                            <td><?php echo $ba_bec_match['numMatch']; ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['competition']); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['matchDate']); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['matchTime'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></td>
                            <td>
                                <?php if ($ba_bec_match['scoreHome'] !== null && $ba_bec_match['scoreAway'] !== null) : ?>
                                    <?php echo (int) $ba_bec_match['scoreHome']; ?> - <?php echo (int) $ba_bec_match['scoreAway']; ?>
                                <?php else : ?>
                                    À compléter
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($ba_bec_match['location'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['status'] ?? ''); ?></td>
                            <td>
                                <?php if ($ba_bec_actionsDisabled) : ?>
                                    <button class="btn btn-primary" disabled>Edit</button>
                                    <button class="btn btn-danger" disabled>Delete</button>
                                <?php else : ?>
                                    <a href="edit.php?numMatch=<?php echo $ba_bec_match['numMatch']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?numMatch=<?php echo $ba_bec_match['numMatch']; ?>" class="btn btn-danger">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="mt-3">
                <span class="me-2">Afficher :</span>
                <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 20, 'page' => 1])); ?>" class="btn btn-outline-primary">20 matchs</a>
                <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 50, 'page' => 1])); ?>" class="btn btn-outline-primary">50 matchs</a>
                <?php if ($ba_bec_perPage !== 10) : ?>
                    <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 10, 'page' => 1])); ?>" class="btn btn-outline-secondary">10 matchs</a>
                <?php endif; ?>
            </div>
            <div class="mt-3">
                <?php if ($ba_bec_hasNextPage) : ?>
                    <a href="list.php?<?php echo http_build_query($ba_bec_nextQuery); ?>" class="btn btn-primary">Page suivante</a>
                <?php else : ?>
                    <button class="btn btn-secondary" disabled>Page suivante</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
