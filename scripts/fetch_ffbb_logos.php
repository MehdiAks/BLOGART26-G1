<?php

declare(strict_types=1);

$defaultTeams = [
    'senior-1' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983',
    'senior-2' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117',
    'senior-3-phase-reguliere' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647',
    'senior-3-playoff' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420',
    'senior-4-phase-reguliere' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778',
    'senior-4-playoff' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439',
    'sf1' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512',
    'sf2' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159',
    'sf3-phase-reguliere' => 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370',
];

$options = parse_cli_options($argv);
$teams = $options['teams'] ?: $defaultTeams;
$outputDir = $options['output'] ?: dirname(__DIR__) . '/src/images/ffbb-logos';

if (!is_dir($outputDir) && !mkdir($outputDir, 0775, true) && !is_dir($outputDir)) {
    fwrite(STDERR, "Impossible de créer le dossier de sortie: {$outputDir}" . PHP_EOL);
    exit(1);
}

$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36';
$logoKeywords = '/logo|emblem|blason|club/i';
$downloaded = [];

foreach ($teams as $slug => $url) {
    $html = fetch_html($url, $userAgent);
    if ($html === null) {
        fwrite(STDERR, "[{$slug}] échec de récupération: {$url}" . PHP_EOL);
        continue;
    }

    $imageUrls = extract_image_urls($html, $url);
    if ($imageUrls === []) {
        fwrite(STDERR, "[{$slug}] aucune image trouvée: {$url}" . PHP_EOL);
        continue;
    }

    $logoUrls = array_values(array_filter($imageUrls, static function (array $image) use ($logoKeywords): bool {
        $haystack = implode(' ', [$image['src'], $image['alt'], $image['class']]);
        return (bool) preg_match($logoKeywords, $haystack);
    }));

    if ($logoUrls === []) {
        $logoUrls = $imageUrls;
        fwrite(STDERR, "[{$slug}] aucun logo détecté, téléchargement de toutes les images." . PHP_EOL);
    }

    foreach ($logoUrls as $image) {
        $imageUrl = $image['src'];
        if (isset($downloaded[$imageUrl])) {
            continue;
        }
        $downloaded[$imageUrl] = true;

        $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION);
        $extension = $extension !== '' ? $extension : 'png';
        $filename = "{$slug}-" . substr(sha1($imageUrl), 0, 10) . ".{$extension}";
        $destination = "{$outputDir}/{$filename}";

        $bytes = download_file($imageUrl, $destination, $userAgent);
        if ($bytes === null) {
            fwrite(STDERR, "[{$slug}] échec de téléchargement: {$imageUrl}" . PHP_EOL);
            continue;
        }
        fwrite(STDOUT, "[{$slug}] logo enregistré: {$destination}" . PHP_EOL);
    }
}

function fetch_html(string $url, string $userAgent): ?string
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => $userAgent,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_HTTPHEADER => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ],
    ]);
    $html = curl_exec($ch);
    $error = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($html === false || $status >= 400) {
        fwrite(STDERR, "Erreur HTTP {$status} pour {$url}. {$error}" . PHP_EOL);
        return null;
    }

    return $html;
}

function parse_cli_options(array $argv): array
{
    $teams = [];
    $output = null;

    $args = $argv;
    array_shift($args);
    while ($args !== []) {
        $arg = array_shift($args);
        if ($arg === '--help' || $arg === '-h') {
            print_usage();
            exit(0);
        }
        if ($arg === '--output' || $arg === '-o') {
            $output = array_shift($args);
            continue;
        }
        if ($arg === '--list' || $arg === '-l') {
            $file = array_shift($args);
            if ($file === null || !is_file($file)) {
                fwrite(STDERR, "Fichier de liste introuvable: {$file}" . PHP_EOL);
                exit(1);
            }
            $teams = load_team_list($file);
            continue;
        }
        if (str_contains($arg, '=')) {
            [$slug, $url] = explode('=', $arg, 2);
            if ($slug !== '' && $url !== '') {
                $teams[$slug] = $url;
            }
            continue;
        }
        fwrite(STDERR, "Argument inconnu: {$arg}" . PHP_EOL);
        print_usage();
        exit(1);
    }

    return [
        'teams' => $teams,
        'output' => $output,
    ];
}

function load_team_list(string $file): array
{
    $teams = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            fwrite(STDERR, "Ligne invalide (format attendu slug=url): {$line}" . PHP_EOL);
            continue;
        }
        [$slug, $url] = explode('=', $line, 2);
        $slug = trim($slug);
        $url = trim($url);
        if ($slug !== '' && $url !== '') {
            $teams[$slug] = $url;
        }
    }

    return $teams;
}

function print_usage(): void
{
    $script = basename(__FILE__);
    $message = <<<TXT
Usage:
  php {$script} [options] [slug=url ...]

Options:
  -h, --help           Afficher l'aide
  -o, --output DIR     Dossier de sortie pour les logos
  -l, --list FILE      Fichier texte (slug=url par ligne, # pour commentaire)

Exemples:
  php {$script}
  php {$script} -o ./logos
  php {$script} -l equipes.txt
  php {$script} senior1=https://example.com/page
TXT;
    fwrite(STDOUT, $message . PHP_EOL);
}

function extract_image_urls(string $html, string $baseUrl): array
{
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    libxml_clear_errors();

    $images = [];
    foreach ($dom->getElementsByTagName('img') as $img) {
        $src = $img->getAttribute('src');
        if ($src === '') {
            $src = $img->getAttribute('data-src') ?: $img->getAttribute('data-lazy');
        }
        if ($src === '') {
            continue;
        }

        $images[] = [
            'src' => resolve_url($baseUrl, $src),
            'alt' => $img->getAttribute('alt'),
            'class' => $img->getAttribute('class'),
        ];
    }

    return $images;
}

function resolve_url(string $baseUrl, string $relative): string
{
    if (preg_match('#^https?://#i', $relative)) {
        return $relative;
    }

    if (str_starts_with($relative, '//')) {
        $scheme = parse_url($baseUrl, PHP_URL_SCHEME) ?: 'https';
        return "{$scheme}:{$relative}";
    }

    $parsed = parse_url($baseUrl);
    $scheme = $parsed['scheme'] ?? 'https';
    $host = $parsed['host'] ?? '';
    $path = $parsed['path'] ?? '';
    $path = rtrim(dirname($path), '/');
    $relative = ltrim($relative, '/');

    return "{$scheme}://{$host}/{$path}/{$relative}";
}

function download_file(string $url, string $destination, string $userAgent): ?int
{
    $ch = curl_init($url);
    $fp = fopen($destination, 'wb');
    if ($fp === false) {
        return null;
    }

    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => $userAgent,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 15,
    ]);

    $success = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    fclose($fp);

    if ($success === false || $status >= 400) {
        unlink($destination);
        fwrite(STDERR, "Erreur HTTP {$status} pour {$url}. {$error}" . PHP_EOL);
        return null;
    }

    return filesize($destination) ?: 0;
}
