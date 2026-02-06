<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';

sql_connect();

$teams = [];
$coachesByTeam = [];
try {
    $teamsStmt = $DB->prepare(
        'SELECT e.numEquipe, e.codeEquipe, e.nomEquipe, e.categorie, e.section, e.niveau
         FROM EQUIPE e
         ORDER BY e.nomEquipe ASC'
    );
    $teamsStmt->execute();
    $teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);

    $coachesStmt = $DB->prepare(
        'SELECT p.numEquipeStaff AS codeEquipe, p.prenomPersonnel, p.nomPersonnel, p.roleStaffEquipe AS libRolePersonnel
         FROM PERSONNEL p
         WHERE p.estStaffEquipe = 1 AND p.numEquipeStaff IS NOT NULL'
    );
    $coachesStmt->execute();
    $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $teams = [];
    $coaches = [];
}

foreach ($coaches ?? [] as $coach) {
    $coachesByTeam[$coach['codeEquipe']][] = $coach;
}
?>

<section class="club-page">
    <header class="club-header">
        <h1>Équipes du club</h1>
        <p>
            Explorez les différentes équipes du BEC, leurs joueurs et les coachs qui les accompagnent.
        </p>
    </header>

    <?php if (empty($teams)) : ?>
        <p>Aucune équipe n'est encore enregistrée.</p>
    <?php else : ?>
        <div class="club-stack">
            <?php foreach ($teams as $team) : ?>
                <?php
                $teamName = $team['nomEquipe'] ?? '';
                ?>
                <article class="team-card">
                    <div class="team-card-header">
                        <h2 class="team-card-title"><?php echo htmlspecialchars($teamName); ?></h2>
                        <p class="team-card-meta">
                            <?php echo htmlspecialchars($team['categorie']); ?> · <?php echo htmlspecialchars($team['section']); ?> · <?php echo htmlspecialchars($team['niveau']); ?>
                        </p>
                    </div>
                    <div class="team-card-body">
                        <?php $teamCoaches = $coachesByTeam[$team['codeEquipe']] ?? []; ?>
                        <?php if (!empty($teamCoaches)) : ?>
                            <p class="team-card-subtitle">Encadrement</p>
                            <ul class="team-card-list">
                                <?php foreach ($teamCoaches as $coach) : ?>
                                    <li>
                                        <?php echo htmlspecialchars($coach['prenomPersonnel'] . ' ' . $coach['nomPersonnel']); ?>
                                        <?php if (!empty($coach['libRolePersonnel'])) : ?>
                                            <span class="team-role">(<?php echo htmlspecialchars($coach['libRolePersonnel']); ?>)</span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="team-card-subtitle">Encadrement</p>
                            <p>Aucun responsable renseigné.</p>
                        <?php endif; ?>
                    </div>
                    <a class="team-link" href="<?php echo ROOT_URL . '/Pages_supplementaires/equipe.php?numEquipe=' . urlencode((string) $team['numEquipe']); ?>">
                        Voir l'équipe
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
