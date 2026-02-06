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

function ba_bec_team_photo_url(?string $path): string
{
    if (!$path) {
        return '';
    }

    if (preg_match('/^(https?:\/\/|\/)/', $path)) {
        return $path;
    }

    if (strpos($path, 'photos-equipes/') === 0) {
        return ROOT_URL . '/src/uploads/' . ltrim($path, '/');
    }

    return ROOT_URL . '/src/uploads/photos-equipes/' . ltrim($path, '/');
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
$teamMatches = [];
$currentSeasonId = null;

if ($dbAvailable) {
    try {
        sql_connect();

        $currentSeasonStmt = $DB->query('SELECT numSaison FROM SAISON WHERE estCourante = 1 ORDER BY dateDebut DESC LIMIT 1');
        $currentSeasonId = $currentSeasonStmt ? $currentSeasonStmt->fetchColumn() : null;

        $teamStmt = $DB->prepare(
            'SELECT e.numEquipe, e.libEquipe, e.libEquipeComplet, e.descriptionEquipe, e.urlPhotoEquipe, e.urlPhotoStaff,
                    c.libCategorie, s.libSection, n.libNiveau
             FROM EQUIPE e
             INNER JOIN CATEGORIE_EQUIPE c ON e.numCategorie = c.numCategorie
             INNER JOIN SECTION_EQUIPE s ON e.numSection = s.numSection
             INNER JOIN NIVEAU_EQUIPE n ON e.numNiveau = n.numNiveau
             WHERE e.numEquipe = :teamId'
        );
        $teamStmt->execute(['teamId' => $teamId]);
        $team = $teamStmt->fetch(PDO::FETCH_ASSOC) ?: null;

        if (!$team) {
            http_response_code(404);
            require_once 'erreur404.php';
            exit;
        }

        $playersStmt = $DB->prepare(
            'SELECT j.prenomJoueur, j.nomJoueur, p.libPoste, j.urlPhotoJoueur
             FROM JOUEUR_AFFECTATION ja
             INNER JOIN JOUEUR j ON ja.numJoueur = j.numJoueur
             LEFT JOIN POSTE p ON ja.numPoste = p.numPoste
             WHERE ja.numEquipe = :teamId' . ($currentSeasonId ? ' AND ja.numSaison = :numSaison' : '') .
            ' ORDER BY j.nomJoueur ASC'
        );
        $params = ['teamId' => $teamId];
        if ($currentSeasonId) {
            $params['numSaison'] = $currentSeasonId;
        }
        $playersStmt->execute($params);
        $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);

        $coachesStmt = $DB->prepare(
            'SELECT p.prenomPersonnel, p.nomPersonnel, rp.libRolePersonnel
             FROM AFFECTATION_PERSONNEL_EQUIPE ape
             INNER JOIN PERSONNEL p ON ape.numPersonnel = p.numPersonnel
             INNER JOIN ROLE_PERSONNEL rp ON ape.numRolePersonnel = rp.numRolePersonnel
             WHERE ape.numEquipe = :teamId' . ($currentSeasonId ? ' AND ape.numSaison = :numSaison' : '') .
            ' ORDER BY p.nomPersonnel ASC'
        );
        $coachParams = ['teamId' => $teamId];
        if ($currentSeasonId) {
            $coachParams['numSaison'] = $currentSeasonId;
        }
        $coachesStmt->execute($coachParams);
        $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);

        $matchesStmt = $DB->prepare(
            'SELECT m.dateMatch, m.heureMatch, m.lieuMatch,
                    home_part.score AS scoreHome,
                    away_part.score AS scoreAway,
                    COALESCE(home_team.libEquipe, home_part.nomEquipeAdverse) AS teamHome,
                    COALESCE(away_team.libEquipe, away_part.nomEquipeAdverse) AS teamAway,
                    home_part.numEquipe AS homeEquipe,
                    away_part.numEquipe AS awayEquipe
             FROM `MATCH` m
             LEFT JOIN MATCH_PARTICIPANT home_part ON m.numMatch = home_part.numMatch AND home_part.cote = "domicile"
             LEFT JOIN MATCH_PARTICIPANT away_part ON m.numMatch = away_part.numMatch AND away_part.cote = "exterieur"
             LEFT JOIN EQUIPE home_team ON home_part.numEquipe = home_team.numEquipe
             LEFT JOIN EQUIPE away_team ON away_part.numEquipe = away_team.numEquipe
             WHERE home_part.numEquipe = :teamId OR away_part.numEquipe = :teamId
             ORDER BY m.dateMatch DESC, m.heureMatch DESC'
        );
        $matchesStmt->execute(['teamId' => $teamId]);
        $teamMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        render_missing_table_page($exception);
        throw $exception;
    }
} else {
    $team = [
        'numEquipe' => $teamId,
        'libEquipe' => 'Équipe du BEC',
        'libEquipeComplet' => 'Seniors filles - National 3',
        'libCategorie' => 'Seniors',
        'libSection' => 'Championnat régional',
        'libNiveau' => 'Niveau 1',
        'descriptionEquipe' => 'Une équipe engagée et soudée qui défend fièrement les couleurs du BEC tout au long de la saison.',
        'urlPhotoEquipe' => '',
        'urlPhotoStaff' => '',
    ];
    $players = [
        ['prenomJoueur' => 'Léo', 'nomJoueur' => 'Martin', 'libPoste' => 'Meneur'],
        ['prenomJoueur' => 'Amélie', 'nomJoueur' => 'Durand', 'libPoste' => 'Ailière'],
        ['prenomJoueur' => 'Hugo', 'nomJoueur' => 'Bernard', 'libPoste' => 'Pivot'],
        ['prenomJoueur' => 'Sara', 'nomJoueur' => 'Lopez', 'libPoste' => 'Arrière'],
    ];
    $coaches = [
        ['prenomPersonnel' => 'Camille', 'nomPersonnel' => 'Roche', 'libRolePersonnel' => 'Coach'],
        ['prenomPersonnel' => 'Paul', 'nomPersonnel' => 'Girard', 'libRolePersonnel' => 'Assistant'],
    ];
    $teamMatches = [
        ['teamHome' => 'BEC', 'teamAway' => 'US Talence', 'scoreHome' => 82, 'scoreAway' => 68, 'dateMatch' => '2024-10-05'],
        ['teamHome' => 'Union Saint-Bruno', 'teamAway' => 'BEC', 'scoreHome' => 79, 'scoreAway' => 74, 'dateMatch' => '2024-10-12'],
    ];
}

