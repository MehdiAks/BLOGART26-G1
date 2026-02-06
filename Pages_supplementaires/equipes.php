<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
// Ligne vide pour aération.

// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
// Ligne vide pour aération.

// Cette ligne contient: function ba_bec_team_photo_url(?string $path): string
function ba_bec_team_photo_url(?string $path): string
// Cette ligne contient: {
{
// Cette ligne contient: if (!$path) {
    if (!$path) {
// Cette ligne contient: return '';
        return '';
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: if (preg_match('/^(https?:\/\/|\/)/', $path)) {
    if (preg_match('/^(https?:\/\/|\/)/', $path)) {
// Cette ligne contient: return $path;
        return $path;
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: if (strpos($path, 'photos-equipes/') === 0) {
    if (strpos($path, 'photos-equipes/') === 0) {
// Cette ligne contient: return ROOT_URL . '/src/uploads/' . ltrim($path, '/');
        return ROOT_URL . '/src/uploads/' . ltrim($path, '/');
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: return ROOT_URL . '/src/uploads/photos-equipes/' . ltrim($path, '/');
    return ROOT_URL . '/src/uploads/photos-equipes/' . ltrim($path, '/');
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: sql_connect();
sql_connect();
// Ligne vide pour aération.

// Cette ligne contient: $teams = [];
$teams = [];
// Cette ligne contient: $coachesByTeam = [];
$coachesByTeam = [];
// Cette ligne contient: $defaultTeamImage = ROOT_URL . '/src/images/image-defaut.jpeg';
$defaultTeamImage = ROOT_URL . '/src/images/image-defaut.jpeg';
// Cette ligne contient: try {
try {
// Cette ligne contient: $teamsStmt = $DB->prepare(
    $teamsStmt = $DB->prepare(
// Cette ligne contient: 'SELECT e.numEquipe, e.codeEquipe, e.nomEquipe, e.categorie, e.section, e.niveau, e.photoDLequipe
        'SELECT e.numEquipe, e.codeEquipe, e.nomEquipe, e.categorie, e.section, e.niveau, e.photoDLequipe
// Cette ligne contient: FROM EQUIPE e
         FROM EQUIPE e
// Cette ligne contient: ORDER BY e.nomEquipe ASC'
         ORDER BY e.nomEquipe ASC'
// Cette ligne contient: );
    );
// Cette ligne contient: $teamsStmt->execute();
    $teamsStmt->execute();
// Cette ligne contient: $teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);
    $teams = $teamsStmt->fetchAll(PDO::FETCH_ASSOC);
// Ligne vide pour aération.

// Cette ligne contient: $coachesStmt = $DB->prepare(
    $coachesStmt = $DB->prepare(
// Cette ligne contient: 'SELECT p.numEquipeStaff AS codeEquipe, p.prenomPersonnel, p.nomPersonnel, p.roleStaffEquipe AS libRolePersonnel
        'SELECT p.numEquipeStaff AS codeEquipe, p.prenomPersonnel, p.nomPersonnel, p.roleStaffEquipe AS libRolePersonnel
// Cette ligne contient: FROM PERSONNEL p
         FROM PERSONNEL p
// Cette ligne contient: WHERE p.estStaffEquipe = 1 AND p.numEquipeStaff IS NOT NULL'
         WHERE p.estStaffEquipe = 1 AND p.numEquipeStaff IS NOT NULL'
// Cette ligne contient: );
    );
// Cette ligne contient: $coachesStmt->execute();
    $coachesStmt->execute();
// Cette ligne contient: $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
    $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
// Cette ligne contient: } catch (PDOException $exception) {
} catch (PDOException $exception) {
// Cette ligne contient: $teams = [];
    $teams = [];
// Cette ligne contient: $coaches = [];
    $coaches = [];
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: foreach ($coaches ?? [] as $coach) {
foreach ($coaches ?? [] as $coach) {
// Cette ligne contient: $coachesByTeam[$coach['codeEquipe']][] = $coach;
    $coachesByTeam[$coach['codeEquipe']][] = $coach;
// Cette ligne contient: }
}
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="club-page"> -->
<section class="club-page">
<!-- Cette ligne contient: <header class="club-header"> -->
    <header class="club-header">
<!-- Cette ligne contient: <h1>Équipes du club</h1> -->
        <h1>Équipes du club</h1>
<!-- Cette ligne contient: <p> -->
        <p>
<!-- Cette ligne contient: Explorez les différentes équipes du BEC, leurs joueurs et les coachs qui les accompagnent. -->
            Explorez les différentes équipes du BEC, leurs joueurs et les coachs qui les accompagnent.
<!-- Cette ligne contient: </p> -->
        </p>
<!-- Cette ligne contient: </header> -->
    </header>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php if (empty($teams)) : ?> -->
    <?php if (empty($teams)) : ?>
<!-- Cette ligne contient: <p>Aucune équipe n'est encore enregistrée.</p> -->
        <p>Aucune équipe n'est encore enregistrée.</p>
<!-- Cette ligne contient: <?php else : ?> -->
    <?php else : ?>
<!-- Cette ligne contient: <div class="club-stack"> -->
        <div class="club-stack">
<!-- Cette ligne contient: <?php foreach ($teams as $team) : ?> -->
            <?php foreach ($teams as $team) : ?>
<!-- Cette ligne contient: <?php -->
                <?php
// Cette ligne contient: $teamName = $team['nomEquipe'] ?? '';
                $teamName = $team['nomEquipe'] ?? '';
// Cette ligne contient: $teamPhotoUrl = ba_bec_team_photo_url($team['photoDLequipe'] ?? '') ?: $defaultTeamImage;
                $teamPhotoUrl = ba_bec_team_photo_url($team['photoDLequipe'] ?? '') ?: $defaultTeamImage;
// Cette ligne contient: ?>
                ?>
<!-- Cette ligne contient: <article class="team-card"> -->
                <article class="team-card">
<!-- Cette ligne contient: <div class="team-card-content"> -->
                    <div class="team-card-content">
<!-- Cette ligne contient: <div class="team-card-info"> -->
                        <div class="team-card-info">
<!-- Cette ligne contient: <div class="team-card-header"> -->
                            <div class="team-card-header">
<!-- Cette ligne contient: <h2 class="team-card-title"><?php echo htmlspecialchars($teamName); ?></h2> -->
                                <h2 class="team-card-title"><?php echo htmlspecialchars($teamName); ?></h2>
<!-- Cette ligne contient: <p class="team-card-meta"> -->
                                <p class="team-card-meta">
<!-- Cette ligne contient: <?php echo htmlspecialchars($team['categorie']); ?> · <?php echo htmlspecialchars($team['section']); ?> · <?php echo htmlspecialchars($team['niveau']); ?> -->
                                    <?php echo htmlspecialchars($team['categorie']); ?> · <?php echo htmlspecialchars($team['section']); ?> · <?php echo htmlspecialchars($team['niveau']); ?>
<!-- Cette ligne contient: </p> -->
                                </p>
<!-- Cette ligne contient: </div> -->
                            </div>
<!-- Cette ligne contient: <div class="team-card-body"> -->
                            <div class="team-card-body">
<!-- Cette ligne contient: <?php $teamCoaches = $coachesByTeam[$team['codeEquipe']] ?? []; ?> -->
                                <?php $teamCoaches = $coachesByTeam[$team['codeEquipe']] ?? []; ?>
<!-- Cette ligne contient: <?php if (!empty($teamCoaches)) : ?> -->
                                <?php if (!empty($teamCoaches)) : ?>
<!-- Cette ligne contient: <p class="team-card-subtitle">Encadrement</p> -->
                                    <p class="team-card-subtitle">Encadrement</p>
<!-- Cette ligne contient: <ul class="team-card-list"> -->
                                    <ul class="team-card-list">
<!-- Cette ligne contient: <?php foreach ($teamCoaches as $coach) : ?> -->
                                        <?php foreach ($teamCoaches as $coach) : ?>
<!-- Cette ligne contient: <li> -->
                                            <li>
<!-- Cette ligne contient: <?php echo htmlspecialchars($coach['prenomPersonnel'] . ' ' . $coach['nomPersonnel']); ?> -->
                                                <?php echo htmlspecialchars($coach['prenomPersonnel'] . ' ' . $coach['nomPersonnel']); ?>
<!-- Cette ligne contient: <?php if (!empty($coach['libRolePersonnel'])) : ?> -->
                                                <?php if (!empty($coach['libRolePersonnel'])) : ?>
<!-- Cette ligne contient: <span class="team-role">(<?php echo htmlspecialchars($coach['libRolePersonnel']); ?>)</span> -->
                                                    <span class="team-role">(<?php echo htmlspecialchars($coach['libRolePersonnel']); ?>)</span>
<!-- Cette ligne contient: <?php endif; ?> -->
                                                <?php endif; ?>
<!-- Cette ligne contient: </li> -->
                                            </li>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                                        <?php endforeach; ?>
<!-- Cette ligne contient: </ul> -->
                                    </ul>
<!-- Cette ligne contient: <?php else : ?> -->
                                <?php else : ?>
<!-- Cette ligne contient: <p class="team-card-subtitle">Encadrement</p> -->
                                    <p class="team-card-subtitle">Encadrement</p>
<!-- Cette ligne contient: <p>Aucun responsable renseigné.</p> -->
                                    <p>Aucun responsable renseigné.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
                                <?php endif; ?>
<!-- Cette ligne contient: </div> -->
                            </div>
<!-- Cette ligne contient: <a class="team-link" href="<?php echo ROOT_URL . '/Pages_supplementaires/equipe.php?numEquipe=' . urlencode((string) $team['numEquipe']); ?>"> -->
                            <a class="team-link" href="<?php echo ROOT_URL . '/Pages_supplementaires/equipe.php?numEquipe=' . urlencode((string) $team['numEquipe']); ?>">
<!-- Cette ligne contient: Voir l'équipe -->
                                Voir l'équipe
<!-- Cette ligne contient: </a> -->
                            </a>
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: <div class="team-card-photo" role="img" -->
                        <div class="team-card-photo" role="img"
<!-- Cette ligne contient: aria-label="Photo de l'équipe <?php echo htmlspecialchars($teamName); ?>" -->
                            aria-label="Photo de l'équipe <?php echo htmlspecialchars($teamName); ?>"
<!-- Cette ligne contient: style="background-image: url('<?php echo htmlspecialchars($teamPhotoUrl); ?>');"> -->
                            style="background-image: url('<?php echo htmlspecialchars($teamPhotoUrl); ?>');">
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </article> -->
                </article>
<!-- Cette ligne contient: <?php endforeach; ?> -->
            <?php endforeach; ?>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: <?php endif; ?> -->
    <?php endif; ?>
<!-- Cette ligne contient: </section> -->
</section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
