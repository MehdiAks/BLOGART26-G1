<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];

function render_missing_table_page(PDOException $exception): void
{
    $errorInfo = $exception->errorInfo ?? [];
    $isMissingTable = $exception->getCode() === '42S02'
        || (isset($errorInfo[1]) && (int) $errorInfo[1] === 1146);

    if ($isMissingTable) {
        http_response_code(404);
        require_once 'erreur404.php';
        exit;
    }
}

$dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');

if ($dbAvailable) {
    try {
        sql_connect();

        $teamsStmt = $DB->prepare(
            'SELECT numEquipe, libEquipe, categorieEquipe, sectionEquipe, niveauEquipe,
                    pointsMarquesDomicile, pointsEncaissesDomicile, pointsMarquesExterieur, pointsEncaissesExterieur
                    FROM EQUIPE
                    ORDER BY libEquipe ASC'
        );
        $teamsStmt->execute();
        $teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);

        $playersStmt = $DB->prepare(
            'SELECT ej.numEquipe, j.prenomJoueur, j.nomJoueur, j.posteJoueur
                    FROM EQUIPE_JOUEUR ej
                    INNER JOIN JOUEUR j ON ej.numJoueur = j.numJoueur
                    ORDER BY j.nomJoueur ASC'
        );
        $playersStmt->execute();
        $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);

        $coachesStmt = $DB->prepare(
            'SELECT ep.numEquipe, p.prenomPersonnel, p.nomPersonnel, ep.libRoleEquipe
                    FROM EQUIPE_PERSONNEL ep
                    INNER JOIN PERSONNEL p ON ep.numPersonnel = p.numPersonnel
                    ORDER BY p.nomPersonnel ASC'
        );
        $coachesStmt->execute();
        $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        render_missing_table_page($exception);
        throw $exception;
    }
} else {
    $teams = [];
    $players = [];
    $coaches = [];
}

$playersByTeam = [];
foreach ($players as $player) {
    $playersByTeam[$player['numEquipe']][] = $player;
}

$coachesByTeam = [];
foreach ($coaches as $coach) {
    $coachesByTeam[$coach['numEquipe']][] = $coach;
}
?>

<?php require_once 'header.php'; ?>

<section class="club-page">
    <header class="club-header">
        <h1>Équipes du club</h1>
        <p class="lead">
            Explorez les différentes équipes du BEC, leurs joueurs et les coachs qui les accompagnent.
        </p>
    </header>

    <?php if (empty($teams)) : ?>
        <div class="empty-state">
            <p>Aucune équipe n'est encore configurée. Les informations seront ajoutées prochainement.</p>
        </div>
    <?php else : ?>
        <div class="club-stack">
            <?php foreach ($teams as $team) : ?>
                <article class="team-card">
                    <div class="team-card-header">
                        <h2><?php echo htmlspecialchars($team['libEquipe']); ?></h2>
                        <p class="team-meta">
                            <?php echo htmlspecialchars($team['categorieEquipe'] ?: 'Catégorie non renseignée'); ?> ·
                            <?php echo htmlspecialchars($team['sectionEquipe'] ?: 'Section non renseignée'); ?> ·
                            <?php echo htmlspecialchars($team['niveauEquipe'] ?: 'Niveau non renseigné'); ?>
                        </p>
                        <a class="team-link" href="<?php echo ROOT_URL . '/equipe.php?numEquipe=' . urlencode((string) $team['numEquipe']); ?>">
                            Voir la page de l'équipe
                        </a>
                    </div>

                    <div class="team-card-body">
                        <div>
                            <h3>Coachs</h3>
                            <?php $teamCoaches = $coachesByTeam[$team['numEquipe']] ?? []; ?>
                            <?php if (empty($teamCoaches)) : ?>
                                <p class="text-muted">Aucun coach renseigné.</p>
                            <?php else : ?>
                                <ul class="team-list">
                                    <?php foreach ($teamCoaches as $coach) : ?>
                                        <li>
                                            <?php echo htmlspecialchars($coach['prenomPersonnel'] . ' ' . $coach['nomPersonnel']); ?>
                                            <?php if (!empty($coach['libRoleEquipe'])) : ?>
                                                <span class="team-role">(<?php echo htmlspecialchars($coach['libRoleEquipe']); ?>)</span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3>Joueurs</h3>
                            <?php $teamPlayers = $playersByTeam[$team['numEquipe']] ?? []; ?>
                            <?php if (empty($teamPlayers)) : ?>
                                <p class="text-muted">Aucun joueur renseigné.</p>
                            <?php else : ?>
                                <ul class="team-list">
                                    <?php foreach ($teamPlayers as $player) : ?>
                                        <li>
                                            <?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>
                                            <?php if (!empty($player['posteJoueur'])) : ?>
                                                <span class="team-role">(<?php echo htmlspecialchars($player['posteJoueur']); ?>)</span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3>Statistiques</h3>
                            <ul class="team-list">
                                <li>
                                    Points marqués à domicile :
                                    <?php echo htmlspecialchars((string) ($team['pointsMarquesDomicile'] ?? 0)); ?>
                                </li>
                                <li>
                                    Points encaissés à domicile :
                                    <?php echo htmlspecialchars((string) ($team['pointsEncaissesDomicile'] ?? 0)); ?>
                                </li>
                                <li>
                                    Points marqués à l'extérieur :
                                    <?php echo htmlspecialchars((string) ($team['pointsMarquesExterieur'] ?? 0)); ?>
                                </li>
                                <li>
                                    Points encaissés à l'extérieur :
                                    <?php echo htmlspecialchars((string) ($team['pointsEncaissesExterieur'] ?? 0)); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php
require_once 'footer.php';
?>
