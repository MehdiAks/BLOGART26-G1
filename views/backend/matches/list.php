<?php // Cette ligne contient: <?php
/* // Cette ligne contient: /*
 * Vue d'administration (liste) pour le module matches. // Cette ligne contient: * Vue d'administration (liste) pour le module matches.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées. // Cette ligne contient: * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base. // Cette ligne contient: * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression. // Cette ligne contient: * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow. // Cette ligne contient: * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections. // Cette ligne contient: * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections.
 */ // Cette ligne contient: */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
include '../../../header.php'; // Cette ligne contient: include '../../../header.php';

sql_connect(); // Cette ligne contient: sql_connect();

$ba_bec_showAll = ($_GET['show'] ?? '') === 'all'; // Cette ligne contient: $ba_bec_showAll = ($_GET['show'] ?? '') === 'all';
$ba_bec_perPage = (int) ($_GET['per_page'] ?? 10); // Cette ligne contient: $ba_bec_perPage = (int) ($_GET['per_page'] ?? 10);
$ba_bec_allowedPerPage = [10, 20, 50]; // Cette ligne contient: $ba_bec_allowedPerPage = [10, 20, 50];
if (!in_array($ba_bec_perPage, $ba_bec_allowedPerPage, true)) { // Cette ligne contient: if (!in_array($ba_bec_perPage, $ba_bec_allowedPerPage, true)) {
    $ba_bec_perPage = 10; // Cette ligne contient: $ba_bec_perPage = 10;
} // Cette ligne contient: }
$ba_bec_page = max(1, (int) ($_GET['page'] ?? 1)); // Cette ligne contient: $ba_bec_page = max(1, (int) ($_GET['page'] ?? 1));
$ba_bec_offset = ($ba_bec_page - 1) * $ba_bec_perPage; // Cette ligne contient: $ba_bec_offset = ($ba_bec_page - 1) * $ba_bec_perPage;

$ba_bec_whereClause = $ba_bec_showAll ? '' : 'WHERE (m.scoreBec IS NULL OR m.scoreAdversaire IS NULL)'; // Cette ligne contient: $ba_bec_whereClause = $ba_bec_showAll ? '' : 'WHERE (m.scoreBec IS NULL OR m.scoreAdversaire IS NULL)';
$ba_bec_order = 'ORDER BY m.dateMatch ASC, m.heureMatch ASC'; // Cette ligne contient: $ba_bec_order = 'ORDER BY m.dateMatch ASC, m.heureMatch ASC';
$ba_bec_limit = 'LIMIT ' . $ba_bec_offset . ', ' . $ba_bec_perPage; // Cette ligne contient: $ba_bec_limit = 'LIMIT ' . $ba_bec_offset . ', ' . $ba_bec_perPage;

$ba_bec_select = "SELECT // Cette ligne contient: $ba_bec_select = "SELECT
        m.numMatch AS numMatch, // Cette ligne contient: m.numMatch AS numMatch,
        m.saison AS saison, // Cette ligne contient: m.saison AS saison,
        m.phase AS phase, // Cette ligne contient: m.phase AS phase,
        m.journee AS journee, // Cette ligne contient: m.journee AS journee,
        m.dateMatch AS matchDate, // Cette ligne contient: m.dateMatch AS matchDate,
        m.heureMatch AS matchTime, // Cette ligne contient: m.heureMatch AS matchTime,
        m.lieuMatch AS location, // Cette ligne contient: m.lieuMatch AS location,
        m.scoreBec AS scoreBec, // Cette ligne contient: m.scoreBec AS scoreBec,
        m.scoreAdversaire AS scoreAdversaire, // Cette ligne contient: m.scoreAdversaire AS scoreAdversaire,
        m.clubAdversaire AS clubAdversaire, // Cette ligne contient: m.clubAdversaire AS clubAdversaire,
        m.numEquipeAdverse AS numEquipeAdverse, // Cette ligne contient: m.numEquipeAdverse AS numEquipeAdverse,
        e.nomEquipe AS teamName // Cette ligne contient: e.nomEquipe AS teamName
    FROM `MATCH` m // Cette ligne contient: FROM `MATCH` m
    INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe // Cette ligne contient: INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
    {$ba_bec_whereClause} // Cette ligne contient: {$ba_bec_whereClause}
    {$ba_bec_order} // Cette ligne contient: {$ba_bec_order}
    {$ba_bec_limit}"; // Cette ligne contient: {$ba_bec_limit}";

