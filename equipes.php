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
            'SELECT numEquipe, libEquipe, libEquipeComplet, categorieEquipe, sectionEquipe, niveauEquipe, photoEquipe
                    FROM EQUIPE
                    ORDER BY libEquipe ASC'
        );
        $teamsStmt->execute();
        $teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);

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
    $coaches = [];
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
                <?php
                $teamName = $team['libEquipeComplet'] ?: $team['libEquipe'];
                $photoEquipe = $team['photoEquipe'] ?? '';
                $photoEquipeUrl = '';
                if (!empty($photoEquipe)) {
                    $photoEquipeUrl = preg_match('/^(https?:\\/\\/|\\/)/', $photoEquipe)
                        ? $photoEquipe
                        : ROOT_URL . '/src/images/photos-equipe/' . $photoEquipe;
                }
                ?>
                <article class="team-card">
                    <div class="team-card-content">
                        <div class="team-card-info">
                            <h2><?php echo htmlspecialchars($teamName); ?></h2>
                            <div>
                                <h3>Staff</h3>
                                <?php $teamCoaches = $coachesByTeam[$team['numEquipe']] ?? []; ?>
                                <?php if (empty($teamCoaches)) : ?>
                                    <p class="text-muted">Aucun membre du staff renseigné.</p>
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
                            <a class="team-link" href="<?php echo ROOT_URL . '/equipe.php?numEquipe=' . urlencode((string) $team['numEquipe']); ?>">
                                Voir la page de l'équipe
                            </a>
                        </div>
                        <div class="team-card-photo" <?php echo $photoEquipeUrl ? 'style="background-image: url(' . htmlspecialchars($photoEquipeUrl) . ');"' : ''; ?>>
                            <?php if (!$photoEquipeUrl) : ?>
                                <span class="team-photo-placeholder">Photo d'équipe à venir</span>
                            <?php endif; ?>
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