$bannerImage = ROOT_URL . '/src/images/background/background-index-4.webp';

$teamName = $team['libEquipeComplet'] ?: $team['libEquipe'];
$teamPhotoUrl = ba_bec_team_photo_url($team['urlPhotoEquipe'] ?? '');
$staffPhotoUrl = ba_bec_team_photo_url($team['urlPhotoStaff'] ?? '');

$stats = [
    'home' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
    'away' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
    'total' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
    'wins' => 0,
    'bestWin' => null,
];

foreach ($teamMatches as $match) {
    $scoreHome = $match['scoreHome'];
    $scoreAway = $match['scoreAway'];
    if ($scoreHome === null || $scoreAway === null) {
        continue;
    }

    $isHome = ($match['homeEquipe'] ?? null) == $teamId;
    $locationKey = $isHome ? 'home' : 'away';
    $pointsFor = $isHome ? $scoreHome : $scoreAway;
    $pointsAgainst = $isHome ? $scoreAway : $scoreHome;

    $stats[$locationKey]['matches']++;
    $stats[$locationKey]['pointsFor'] += (int) $pointsFor;
    $stats[$locationKey]['pointsAgainst'] += (int) $pointsAgainst;

    $stats['total']['matches']++;
    $stats['total']['pointsFor'] += (int) $pointsFor;
    $stats['total']['pointsAgainst'] += (int) $pointsAgainst;

    if ($pointsFor > $pointsAgainst) {
        $stats['wins']++;
        $diff = (int) $pointsFor - (int) $pointsAgainst;
        if (!$stats['bestWin'] || $diff > $stats['bestWin']['diff']) {
            $opponent = $isHome ? ($match['teamAway'] ?? '') : ($match['teamHome'] ?? '');
            $stats['bestWin'] = [
                'diff' => $diff,
                'opponent' => $opponent,
                'date' => $match['dateMatch'] ?? '',
            ];
        }
    }
}

