<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/equipe_stats.php';

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

function resolve_match_side(string $home, string $away): array
{
    $clubIdentifiers = [
        'bec',
        'bordeaux',
        'etudiant',
    ];

    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($home, $identifier) !== false) {
            return [
                'team' => $home,
                'opponent' => $away,
                'location' => 'Domicile',
            ];
        }
    }

    foreach ($clubIdentifiers as $identifier) {
        if ($identifier !== '' && stripos($away, $identifier) !== false) {
            return [
                'team' => $away,
                'opponent' => $home,
                'location' => 'Extérieur',
            ];
        }
    }

    return [
        'team' => $home,
        'opponent' => $away,
        'location' => 'Domicile',
    ];
}

function normalize_match(array $item): ?array
{
    $home = trim((string) ($item['home'] ?? $item['homeTeam'] ?? $item['teamHome'] ?? $item['domicile'] ?? ''));
    $away = trim((string) ($item['away'] ?? $item['awayTeam'] ?? $item['teamAway'] ?? $item['exterieur'] ?? ''));
    $competition = trim((string) ($item['competition'] ?? $item['league'] ?? $item['championship'] ?? ''));
    $location = trim((string) ($item['location'] ?? $item['gym'] ?? $item['salle'] ?? ''));
    $status = trim((string) ($item['phase'] ?? $item['status'] ?? $item['etat'] ?? ''));
    $scoreHome = isset($item['scoreHome']) ? (int) $item['scoreHome'] : (isset($item['score_dom']) ? (int) $item['score_dom'] : null);
    $scoreAway = isset($item['scoreAway']) ? (int) $item['scoreAway'] : (isset($item['score_ext']) ? (int) $item['score_ext'] : null);
    $sourceUrl = trim((string) ($item['url'] ?? $item['sourceUrl'] ?? ''));
    $sourceId = trim((string) ($item['id'] ?? $item['matchId'] ?? $item['uid'] ?? ''));
    $section = trim((string) ($item['section'] ?? $item['category'] ?? $item['teamSection'] ?? ''));
    $journee = trim((string) ($item['journee'] ?? $item['matchDay'] ?? $item['day'] ?? ''));

    [$matchDate, $matchTime] = parse_date_and_time($item['date'] ?? $item['matchDate'] ?? null, $item['time'] ?? $item['matchTime'] ?? null);

    if ($home === '' || $away === '' || $matchDate === null) {
        return null;
    }

    if ($sourceId === '') {
        $sourceId = sha1($competition . '|' . $matchDate . '|' . ($matchTime ?? '') . '|' . $home . '|' . $away);
    }

    $resolved = resolve_match_side($home, $away);
    $locationValue = $location !== '' ? $location : $resolved['location'];
    $team = $resolved['team'];
    $opponent = $resolved['opponent'];

    $scoreBec = $scoreHome;
    $scoreOpponent = $scoreAway;
    if (strtolower($locationValue) === 'extérieur' || strtolower($locationValue) === 'exterieur') {
        $scoreBec = $scoreAway;
        $scoreOpponent = $scoreHome;
    }

    $sectionValue = $section;
    if ($sectionValue === '') {
        $haystack = strtolower($team . ' ' . $competition);
        $sectionValue = (str_contains($haystack, 'féminin') || str_contains($haystack, 'feminin') || str_contains($haystack, 'sf'))
            ? 'Féminin'
            : 'Masculin';
    }

    $journeeValue = $journee;
    if ($journeeValue !== '' && preg_match('/^j/i', $journeeValue) !== 1) {
        $journeeValue = 'J' . $journeeValue;
    }

    $matchNo = (int) ($item['matchNo'] ?? $item['matchNumber'] ?? $item['MatchNo'] ?? $item['match_id'] ?? 0);
    if ($matchNo <= 0) {
        $matchNo = abs(crc32($sourceId));
    }

    return [
        'sourceId' => $sourceId,
        'section' => $sectionValue,
        'competition' => $competition !== '' ? $competition : 'Compétition FFBB',
        'phase' => $status !== '' ? $status : 'Saison régulière',
        'journee' => $journeeValue,
        'matchDate' => $matchDate,
        'matchTime' => $matchTime ?? '00:00:00',
        'location' => $locationValue,
        'team' => $team,
        'opponent' => $opponent,
        'scoreBec' => $scoreBec,
        'scoreOpponent' => $scoreOpponent,
        'sourceUrl' => $sourceUrl !== '' ? $sourceUrl : $sourceId,
        'matchNo' => $matchNo,
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
    'INSERT INTO bec_matches (Section, numEquipe, Equipe, Competition, Phase, Journee, Date, Heure, Domicile_Exterieur, Adversaire, Score_BEC, Score_Adversaire, MatchNo, Source)
     VALUES (:section, :numEquipe, :team, :competition, :phase, :journee, :matchDate, :matchTime, :location, :opponent, :scoreBec, :scoreOpponent, :matchNo, :sourceUrl)
     ON DUPLICATE KEY UPDATE
        Section = VALUES(Section),
        numEquipe = VALUES(numEquipe),
        Equipe = VALUES(Equipe),
        Competition = VALUES(Competition),
        Phase = VALUES(Phase),
        Journee = VALUES(Journee),
        Date = VALUES(Date),
        Heure = VALUES(Heure),
        Domicile_Exterieur = VALUES(Domicile_Exterieur),
        Adversaire = VALUES(Adversaire),
        Score_BEC = VALUES(Score_BEC),
        Score_Adversaire = VALUES(Score_Adversaire),
        Source = VALUES(Source)'
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

    $numEquipe = null;
    if (!empty($normalized['section'])) {
        $numEquipe = ba_bec_resolve_equipe_id_from_section($normalized['section']);
    }

    $stmt->execute([
        ':section' => $normalized['section'],
        ':numEquipe' => $numEquipe,
        ':team' => $normalized['team'],
        ':competition' => $normalized['competition'],
        ':phase' => $normalized['phase'],
        ':journee' => $normalized['journee'],
        ':matchDate' => $normalized['matchDate'],
        ':matchTime' => $normalized['matchTime'],
        ':location' => $normalized['location'],
        ':opponent' => $normalized['opponent'],
        ':scoreBec' => $normalized['scoreBec'],
        ':scoreOpponent' => $normalized['scoreOpponent'],
        ':matchNo' => $normalized['matchNo'],
        ':sourceUrl' => $normalized['sourceUrl'],
    ]);

    $inserted++;
}

echo json_encode([
    'imported' => $inserted,
    'skipped' => $skipped,
]);
