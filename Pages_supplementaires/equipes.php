<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/club-structure.css'];
$pageTitle = 'Équipes';
$pageDescription = 'Les équipes du Bordeaux Étudiant Club Basket, leurs catégories et leur encadrement.';

require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';

function ba_bec_team_photo_url(?string $photoPath, ?string $nomEquipe, ?string $codeEquipe, string $suffix): string
{
    if (!empty($photoPath)) {
        $uploadedUrl = uploaded_file_url($photoPath);
        if ($uploadedUrl !== '') {
            return $uploadedUrl;
        }
    }

    $slug = strtolower((string) iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string) ($nomEquipe ?: $codeEquipe)));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) $slug, '-');
    if ($slug === '') {
        return '';
    }

    foreach (['jpg', 'jpeg', 'png', 'avif', 'webp'] as $ext) {
        $uploadedUrl = uploaded_file_url('photos-equipes/' . $slug . '-' . $suffix . '.' . $ext);
        if ($uploadedUrl !== '') {
            return $uploadedUrl;
        }
    }

    return '';
}

sql_connect();

$teams = [];
$coachesByTeam = [];
$defaultTeamImage = ROOT_URL . '/src/images/image-defaut.jpeg';
try {
    $teamsStmt = $DB->prepare(
        'SELECT e.numEquipe, e.codeEquipe, e.nomEquipe, e.categorie, e.section, e.niveau, e.photoDLequipe
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
                $teamPhotoUrl = ba_bec_team_photo_url($team['photoDLequipe'] ?? null, $team['nomEquipe'] ?? null, $team['codeEquipe'] ?? null, 'photo-equipe') ?: $defaultTeamImage;
                ?>
                <a class="team-card" href="<?php echo ROOT_URL . '/Pages_supplementaires/equipe.php?numEquipe=' . urlencode((string) $team['numEquipe']); ?>">
                    <div class="team-card-content">
                        <div class="team-card-info">
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
                            <span class="team-link">Voir l'équipe</span>
                        </div>
                        <div class="team-card-photo" role="img"
                            aria-label="Photo de l'équipe <?php echo htmlspecialchars($teamName); ?>"
                            style="background-image: url('<?php echo htmlspecialchars($teamPhotoUrl); ?>');">
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
