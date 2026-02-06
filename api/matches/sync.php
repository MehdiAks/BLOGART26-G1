<?php
/*
 * Endpoint API: api/matches/sync.php
 * Rôle: synchroniser une liste de matchs (JSON) vers la base de données.
 *
 * Déroulé détaillé:
 * 1) Charge la configuration et les helpers nécessaires pour les équipes/statistiques.
 * 2) Vérifie le token de synchronisation (MATCHES_SYNC_TOKEN) si défini.
 * 3) Récupère le JSON soit depuis le body POST, soit depuis un flux distant (FFBB_MATCHES_FEED).
 * 4) Normalise chaque match (dates/équipes/compétition) et crée les références manquantes.
 * 5) Insère le match et ses participants, puis retourne un bilan JSON (importés/sautés).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/equipe_stats.php';

header('Content-Type: application/json; charset=utf-8');

// Étape 1: sécuriser l'accès via un token partagé (si configuré).
$expectedToken = getenv('MATCHES_SYNC_TOKEN');
$providedToken = $_GET['token'] ?? '';
if (!empty($expectedToken) && !hash_equals($expectedToken, $providedToken)) {
    http_response_code(403);
    echo json_encode(['error' => 'Token invalide.']);
    exit;
}

function fetch_remote_payload(string $url): ?string
{
    // Préparer un contexte HTTP avec timeout et User-Agent explicite.
    $context = stream_context_create([
        'http' => [
            'timeout' => 15,
            'header' => "User-Agent: Mozilla/5.0 (compatible; BECBot/1.0)\r\n",
        ],
    ]);

    $payload = @file_get_contents($url, false, $context);
    if ($payload !== false) {
        return $payload;
    }

    return null;
}

function parse_date_and_time(?string $dateRaw, ?string $timeRaw): array
{
    // Normaliser la date/heure et retourner un tuple [date, heure] ou [null, null].
    $dateRaw = trim((string) $dateRaw);
    $timeRaw = trim((string) $timeRaw);

    if ($dateRaw === '') {
        return [null, null];
    }

    $hasTime = $timeRaw !== '' || preg_match('/\d{1,2}:\d{2}/', $dateRaw) === 1;
    $timestamp = strtotime(trim($dateRaw . ' ' . $timeRaw));
    if ($timestamp === false) {
        return [null, null];
    }

    $date = date('Y-m-d', $timestamp);
    $time = $hasTime ? date('H:i:s', $timestamp) : null;

    return [$date, $time];
}

function normalize_match(array $item): ?array
{
    // Harmoniser les clés attendues (home/away/competition/etc.) en tenant compte des variantes.
    $home = trim((string) ($item['home'] ?? $item['homeTeam'] ?? $item['teamHome'] ?? $item['domicile'] ?? ''));
    $away = trim((string) ($item['away'] ?? $item['awayTeam'] ?? $item['teamAway'] ?? $item['exterieur'] ?? ''));
    $competition = trim((string) ($item['competition'] ?? $item['league'] ?? $item['championship'] ?? ''));
    $location = trim((string) ($item['location'] ?? $item['gym'] ?? $item['salle'] ?? ''));
    $status = trim((string) ($item['phase'] ?? $item['status'] ?? $item['etat'] ?? ''));
    $scoreHome = isset($item['scoreHome']) ? (int) $item['scoreHome'] : (isset($item['score_dom']) ? (int) $item['score_dom'] : null);
    $scoreAway = isset($item['scoreAway']) ? (int) $item['scoreAway'] : (isset($item['score_ext']) ? (int) $item['score_ext'] : null);
    $section = trim((string) ($item['section'] ?? $item['category'] ?? $item['teamSection'] ?? ''));
    $journee = trim((string) ($item['journee'] ?? $item['matchDay'] ?? $item['day'] ?? ''));

    [$matchDate, $matchTime] = parse_date_and_time($item['date'] ?? $item['matchDate'] ?? null, $item['time'] ?? $item['matchTime'] ?? null);

    if ($home === '' || $away === '' || $matchDate === null) {
        return null;
    }

    $journeeValue = $journee;
    if ($journeeValue !== '' && preg_match('/^j/i', $journeeValue) !== 1) {
        $journeeValue = 'J' . $journeeValue;
    }

    return [
        'home' => $home,
        'away' => $away,
        'competition' => $competition !== '' ? $competition : 'Compétition FFBB',
        'phase' => $status !== '' ? $status : 'Saison régulière',
        'journee' => $journeeValue,
        'matchDate' => $matchDate,
        'matchTime' => $matchTime,
        'location' => $location,
        'scoreHome' => $scoreHome,
        'scoreAway' => $scoreAway,
        'section' => $section,
    ];
}

function ensure_reference(PDO $DB, string $table, string $labelColumn, string $value): int
{
    // Obtenir l'identifiant d'une table de référence (ou l'insérer si absent).
    $stmt = $DB->prepare("SELECT {$table}.{$table === 'SAISON' ? 'numSaison' : 'num' . ucfirst(strtolower(str_replace('_', '', $table)))} FROM {$table} WHERE {$labelColumn} = :label LIMIT 1");
    $stmt->execute([':label' => $value]);
    $found = $stmt->fetchColumn();
    if ($found !== false) {
        return (int) $found;
    }

    $insert = $DB->prepare("INSERT INTO {$table} ({$labelColumn}) VALUES (:label)");
    $insert->execute([':label' => $value]);

    return (int) $DB->lastInsertId();
}

function get_or_create_club(PDO $DB, string $clubName): int
{
    // Récupérer ou créer un club (avec un flag club maison basé sur le nom).
    $stmt = $DB->prepare('SELECT numClub FROM CLUB WHERE nomClub = :name LIMIT 1');
    $stmt->execute([':name' => $clubName]);
    $existing = $stmt->fetchColumn();
    if ($existing !== false) {
        return (int) $existing;
    }

    $isHomeClub = stripos($clubName, 'bec') !== false || stripos($clubName, 'bordeaux') !== false;
    $insert = $DB->prepare('INSERT INTO CLUB (nomClub, estClubMaison) VALUES (:name, :isHome)');
    $insert->execute([
        ':name' => $clubName,
        ':isHome' => $isHomeClub ? 1 : 0,
    ]);

    return (int) $DB->lastInsertId();
}

function slugify_code(string $value): string
{
    $normalized = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
    if ($normalized === false) {
        $normalized = $value;
    }
    $normalized = preg_replace('/[^a-zA-Z0-9]+/', '-', (string) $normalized);
    $normalized = strtoupper(trim((string) $normalized, '-'));
    return $normalized !== '' ? $normalized : 'EQUIPE';
}

function get_or_create_team(PDO $DB, int $numClub, string $teamName, ?string $teamCode, ?string $sectionLabel): int
{
    // Récupérer ou créer une équipe liée à un club et ses références (catégorie/section/niveau).
    $code = $teamCode !== null && $teamCode !== '' ? strtoupper($teamCode) : slugify_code($teamName);

    $stmt = $DB->prepare('SELECT numEquipe FROM EQUIPE WHERE numClub = :numClub AND codeEquipe = :code LIMIT 1');
    $stmt->execute([
        ':numClub' => $numClub,
        ':code' => $code,
    ]);
    $existing = $stmt->fetchColumn();
    if ($existing !== false) {
        return (int) $existing;
    }

    $categorieId = ensure_reference($DB, 'CATEGORIE_EQUIPE', 'libCategorie', 'Non renseigné');
    $sectionLabel = $sectionLabel !== null && $sectionLabel !== '' ? $sectionLabel : 'Non renseigné';
    $sectionId = ensure_reference($DB, 'SECTION_EQUIPE', 'libSection', $sectionLabel);
    $niveauId = ensure_reference($DB, 'NIVEAU_EQUIPE', 'libNiveau', 'Non renseigné');

    $insert = $DB->prepare(
        'INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau)
         VALUES (:numClub, :codeEquipe, :libEquipe, :libEquipeComplet, :numCategorie, :numSection, :numNiveau)'
    );
    $insert->execute([
        ':numClub' => $numClub,
        ':codeEquipe' => $code,
        ':libEquipe' => $teamName,
        ':libEquipeComplet' => $teamName,
        ':numCategorie' => $categorieId,
        ':numSection' => $sectionId,
        ':numNiveau' => $niveauId,
    ]);

    return (int) $DB->lastInsertId();
}

function get_current_season(PDO $DB): int
{
    // Retourner la saison courante ou en créer une si absente.
    $stmt = $DB->query('SELECT numSaison FROM SAISON WHERE estCourante = 1 ORDER BY dateDebut DESC LIMIT 1');
    $season = $stmt->fetchColumn();
    if ($season !== false) {
        return (int) $season;
    }

    $year = (int) date('Y');
    $label = $year . '-' . ($year + 1);
    $insert = $DB->prepare('INSERT INTO SAISON (libSaison, estCourante) VALUES (:label, 1)');
    $insert->execute([':label' => $label]);

    return (int) $DB->lastInsertId();
}

function get_or_create_competition(PDO $DB, int $numSaison, string $label): int
{
    // Retourner la compétition correspondante (par saison) ou l'insérer.
    $stmt = $DB->prepare('SELECT numCompetition FROM COMPETITION WHERE numSaison = :numSaison AND libCompetition = :label LIMIT 1');
    $stmt->execute([':numSaison' => $numSaison, ':label' => $label]);
    $found = $stmt->fetchColumn();
    if ($found !== false) {
        return (int) $found;
    }

    $insert = $DB->prepare('INSERT INTO COMPETITION (numSaison, libCompetition) VALUES (:numSaison, :label)');
    $insert->execute([':numSaison' => $numSaison, ':label' => $label]);

    return (int) $DB->lastInsertId();
}

function get_or_create_phase(PDO $DB, int $numCompetition, string $label): int
{
    // Retourner la phase de compétition correspondante ou la créer.
    $stmt = $DB->prepare('SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = :numCompetition AND libPhase = :label LIMIT 1');
    $stmt->execute([':numCompetition' => $numCompetition, ':label' => $label]);
    $found = $stmt->fetchColumn();
    if ($found !== false) {
        return (int) $found;
    }

    $insert = $DB->prepare('INSERT INTO PHASE_COMPETITION (numCompetition, libPhase) VALUES (:numCompetition, :label)');
    $insert->execute([':numCompetition' => $numCompetition, ':label' => $label]);

    return (int) $DB->lastInsertId();
}

function get_or_create_journee(PDO $DB, int $numPhase, string $journee): int
{
    // Retourner la journée correspondante (par libellé/numéro) ou la créer.
    $numero = null;
    if (preg_match('/\d+/', $journee, $matches)) {
        $numero = (int) $matches[0];
    }

    $stmt = $DB->prepare('SELECT numJournee FROM JOURNEE WHERE numPhase = :numPhase AND (libJournee = :libJournee OR numeroJournee = :numero) LIMIT 1');
    $stmt->execute([
        ':numPhase' => $numPhase,
        ':libJournee' => $journee,
        ':numero' => $numero,
    ]);
    $found = $stmt->fetchColumn();
    if ($found !== false) {
        return (int) $found;
    }

    $insert = $DB->prepare('INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee) VALUES (:numPhase, :libJournee, :numero)');
    $insert->execute([
        ':numPhase' => $numPhase,
        ':libJournee' => $journee,
        ':numero' => $numero,
    ]);

    return (int) $DB->lastInsertId();
}

$payload = null;

// Étape 2: tenter de lire un JSON envoyé dans le body POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawPayload = file_get_contents('php://input');
    if ($rawPayload) {
        $payload = json_decode($rawPayload, true);
    }
}

// Étape 3: fallback sur un flux distant configuré via FFBB_MATCHES_FEED.
if ($payload === null) {
    $feedUrl = getenv('FFBB_MATCHES_FEED');
    if (!empty($feedUrl)) {
        $remotePayload = fetch_remote_payload($feedUrl);
        if ($remotePayload !== null) {
            $payload = json_decode($remotePayload, true);
        }
    }
}

if ($payload === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucune donnée reçue. Fournissez un JSON ou configurez FFBB_MATCHES_FEED.']);
    exit;
}

$matches = $payload['matches'] ?? $payload['data'] ?? $payload;
if (!is_array($matches)) {
    http_response_code(400);
    echo json_encode(['error' => 'Le JSON ne contient pas de liste de matchs exploitable.']);
    exit;
}

// Étape 4: ouverture de la connexion DB pour les insertions.
sql_connect();

$inserted = 0;
$skipped = 0;

// Étape 5: normaliser et importer chaque match un par un.
foreach ($matches as $matchItem) {
    if (!is_array($matchItem)) {
        $skipped++;
        continue;
    }

    $normalized = normalize_match($matchItem);
    if ($normalized === null) {
        $skipped++;
        continue;
    }

    $numSaison = get_current_season($DB);
    $numCompetition = get_or_create_competition($DB, $numSaison, $normalized['competition']);
    $numPhase = get_or_create_phase($DB, $numCompetition, $normalized['phase']);
    $numJournee = $normalized['journee'] !== '' ? get_or_create_journee($DB, $numPhase, $normalized['journee']) : null;

    $clubHome = get_or_create_club($DB, $normalized['home']);
    $clubAway = get_or_create_club($DB, $normalized['away']);

    $teamCode = $normalized['section'] !== '' ? $normalized['section'] : null;
    $sectionLabel = $normalized['section'] !== '' ? $normalized['section'] : null;

    $teamHome = get_or_create_team($DB, $clubHome, $normalized['home'], $teamCode, $sectionLabel);
    $teamAway = get_or_create_team($DB, $clubAway, $normalized['away'], null, $sectionLabel);

    $matchStmt = $DB->prepare(
        'INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
         VALUES (:numSaison, :numCompetition, :numPhase, :numJournee, :dateMatch, :heureMatch, :lieuMatch)'
    );
    $matchStmt->execute([
        ':numSaison' => $numSaison,
        ':numCompetition' => $numCompetition,
        ':numPhase' => $numPhase,
        ':numJournee' => $numJournee,
        ':dateMatch' => $normalized['matchDate'],
        ':heureMatch' => $normalized['matchTime'],
        ':lieuMatch' => $normalized['location'] !== '' ? $normalized['location'] : null,
    ]);

    $numMatch = (int) $DB->lastInsertId();

    $participantStmt = $DB->prepare(
        'INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score)
         VALUES (:numMatch, :numEquipe, :cote, :score)'
    );
    $participantStmt->execute([
        ':numMatch' => $numMatch,
        ':numEquipe' => $teamHome,
        ':cote' => 'domicile',
        ':score' => $normalized['scoreHome'],
    ]);
    $participantStmt->execute([
        ':numMatch' => $numMatch,
        ':numEquipe' => $teamAway,
        ':cote' => 'exterieur',
        ':score' => $normalized['scoreAway'],
    ]);

    $inserted++;
}

// Étape 6: retourner le bilan d'import JSON.
echo json_encode([
    'imported' => $inserted,
    'skipped' => $skipped,
]);