$ba_bec_matches = []; // Cette ligne contient: $ba_bec_matches = [];
try { // Cette ligne contient: try {
    $ba_bec_matches = $DB->query($ba_bec_select)->fetchAll(PDO::FETCH_ASSOC); // Cette ligne contient: $ba_bec_matches = $DB->query($ba_bec_select)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) { // Cette ligne contient: } catch (PDOException $exception) {
    $ba_bec_matches = []; // Cette ligne contient: $ba_bec_matches = [];
} // Cette ligne contient: }

$ba_bec_totalQuery = "SELECT COUNT(*) AS total FROM `MATCH` m {$ba_bec_whereClause}"; // Cette ligne contient: $ba_bec_totalQuery = "SELECT COUNT(*) AS total FROM `MATCH` m {$ba_bec_whereClause}";
$ba_bec_totalRow = $DB->query($ba_bec_totalQuery)->fetch(PDO::FETCH_ASSOC); // Cette ligne contient: $ba_bec_totalRow = $DB->query($ba_bec_totalQuery)->fetch(PDO::FETCH_ASSOC);
$ba_bec_total = $ba_bec_totalRow['total'] ?? 0; // Cette ligne contient: $ba_bec_total = $ba_bec_totalRow['total'] ?? 0;
$ba_bec_hasNextPage = ($ba_bec_offset + $ba_bec_perPage) < $ba_bec_total; // Cette ligne contient: $ba_bec_hasNextPage = ($ba_bec_offset + $ba_bec_perPage) < $ba_bec_total;

$ba_bec_queryBase = [ // Cette ligne contient: $ba_bec_queryBase = [
    'show' => $ba_bec_showAll ? 'all' : 'pending', // Cette ligne contient: 'show' => $ba_bec_showAll ? 'all' : 'pending',
    'per_page' => $ba_bec_perPage, // Cette ligne contient: 'per_page' => $ba_bec_perPage,
]; // Cette ligne contient: ];
$ba_bec_nextQuery = array_merge($ba_bec_queryBase, ['page' => $ba_bec_page + 1]); // Cette ligne contient: $ba_bec_nextQuery = array_merge($ba_bec_queryBase, ['page' => $ba_bec_page + 1]);

$ba_bec_pendingLabel = $ba_bec_showAll ? 'Tous les matchs' : 'Matchs sans score'; // Cette ligne contient: $ba_bec_pendingLabel = $ba_bec_showAll ? 'Tous les matchs' : 'Matchs sans score';
$ba_bec_formatTime = static function ($time): string { // Cette ligne contient: $ba_bec_formatTime = static function ($time): string {
    if (empty($time)) { // Cette ligne contient: if (empty($time)) {
        return ''; // Cette ligne contient: return '';
    } // Cette ligne contient: }
    $timestamp = strtotime($time); // Cette ligne contient: $timestamp = strtotime($time);
    if ($timestamp === false) { // Cette ligne contient: if ($timestamp === false) {
        return (string) $time; // Cette ligne contient: return (string) $time;
    } // Cette ligne contient: }
    return date('H:i', $timestamp); // Cette ligne contient: return date('H:i', $timestamp);
}; // Cette ligne contient: };

