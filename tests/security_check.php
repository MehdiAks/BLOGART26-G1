<?php

// Vérifications de sécurité statiques, sans connexion à la base.
$ba_bec_root = dirname(__DIR__);
$ba_bec_errors = [];

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return $needle === '' || strpos($haystack, $needle) === 0;
    }
}

require_once $ba_bec_root . '/functions/security.php';
require_once $ba_bec_root . '/functions/various.php';

$ba_bec_assert = static function ($condition, string $message) use (&$ba_bec_errors): void {
    if (!$condition) {
        $ba_bec_errors[] = $message;
    }
};

$ba_bec_assert(e('&eacute;') === '&eacute;', 'e() ne doit pas double-encoder les entités.');
$ba_bec_assert(e('<script>') === '&lt;script&gt;', 'e() doit échapper les balises HTML.');
$ba_bec_assert(legacy_password_variant('a\\b<c') === 'ab&lt;c', 'La variante de mot de passe historique est incorrecte.');

// Vérifie que X-Forwarded-For est ignoré par défaut et utilisé uniquement pour un proxy déclaré fiable.
$ba_bec_hadRemoteAddr = array_key_exists('REMOTE_ADDR', $_SERVER);
$ba_bec_oldRemoteAddr = $_SERVER['REMOTE_ADDR'] ?? null;
$ba_bec_hadForwardedFor = array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER);
$ba_bec_oldForwardedFor = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
$ba_bec_oldTrustProxy = getenv('TRUST_PROXY');
$_SERVER['REMOTE_ADDR'] = '10.0.0.2';
$_SERVER['HTTP_X_FORWARDED_FOR'] = '203.0.113.8, 8.8.8.8';
putenv('TRUST_PROXY=false');
$ba_bec_assert(client_ip() === '10.0.0.2', 'X-Forwarded-For ne doit pas être utilisé sans proxy déclaré fiable.');
putenv('TRUST_PROXY=true');
$ba_bec_assert(client_ip() === '8.8.8.8', 'La dernière adresse valide de X-Forwarded-For doit être utilisée avec un proxy fiable.');
if ($ba_bec_oldTrustProxy === false) {
    putenv('TRUST_PROXY');
} else {
    putenv('TRUST_PROXY=' . $ba_bec_oldTrustProxy);
}
if ($ba_bec_hadRemoteAddr) {
    $_SERVER['REMOTE_ADDR'] = $ba_bec_oldRemoteAddr;
} else {
    unset($_SERVER['REMOTE_ADDR']);
}
if ($ba_bec_hadForwardedFor) {
    $_SERVER['HTTP_X_FORWARDED_FOR'] = $ba_bec_oldForwardedFor;
} else {
    unset($_SERVER['HTTP_X_FORWARDED_FOR']);
}

// Vérifie statiquement les seuils IP et compte sans nécessiter de connexion à la base.
$ba_bec_securitySource = file_get_contents($ba_bec_root . '/functions/security.php');
$ba_bec_assert(
    $ba_bec_securitySource !== false
        && strpos($ba_bec_securitySource, "['ipFailures'] ?? 0) >= 5") !== false
        && strpos($ba_bec_securitySource, "['pseudoFailures'] ?? 0) >= 10") !== false,
    'Les seuils de limitation IP ou compte sont incorrects.'
);

$ba_bec_fallback = '/index.php';
$ba_bec_assert(safe_redirect_target('//evil.com', $ba_bec_fallback) === $ba_bec_fallback, 'Redirection // externe acceptée.');
$ba_bec_assert(safe_redirect_target('https://evil.com', $ba_bec_fallback) === $ba_bec_fallback, 'Redirection https externe acceptée.');
$ba_bec_assert(safe_redirect_target('/\\evil.com', $ba_bec_fallback) === $ba_bec_fallback, 'Redirection avec antislash acceptée.');
$ba_bec_assert(safe_redirect_target('javascript:x', $ba_bec_fallback) === $ba_bec_fallback, 'Redirection javascript acceptée.');
$ba_bec_assert(safe_redirect_target('/article.php?numArt=3', $ba_bec_fallback) === '/article.php?numArt=3', 'Redirection locale refusée.');
$ba_bec_assert(isAllowedBbcodeUrl('//evil.com') === false, 'URL BBCode protocole-relative acceptée.');

$ba_bec_phpFiles = [];
$ba_bec_iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($ba_bec_root, FilesystemIterator::SKIP_DOTS)
);
foreach ($ba_bec_iterator as $ba_bec_fileInfo) {
    if (!$ba_bec_fileInfo->isFile() || strtolower($ba_bec_fileInfo->getExtension()) !== 'php') {
        continue;
    }
    $ba_bec_path = $ba_bec_fileInfo->getPathname();
    if (strpos($ba_bec_path, DIRECTORY_SEPARATOR . '.git' . DIRECTORY_SEPARATOR) !== false) {
        continue;
    }
    $ba_bec_phpFiles[] = $ba_bec_path;
}

foreach ($ba_bec_phpFiles as $ba_bec_path) {
    $ba_bec_relative = ltrim(str_replace($ba_bec_root, '', $ba_bec_path), DIRECTORY_SEPARATOR);
    $ba_bec_content = file_get_contents($ba_bec_path);
    if ($ba_bec_content === false) {
        $ba_bec_errors[] = 'Lecture impossible : ' . $ba_bec_relative;
        continue;
    }

    foreach (preg_split('/\R/', $ba_bec_content) as $ba_bec_lineNumber => $ba_bec_line) {
        if (preg_match('/sql_(?:select|insert|update|delete)\s*\(.*"[^"\r\n]*\$[^"\r\n]*"/', $ba_bec_line)) {
            $ba_bec_errors[] = sprintf('SQL interpolé : %s:%d', $ba_bec_relative, $ba_bec_lineNumber + 1);
        }
    }

    if (preg_match_all('/<form\b(?:(?!<\/form>).)*<\/form>/is', $ba_bec_content, $ba_bec_forms)) {
        foreach ($ba_bec_forms[0] as $ba_bec_form) {
            $ba_bec_openEnd = strpos($ba_bec_form, '>');
            $ba_bec_openTag = $ba_bec_openEnd === false ? $ba_bec_form : substr($ba_bec_form, 0, $ba_bec_openEnd + 1);
            if (preg_match('/\bmethod\s*=\s*(["\'])post\1/i', $ba_bec_openTag)
                && strpos($ba_bec_form, 'csrf_field()') === false) {
                $ba_bec_errors[] = 'Formulaire POST sans CSRF : ' . $ba_bec_relative;
            }
        }
    }

    $ba_bec_backendPrefix = 'views' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR;
    $ba_bec_securityPrefix = $ba_bec_backendPrefix . 'security' . DIRECTORY_SEPARATOR;
    if (strpos($ba_bec_relative, $ba_bec_backendPrefix) === 0
        && strpos($ba_bec_relative, $ba_bec_securityPrefix) !== 0
        && !preg_match('/redirec(?:modo)?\.php|require_stat\s*\(/', $ba_bec_content)) {
        $ba_bec_errors[] = 'Vue backend sans garde : ' . $ba_bec_relative;
    }
}

if ($ba_bec_errors) {
    foreach (array_unique($ba_bec_errors) as $ba_bec_error) {
        fwrite(STDERR, '[ECHEC] ' . $ba_bec_error . PHP_EOL);
    }
    exit(1);
}

echo "Security checks: OK\n";
exit(0);
