<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$pageStyles = [ROOT_URL . '/src/css/team-detail.css'];

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

$teamId = filter_input(INPUT_GET, 'numEquipe', FILTER_VALIDATE_INT);
if (!$teamId) {
    http_response_code(404);
    require_once 'erreur404.php';
    exit;
}

$dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');
$team = null;
$players = [];
$coaches = [];

if ($dbAvailable) {
    try {
        sql_connect();

        $teamStmt = $DB->prepare(
            'SELECT numEquipe, libEquipe, categorieEquipe, sectionEquipe, niveauEquipe,
                    pointsMarquesDomicile, pointsEncaissesDomicile, pointsMarquesExterieur, pointsEncaissesExterieur
             FROM EQUIPE
             WHERE numEquipe = :teamId'
        );
        $teamStmt->execute(['teamId' => $teamId]);
        $team = $teamStmt->fetch(PDO::FETCH_ASSOC) ?: null;

        if (!$team) {
            http_response_code(404);
            require_once 'erreur404.php';
            exit;
        }

        $playersStmt = $DB->prepare(
            'SELECT j.prenomJoueur, j.nomJoueur, j.posteJoueur
             FROM EQUIPE_JOUEUR ej
             INNER JOIN JOUEUR j ON ej.numJoueur = j.numJoueur
             WHERE ej.numEquipe = :teamId
             ORDER BY j.nomJoueur ASC'
        );
        $playersStmt->execute(['teamId' => $teamId]);
        $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);

        $coachesStmt = $DB->prepare(
            'SELECT p.prenomPersonnel, p.nomPersonnel, ep.libRoleEquipe
             FROM EQUIPE_PERSONNEL ep
             INNER JOIN PERSONNEL p ON ep.numPersonnel = p.numPersonnel
             WHERE ep.numEquipe = :teamId
             ORDER BY p.nomPersonnel ASC'
        );
        $coachesStmt->execute(['teamId' => $teamId]);
        $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        render_missing_table_page($exception);
        throw $exception;
    }
} else {
    $team = [
        'numEquipe' => $teamId,
        'libEquipe' => 'Équipe du BEC',
        'categorieEquipe' => 'Seniors',
        'sectionEquipe' => 'Championnat régional',
        'niveauEquipe' => 'Niveau 1',
        'pointsMarquesDomicile' => 320,
        'pointsEncaissesDomicile' => 280,
        'pointsMarquesExterieur' => 295,
        'pointsEncaissesExterieur' => 310,
    ];
    $players = [
        ['prenomJoueur' => 'Léo', 'nomJoueur' => 'Martin', 'posteJoueur' => 'Meneur'],
        ['prenomJoueur' => 'Amélie', 'nomJoueur' => 'Durand', 'posteJoueur' => 'Ailière'],
        ['prenomJoueur' => 'Hugo', 'nomJoueur' => 'Bernard', 'posteJoueur' => 'Pivot'],
        ['prenomJoueur' => 'Sara', 'nomJoueur' => 'Lopez', 'posteJoueur' => 'Arrière'],
    ];
    $coaches = [
        ['prenomPersonnel' => 'Camille', 'nomPersonnel' => 'Roche', 'libRoleEquipe' => 'Coach'],
        ['prenomPersonnel' => 'Paul', 'nomPersonnel' => 'Girard', 'libRoleEquipe' => 'Assistant'],
    ];
}

$bannerImage = ROOT_URL . '/src/images/background/background-index-4.webp';
$becLogo = ROOT_URL . '/src/images/logo/logo-bec/logo.png';

$matches = [
    [
        'opponent' => 'US Talence',
        'logo' => ROOT_URL . '/src/images/logo/logo-adversaire/US_TALENCE.avif',
        'date' => 'Samedi 12 octobre · 20h30',
        'location' => 'Gymnase BEC',
        'home' => true,
    ],
    [
        'opponent' => 'Union Saint-Bruno',
        'logo' => ROOT_URL . '/src/images/logo/logo-adversaire/UNION_SAINT_BRUNO_BORDEAUX.avif',
        'date' => 'Samedi 19 octobre · 18h00',
        'location' => 'Extérieur',
        'home' => false,
    ],
    [
        'opponent' => 'JSA Bordeaux',
        'logo' => ROOT_URL . '/src/images/logo/logo-adversaire/JSA_BORDEAUX_BASKET.avif',
        'date' => 'Samedi 26 octobre · 17h30',
        'location' => 'Gymnase BEC',
        'home' => true,
    ],
    [
        'opponent' => 'Cenon Rive Droite',
        'logo' => ROOT_URL . '/src/images/logo/logo-adversaire/US_CENON_RIVE_DROITE.avif',
        'date' => 'Samedi 2 novembre · 20h00',
        'location' => 'Extérieur',
        'home' => false,
    ],
    [
        'opponent' => 'Union Sportive Brédoise',
        'logo' => ROOT_URL . '/src/images/logo/logo-adversaire/UNION_SPORTIVE_BREDOISE_BASKET.avif',
        'date' => 'Samedi 9 novembre · 19h15',
        'location' => 'Gymnase BEC',
        'home' => true,
    ],
];

$nextMatch = $matches[0];
$upcomingMatches = array_slice($matches, 1, 4);

$coachLead = null;
$assistantCoaches = [];
$otherCoaches = [];

foreach ($coaches as $coach) {
    $role = strtolower($coach['libRoleEquipe'] ?? '');
    if (strpos($role, 'assistant') !== false) {
        $assistantCoaches[] = $coach;
        continue;
    }

    if (!$coachLead) {
        $coachLead = $coach;
        continue;
    }

    $otherCoaches[] = $coach;
}

