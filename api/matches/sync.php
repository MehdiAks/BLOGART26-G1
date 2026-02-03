<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

header('Content-Type: application/json; charset=utf-8');

$expectedToken = getenv('MATCHES_SYNC_TOKEN');
$providedToken = $_GET['token'] ?? '';
if (!empty($expectedToken) && !hash_equals($expectedToken, $providedToken)) {
    http_response_code(403);
    echo json_encode(['error' => 'Token invalide.']);
    exit;
}

function fetch_remote_payload(string $url): ?string
{
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
    $home = trim((string) ($item['home'] ?? $item['homeTeam'] ?? $item['teamHome'] ?? $item['domicile'] ?? ''));
    $away = trim((string) ($item['away'] ?? $item['awayTeam'] ?? $item['teamAway'] ?? $item['exterieur'] ?? ''));
    $competition = trim((string) ($item['competition'] ?? $item['league'] ?? $item['championship'] ?? ''));
    $location = trim((string) ($item['location'] ?? $item['gym'] ?? $item['salle'] ?? ''));
    $status = trim((string) ($item['status'] ?? $item['etat'] ?? ''));
    $scoreHome = isset($item['scoreHome']) ? (int) $item['scoreHome'] : (isset($item['score_dom']) ? (int) $item['score_dom'] : null);
    $scoreAway = isset($item['scoreAway']) ? (int) $item['scoreAway'] : (isset($item['score_ext']) ? (int) $item['score_ext'] : null);
    $sourceUrl = trim((string) ($item['url'] ?? $item['sourceUrl'] ?? ''));
    $sourceId = trim((string) ($item['id'] ?? $item['matchId'] ?? $item['uid'] ?? ''));

    [$matchDate, $matchTime] = parse_date_and_time($item['date'] ?? $item['matchDate'] ?? null, $item['time'] ?? $item['matchTime'] ?? null);

    if ($home === '' || $away === '' || $matchDate === null) {
        return null;
    }

    if ($sourceId === '') {
        $sourceId = sha1($competition . '|' . $matchDate . '|' . ($matchTime ?? '') . '|' . $home . '|' . $away);
    }

    return [
        'sourceId' => $sourceId,
        'competition' => $competition !== '' ? $competition : 'Compétition FFBB',
        'matchDate' => $matchDate,
        'matchTime' => $matchTime,
        'teamHome' => $home,
        'teamAway' => $away,
        'location' => $location !== '' ? $location : null,
        'status' => $status !== '' ? $status : null,
        'scoreHome' => $scoreHome,
        'scoreAway' => $scoreAway,
        'sourceUrl' => $sourceUrl !== '' ? $sourceUrl : null,
    ];
}

$payload = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawPayload = file_get_contents('php://input');
    if ($rawPayload) {
        $payload = json_decode($rawPayload, true);
    }
}

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

sql_connect();

$stmt = $DB->prepare(
    'INSERT INTO MATCH_CLUB (sourceId, competition, matchDate, matchTime, teamHome, teamAway, location, status, scoreHome, scoreAway, sourceUrl)
     VALUES (:sourceId, :competition, :matchDate, :matchTime, :teamHome, :teamAway, :location, :status, :scoreHome, :scoreAway, :sourceUrl)
     ON DUPLICATE KEY UPDATE
        competition = VALUES(competition),
        matchDate = VALUES(matchDate),
        matchTime = VALUES(matchTime),
        teamHome = VALUES(teamHome),
        teamAway = VALUES(teamAway),
        location = VALUES(location),
        status = VALUES(status),
        scoreHome = VALUES(scoreHome),
        scoreAway = VALUES(scoreAway),
        sourceUrl = VALUES(sourceUrl),
        dtMajMatch = CURRENT_TIMESTAMP'
);

$inserted = 0;
$skipped = 0;

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

    $stmt->execute([
        ':sourceId' => $normalized['sourceId'],
        ':competition' => $normalized['competition'],
        ':matchDate' => $normalized['matchDate'],
        ':matchTime' => $normalized['matchTime'],
        ':teamHome' => $normalized['teamHome'],
        ':teamAway' => $normalized['teamAway'],
        ':location' => $normalized['location'],
        ':status' => $normalized['status'],
        ':scoreHome' => $normalized['scoreHome'],
        ':scoreAway' => $normalized['scoreAway'],
        ':sourceUrl' => $normalized['sourceUrl'],
    ]);

    $inserted++;
}

echo json_encode([
    'imported' => $inserted,
    'skipped' => $skipped,
]);
