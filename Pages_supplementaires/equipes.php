<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];

require_once 'header.php';

sql_connect();

$ba_bec_currentSeasonId = null;
$currentSeasonStmt = $DB->query('SELECT numSaison FROM SAISON WHERE estCourante = 1 ORDER BY dateDebut DESC LIMIT 1');
if ($currentSeasonStmt) {
    $ba_bec_currentSeasonId = $currentSeasonStmt->fetchColumn();
}

$teams = [];
$coachesByTeam = [];
try {
    $teamsStmt = $DB->prepare(
        'SELECT e.numEquipe, e.libEquipe, e.libEquipeComplet,
                c.libCategorie, s.libSection, n.libNiveau
         FROM EQUIPE e
         INNER JOIN CATEGORIE_EQUIPE c ON e.numCategorie = c.numCategorie
         INNER JOIN SECTION_EQUIPE s ON e.numSection = s.numSection
         INNER JOIN NIVEAU_EQUIPE n ON e.numNiveau = n.numNiveau
         ORDER BY e.libEquipe ASC'
    );
    $teamsStmt->execute();
    $teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);

    $coachesStmt = $DB->prepare(
        'SELECT p.numEquipeStaff AS numEquipe, p.prenomPersonnel, p.nomPersonnel, p.roleStaffEquipe AS libRolePersonnel
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
    $coachesByTeam[$coach['numEquipe']][] = $coach;
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
                $teamName = $team['libEquipeComplet'] ?: $team['libEquipe'];
                ?>
                <article class="team-card">
                    <div class="team-card-header">
                        <h2 class="team-card-title"><?php echo htmlspecialchars($teamName); ?></h2>
                        <p class="team-card-meta">
                            <?php echo htmlspecialchars($team['libCategorie']); ?> · <?php echo htmlspecialchars($team['libSection']); ?> · <?php echo htmlspecialchars($team['libNiveau']); ?>
                        </p>
                    </div>
                    <div class="team-card-body">
                        <?php $teamCoaches = $coachesByTeam[$team['numEquipe']] ?? []; ?>
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

<?php require_once 'footer.php'; ?>