if (!$coachLead && !empty($assistantCoaches)) {
    $coachLead = array_shift($assistantCoaches);
}
?>

<?php require_once 'header.php'; ?>

<section class="team-detail">
    <header class="team-detail-header">
        <div class="team-detail-banner" style="background-image: url('<?php echo htmlspecialchars($bannerImage); ?>');">
            <div class="team-detail-banner-content">
                <p class="team-detail-category">
                    <?php echo htmlspecialchars($team['categorieEquipe'] ?: 'Catégorie non renseignée'); ?>
                </p>
                <h1><?php echo htmlspecialchars($team['libEquipe']); ?></h1>
                <p class="team-detail-meta">
                    <?php echo htmlspecialchars($team['sectionEquipe'] ?: 'Section non renseignée'); ?> ·
                    <?php echo htmlspecialchars($team['niveauEquipe'] ?: 'Niveau non renseigné'); ?>
                </p>
            </div>
        </div>
    </header>

    <section class="team-detail-section">
        <h2>Statistiques de l'équipe</h2>
        <div class="team-stats-grid">
            <article class="team-stat-card">
                <span>Points marqués à domicile</span>
                <strong><?php echo htmlspecialchars((string) ($team['pointsMarquesDomicile'] ?? 0)); ?></strong>
            </article>
            <article class="team-stat-card">
                <span>Points encaissés à domicile</span>
                <strong><?php echo htmlspecialchars((string) ($team['pointsEncaissesDomicile'] ?? 0)); ?></strong>
            </article>
            <article class="team-stat-card">
                <span>Points marqués à l'extérieur</span>
                <strong><?php echo htmlspecialchars((string) ($team['pointsMarquesExterieur'] ?? 0)); ?></strong>
            </article>
            <article class="team-stat-card">
                <span>Points encaissés à l'extérieur</span>
                <strong><?php echo htmlspecialchars((string) ($team['pointsEncaissesExterieur'] ?? 0)); ?></strong>
            </article>
        </div>
    </section>

    <section class="team-detail-section">
        <h2>Prochain match</h2>
        <article class="match-highlight">
            <div class="match-clubs">
                <div class="match-team">
                    <img src="<?php echo htmlspecialchars($becLogo); ?>" alt="BEC" loading="lazy">
                    <span>BEC</span>
                </div>
                <span class="match-versus">VS</span>
                <div class="match-team">
                    <img src="<?php echo htmlspecialchars($nextMatch['logo']); ?>" alt="<?php echo htmlspecialchars($nextMatch['opponent']); ?>" loading="lazy">
                    <span><?php echo htmlspecialchars($nextMatch['opponent']); ?></span>
                </div>
            </div>
            <div class="match-details">
                <p><?php echo htmlspecialchars($nextMatch['date']); ?></p>
                <p class="text-muted"><?php echo htmlspecialchars($nextMatch['location']); ?></p>
            </div>
        </article>

        <div class="match-upcoming">
            <?php foreach ($upcomingMatches as $match) : ?>
                <article class="match-card">
                    <div class="match-card-logos">
                        <img src="<?php echo htmlspecialchars($becLogo); ?>" alt="BEC" loading="lazy">
                        <span>vs</span>
                        <img src="<?php echo htmlspecialchars($match['logo']); ?>" alt="<?php echo htmlspecialchars($match['opponent']); ?>" loading="lazy">
                    </div>
                    <p class="match-card-opponent"><?php echo htmlspecialchars($match['opponent']); ?></p>
                    <p class="match-card-date"><?php echo htmlspecialchars($match['date']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="team-detail-section">
        <h2>Staff technique</h2>
        <div class="staff-grid">
            <article class="staff-card">
                <h3>Coach principal</h3>
                <?php if ($coachLead) : ?>
                    <p><?php echo htmlspecialchars($coachLead['prenomPersonnel'] . ' ' . $coachLead['nomPersonnel']); ?></p>
                    <?php if (!empty($coachLead['libRoleEquipe'])) : ?>
                        <p class="text-muted"><?php echo htmlspecialchars($coachLead['libRoleEquipe']); ?></p>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="text-muted">Aucun coach renseigné.</p>
                <?php endif; ?>
            </article>
            <article class="staff-card">
                <h3>Assistant</h3>
                <?php if (!empty($assistantCoaches)) : ?>
                    <ul>
                        <?php foreach ($assistantCoaches as $assistant) : ?>
                            <li><?php echo htmlspecialchars($assistant['prenomPersonnel'] . ' ' . $assistant['nomPersonnel']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-muted">Aucun assistant renseigné.</p>
                <?php endif; ?>
            </article>
        </div>
        <?php if (!empty($otherCoaches)) : ?>
            <div class="staff-extra">
                <h3>Encadrement supplémentaire</h3>
                <ul>
                    <?php foreach ($otherCoaches as $coach) : ?>
                        <li>
                            <?php echo htmlspecialchars($coach['prenomPersonnel'] . ' ' . $coach['nomPersonnel']); ?>
                            <?php if (!empty($coach['libRoleEquipe'])) : ?>
                                <span class="text-muted">(<?php echo htmlspecialchars($coach['libRoleEquipe']); ?>)</span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>

    <section class="team-detail-section">
        <h2>Joueurs</h2>
        <?php if (empty($players)) : ?>
            <p class="text-muted">Aucun joueur renseigné.</p>
        <?php else : ?>
            <div class="players-grid">
                <?php foreach ($players as $player) : ?>
                    <article class="player-card">
                        <h3><?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?></h3>
                        <?php if (!empty($player['posteJoueur'])) : ?>
                            <p class="text-muted"><?php echo htmlspecialchars($player['posteJoueur']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</section>

<?php
require_once 'footer.php';
?>
