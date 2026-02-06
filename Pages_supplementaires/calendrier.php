<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [
    ROOT_URL . '/src/css/matches.css',
];

require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';

sql_connect();

$becMatchesAvailable = true;

$matchesQuery = "SELECT
        m.numMatch AS numMatch,
        m.dateMatch AS matchDate,
        m.heureMatch AS matchTime,
        m.lieuMatch AS location,
        m.scoreBec AS scoreBec,
        m.scoreAdversaire AS scoreAdversaire,
        m.clubAdversaire AS clubAdversaire,
        m.numEquipeAdverse AS numEquipeAdverse,
        e.nomEquipe AS teamName
    FROM `MATCH` m
    INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
    WHERE m.dateMatch BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
    ORDER BY m.dateMatch ASC, m.heureMatch ASC";
$lastUpdateQuery = "SELECT MAX(dateMatch) AS lastUpdate FROM `MATCH`";

$allMatches = [];
try {
    $matchesStmt = $DB->prepare($matchesQuery);
    $matchesStmt->execute();
    $allMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $becMatchesAvailable = false;
}

$resolveMatchSide = static function (string $location): string {
    $location = strtolower(trim($location));
    if ($location === '') {
        return 'home';
    }
    if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
        return 'away';
    }
    if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
        return 'home';
    }
    return 'home';
};

$buildOpponent = static function (array $match): string {
    $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
    if (!empty($match['numEquipeAdverse'])) {
        $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
    }
    return $opponent !== '' ? $opponent : 'Adversaire';
};

$homeMatches = [];
$awayMatches = [];
foreach ($allMatches as $ba_bec_match) {
    $side = $resolveMatchSide((string) ($ba_bec_match['location'] ?? ''));
    $opponent = $buildOpponent($ba_bec_match);
    $isHome = $side !== 'away';
    $ba_bec_match['teamHome'] = $isHome ? ($ba_bec_match['teamName'] ?? 'BEC') : $opponent;
    $ba_bec_match['teamAway'] = $isHome ? $opponent : ($ba_bec_match['teamName'] ?? 'BEC');
    $ba_bec_match['scoreHome'] = $isHome ? ($ba_bec_match['scoreBec'] ?? null) : ($ba_bec_match['scoreAdversaire'] ?? null);
    $ba_bec_match['scoreAway'] = $isHome ? ($ba_bec_match['scoreAdversaire'] ?? null) : ($ba_bec_match['scoreBec'] ?? null);
    if ($side === 'away') {
        $awayMatches[] = $ba_bec_match;
    } else {
        $homeMatches[] = $ba_bec_match;
    }
}

$lastUpdate = null;
if ($becMatchesAvailable) {
    try {
        $lastUpdateStmt = $DB->query($lastUpdateQuery);
        $lastUpdateRow = $lastUpdateStmt->fetch(PDO::FETCH_ASSOC);
        $lastUpdate = $lastUpdateRow['lastUpdate'] ?? null;
    } catch (PDOException $exception) {
        $becMatchesAvailable = false;
    }
}

$renderMatchCard = static function (array $ba_bec_match): string {
    $matchDate = new DateTime($ba_bec_match['matchDate']);
    $displayDate = $matchDate->format('d/m/Y');
    $displayTime = '';
    if (!empty($ba_bec_match['matchTime'])) {
        $matchTime = new DateTime($ba_bec_match['matchTime']);
        $displayTime = $matchTime->format('H:i');
    }
    $score = '';
    if ($ba_bec_match['scoreHome'] !== null && $ba_bec_match['scoreAway'] !== null) {
        $score = (int) $ba_bec_match['scoreHome'] . ' - ' . (int) $ba_bec_match['scoreAway'];
    }

    ob_start();
    ?>
    <div class="col-12">
        <article class="match-card">
            <header class="match-card__header">
                <div>
                    <p class="match-card__competition"><?php echo htmlspecialchars($ba_bec_match['teamName'] ?? 'Match'); ?></p>
                    <p class="match-card__date">
                        <?php echo htmlspecialchars($displayDate); ?>
                        <?php if ($displayTime !== ''): ?>
                            <span>• <?php echo htmlspecialchars($displayTime); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </header>
            <div class="wrapper">
                <div class="match-card__team">
                    <span>Domicile</span>
                    <strong><?php echo htmlspecialchars($ba_bec_match['teamHome']); ?></strong>
                </div>
                <div class="match-card__score">
                    <?php echo $score !== '' ? htmlspecialchars($score) : 'vs'; ?>
                </div>
                <div class="match-card__team">
                    <span>Extérieur</span>
                    <strong><?php echo htmlspecialchars($ba_bec_match['teamAway']); ?></strong>
                </div>
            </div>
            <?php if (!empty($ba_bec_match['location'])): ?>
                <p class="match-card__location">Lieu : <?php echo htmlspecialchars($ba_bec_match['location']); ?></p>
            <?php endif; ?>
        </article>
    </div>
    <?php

    return (string) ob_get_clean();
};
?>

<main class="container py-5">
    <section class="matches-hero">
        <p class="matches-hero__eyebrow">Calendrier</p>
        <h1 class="matches-hero__title">Les prochains matchs des équipes seniors</h1>
        <p class="matches-hero__text">
            Retrouvez ici le prochain match de chaque équipe senior du club, affiché selon la date du jour.
        </p>
        <div class="matches-hero__meta">
            <?php if ($becMatchesAvailable && !empty($lastUpdate)): ?>
                <span class="matches-hero__update">Dernière mise à jour : <?php echo htmlspecialchars($lastUpdate); ?></span>
            <?php endif; ?>
        </div>
    </section>

    <section class="matches-list" aria-live="polite">
        <?php if (!$becMatchesAvailable): ?>
            <div class="alert alert-light border matches-empty" role="status">
                Le calendrier n'est pas disponible pour le moment.
            </div>
        <?php elseif (!empty($homeMatches) || !empty($awayMatches)): ?>
            <?php if (!empty($homeMatches)): ?>
                <div class="mb-5">
                    <h2 class="matches-list__title">Matchs à domicile</h2>
                    <div class="row g-4">
                        <?php foreach ($homeMatches as $ba_bec_match): ?>
                            <?php echo $renderMatchCard($ba_bec_match); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($awayMatches)): ?>
                <div>
                    <h2 class="matches-list__title">Matchs à l'extérieur</h2>
                    <div class="row g-4">
                        <?php foreach ($awayMatches as $ba_bec_match): ?>
                            <?php echo $renderMatchCard($ba_bec_match); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-light border matches-empty" role="status">
                Aucun match n'est disponible pour le moment.
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