$ba_bec_resolveSide = static function (?string $location): string { // Cette ligne contient: $ba_bec_resolveSide = static function (?string $location): string {
    $location = strtolower(trim((string) $location)); // Cette ligne contient: $location = strtolower(trim((string) $location));
    if ($location === '') { // Cette ligne contient: if ($location === '') {
        return 'home'; // Cette ligne contient: return 'home';
    } // Cette ligne contient: }
    if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) { // Cette ligne contient: if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
        return 'away'; // Cette ligne contient: return 'away';
    } // Cette ligne contient: }
    if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) { // Cette ligne contient: if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
        return 'home'; // Cette ligne contient: return 'home';
    } // Cette ligne contient: }
    return 'home'; // Cette ligne contient: return 'home';
}; // Cette ligne contient: };

$ba_bec_buildOpponent = static function (array $match): string { // Cette ligne contient: $ba_bec_buildOpponent = static function (array $match): string {
    $opponent = trim((string) ($match['clubAdversaire'] ?? '')); // Cette ligne contient: $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
    if (!empty($match['numEquipeAdverse'])) { // Cette ligne contient: if (!empty($match['numEquipeAdverse'])) {
        $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']); // Cette ligne contient: $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
    } // Cette ligne contient: }
    return $opponent !== '' ? $opponent : 'Adversaire'; // Cette ligne contient: return $opponent !== '' ? $opponent : 'Adversaire';
}; // Cette ligne contient: };
/* Cette ligne contient: ?> */ ?>