$upcomingMatches = array_values(array_filter(
    $teamMatches,
    static function (array $match): bool {
        if (empty($match['dateMatch'])) {
            return false;
        }
        return $match['dateMatch'] >= date('Y-m-d');
    }
));
$nextMatch = $upcomingMatches[0] ?? null;
$nextMatchOthers = array_slice($upcomingMatches, 1, 4);

$coachLead = null;
$assistantCoaches = [];
$otherCoaches = [];

foreach ($coaches as $coach) {
    $role = strtolower($coach['libRolePersonnel'] ?? '');
    if (str_contains($role, 'assistant')) {
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
                    <?php echo htmlspecialchars($team['libCategorie'] ?: 'Catégorie non renseignée'); ?>
                </p>
                <h1><?php echo htmlspecialchars($teamName); ?></h1>
                <p class="team-detail-meta">
                    <?php echo htmlspecialchars($team['libSection'] ?: 'Section non renseignée'); ?> ·
                    <?php echo htmlspecialchars($team['libNiveau'] ?: 'Niveau non renseigné'); ?>
                </p>
            </div>
        </div>
    </header>

    <section class="team-detail-section">
        <div class="team-profile card shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-4 team-profile-media">
                    <div class="team-profile-gallery">
                        <div class="team-profile-photo">
                            <p class="team-profile-label">Photo équipe</p>
                            <?php if ($teamPhotoUrl) : ?>
                                <img src="<?php echo htmlspecialchars($teamPhotoUrl); ?>" alt="<?php echo htmlspecialchars($teamName); ?>">
                            <?php else : ?>
                                <span class="team-profile-placeholder">Photo d'équipe à venir</span>
                            <?php endif; ?>
                        </div>
                        <div class="team-profile-photo">
                            <p class="team-profile-label">Photo staff</p>
                            <?php if ($staffPhotoUrl) : ?>
                                <img src="<?php echo htmlspecialchars($staffPhotoUrl); ?>" alt="Photo du staff <?php echo htmlspecialchars($teamName); ?>">
                            <?php else : ?>
                                <span class="team-profile-placeholder">Photo du staff à venir</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2>Le staff en action</h2>
                        <p class="mb-0">
                            <?php echo htmlspecialchars($team['descriptionEquipe'] ?: 'La description de l\'équipe sera bientôt disponible.'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-detail-section">
        <h2>Quelques statistiques</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h6 text-uppercase text-muted">Matchs joués</h3>
                        <p class="mb-1"><strong>Domicile :</strong> <?php echo htmlspecialchars((string) $stats['home']['matches']); ?></p>
                        <p class="mb-1"><strong>Extérieur :</strong> <?php echo htmlspecialchars((string) $stats['away']['matches']); ?></p>
                        <p class="mb-0"><strong>Total :</strong> <?php echo htmlspecialchars((string) $stats['total']['matches']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h6 text-uppercase text-muted">Points marqués</h3>
                        <p class="mb-1"><strong>Domicile :</strong> <?php echo htmlspecialchars((string) $stats['home']['pointsFor']); ?></p>
                        <p class="mb-1"><strong>Extérieur :</strong> <?php echo htmlspecialchars((string) $stats['away']['pointsFor']); ?></p>
                        <p class="mb-0"><strong>Total :</strong> <?php echo htmlspecialchars((string) $stats['total']['pointsFor']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h6 text-uppercase text-muted">Points encaissés</h3>
                        <p class="mb-1"><strong>Domicile :</strong> <?php echo htmlspecialchars((string) $stats['home']['pointsAgainst']); ?></p>
                        <p class="mb-1"><strong>Extérieur :</strong> <?php echo htmlspecialchars((string) $stats['away']['pointsAgainst']); ?></p>
                        <p class="mb-0"><strong>Total :</strong> <?php echo htmlspecialchars((string) $stats['total']['pointsAgainst']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h6 text-uppercase text-muted">Matchs gagnés</h3>
                        <p class="display-6 mb-0"><?php echo htmlspecialchars((string) $stats['wins']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h6 text-uppercase text-muted">Meilleure différence</h3>
                        <?php if ($stats['bestWin']) : ?>
                            <p class="mb-1"><strong>+<?php echo htmlspecialchars((string) $stats['bestWin']['diff']); ?></strong></p>
                            <?php if (!empty($stats['bestWin']['opponent'])) : ?>
                                <p class="mb-0 text-muted">
                                    <?php echo htmlspecialchars($stats['bestWin']['opponent']); ?>
                                    <?php if (!empty($stats['bestWin']['date'])) : ?>
                                        · <?php echo htmlspecialchars($stats['bestWin']['date']); ?>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        <?php else : ?>
                            <p class="mb-0 text-muted">Aucune victoire enregistrée.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-detail-section">
        <h2>Prochain match</h2>
        <?php if ($nextMatch) : ?>
            <article class="match-highlight">
                <div class="match-clubs">
                    <div class="match-team">
                        <span><?php echo htmlspecialchars($nextMatch['teamHome'] ?? 'Domicile'); ?></span>
                    </div>
                    <span class="match-versus">VS</span>
                    <div class="match-team">
                        <span><?php echo htmlspecialchars($nextMatch['teamAway'] ?? 'Extérieur'); ?></span>
                    </div>
                </div>
                <div class="match-details">
                    <p><?php echo htmlspecialchars($nextMatch['dateMatch'] ?? ''); ?><?php echo !empty($nextMatch['heureMatch']) ? ' · ' . htmlspecialchars($nextMatch['heureMatch']) : ''; ?></p>
                    <p class="text-muted"><?php echo htmlspecialchars($nextMatch['lieuMatch'] ?? 'Lieu à confirmer'); ?></p>
                </div>
            </article>
        <?php else : ?>
            <p class="text-muted">Aucun match à venir.</p>
        <?php endif; ?>

        <?php if (!empty($nextMatchOthers)) : ?>
            <div class="match-upcoming">
                <?php foreach ($nextMatchOthers as $match) : ?>
                    <article class="match-card">
                        <p class="match-card-opponent"><?php echo htmlspecialchars(($match['teamHome'] ?? '') . ' vs ' . ($match['teamAway'] ?? '')); ?></p>
                        <p class="match-card-date"><?php echo htmlspecialchars($match['dateMatch'] ?? ''); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="team-detail-section">
        <h2>Staff technique</h2>
        <div class="staff-grid">
            <article class="staff-card">
                <h3>Coach principal</h3>
                <?php if ($coachLead) : ?>
                    <p><?php echo htmlspecialchars($coachLead['prenomPersonnel'] . ' ' . $coachLead['nomPersonnel']); ?></p>
                    <?php if (!empty($coachLead['libRolePersonnel'])) : ?>
                        <p class="text-muted"><?php echo htmlspecialchars($coachLead['libRolePersonnel']); ?></p>
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
    </section>

    <section class="team-detail-section">
        <h2>Joueurs</h2>
        <?php if (empty($players)) : ?>
            <p class="text-muted">Aucun joueur renseigné.</p>
        <?php else : ?>
            <div class="players-grid">
                <?php foreach ($players as $player) : ?>
                    <?php
                    $playerPhoto = $player['urlPhotoJoueur'] ?? '';
                    $playerPhotoUrl = '';
                    if (!empty($playerPhoto)) {
                        $playerPhotoUrl = preg_match('/^(https?:\/\/|\/)/', $playerPhoto)
                            ? $playerPhoto
                            : ROOT_URL . '/src/uploads/' . $playerPhoto;
                    }
                    ?>
                    <article class="player-card">
                        <h3><?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?></h3>
                        <div class="player-photo">
                            <?php if ($playerPhotoUrl) : ?>
                                <img src="<?php echo htmlspecialchars($playerPhotoUrl); ?>" alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>" loading="lazy">
                            <?php else : ?>
                                <span class="player-photo-placeholder">Photo à venir</span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($player['libPoste'])) : ?>
                            <p class="text-muted"><?php echo htmlspecialchars($player['libPoste']); ?></p>
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
