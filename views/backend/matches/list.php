<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php';

sql_connect();

$ba_bec_showAll = ($_GET['show'] ?? '') === 'all';
$ba_bec_perPage = (int) ($_GET['per_page'] ?? 10);
$ba_bec_allowedPerPage = [10, 20, 50];
if (!in_array($ba_bec_perPage, $ba_bec_allowedPerPage, true)) {
    $ba_bec_perPage = 10;
}
$ba_bec_page = max(1, (int) ($_GET['page'] ?? 1));
$ba_bec_offset = ($ba_bec_page - 1) * $ba_bec_perPage;

$ba_bec_where = $ba_bec_showAll ? null : '(Score_BEC IS NULL OR Score_Adversaire IS NULL)';
$ba_bec_order = 'Date ASC, Heure ASC';
$ba_bec_limit = $ba_bec_offset . ', ' . $ba_bec_perPage;

$ba_bec_select = "MatchNo AS numMatch, Competition AS competition, Date AS matchDate, Heure AS matchTime, Domicile_Exterieur AS location, Phase AS status, Equipe AS team, Adversaire AS opponent, Score_BEC AS scoreBec, Score_Adversaire AS scoreOpponent";
$ba_bec_table = 'bec_matches';

$ba_bec_matches = sql_select($ba_bec_table, $ba_bec_select, $ba_bec_where, null, $ba_bec_order, $ba_bec_limit);
$ba_bec_matches = array_map(
    static function (array $match): array {
        $location = strtolower(trim((string) ($match['location'] ?? '')));
        $isAway = str_contains($location, 'extérieur') || str_contains($location, 'exterieur');
        $team = (string) ($match['team'] ?? '');
        $opponent = (string) ($match['opponent'] ?? '');

        $teamHome = $isAway ? $opponent : $team;
        $teamAway = $isAway ? $team : $opponent;
        $scoreHome = $match['scoreBec'];
        $scoreAway = $match['scoreOpponent'];
        if ($isAway) {
            $scoreHome = $match['scoreOpponent'];
            $scoreAway = $match['scoreBec'];
        }

        return array_merge(
            $match,
            [
                'teamHome' => $teamHome,
                'teamAway' => $teamAway,
                'scoreHome' => $scoreHome,
                'scoreAway' => $scoreAway,
            ]
        );
    },
    $ba_bec_matches
);
$ba_bec_totalRow = sql_select($ba_bec_table, 'COUNT(*) AS total', $ba_bec_where);
$ba_bec_total = $ba_bec_totalRow[0]['total'] ?? 0;
$ba_bec_hasNextPage = ($ba_bec_offset + $ba_bec_perPage) < $ba_bec_total;

$ba_bec_queryBase = [
    'show' => $ba_bec_showAll ? 'all' : 'pending',
    'per_page' => $ba_bec_perPage,
];
$ba_bec_nextQuery = array_merge($ba_bec_queryBase, ['page' => $ba_bec_page + 1]);

$ba_bec_pendingLabel = $ba_bec_showAll ? 'Tous les matchs' : 'Matchs sans score';
$ba_bec_formatTime = static function ($time): string {
    if (empty($time)) {
        return '';
    }
    $timestamp = strtotime($time);
    if ($timestamp === false) {
        return (string) $time;
    }
    return date('H:i', $timestamp);
};
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary">
                    Retour au panneau admin
                </a>
            </div>
            <h1><?php echo $ba_bec_pendingLabel; ?></h1>
            <p>Affichage : <?php echo (int) $ba_bec_total; ?> match(s) au total.</p>
            <div class="mb-3">
                <?php if ($ba_bec_showAll) : ?>
                    <a href="list.php" class="btn btn-secondary">Afficher uniquement les matchs sans score</a>
                <?php else : ?>
                    <a href="list.php?show=all&per_page=<?php echo $ba_bec_perPage; ?>" class="btn btn-secondary">Afficher tous les matchs</a>
                <?php endif; ?>
                <a href="create.php" class="btn btn-success">Create</a>
            </div>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ba_bec_matches as $ba_bec_match) { ?>
                        <tr>
                            <td><?php echo $ba_bec_match['numMatch']; ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['competition']); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['matchDate']); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_formatTime($ba_bec_match['matchTime'] ?? '')); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></td>
                            <td>
                                <?php if ($ba_bec_match['scoreHome'] !== null && $ba_bec_match['scoreAway'] !== null) : ?>
                                    <?php echo (int) $ba_bec_match['scoreHome']; ?> - <?php echo (int) $ba_bec_match['scoreAway']; ?>
                                <?php else : ?>
                                    À compléter
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?numMatch=<?php echo $ba_bec_match['numMatch']; ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?numMatch=<?php echo $ba_bec_match['numMatch']; ?>" class="btn btn-danger">Delete</a>
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