<div class="container"> <!-- Cette ligne contient: <div class="container"> -->
    <div class="row"> <!-- Cette ligne contient: <div class="row"> -->
        <div class="col-md-12"> <!-- Cette ligne contient: <div class="col-md-12"> -->
            <div class="mb-3"> <!-- Cette ligne contient: <div class="mb-3"> -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; /* Cette ligne contient: <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> */ ?>" class="btn btn-secondary">
                    Retour au panneau admin <!-- Cette ligne contient: Retour au panneau admin -->
                </a> <!-- Cette ligne contient: </a> -->
            </div> <!-- Cette ligne contient: </div> -->
            <h1><?php echo $ba_bec_pendingLabel; /* Cette ligne contient: <h1><?php echo $ba_bec_pendingLabel; ?></h1> */ ?></h1>
            <p>Affichage : <?php echo (int) $ba_bec_total; /* Cette ligne contient: <p>Affichage : <?php echo (int) $ba_bec_total; ?> match(s) au total.</p> */ ?> match(s) au total.</p>
            <div class="mb-3"> <!-- Cette ligne contient: <div class="mb-3"> -->
                <?php if ($ba_bec_showAll) : /* Cette ligne contient: <?php if ($ba_bec_showAll) : ?> */ ?>
                    <a href="list.php" class="btn btn-secondary">Afficher uniquement les matchs sans score</a> <!-- Cette ligne contient: <a href="list.php" class="btn btn-secondary">Afficher uniquement les matchs sans score</a> -->
                <?php else : /* Cette ligne contient: <?php else : ?> */ ?>
                    <a href="list.php?show=all&per_page=<?php echo $ba_bec_perPage; /* Cette ligne contient: <a href="list.php?show=all&per_page=<?php echo $ba_bec_perPage; ?>" class="btn btn-secondary">Afficher tous les matchs</a> */ ?>" class="btn btn-secondary">Afficher tous les matchs</a>
                <?php endif; /* Cette ligne contient: <?php endif; ?> */ ?>
                <a href="create.php" class="btn btn-success">Create</a> <!-- Cette ligne contient: <a href="create.php" class="btn btn-success">Create</a> -->
            </div> <!-- Cette ligne contient: </div> -->
            <table class="table table-striped"> <!-- Cette ligne contient: <table class="table table-striped"> -->
                <thead> <!-- Cette ligne contient: <thead> -->
                    <tr> <!-- Cette ligne contient: <tr> -->
                        <th>ID</th> <!-- Cette ligne contient: <th>ID</th> -->
                        <th>Saison</th> <!-- Cette ligne contient: <th>Saison</th> -->
                        <th>Phase</th> <!-- Cette ligne contient: <th>Phase</th> -->
                        <th>Date</th> <!-- Cette ligne contient: <th>Date</th> -->
                        <th>Heure</th> <!-- Cette ligne contient: <th>Heure</th> -->
                        <th>Domicile</th> <!-- Cette ligne contient: <th>Domicile</th> -->
                        <th>Extérieur</th> <!-- Cette ligne contient: <th>Extérieur</th> -->
                        <th>Score</th> <!-- Cette ligne contient: <th>Score</th> -->
                        <th>Actions</th> <!-- Cette ligne contient: <th>Actions</th> -->
                    </tr> <!-- Cette ligne contient: </tr> -->
                </thead> <!-- Cette ligne contient: </thead> -->
                <tbody> <!-- Cette ligne contient: <tbody> -->
                    <?php foreach ($ba_bec_matches as $ba_bec_match) { /* Cette ligne contient: <?php foreach ($ba_bec_matches as $ba_bec_match) { ?> */ ?>
                        <?php // Cette ligne contient: <?php
                        $side = $ba_bec_resolveSide($ba_bec_match['location'] ?? ''); // Cette ligne contient: $side = $ba_bec_resolveSide($ba_bec_match['location'] ?? '');
                        $opponent = $ba_bec_buildOpponent($ba_bec_match); // Cette ligne contient: $opponent = $ba_bec_buildOpponent($ba_bec_match);
                        $isHome = $side !== 'away'; // Cette ligne contient: $isHome = $side !== 'away';
                        $teamHome = $isHome ? ($ba_bec_match['teamName'] ?? 'BEC') : $opponent; // Cette ligne contient: $teamHome = $isHome ? ($ba_bec_match['teamName'] ?? 'BEC') : $opponent;
                        $teamAway = $isHome ? $opponent : ($ba_bec_match['teamName'] ?? 'BEC'); // Cette ligne contient: $teamAway = $isHome ? $opponent : ($ba_bec_match['teamName'] ?? 'BEC');
                        $scoreHome = $isHome ? ($ba_bec_match['scoreBec'] ?? null) : ($ba_bec_match['scoreAdversaire'] ?? null); // Cette ligne contient: $scoreHome = $isHome ? ($ba_bec_match['scoreBec'] ?? null) : ($ba_bec_match['scoreAdversaire'] ?? null);
                        $scoreAway = $isHome ? ($ba_bec_match['scoreAdversaire'] ?? null) : ($ba_bec_match['scoreBec'] ?? null); // Cette ligne contient: $scoreAway = $isHome ? ($ba_bec_match['scoreAdversaire'] ?? null) : ($ba_bec_match['scoreBec'] ?? null);
                        /* Cette ligne contient: ?> */ ?>
                        <tr> <!-- Cette ligne contient: <tr> -->
                            <td><?php echo $ba_bec_match['numMatch']; /* Cette ligne contient: <td><?php echo $ba_bec_match['numMatch']; ?></td> */ ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['saison'] ?? ''); /* Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_match['saison'] ?? ''); ?></td> */ ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['phase'] ?? ''); /* Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_match['phase'] ?? ''); ?></td> */ ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_match['matchDate'] ?? ''); /* Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_match['matchDate'] ?? ''); ?></td> */ ?></td>
                            <td><?php echo htmlspecialchars($ba_bec_formatTime($ba_bec_match['matchTime'] ?? '')); /* Cette ligne contient: <td><?php echo htmlspecialchars($ba_bec_formatTime($ba_bec_match['matchTime'] ?? '')); ?></td> */ ?></td>
                            <td><?php echo htmlspecialchars($teamHome); /* Cette ligne contient: <td><?php echo htmlspecialchars($teamHome); ?></td> */ ?></td>
                            <td><?php echo htmlspecialchars($teamAway); /* Cette ligne contient: <td><?php echo htmlspecialchars($teamAway); ?></td> */ ?></td>
                            <td> <!-- Cette ligne contient: <td> -->
                                <?php if ($scoreHome !== null && $scoreAway !== null) : /* Cette ligne contient: <?php if ($scoreHome !== null && $scoreAway !== null) : ?> */ ?>
                                    <?php echo (int) $scoreHome; /* Cette ligne contient: <?php echo (int) $scoreHome; ?> - <?php echo (int) $scoreAway; ?> */ ?> - <?php echo (int) $scoreAway; /* Cette ligne contient: <?php echo (int) $scoreHome; ?> - <?php echo (int) $scoreAway; ?> */ ?>
                                <?php else : /* Cette ligne contient: <?php else : ?> */ ?>
                                    À compléter <!-- Cette ligne contient: À compléter -->
                                <?php endif; /* Cette ligne contient: <?php endif; ?> */ ?>
                            </td> <!-- Cette ligne contient: </td> -->
                            <td> <!-- Cette ligne contient: <td> -->
                                <a href="edit.php?numMatch=<?php echo $ba_bec_match['numMatch']; /* Cette ligne contient: <a href="edit.php?numMatch=<?php echo $ba_bec_match['numMatch']; ?>" class="btn btn-primary">Edit</a> */ ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?numMatch=<?php echo $ba_bec_match['numMatch']; /* Cette ligne contient: <a href="delete.php?numMatch=<?php echo $ba_bec_match['numMatch']; ?>" class="btn btn-danger">Delete</a> */ ?>" class="btn btn-danger">Delete</a>
                            </td> <!-- Cette ligne contient: </td> -->
                        </tr> <!-- Cette ligne contient: </tr> -->
                    <?php } /* Cette ligne contient: <?php } ?> */ ?>
                </tbody> <!-- Cette ligne contient: </tbody> -->
            </table> <!-- Cette ligne contient: </table> -->
            <div class="mt-3"> <!-- Cette ligne contient: <div class="mt-3"> -->
                <span class="me-2">Afficher :</span> <!-- Cette ligne contient: <span class="me-2">Afficher :</span> -->
                <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 20, 'page' => 1])); /* Cette ligne contient: <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 20, 'page' => 1])); ?>" class="btn btn-outline-primary">20 matchs</a> */ ?>" class="btn btn-outline-primary">20 matchs</a>
                <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 50, 'page' => 1])); /* Cette ligne contient: <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 50, 'page' => 1])); ?>" class="btn btn-outline-primary">50 matchs</a> */ ?>" class="btn btn-outline-primary">50 matchs</a>
                <?php if ($ba_bec_perPage !== 10) : /* Cette ligne contient: <?php if ($ba_bec_perPage !== 10) : ?> */ ?>
                    <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 10, 'page' => 1])); /* Cette ligne contient: <a href="list.php?<?php echo http_build_query(array_merge($ba_bec_queryBase, ['per_page' => 10, 'page' => 1])); ?>" class="btn btn-outline-secondary">10 matchs</a> */ ?>" class="btn btn-outline-secondary">10 matchs</a>
                <?php endif; /* Cette ligne contient: <?php endif; ?> */ ?>
            </div> <!-- Cette ligne contient: </div> -->
            <div class="mt-3"> <!-- Cette ligne contient: <div class="mt-3"> -->
                <?php if ($ba_bec_hasNextPage) : /* Cette ligne contient: <?php if ($ba_bec_hasNextPage) : ?> */ ?>
                    <a href="list.php?<?php echo http_build_query($ba_bec_nextQuery); /* Cette ligne contient: <a href="list.php?<?php echo http_build_query($ba_bec_nextQuery); ?>" class="btn btn-primary">Page suivante</a> */ ?>" class="btn btn-primary">Page suivante</a>
                <?php else : /* Cette ligne contient: <?php else : ?> */ ?>
                    <button class="btn btn-secondary" disabled>Page suivante</button> <!-- Cette ligne contient: <button class="btn btn-secondary" disabled>Page suivante</button> -->
                <?php endif; /* Cette ligne contient: <?php endif; ?> */ ?>
            </div> <!-- Cette ligne contient: </div> -->
        </div> <!-- Cette ligne contient: </div> -->
    </div> <!-- Cette ligne contient: </div> -->
</div> <!-- Cette ligne contient: </div> -->
