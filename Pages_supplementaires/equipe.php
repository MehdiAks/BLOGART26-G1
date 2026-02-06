<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Ligne vide pour aération.

// Cette ligne contient: $pageStyles = [ROOT_URL . '/src/css/team-detail.css'];
$pageStyles = [ROOT_URL . '/src/css/team-detail.css'];
// Ligne vide pour aération.

// Cette ligne contient: function render_missing_table_page(PDOException $exception): void
function render_missing_table_page(PDOException $exception): void
// Cette ligne contient: {
{
// Cette ligne contient: $errorInfo = $exception->errorInfo ?? [];
    $errorInfo = $exception->errorInfo ?? [];
// Cette ligne contient: $isMissingTable = $exception->getCode() === '42S02'
    $isMissingTable = $exception->getCode() === '42S02'
// Cette ligne contient: || (isset($errorInfo[1]) && (int) $errorInfo[1] === 1146);
        || (isset($errorInfo[1]) && (int) $errorInfo[1] === 1146);
// Ligne vide pour aération.

// Cette ligne contient: if ($isMissingTable) {
    if ($isMissingTable) {
// Cette ligne contient: http_response_code(404);
        http_response_code(404);
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/erreur404.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/erreur404.php';
// Cette ligne contient: exit;
        exit;
// Cette ligne contient: }
    }
// Cette ligne contient: }
}
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

// Cette ligne contient: function format_poste(?int $poste): string
function format_poste(?int $poste): string
// Cette ligne contient: {
{
// Cette ligne contient: $labels = [
    $labels = [
// Cette ligne contient: 1 => 'Meneur',
        1 => 'Meneur',
// Cette ligne contient: 2 => 'Arrière',
        2 => 'Arrière',
// Cette ligne contient: 3 => 'Ailier',
        3 => 'Ailier',
// Cette ligne contient: 4 => 'Ailier fort',
        4 => 'Ailier fort',
// Cette ligne contient: 5 => 'Pivot',
        5 => 'Pivot',
// Cette ligne contient: ];
    ];
// Cette ligne contient: if (!$poste) {
    if (!$poste) {
// Cette ligne contient: return 'Poste non renseigné';
        return 'Poste non renseigné';
// Cette ligne contient: }
    }
// Cette ligne contient: return $labels[$poste] ?? ('Poste ' . $poste);
    return $labels[$poste] ?? ('Poste ' . $poste);
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: function resolve_match_side(?string $location): string
function resolve_match_side(?string $location): string
// Cette ligne contient: {
{
// Cette ligne contient: $location = strtolower(trim((string) $location));
    $location = strtolower(trim((string) $location));
// Cette ligne contient: if ($location === '') {
    if ($location === '') {
// Cette ligne contient: return 'home';
        return 'home';
// Cette ligne contient: }
    }
// Cette ligne contient: if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
    if (str_contains($location, 'exterieur') || str_contains($location, 'extérieur') || str_contains($location, 'away')) {
// Cette ligne contient: return 'away';
        return 'away';
// Cette ligne contient: }
    }
// Cette ligne contient: if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
    if (str_contains($location, 'domicile') || str_contains($location, 'home') || str_contains($location, 'barbey')) {
// Cette ligne contient: return 'home';
        return 'home';
// Cette ligne contient: }
    }
// Cette ligne contient: return 'home';
    return 'home';
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $teamId = filter_input(INPUT_GET, 'numEquipe', FILTER_VALIDATE_INT);
$teamId = filter_input(INPUT_GET, 'numEquipe', FILTER_VALIDATE_INT);
// Cette ligne contient: if (!$teamId) {
if (!$teamId) {
// Cette ligne contient: http_response_code(404);
    http_response_code(404);
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/erreur404.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/erreur404.php';
// Cette ligne contient: exit;
    exit;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');
$dbAvailable = getenv('DB_HOST') && getenv('DB_USER') && getenv('DB_DATABASE');
// Cette ligne contient: $team = null;
$team = null;
// Cette ligne contient: $players = [];
$players = [];
// Cette ligne contient: $coaches = [];
$coaches = [];
// Cette ligne contient: $teamMatches = [];
$teamMatches = [];
// Ligne vide pour aération.

// Cette ligne contient: if ($dbAvailable) {
if ($dbAvailable) {
// Cette ligne contient: try {
    try {
// Cette ligne contient: sql_connect();
        sql_connect();
// Ligne vide pour aération.

// Cette ligne contient: $teamStmt = $DB->prepare(
        $teamStmt = $DB->prepare(
// Cette ligne contient: 'SELECT numEquipe, codeEquipe, nomEquipe, descriptionEquipe, photoDLequipe, photoStaff, categorie, section, niveau
            'SELECT numEquipe, codeEquipe, nomEquipe, descriptionEquipe, photoDLequipe, photoStaff, categorie, section, niveau
// Cette ligne contient: FROM EQUIPE
             FROM EQUIPE
// Cette ligne contient: WHERE numEquipe = :teamId'
             WHERE numEquipe = :teamId'
// Cette ligne contient: );
        );
// Cette ligne contient: $teamStmt->execute(['teamId' => $teamId]);
        $teamStmt->execute(['teamId' => $teamId]);
// Cette ligne contient: $team = $teamStmt->fetch(PDO::FETCH_ASSOC) ?: null;
        $team = $teamStmt->fetch(PDO::FETCH_ASSOC) ?: null;
// Ligne vide pour aération.

// Cette ligne contient: if (!$team) {
        if (!$team) {
// Cette ligne contient: http_response_code(404);
            http_response_code(404);
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/erreur404.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/erreur404.php';
// Cette ligne contient: exit;
            exit;
// Cette ligne contient: }
        }
// Ligne vide pour aération.

// Cette ligne contient: $playersStmt = $DB->prepare(
        $playersStmt = $DB->prepare(
// Cette ligne contient: 'SELECT prenomJoueur, nomJoueur, posteJoueur, urlPhotoJoueur
            'SELECT prenomJoueur, nomJoueur, posteJoueur, urlPhotoJoueur
// Cette ligne contient: FROM JOUEUR
             FROM JOUEUR
// Cette ligne contient: WHERE codeEquipe = :codeEquipe
             WHERE codeEquipe = :codeEquipe
// Cette ligne contient: ORDER BY nomJoueur ASC'
             ORDER BY nomJoueur ASC'
// Cette ligne contient: );
        );
// Cette ligne contient: $playersStmt->execute(['codeEquipe' => $team['codeEquipe']]);
        $playersStmt->execute(['codeEquipe' => $team['codeEquipe']]);
// Cette ligne contient: $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);
        $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);
// Ligne vide pour aération.

// Cette ligne contient: $coachesStmt = $DB->prepare(
        $coachesStmt = $DB->prepare(
// Cette ligne contient: 'SELECT prenomPersonnel, nomPersonnel, roleStaffEquipe AS libRolePersonnel
            'SELECT prenomPersonnel, nomPersonnel, roleStaffEquipe AS libRolePersonnel
// Cette ligne contient: FROM PERSONNEL
             FROM PERSONNEL
// Cette ligne contient: WHERE estStaffEquipe = 1 AND numEquipeStaff = :codeEquipe
             WHERE estStaffEquipe = 1 AND numEquipeStaff = :codeEquipe
// Cette ligne contient: ORDER BY nomPersonnel ASC'
             ORDER BY nomPersonnel ASC'
// Cette ligne contient: );
        );
// Cette ligne contient: $coachesStmt->execute(['codeEquipe' => $team['codeEquipe']]);
        $coachesStmt->execute(['codeEquipe' => $team['codeEquipe']]);
// Cette ligne contient: $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
        $coaches = $coachesStmt->fetchAll(PDO::FETCH_ASSOC);
// Ligne vide pour aération.

// Cette ligne contient: $matchesStmt = $DB->prepare(
        $matchesStmt = $DB->prepare(
// Cette ligne contient: 'SELECT m.dateMatch, m.heureMatch, m.lieuMatch,
            'SELECT m.dateMatch, m.heureMatch, m.lieuMatch,
// Cette ligne contient: m.scoreBec AS scoreBec,
                    m.scoreBec AS scoreBec,
// Cette ligne contient: m.scoreAdversaire AS scoreAdversaire,
                    m.scoreAdversaire AS scoreAdversaire,
// Cette ligne contient: m.clubAdversaire AS clubAdversaire,
                    m.clubAdversaire AS clubAdversaire,
// Cette ligne contient: m.numEquipeAdverse AS numEquipeAdverse,
                    m.numEquipeAdverse AS numEquipeAdverse,
// Cette ligne contient: e.nomEquipe AS teamName
                    e.nomEquipe AS teamName
// Cette ligne contient: FROM `MATCH` m
             FROM `MATCH` m
// Cette ligne contient: INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
             INNER JOIN EQUIPE e ON m.codeEquipe = e.codeEquipe
// Cette ligne contient: WHERE m.codeEquipe = :codeEquipe
             WHERE m.codeEquipe = :codeEquipe
// Cette ligne contient: ORDER BY m.dateMatch DESC, m.heureMatch DESC'
             ORDER BY m.dateMatch DESC, m.heureMatch DESC'
// Cette ligne contient: );
        );
// Cette ligne contient: $matchesStmt->execute(['codeEquipe' => $team['codeEquipe']]);
        $matchesStmt->execute(['codeEquipe' => $team['codeEquipe']]);
// Cette ligne contient: $teamMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
        $teamMatches = $matchesStmt->fetchAll(PDO::FETCH_ASSOC);
// Cette ligne contient: } catch (PDOException $exception) {
    } catch (PDOException $exception) {
// Cette ligne contient: render_missing_table_page($exception);
        render_missing_table_page($exception);
// Cette ligne contient: throw $exception;
        throw $exception;
// Cette ligne contient: }
    }
// Cette ligne contient: } else {
} else {
// Cette ligne contient: $team = [
    $team = [
// Cette ligne contient: 'numEquipe' => $teamId,
        'numEquipe' => $teamId,
// Cette ligne contient: 'codeEquipe' => 'BEC',
        'codeEquipe' => 'BEC',
// Cette ligne contient: 'nomEquipe' => 'Équipe du BEC',
        'nomEquipe' => 'Équipe du BEC',
// Cette ligne contient: 'categorie' => 'Seniors',
        'categorie' => 'Seniors',
// Cette ligne contient: 'section' => 'Championnat régional',
        'section' => 'Championnat régional',
// Cette ligne contient: 'niveau' => 'Niveau 1',
        'niveau' => 'Niveau 1',
// Cette ligne contient: 'descriptionEquipe' => 'Une équipe engagée et soudée qui défend fièrement les couleurs du BEC tout au long de la saison.',
        'descriptionEquipe' => 'Une équipe engagée et soudée qui défend fièrement les couleurs du BEC tout au long de la saison.',
// Cette ligne contient: 'photoDLequipe' => '',
        'photoDLequipe' => '',
// Cette ligne contient: 'photoStaff' => '',
        'photoStaff' => '',
// Cette ligne contient: ];
    ];
// Cette ligne contient: $players = [
    $players = [
// Cette ligne contient: ['prenomJoueur' => 'Léo', 'nomJoueur' => 'Martin', 'posteJoueur' => 1],
        ['prenomJoueur' => 'Léo', 'nomJoueur' => 'Martin', 'posteJoueur' => 1],
// Cette ligne contient: ['prenomJoueur' => 'Amélie', 'nomJoueur' => 'Durand', 'posteJoueur' => 3],
        ['prenomJoueur' => 'Amélie', 'nomJoueur' => 'Durand', 'posteJoueur' => 3],
// Cette ligne contient: ['prenomJoueur' => 'Hugo', 'nomJoueur' => 'Bernard', 'posteJoueur' => 5],
        ['prenomJoueur' => 'Hugo', 'nomJoueur' => 'Bernard', 'posteJoueur' => 5],
// Cette ligne contient: ['prenomJoueur' => 'Sara', 'nomJoueur' => 'Lopez', 'posteJoueur' => 2],
        ['prenomJoueur' => 'Sara', 'nomJoueur' => 'Lopez', 'posteJoueur' => 2],
// Cette ligne contient: ];
    ];
// Cette ligne contient: $coaches = [
    $coaches = [
// Cette ligne contient: ['prenomPersonnel' => 'Camille', 'nomPersonnel' => 'Roche', 'libRolePersonnel' => 'Coach'],
        ['prenomPersonnel' => 'Camille', 'nomPersonnel' => 'Roche', 'libRolePersonnel' => 'Coach'],
// Cette ligne contient: ['prenomPersonnel' => 'Paul', 'nomPersonnel' => 'Girard', 'libRolePersonnel' => 'Assistant'],
        ['prenomPersonnel' => 'Paul', 'nomPersonnel' => 'Girard', 'libRolePersonnel' => 'Assistant'],
// Cette ligne contient: ];
    ];
// Cette ligne contient: $teamMatches = [
    $teamMatches = [
// Cette ligne contient: ['teamHome' => 'BEC', 'teamAway' => 'US Talence', 'scoreHome' => 82, 'scoreAway' => 68, 'dateMatch' => '2024-10-05', 'isHome' => true],
        ['teamHome' => 'BEC', 'teamAway' => 'US Talence', 'scoreHome' => 82, 'scoreAway' => 68, 'dateMatch' => '2024-10-05', 'isHome' => true],
// Cette ligne contient: ['teamHome' => 'Union Saint-Bruno', 'teamAway' => 'BEC', 'scoreHome' => 79, 'scoreAway' => 74, 'dateMatch' => '2024-10-12', 'isHome' => false],
        ['teamHome' => 'Union Saint-Bruno', 'teamAway' => 'BEC', 'scoreHome' => 79, 'scoreAway' => 74, 'dateMatch' => '2024-10-12', 'isHome' => false],
// Cette ligne contient: ];
    ];
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $teamMatches = array_map(
$teamMatches = array_map(
// Cette ligne contient: static function (array $match) use ($team): array {
    static function (array $match) use ($team): array {
// Cette ligne contient: if (empty($team) || empty($team['nomEquipe'])) {
        if (empty($team) || empty($team['nomEquipe'])) {
// Cette ligne contient: return $match;
            return $match;
// Cette ligne contient: }
        }
// Cette ligne contient: $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
        $opponent = trim((string) ($match['clubAdversaire'] ?? ''));
// Cette ligne contient: if (!empty($match['numEquipeAdverse'])) {
        if (!empty($match['numEquipeAdverse'])) {
// Cette ligne contient: $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
            $opponent = trim($opponent . ' ' . $match['numEquipeAdverse']);
// Cette ligne contient: }
        }
// Cette ligne contient: if ($opponent === '') {
        if ($opponent === '') {
// Cette ligne contient: $opponent = 'Adversaire';
            $opponent = 'Adversaire';
// Cette ligne contient: }
        }
// Cette ligne contient: $side = resolve_match_side($match['lieuMatch'] ?? '');
        $side = resolve_match_side($match['lieuMatch'] ?? '');
// Cette ligne contient: $isHome = $side === 'home';
        $isHome = $side === 'home';
// Cette ligne contient: $teamHome = $isHome ? $team['nomEquipe'] : $opponent;
        $teamHome = $isHome ? $team['nomEquipe'] : $opponent;
// Cette ligne contient: $teamAway = $isHome ? $opponent : $team['nomEquipe'];
        $teamAway = $isHome ? $opponent : $team['nomEquipe'];
// Cette ligne contient: $scoreHome = $isHome ? ($match['scoreBec'] ?? null) : ($match['scoreAdversaire'] ?? null);
        $scoreHome = $isHome ? ($match['scoreBec'] ?? null) : ($match['scoreAdversaire'] ?? null);
// Cette ligne contient: $scoreAway = $isHome ? ($match['scoreAdversaire'] ?? null) : ($match['scoreBec'] ?? null);
        $scoreAway = $isHome ? ($match['scoreAdversaire'] ?? null) : ($match['scoreBec'] ?? null);
// Ligne vide pour aération.

// Cette ligne contient: return array_merge($match, [
        return array_merge($match, [
// Cette ligne contient: 'teamHome' => $teamHome,
            'teamHome' => $teamHome,
// Cette ligne contient: 'teamAway' => $teamAway,
            'teamAway' => $teamAway,
// Cette ligne contient: 'scoreHome' => $scoreHome,
            'scoreHome' => $scoreHome,
// Cette ligne contient: 'scoreAway' => $scoreAway,
            'scoreAway' => $scoreAway,
// Cette ligne contient: 'isHome' => $isHome,
            'isHome' => $isHome,
// Cette ligne contient: ]);
        ]);
// Cette ligne contient: },
    },
// Cette ligne contient: $teamMatches
    $teamMatches
// Cette ligne contient: );
);
// Ligne vide pour aération.

// Cette ligne contient: $bannerImage = ROOT_URL . '/src/images/background/background-index-4.webp';
$bannerImage = ROOT_URL . '/src/images/background/background-index-4.webp';
// Cette ligne contient: $defaultTeamImage = ROOT_URL . '/src/images/image-defaut.jpeg';
$defaultTeamImage = ROOT_URL . '/src/images/image-defaut.jpeg';
// Ligne vide pour aération.

// Cette ligne contient: $teamName = $team['nomEquipe'] ?? '';
$teamName = $team['nomEquipe'] ?? '';
// Cette ligne contient: $teamPhotoUrl = ba_bec_team_photo_url($team['photoDLequipe'] ?? '') ?: $defaultTeamImage;
$teamPhotoUrl = ba_bec_team_photo_url($team['photoDLequipe'] ?? '') ?: $defaultTeamImage;
// Cette ligne contient: $staffPhotoUrl = ba_bec_team_photo_url($team['photoStaff'] ?? '') ?: $defaultTeamImage;
$staffPhotoUrl = ba_bec_team_photo_url($team['photoStaff'] ?? '') ?: $defaultTeamImage;
// Ligne vide pour aération.

// Cette ligne contient: $stats = [
$stats = [
// Cette ligne contient: 'home' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
    'home' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
// Cette ligne contient: 'away' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
    'away' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
// Cette ligne contient: 'total' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
    'total' => ['matches' => 0, 'pointsFor' => 0, 'pointsAgainst' => 0],
// Cette ligne contient: 'wins' => 0,
    'wins' => 0,
// Cette ligne contient: 'bestWin' => null,
    'bestWin' => null,
// Cette ligne contient: ];
];
// Ligne vide pour aération.

// Cette ligne contient: foreach ($teamMatches as $match) {
foreach ($teamMatches as $match) {
// Cette ligne contient: $scoreHome = $match['scoreHome'];
    $scoreHome = $match['scoreHome'];
// Cette ligne contient: $scoreAway = $match['scoreAway'];
    $scoreAway = $match['scoreAway'];
// Cette ligne contient: if ($scoreHome === null || $scoreAway === null) {
    if ($scoreHome === null || $scoreAway === null) {
// Cette ligne contient: continue;
        continue;
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: $isHome = (bool) ($match['isHome'] ?? false);
    $isHome = (bool) ($match['isHome'] ?? false);
// Cette ligne contient: $locationKey = $isHome ? 'home' : 'away';
    $locationKey = $isHome ? 'home' : 'away';
// Cette ligne contient: $pointsFor = $isHome ? $scoreHome : $scoreAway;
    $pointsFor = $isHome ? $scoreHome : $scoreAway;
// Cette ligne contient: $pointsAgainst = $isHome ? $scoreAway : $scoreHome;
    $pointsAgainst = $isHome ? $scoreAway : $scoreHome;
// Ligne vide pour aération.

// Cette ligne contient: $stats[$locationKey]['matches']++;
    $stats[$locationKey]['matches']++;
// Cette ligne contient: $stats[$locationKey]['pointsFor'] += (int) $pointsFor;
    $stats[$locationKey]['pointsFor'] += (int) $pointsFor;
// Cette ligne contient: $stats[$locationKey]['pointsAgainst'] += (int) $pointsAgainst;
    $stats[$locationKey]['pointsAgainst'] += (int) $pointsAgainst;
// Ligne vide pour aération.

// Cette ligne contient: $stats['total']['matches']++;
    $stats['total']['matches']++;
// Cette ligne contient: $stats['total']['pointsFor'] += (int) $pointsFor;
    $stats['total']['pointsFor'] += (int) $pointsFor;
// Cette ligne contient: $stats['total']['pointsAgainst'] += (int) $pointsAgainst;
    $stats['total']['pointsAgainst'] += (int) $pointsAgainst;
// Ligne vide pour aération.

// Cette ligne contient: if ($pointsFor > $pointsAgainst) {
    if ($pointsFor > $pointsAgainst) {
// Cette ligne contient: $stats['wins']++;
        $stats['wins']++;
// Cette ligne contient: $diff = (int) $pointsFor - (int) $pointsAgainst;
        $diff = (int) $pointsFor - (int) $pointsAgainst;
// Cette ligne contient: if (!$stats['bestWin'] || $diff > $stats['bestWin']['diff']) {
        if (!$stats['bestWin'] || $diff > $stats['bestWin']['diff']) {
// Cette ligne contient: $opponent = $isHome ? ($match['teamAway'] ?? '') : ($match['teamHome'] ?? '');
            $opponent = $isHome ? ($match['teamAway'] ?? '') : ($match['teamHome'] ?? '');
// Cette ligne contient: $stats['bestWin'] = [
            $stats['bestWin'] = [
// Cette ligne contient: 'diff' => $diff,
                'diff' => $diff,
// Cette ligne contient: 'opponent' => $opponent,
                'opponent' => $opponent,
// Cette ligne contient: 'date' => $match['dateMatch'] ?? '',
                'date' => $match['dateMatch'] ?? '',
// Cette ligne contient: ];
            ];
// Cette ligne contient: }
        }
// Cette ligne contient: }
    }
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $totalMatches = (int) $stats['total']['matches'];
$totalMatches = (int) $stats['total']['matches'];
// Cette ligne contient: $totalPoints = (int) $stats['total']['pointsFor'];
$totalPoints = (int) $stats['total']['pointsFor'];
// Cette ligne contient: $totalWins = (int) $stats['wins'];
$totalWins = (int) $stats['wins'];
// Cette ligne contient: $totalLosses = max(0, $totalMatches - $totalWins);
$totalLosses = max(0, $totalMatches - $totalWins);
// Ligne vide pour aération.

// Cette ligne contient: $recentFor = [];
$recentFor = [];
// Cette ligne contient: $recentAgainst = [];
$recentAgainst = [];
// Cette ligne contient: foreach ($teamMatches as $match) {
foreach ($teamMatches as $match) {
// Cette ligne contient: $scoreHome = $match['scoreHome'] ?? null;
    $scoreHome = $match['scoreHome'] ?? null;
// Cette ligne contient: $scoreAway = $match['scoreAway'] ?? null;
    $scoreAway = $match['scoreAway'] ?? null;
// Cette ligne contient: if ($scoreHome === null || $scoreAway === null) {
    if ($scoreHome === null || $scoreAway === null) {
// Cette ligne contient: continue;
        continue;
// Cette ligne contient: }
    }
// Cette ligne contient: $isHome = (bool) ($match['isHome'] ?? false);
    $isHome = (bool) ($match['isHome'] ?? false);
// Cette ligne contient: $pointsFor = $isHome ? $scoreHome : $scoreAway;
    $pointsFor = $isHome ? $scoreHome : $scoreAway;
// Cette ligne contient: $pointsAgainst = $isHome ? $scoreAway : $scoreHome;
    $pointsAgainst = $isHome ? $scoreAway : $scoreHome;
// Cette ligne contient: $recentFor[] = (int) $pointsFor;
    $recentFor[] = (int) $pointsFor;
// Cette ligne contient: $recentAgainst[] = (int) $pointsAgainst;
    $recentAgainst[] = (int) $pointsAgainst;
// Cette ligne contient: }
}
// Cette ligne contient: $recentFor = array_reverse(array_slice($recentFor, 0, 10));
$recentFor = array_reverse(array_slice($recentFor, 0, 10));
// Cette ligne contient: $recentAgainst = array_reverse(array_slice($recentAgainst, 0, 10));
$recentAgainst = array_reverse(array_slice($recentAgainst, 0, 10));
// Ligne vide pour aération.

// Cette ligne contient: $recentForCumulative = [];
$recentForCumulative = [];
// Cette ligne contient: $recentAgainstCumulative = [];
$recentAgainstCumulative = [];
// Cette ligne contient: $sumFor = 0;
$sumFor = 0;
// Cette ligne contient: $sumAgainst = 0;
$sumAgainst = 0;
// Cette ligne contient: foreach ($recentFor as $index => $value) {
foreach ($recentFor as $index => $value) {
// Cette ligne contient: $sumFor += $value;
    $sumFor += $value;
// Cette ligne contient: $sumAgainst += $recentAgainst[$index] ?? 0;
    $sumAgainst += $recentAgainst[$index] ?? 0;
// Cette ligne contient: $recentForCumulative[] = $sumFor;
    $recentForCumulative[] = $sumFor;
// Cette ligne contient: $recentAgainstCumulative[] = $sumAgainst;
    $recentAgainstCumulative[] = $sumAgainst;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $axisLabels = [];
$axisLabels = [];
// Cette ligne contient: $recentCount = count($recentForCumulative);
$recentCount = count($recentForCumulative);
// Cette ligne contient: if ($recentCount > 0) {
if ($recentCount > 0) {
// Cette ligne contient: if ($recentCount === 1) {
    if ($recentCount === 1) {
// Cette ligne contient: $axisLabels[] = ['index' => 1, 'pos' => 0];
        $axisLabels[] = ['index' => 1, 'pos' => 0];
// Cette ligne contient: } else {
    } else {
// Cette ligne contient: $indices = [
        $indices = [
// Cette ligne contient: 1,
            1,
// Cette ligne contient: (int) round(($recentCount + 1) / 3),
            (int) round(($recentCount + 1) / 3),
// Cette ligne contient: (int) round(2 * ($recentCount + 1) / 3),
            (int) round(2 * ($recentCount + 1) / 3),
// Cette ligne contient: $recentCount,
            $recentCount,
// Cette ligne contient: ];
        ];
// Cette ligne contient: $indices = array_values(array_unique($indices));
        $indices = array_values(array_unique($indices));
// Cette ligne contient: sort($indices);
        sort($indices);
// Cette ligne contient: foreach ($indices as $index) {
        foreach ($indices as $index) {
// Cette ligne contient: $pos = (($index - 1) / ($recentCount - 1)) * 100;
            $pos = (($index - 1) / ($recentCount - 1)) * 100;
// Cette ligne contient: $axisLabels[] = ['index' => $index, 'pos' => $pos];
            $axisLabels[] = ['index' => $index, 'pos' => $pos];
// Cette ligne contient: }
        }
// Cette ligne contient: }
    }
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: $upcomingMatches = array_values(array_filter(
$upcomingMatches = array_values(array_filter(
// Cette ligne contient: $teamMatches,
    $teamMatches,
// Cette ligne contient: static function (array $match): bool {
    static function (array $match): bool {
// Cette ligne contient: if (empty($match['dateMatch'])) {
        if (empty($match['dateMatch'])) {
// Cette ligne contient: return false;
            return false;
// Cette ligne contient: }
        }
// Cette ligne contient: return $match['dateMatch'] >= date('Y-m-d');
        return $match['dateMatch'] >= date('Y-m-d');
// Cette ligne contient: }
    }
// Cette ligne contient: ));
));
// Cette ligne contient: $nextMatch = $upcomingMatches[0] ?? null;
$nextMatch = $upcomingMatches[0] ?? null;
// Cette ligne contient: $nextMatchOthers = array_slice($upcomingMatches, 1, 4);
$nextMatchOthers = array_slice($upcomingMatches, 1, 4);
// Ligne vide pour aération.

// Cette ligne contient: $coachLead = null;
$coachLead = null;
// Cette ligne contient: $assistantCoaches = [];
$assistantCoaches = [];
// Cette ligne contient: $otherCoaches = [];
$otherCoaches = [];
// Ligne vide pour aération.

// Cette ligne contient: foreach ($coaches as $coach) {
foreach ($coaches as $coach) {
// Cette ligne contient: $role = strtolower($coach['libRolePersonnel'] ?? '');
    $role = strtolower($coach['libRolePersonnel'] ?? '');
// Cette ligne contient: if (str_contains($role, 'assistant')) {
    if (str_contains($role, 'assistant')) {
// Cette ligne contient: $assistantCoaches[] = $coach;
        $assistantCoaches[] = $coach;
// Cette ligne contient: continue;
        continue;
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: if (!$coachLead) {
    if (!$coachLead) {
// Cette ligne contient: $coachLead = $coach;
        $coachLead = $coach;
// Cette ligne contient: continue;
        continue;
// Cette ligne contient: }
    }
// Ligne vide pour aération.

// Cette ligne contient: $otherCoaches[] = $coach;
    $otherCoaches[] = $coach;
// Cette ligne contient: }
}
// Ligne vide pour aération.

// Cette ligne contient: if (!$coachLead && !empty($assistantCoaches)) {
if (!$coachLead && !empty($assistantCoaches)) {
// Cette ligne contient: $coachLead = array_shift($assistantCoaches);
    $coachLead = array_shift($assistantCoaches);
// Cette ligne contient: }
}
// Cette ligne contient: ?>
?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="team-detail"> -->
<section class="team-detail">
<!-- Cette ligne contient: <header class="team-detail-header"> -->
    <header class="team-detail-header">
<!-- Cette ligne contient: <div class="team-detail-banner" style="background-image: url('<?php echo htmlspecialchars($bannerImage); ?>');"> -->
        <div class="team-detail-banner" style="background-image: url('<?php echo htmlspecialchars($bannerImage); ?>');">
<!-- Cette ligne contient: <div class="team-detail-banner-content"> -->
            <div class="team-detail-banner-content">
<!-- Cette ligne contient: <p class="team-detail-category"> -->
                <p class="team-detail-category">
<!-- Cette ligne contient: <?php echo htmlspecialchars($team['categorie'] ?: 'Catégorie non renseignée'); ?> -->
                    <?php echo htmlspecialchars($team['categorie'] ?: 'Catégorie non renseignée'); ?>
<!-- Cette ligne contient: </p> -->
                </p>
<!-- Cette ligne contient: <h1><?php echo htmlspecialchars($teamName); ?></h1> -->
                <h1><?php echo htmlspecialchars($teamName); ?></h1>
<!-- Cette ligne contient: <p class="team-detail-meta"> -->
                <p class="team-detail-meta">
<!-- Cette ligne contient: <?php echo htmlspecialchars($team['section'] ?: 'Section non renseignée'); ?> · -->
                    <?php echo htmlspecialchars($team['section'] ?: 'Section non renseignée'); ?> ·
<!-- Cette ligne contient: <?php echo htmlspecialchars($team['niveau'] ?: 'Niveau non renseigné'); ?> -->
                    <?php echo htmlspecialchars($team['niveau'] ?: 'Niveau non renseigné'); ?>
<!-- Cette ligne contient: </p> -->
                </p>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </header> -->
    </header>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="team-detail-section"> -->
    <section class="team-detail-section">
<!-- Cette ligne contient: <div class="team-profile card shadow-sm"> -->
        <div class="team-profile card shadow-sm">
<!-- Cette ligne contient: <div class="row g-0 align-items-center"> -->
            <div class="row g-0 align-items-center">
<!-- Cette ligne contient: <div class="col-md-4 team-profile-media"> -->
                <div class="col-md-4 team-profile-media">
<!-- Cette ligne contient: <div class="team-profile-gallery"> -->
                    <div class="team-profile-gallery">
<!-- Cette ligne contient: <div class="team-profile-photo"> -->
                        <div class="team-profile-photo">
<!-- Cette ligne contient: <p class="team-profile-label">Photo équipe</p> -->
                            <p class="team-profile-label">Photo équipe</p>
<!-- Cette ligne contient: <img src="<?php echo htmlspecialchars($teamPhotoUrl); ?>" -->
                            <img src="<?php echo htmlspecialchars($teamPhotoUrl); ?>"
<!-- Cette ligne contient: alt="<?php echo htmlspecialchars($teamName); ?>"> -->
                                alt="<?php echo htmlspecialchars($teamName); ?>">
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: <div class="team-profile-photo"> -->
                        <div class="team-profile-photo">
<!-- Cette ligne contient: <p class="team-profile-label">Photo staff</p> -->
                            <p class="team-profile-label">Photo staff</p>
<!-- Cette ligne contient: <img src="<?php echo htmlspecialchars($staffPhotoUrl); ?>" -->
                            <img src="<?php echo htmlspecialchars($staffPhotoUrl); ?>"
<!-- Cette ligne contient: alt="Photo du staff <?php echo htmlspecialchars($teamName); ?>"> -->
                                alt="Photo du staff <?php echo htmlspecialchars($teamName); ?>">
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <div class="col-md-8"> -->
                <div class="col-md-8">
<!-- Cette ligne contient: <div class="card-body"> -->
                    <div class="card-body">
<!-- Cette ligne contient: <h2>Le staff en action</h2> -->
                        <h2>Le staff en action</h2>
<!-- Cette ligne contient: <p class="mb-0"> -->
                        <p class="mb-0">
<!-- Cette ligne contient: <?php echo htmlspecialchars($team['descriptionEquipe'] ?: 'La description de l\'équipe sera bientôt disponible.'); ?> -->
                            <?php echo htmlspecialchars($team['descriptionEquipe'] ?: 'La description de l\'équipe sera bientôt disponible.'); ?>
<!-- Cette ligne contient: </p> -->
                        </p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </section> -->
    </section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="team-detail-section"> -->
    <section class="team-detail-section">
<!-- Cette ligne contient: <h2>Quelques statistiques</h2> -->
        <h2>Quelques statistiques</h2>
<!-- Cette ligne contient: <div class="row g-3"> -->
        <div class="row g-3">
<!-- Cette ligne contient: <div class="col-md-4"> -->
            <div class="col-md-4">
<!-- Cette ligne contient: <div class="card h-100 shadow-sm"> -->
                <div class="card h-100 shadow-sm">
<!-- Cette ligne contient: <div class="card-body"> -->
                    <div class="card-body">
<!-- Cette ligne contient: <h3 class="h6 text-uppercase text-muted">Matchs joués</h3> -->
                        <h3 class="h6 text-uppercase text-muted">Matchs joués</h3>
<!-- Cette ligne contient: <p class="mb-1"><strong>Domicile :</strong> -->
                        <p class="mb-1"><strong>Domicile :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['home']['matches']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['home']['matches']); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Extérieur :</strong> -->
                        <p class="mb-1"><strong>Extérieur :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['away']['matches']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['away']['matches']); ?></p>
<!-- Cette ligne contient: <p class="mb-0"><strong>Total :</strong> -->
                        <p class="mb-0"><strong>Total :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['total']['matches']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['total']['matches']); ?></p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <div class="col-md-4"> -->
            <div class="col-md-4">
<!-- Cette ligne contient: <div class="card h-100 shadow-sm"> -->
                <div class="card h-100 shadow-sm">
<!-- Cette ligne contient: <div class="card-body"> -->
                    <div class="card-body">
<!-- Cette ligne contient: <h3 class="h6 text-uppercase text-muted">Points marqués</h3> -->
                        <h3 class="h6 text-uppercase text-muted">Points marqués</h3>
<!-- Cette ligne contient: <p class="mb-1"><strong>Domicile :</strong> -->
                        <p class="mb-1"><strong>Domicile :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['home']['pointsFor']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['home']['pointsFor']); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Extérieur :</strong> -->
                        <p class="mb-1"><strong>Extérieur :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['away']['pointsFor']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['away']['pointsFor']); ?></p>
<!-- Cette ligne contient: <p class="mb-0"><strong>Total :</strong> -->
                        <p class="mb-0"><strong>Total :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['total']['pointsFor']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['total']['pointsFor']); ?></p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <div class="col-md-4"> -->
            <div class="col-md-4">
<!-- Cette ligne contient: <div class="card h-100 shadow-sm"> -->
                <div class="card h-100 shadow-sm">
<!-- Cette ligne contient: <div class="card-body"> -->
                    <div class="card-body">
<!-- Cette ligne contient: <h3 class="h6 text-uppercase text-muted">Points encaissés</h3> -->
                        <h3 class="h6 text-uppercase text-muted">Points encaissés</h3>
<!-- Cette ligne contient: <p class="mb-1"><strong>Domicile :</strong> -->
                        <p class="mb-1"><strong>Domicile :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['home']['pointsAgainst']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['home']['pointsAgainst']); ?></p>
<!-- Cette ligne contient: <p class="mb-1"><strong>Extérieur :</strong> -->
                        <p class="mb-1"><strong>Extérieur :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['away']['pointsAgainst']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['away']['pointsAgainst']); ?></p>
<!-- Cette ligne contient: <p class="mb-0"><strong>Total :</strong> -->
                        <p class="mb-0"><strong>Total :</strong>
<!-- Cette ligne contient: <?php echo htmlspecialchars((string) $stats['total']['pointsAgainst']); ?></p> -->
                            <?php echo htmlspecialchars((string) $stats['total']['pointsAgainst']); ?></p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <div class="col-md-6"> -->
            <div class="col-md-6">
<!-- Cette ligne contient: <div class="card h-100 shadow-sm"> -->
                <div class="card h-100 shadow-sm">
<!-- Cette ligne contient: <div class="card-body"> -->
                    <div class="card-body">
<!-- Cette ligne contient: <h3 class="h6 text-uppercase text-muted">Matchs gagnés</h3> -->
                        <h3 class="h6 text-uppercase text-muted">Matchs gagnés</h3>
<!-- Cette ligne contient: <p class="display-6 mb-0"><?php echo htmlspecialchars((string) $stats['wins']); ?></p> -->
                        <p class="display-6 mb-0"><?php echo htmlspecialchars((string) $stats['wins']); ?></p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <div class="col-md-6"> -->
            <div class="col-md-6">
<!-- Cette ligne contient: <div class="card h-100 shadow-sm"> -->
                <div class="card h-100 shadow-sm">
<!-- Cette ligne contient: <div class="card-body"> -->
                    <div class="card-body">
<!-- Cette ligne contient: <h3 class="h6 text-uppercase text-muted">Meilleure différence</h3> -->
                        <h3 class="h6 text-uppercase text-muted">Meilleure différence</h3>
<!-- Cette ligne contient: <?php if ($stats['bestWin']): ?> -->
                        <?php if ($stats['bestWin']): ?>
<!-- Cette ligne contient: <p class="mb-1"> -->
                            <p class="mb-1">
<!-- Cette ligne contient: <strong>+<?php echo htmlspecialchars((string) $stats['bestWin']['diff']); ?></strong></p> -->
                                <strong>+<?php echo htmlspecialchars((string) $stats['bestWin']['diff']); ?></strong></p>
<!-- Cette ligne contient: <?php if (!empty($stats['bestWin']['opponent'])): ?> -->
                            <?php if (!empty($stats['bestWin']['opponent'])): ?>
<!-- Cette ligne contient: <p class="mb-0 text-muted"> -->
                                <p class="mb-0 text-muted">
<!-- Cette ligne contient: <?php echo htmlspecialchars($stats['bestWin']['opponent']); ?> -->
                                    <?php echo htmlspecialchars($stats['bestWin']['opponent']); ?>
<!-- Cette ligne contient: <?php if (!empty($stats['bestWin']['date'])): ?> -->
                                    <?php if (!empty($stats['bestWin']['date'])): ?>
<!-- Cette ligne contient: · <?php echo htmlspecialchars($stats['bestWin']['date']); ?> -->
                                        · <?php echo htmlspecialchars($stats['bestWin']['date']); ?>
<!-- Cette ligne contient: <?php endif; ?> -->
                                    <?php endif; ?>
<!-- Cette ligne contient: </p> -->
                                </p>
<!-- Cette ligne contient: <?php endif; ?> -->
                            <?php endif; ?>
<!-- Cette ligne contient: <?php else: ?> -->
                        <?php else: ?>
<!-- Cette ligne contient: <p class="mb-0 text-muted">Aucune victoire enregistrée.</p> -->
                            <p class="mb-0 text-muted">Aucune victoire enregistrée.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </section> -->
    </section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="team-detail-section chart-section"> -->
    <section class="team-detail-section chart-section">
<!-- Cette ligne contient: <div class="row g-4"> -->
        <div class="row g-4">
<!-- Cette ligne contient: <div class="col-12 col-lg-7"> -->
            <div class="col-12 col-lg-7">
<!-- Cette ligne contient: <article class="chart-card h-100"> -->
                <article class="chart-card h-100">
<!-- Cette ligne contient: <div class="chart-header"> -->
                    <div class="chart-header">
<!-- Cette ligne contient: <h3>Évolution des points</h3> -->
                        <h3>Évolution des points</h3>
<!-- Cette ligne contient: <p class="text-body-secondary mb-0"> -->
                        <p class="text-body-secondary mb-0">
<!-- Cette ligne contient: Courbe personnalisée sur les 10 derniers matchs. -->
                            Courbe personnalisée sur les 10 derniers matchs.
<!-- Cette ligne contient: </p> -->
                        </p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: <div class="line-chart" -->
                    <div class="line-chart"
<!-- Cette ligne contient: data-for="<?php echo htmlspecialchars(implode(',', $recentForCumulative)); ?>" -->
                        data-for="<?php echo htmlspecialchars(implode(',', $recentForCumulative)); ?>"
<!-- Cette ligne contient: data-against="<?php echo htmlspecialchars(implode(',', $recentAgainstCumulative)); ?>"> -->
                        data-against="<?php echo htmlspecialchars(implode(',', $recentAgainstCumulative)); ?>">
<!-- Cette ligne contient: <div class="line-chart-layout"> -->
                        <div class="line-chart-layout">
<!-- Cette ligne contient: <div class="line-chart-y"> -->
                            <div class="line-chart-y">
<!-- Cette ligne contient: <span class="line-y-label" data-y="max"></span> -->
                                <span class="line-y-label" data-y="max"></span>
<!-- Cette ligne contient: <span class="line-y-label" data-y="mid"></span> -->
                                <span class="line-y-label" data-y="mid"></span>
<!-- Cette ligne contient: <span class="line-y-label" data-y="min"></span> -->
                                <span class="line-y-label" data-y="min"></span>
<!-- Cette ligne contient: </div> -->
                            </div>
<!-- Cette ligne contient: <div class="line-chart-frame"> -->
                            <div class="line-chart-frame">
<!-- Cette ligne contient: <svg class="line-chart-svg" viewBox="0 0 100 60" preserveAspectRatio="none" aria-hidden="true"> -->
                                <svg class="line-chart-svg" viewBox="0 0 100 60" preserveAspectRatio="none" aria-hidden="true">
<!-- Cette ligne contient: <path class="line-area line-area-for" d=""></path> -->
                                    <path class="line-area line-area-for" d=""></path>
<!-- Cette ligne contient: <path class="line-area line-area-against" d=""></path> -->
                                    <path class="line-area line-area-against" d=""></path>
<!-- Cette ligne contient: <path class="line-stroke line-stroke-for" d=""></path> -->
                                    <path class="line-stroke line-stroke-for" d=""></path>
<!-- Cette ligne contient: <path class="line-stroke line-stroke-against" d=""></path> -->
                                    <path class="line-stroke line-stroke-against" d=""></path>
<!-- Cette ligne contient: </svg> -->
                                </svg>
<!-- Cette ligne contient: </div> -->
                            </div>
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: <p class="line-chart-empty text-body-secondary mb-0">Aucun match terminé.</p> -->
                        <p class="line-chart-empty text-body-secondary mb-0">Aucun match terminé.</p>
<!-- Cette ligne contient: <div class="line-chart-axis"> -->
                        <div class="line-chart-axis">
<!-- Cette ligne contient: <?php foreach ($axisLabels as $label) : ?> -->
                            <?php foreach ($axisLabels as $label) : ?>
<!-- Cette ligne contient: <span class="line-axis-label" style="- -pos: <?php echo number_format((float) $label['pos'], 2, '.', ''); ?>%;"> -->
                                <span class="line-axis-label" style="--pos: <?php echo number_format((float) $label['pos'], 2, '.', ''); ?>%;">
<!-- Cette ligne contient: <?php echo 'J' . (int) $label['index']; ?> -->
                                    <?php echo 'J' . (int) $label['index']; ?>
<!-- Cette ligne contient: </span> -->
                                </span>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                            <?php endforeach; ?>
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: <div class="line-chart-legend"> -->
                        <div class="line-chart-legend">
<!-- Cette ligne contient: <span><i class="legend-dot legend-for"></i>Points marqués (cumulés)</span> -->
                            <span><i class="legend-dot legend-for"></i>Points marqués (cumulés)</span>
<!-- Cette ligne contient: <span><i class="legend-dot legend-against"></i>Points encaissés (cumulés)</span> -->
                            <span><i class="legend-dot legend-against"></i>Points encaissés (cumulés)</span>
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </article> -->
                </article>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: <div class="col-12 col-lg-5"> -->
            <div class="col-12 col-lg-5">
<!-- Cette ligne contient: <article class="chart-card h-100"> -->
                <article class="chart-card h-100">
<!-- Cette ligne contient: <div class="chart-header"> -->
                    <div class="chart-header">
<!-- Cette ligne contient: <h3>Victoires / défaites</h3> -->
                        <h3>Victoires / défaites</h3>
<!-- Cette ligne contient: <p class="text-body-secondary mb-0"> -->
                        <p class="text-body-secondary mb-0">
<!-- Cette ligne contient: Répartition des matchs gagnés et perdus. -->
                            Répartition des matchs gagnés et perdus.
<!-- Cette ligne contient: </p> -->
                        </p>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: <div class="donut" -->
                    <div class="donut"
<!-- Cette ligne contient: role="img" -->
                        role="img"
<!-- Cette ligne contient: aria-label="Victoires <?php echo (int) $totalWins; ?>, défaites <?php echo (int) $totalLosses; ?>" -->
                        aria-label="Victoires <?php echo (int) $totalWins; ?>, défaites <?php echo (int) $totalLosses; ?>"
<!-- Cette ligne contient: data-wins="<?php echo (int) $totalWins; ?>" -->
                        data-wins="<?php echo (int) $totalWins; ?>"
<!-- Cette ligne contient: data-losses="<?php echo (int) $totalLosses; ?>"> -->
                        data-losses="<?php echo (int) $totalLosses; ?>">
<!-- Cette ligne contient: <div class="donut-center"> -->
                        <div class="donut-center">
<!-- Cette ligne contient: <span class="donut-label">Bilan</span> -->
                            <span class="donut-label">Bilan</span>
<!-- Cette ligne contient: <strong class="donut-value" data-record><?php echo htmlspecialchars($totalWins . ' - ' . $totalLosses); ?></strong> -->
                            <strong class="donut-value" data-record><?php echo htmlspecialchars($totalWins . ' - ' . $totalLosses); ?></strong>
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: <div class="donut-legend"> -->
                    <div class="donut-legend">
<!-- Cette ligne contient: <span><i class="legend-dot legend-wins"></i>Victoires</span> -->
                        <span><i class="legend-dot legend-wins"></i>Victoires</span>
<!-- Cette ligne contient: <span><i class="legend-dot legend-losses"></i>Défaites</span> -->
                        <span><i class="legend-dot legend-losses"></i>Défaites</span>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </article> -->
                </article>
<!-- Cette ligne contient: </div> -->
            </div>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </section> -->
    </section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="team-detail-section"> -->
    <section class="team-detail-section">
<!-- Cette ligne contient: <h2>Prochain match</h2> -->
        <h2>Prochain match</h2>
<!-- Cette ligne contient: <?php if ($nextMatch): ?> -->
        <?php if ($nextMatch): ?>
<!-- Cette ligne contient: <article class="match-highlight"> -->
            <article class="match-highlight">
<!-- Cette ligne contient: <div class="match-clubs"> -->
                <div class="match-clubs">
<!-- Cette ligne contient: <div class="match-team"> -->
                    <div class="match-team">
<!-- Cette ligne contient: <span><?php echo htmlspecialchars($nextMatch['teamHome'] ?? 'Domicile'); ?></span> -->
                        <span><?php echo htmlspecialchars($nextMatch['teamHome'] ?? 'Domicile'); ?></span>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: <span class="match-versus">VS</span> -->
                    <span class="match-versus">VS</span>
<!-- Cette ligne contient: <div class="match-team"> -->
                    <div class="match-team">
<!-- Cette ligne contient: <span><?php echo htmlspecialchars($nextMatch['teamAway'] ?? 'Extérieur'); ?></span> -->
                        <span><?php echo htmlspecialchars($nextMatch['teamAway'] ?? 'Extérieur'); ?></span>
<!-- Cette ligne contient: </div> -->
                    </div>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: <div class="match-details"> -->
                <div class="match-details">
<!-- Cette ligne contient: <p><?php echo htmlspecialchars($nextMatch['dateMatch'] ?? ''); ?><?php echo !empty($nextMatch['heureMatch']) ? ' · ' . htmlspecialchars($nextMatch['heureMatch']) : ''; ?> -->
                    <p><?php echo htmlspecialchars($nextMatch['dateMatch'] ?? ''); ?><?php echo !empty($nextMatch['heureMatch']) ? ' · ' . htmlspecialchars($nextMatch['heureMatch']) : ''; ?>
<!-- Cette ligne contient: </p> -->
                    </p>
<!-- Cette ligne contient: <p class="text-muted"><?php echo htmlspecialchars($nextMatch['lieuMatch'] ?? 'Lieu à confirmer'); ?></p> -->
                    <p class="text-muted"><?php echo htmlspecialchars($nextMatch['lieuMatch'] ?? 'Lieu à confirmer'); ?></p>
<!-- Cette ligne contient: </div> -->
                </div>
<!-- Cette ligne contient: </article> -->
            </article>
<!-- Cette ligne contient: <?php else: ?> -->
        <?php else: ?>
<!-- Cette ligne contient: <p class="text-muted">Aucun match à venir.</p> -->
            <p class="text-muted">Aucun match à venir.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
        <?php endif; ?>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php if (!empty($nextMatchOthers)): ?> -->
        <?php if (!empty($nextMatchOthers)): ?>
<!-- Cette ligne contient: <div class="match-upcoming"> -->
            <div class="match-upcoming">
<!-- Cette ligne contient: <?php foreach ($nextMatchOthers as $match): ?> -->
                <?php foreach ($nextMatchOthers as $match): ?>
<!-- Cette ligne contient: <article class="match-card"> -->
                    <article class="match-card">
<!-- Cette ligne contient: <p class="match-card-opponent"> -->
                        <p class="match-card-opponent">
<!-- Cette ligne contient: <?php echo htmlspecialchars(($match['teamHome'] ?? '') . ' vs ' . ($match['teamAway'] ?? '')); ?> -->
                            <?php echo htmlspecialchars(($match['teamHome'] ?? '') . ' vs ' . ($match['teamAway'] ?? '')); ?>
<!-- Cette ligne contient: </p> -->
                        </p>
<!-- Cette ligne contient: <p class="match-card-date"><?php echo htmlspecialchars($match['dateMatch'] ?? ''); ?></p> -->
                        <p class="match-card-date"><?php echo htmlspecialchars($match['dateMatch'] ?? ''); ?></p>
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

<!-- Cette ligne contient: <section class="team-detail-section"> -->
    <section class="team-detail-section">
<!-- Cette ligne contient: <h2>Staff technique</h2> -->
        <h2>Staff technique</h2>
<!-- Cette ligne contient: <div class="staff-grid"> -->
        <div class="staff-grid">
<!-- Cette ligne contient: <article class="staff-card"> -->
            <article class="staff-card">
<!-- Cette ligne contient: <h3>Coach principal</h3> -->
                <h3>Coach principal</h3>
<!-- Cette ligne contient: <?php if ($coachLead): ?> -->
                <?php if ($coachLead): ?>
<!-- Cette ligne contient: <p><?php echo htmlspecialchars($coachLead['prenomPersonnel'] . ' ' . $coachLead['nomPersonnel']); ?></p> -->
                    <p><?php echo htmlspecialchars($coachLead['prenomPersonnel'] . ' ' . $coachLead['nomPersonnel']); ?></p>
<!-- Cette ligne contient: <?php if (!empty($coachLead['libRolePersonnel'])): ?> -->
                    <?php if (!empty($coachLead['libRolePersonnel'])): ?>
<!-- Cette ligne contient: <p class="text-muted"><?php echo htmlspecialchars($coachLead['libRolePersonnel']); ?></p> -->
                        <p class="text-muted"><?php echo htmlspecialchars($coachLead['libRolePersonnel']); ?></p>
<!-- Cette ligne contient: <?php endif; ?> -->
                    <?php endif; ?>
<!-- Cette ligne contient: <?php else: ?> -->
                <?php else: ?>
<!-- Cette ligne contient: <p class="text-muted">Aucun coach renseigné.</p> -->
                    <p class="text-muted">Aucun coach renseigné.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
                <?php endif; ?>
<!-- Cette ligne contient: </article> -->
            </article>
<!-- Cette ligne contient: <article class="staff-card"> -->
            <article class="staff-card">
<!-- Cette ligne contient: <h3>Assistant</h3> -->
                <h3>Assistant</h3>
<!-- Cette ligne contient: <?php if (!empty($assistantCoaches)): ?> -->
                <?php if (!empty($assistantCoaches)): ?>
<!-- Cette ligne contient: <ul> -->
                    <ul>
<!-- Cette ligne contient: <?php foreach ($assistantCoaches as $assistant): ?> -->
                        <?php foreach ($assistantCoaches as $assistant): ?>
<!-- Cette ligne contient: <li><?php echo htmlspecialchars($assistant['prenomPersonnel'] . ' ' . $assistant['nomPersonnel']); ?> -->
                            <li><?php echo htmlspecialchars($assistant['prenomPersonnel'] . ' ' . $assistant['nomPersonnel']); ?>
<!-- Cette ligne contient: </li> -->
                            </li>
<!-- Cette ligne contient: <?php endforeach; ?> -->
                        <?php endforeach; ?>
<!-- Cette ligne contient: </ul> -->
                    </ul>
<!-- Cette ligne contient: <?php else: ?> -->
                <?php else: ?>
<!-- Cette ligne contient: <p class="text-muted">Aucun assistant renseigné.</p> -->
                    <p class="text-muted">Aucun assistant renseigné.</p>
<!-- Cette ligne contient: <?php endif; ?> -->
                <?php endif; ?>
<!-- Cette ligne contient: </article> -->
            </article>
<!-- Cette ligne contient: </div> -->
        </div>
<!-- Cette ligne contient: </section> -->
    </section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <section class="team-detail-section"> -->
    <section class="team-detail-section">
<!-- Cette ligne contient: <h2>Joueurs</h2> -->
        <h2>Joueurs</h2>
<!-- Cette ligne contient: <?php if (empty($players)): ?> -->
        <?php if (empty($players)): ?>
<!-- Cette ligne contient: <p class="text-muted">Aucun joueur renseigné.</p> -->
            <p class="text-muted">Aucun joueur renseigné.</p>
<!-- Cette ligne contient: <?php else: ?> -->
        <?php else: ?>
<!-- Cette ligne contient: <div class="players-grid"> -->
            <div class="players-grid">
<!-- Cette ligne contient: <?php foreach ($players as $player): ?> -->
                <?php foreach ($players as $player): ?>
<!-- Cette ligne contient: <?php -->
                    <?php
// Cette ligne contient: $playerPhoto = $player['urlPhotoJoueur'] ?? '';
                    $playerPhoto = $player['urlPhotoJoueur'] ?? '';
// Cette ligne contient: $playerPhotoUrl = '';
                    $playerPhotoUrl = '';
// Cette ligne contient: if (!empty($playerPhoto)) {
                    if (!empty($playerPhoto)) {
// Cette ligne contient: $playerPhotoUrl = preg_match('/^(https?:\/\/|\/)/', $playerPhoto)
                        $playerPhotoUrl = preg_match('/^(https?:\/\/|\/)/', $playerPhoto)
// Cette ligne contient: ? $playerPhoto
                            ? $playerPhoto
// Cette ligne contient: : ROOT_URL . '/src/uploads/' . $playerPhoto;
                            : ROOT_URL . '/src/uploads/' . $playerPhoto;
// Cette ligne contient: }
                    }
// Cette ligne contient: ?>
                    ?>
<!-- Cette ligne contient: <article class="player-card"> -->
                    <article class="player-card">
<!-- Cette ligne contient: <h3><?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?></h3> -->
                        <h3><?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?></h3>
<!-- Cette ligne contient: <div class="player-photo"> -->
                        <div class="player-photo">
<!-- Cette ligne contient: <?php if ($playerPhotoUrl): ?> -->
                            <?php if ($playerPhotoUrl): ?>
<!-- Cette ligne contient: <img src="<?php echo htmlspecialchars($playerPhotoUrl); ?>" -->
                                <img src="<?php echo htmlspecialchars($playerPhotoUrl); ?>"
<!-- Cette ligne contient: alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>" -->
                                    alt="<?php echo htmlspecialchars($player['prenomJoueur'] . ' ' . $player['nomJoueur']); ?>"
<!-- Cette ligne contient: loading="lazy"> -->
                                    loading="lazy">
<!-- Cette ligne contient: <?php else: ?> -->
                            <?php else: ?>
<!-- Cette ligne contient: <span class="player-photo-placeholder">Photo à venir</span> -->
                                <span class="player-photo-placeholder">Photo à venir</span>
<!-- Cette ligne contient: <?php endif; ?> -->
                            <?php endif; ?>
<!-- Cette ligne contient: </div> -->
                        </div>
<!-- Cette ligne contient: <?php if (!empty($player['posteJoueur'])): ?> -->
                        <?php if (!empty($player['posteJoueur'])): ?>
<!-- Cette ligne contient: <p class="text-muted"><?php echo htmlspecialchars(format_poste((int) $player['posteJoueur'])); ?></p> -->
                            <p class="text-muted"><?php echo htmlspecialchars(format_poste((int) $player['posteJoueur'])); ?></p>
<!-- Cette ligne contient: <?php endif; ?> -->
                        <?php endif; ?>
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
<!-- Cette ligne contient: </section> -->
</section>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <script> -->
<script>
<!-- Cette ligne contient: (function () { -->
    (function () {
<!-- Cette ligne contient: const lineCharts = document.querySelectorAll(".line-chart"); -->
        const lineCharts = document.querySelectorAll(".line-chart");
<!-- Cette ligne contient: lineCharts.forEach((chart) => { -->
        lineCharts.forEach((chart) => {
<!-- Cette ligne contient: const forValues = (chart.dataset["for"] || "") -->
            const forValues = (chart.dataset["for"] || "")
<!-- Cette ligne contient: .split(",") -->
                .split(",")
<!-- Cette ligne contient: .map((value) => Number.parseInt(value, 10)) -->
                .map((value) => Number.parseInt(value, 10))
<!-- Cette ligne contient: .filter((value) => Number.isFinite(value)); -->
                .filter((value) => Number.isFinite(value));
<!-- Cette ligne contient: const againstValues = (chart.dataset.against || "") -->
            const againstValues = (chart.dataset.against || "")
<!-- Cette ligne contient: .split(",") -->
                .split(",")
<!-- Cette ligne contient: .map((value) => Number.parseInt(value, 10)) -->
                .map((value) => Number.parseInt(value, 10))
<!-- Cette ligne contient: .filter((value) => Number.isFinite(value)); -->
                .filter((value) => Number.isFinite(value));
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const areaFor = chart.querySelector(".line-area-for"); -->
            const areaFor = chart.querySelector(".line-area-for");
<!-- Cette ligne contient: const areaAgainst = chart.querySelector(".line-area-against"); -->
            const areaAgainst = chart.querySelector(".line-area-against");
<!-- Cette ligne contient: const lineFor = chart.querySelector(".line-stroke-for"); -->
            const lineFor = chart.querySelector(".line-stroke-for");
<!-- Cette ligne contient: const lineAgainst = chart.querySelector(".line-stroke-against"); -->
            const lineAgainst = chart.querySelector(".line-stroke-against");
<!-- Cette ligne contient: const yLabelMax = chart.querySelector('.line-y-label[data-y="max"]'); -->
            const yLabelMax = chart.querySelector('.line-y-label[data-y="max"]');
<!-- Cette ligne contient: const yLabelMid = chart.querySelector('.line-y-label[data-y="mid"]'); -->
            const yLabelMid = chart.querySelector('.line-y-label[data-y="mid"]');
<!-- Cette ligne contient: const yLabelMin = chart.querySelector('.line-y-label[data-y="min"]'); -->
            const yLabelMin = chart.querySelector('.line-y-label[data-y="min"]');
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const hasFor = forValues.length > 0; -->
            const hasFor = forValues.length > 0;
<!-- Cette ligne contient: const hasAgainst = againstValues.length > 0; -->
            const hasAgainst = againstValues.length > 0;
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: if (!hasFor && !hasAgainst) { -->
            if (!hasFor && !hasAgainst) {
<!-- Cette ligne contient: chart.classList.add("is-empty"); -->
                chart.classList.add("is-empty");
<!-- Cette ligne contient: return; -->
                return;
<!-- Cette ligne contient: } -->
            }
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: chart.classList.remove("is-empty"); -->
            chart.classList.remove("is-empty");
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const allValues = [...forValues, ...againstValues]; -->
            const allValues = [...forValues, ...againstValues];
<!-- Cette ligne contient: const minValue = Math.min(...allValues); -->
            const minValue = Math.min(...allValues);
<!-- Cette ligne contient: const maxValue = Math.max(...allValues); -->
            const maxValue = Math.max(...allValues);
<!-- Cette ligne contient: const range = Math.max(1, maxValue - minValue); -->
            const range = Math.max(1, maxValue - minValue);
<!-- Cette ligne contient: const height = 60; -->
            const height = 60;
<!-- Cette ligne contient: const width = 100; -->
            const width = 100;
<!-- Cette ligne contient: const paddingTop = 6; -->
            const paddingTop = 6;
<!-- Cette ligne contient: const paddingBottom = 8; -->
            const paddingBottom = 8;
<!-- Cette ligne contient: const usableHeight = height - paddingTop - paddingBottom; -->
            const usableHeight = height - paddingTop - paddingBottom;
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const buildPath = (values) => { -->
            const buildPath = (values) => {
<!-- Cette ligne contient: const count = values.length; -->
                const count = values.length;
<!-- Cette ligne contient: if (count === 0) { -->
                if (count === 0) {
<!-- Cette ligne contient: return { line: "", area: "" }; -->
                    return { line: "", area: "" };
<!-- Cette ligne contient: } -->
                }
<!-- Cette ligne contient: const points = values.map((value, index) => { -->
                const points = values.map((value, index) => {
<!-- Cette ligne contient: const x = count === 1 ? width / 2 : (index / (count - 1)) * width; -->
                    const x = count === 1 ? width / 2 : (index / (count - 1)) * width;
<!-- Cette ligne contient: const y = paddingTop + ((maxValue - value) / range) * usableHeight; -->
                    const y = paddingTop + ((maxValue - value) / range) * usableHeight;
<!-- Cette ligne contient: return [x, y]; -->
                    return [x, y];
<!-- Cette ligne contient: }); -->
                });
<!-- Cette ligne contient: const linePath = points -->
                const linePath = points
<!-- Cette ligne contient: .map((point, index) => `${index === 0 ? "M" : "L"} ${point[0].toFixed(2)} ${point[1].toFixed(2)}`) -->
                    .map((point, index) => `${index === 0 ? "M" : "L"} ${point[0].toFixed(2)} ${point[1].toFixed(2)}`)
<!-- Cette ligne contient: .join(" "); -->
                    .join(" ");
<!-- Cette ligne contient: const baseline = height - paddingBottom; -->
                const baseline = height - paddingBottom;
<!-- Cette ligne contient: const areaPath = `M ${points[0][0].toFixed(2)} ${baseline.toFixed(2)} ${points -->
                const areaPath = `M ${points[0][0].toFixed(2)} ${baseline.toFixed(2)} ${points
<!-- Cette ligne contient: .map((point) => `L ${point[0].toFixed(2)} ${point[1].toFixed(2)}`) -->
                    .map((point) => `L ${point[0].toFixed(2)} ${point[1].toFixed(2)}`)
<!-- Cette ligne contient: .join(" ")} L ${points[points.length - 1][0].toFixed(2)} ${baseline.toFixed(2)} Z`; -->
                    .join(" ")} L ${points[points.length - 1][0].toFixed(2)} ${baseline.toFixed(2)} Z`;
<!-- Cette ligne contient: return { line: linePath, area: areaPath }; -->
                return { line: linePath, area: areaPath };
<!-- Cette ligne contient: }; -->
            };
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: if (areaFor && lineFor) { -->
            if (areaFor && lineFor) {
<!-- Cette ligne contient: const paths = buildPath(forValues); -->
                const paths = buildPath(forValues);
<!-- Cette ligne contient: lineFor.setAttribute("d", paths.line); -->
                lineFor.setAttribute("d", paths.line);
<!-- Cette ligne contient: areaFor.setAttribute("d", paths.area); -->
                areaFor.setAttribute("d", paths.area);
<!-- Cette ligne contient: } -->
            }
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: if (areaAgainst && lineAgainst) { -->
            if (areaAgainst && lineAgainst) {
<!-- Cette ligne contient: const paths = buildPath(againstValues); -->
                const paths = buildPath(againstValues);
<!-- Cette ligne contient: lineAgainst.setAttribute("d", paths.line); -->
                lineAgainst.setAttribute("d", paths.line);
<!-- Cette ligne contient: areaAgainst.setAttribute("d", paths.area); -->
                areaAgainst.setAttribute("d", paths.area);
<!-- Cette ligne contient: } -->
            }
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const midValue = Math.round((minValue + maxValue) / 2); -->
            const midValue = Math.round((minValue + maxValue) / 2);
<!-- Cette ligne contient: if (yLabelMax) { -->
            if (yLabelMax) {
<!-- Cette ligne contient: yLabelMax.textContent = maxValue.toLocaleString("fr-FR"); -->
                yLabelMax.textContent = maxValue.toLocaleString("fr-FR");
<!-- Cette ligne contient: } -->
            }
<!-- Cette ligne contient: if (yLabelMid) { -->
            if (yLabelMid) {
<!-- Cette ligne contient: yLabelMid.textContent = midValue.toLocaleString("fr-FR"); -->
                yLabelMid.textContent = midValue.toLocaleString("fr-FR");
<!-- Cette ligne contient: } -->
            }
<!-- Cette ligne contient: if (yLabelMin) { -->
            if (yLabelMin) {
<!-- Cette ligne contient: yLabelMin.textContent = minValue.toLocaleString("fr-FR"); -->
                yLabelMin.textContent = minValue.toLocaleString("fr-FR");
<!-- Cette ligne contient: } -->
            }
<!-- Cette ligne contient: }); -->
        });
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const donuts = document.querySelectorAll(".donut"); -->
        const donuts = document.querySelectorAll(".donut");
<!-- Cette ligne contient: donuts.forEach((donut) => { -->
        donuts.forEach((donut) => {
<!-- Cette ligne contient: const wins = Number.parseInt(donut.dataset.wins || "0", 10) || 0; -->
            const wins = Number.parseInt(donut.dataset.wins || "0", 10) || 0;
<!-- Cette ligne contient: const losses = Number.parseInt(donut.dataset.losses || "0", 10) || 0; -->
            const losses = Number.parseInt(donut.dataset.losses || "0", 10) || 0;
<!-- Cette ligne contient: const total = Math.max(wins + losses, 1); -->
            const total = Math.max(wins + losses, 1);
<!-- Cette ligne contient: const winAngle = Math.round((wins / total) * 360); -->
            const winAngle = Math.round((wins / total) * 360);
<!-- Cette ligne contient: donut.style.setProperty("- -win-angle", `${winAngle}deg`); -->
            donut.style.setProperty("--win-angle", `${winAngle}deg`);
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: const recordValue = donut.querySelector("[data-record]"); -->
            const recordValue = donut.querySelector("[data-record]");
<!-- Cette ligne contient: if (recordValue) { -->
            if (recordValue) {
<!-- Cette ligne contient: recordValue.textContent = `${wins} - ${losses}`; -->
                recordValue.textContent = `${wins} - ${losses}`;
<!-- Cette ligne contient: } -->
            }
<!-- Cette ligne contient: }); -->
        });
<!-- Cette ligne contient: })(); -->
    })();
<!-- Cette ligne contient: </script> -->
</script>
<!-- Ligne vide pour aération. -->

<!-- Cette ligne contient: <?php -->
<?php
// Cette ligne contient: require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
// Cette ligne contient: ?>
?>
