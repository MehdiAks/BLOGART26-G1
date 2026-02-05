<?php
// Commentaire: Fichier PHP pour config.
//define ROOT_PATH
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']);

// Ensure session is available across the app
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Block access to API endpoints for non-authenticated users (except public endpoints)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
if (strpos($scriptName, '/api/') === 0) {
    $publicApiEndpoints = [
        '/api/security/signup.php',
        '/api/security/login.php',
        '/api/security/disconnect.php',
        '/api/security/cookie-consent.php',
    ];

    $isPublicEndpoint = in_array($scriptName, $publicApiEndpoints, true);
    $isAuthenticated = !empty($_SESSION['user_id']);

    if (!$isPublicEndpoint && !$isAuthenticated) {
        http_response_code(403);
        exit('Accès interdit.');
    }
}

//Load env
require_once ROOT . '/includes/libs/DotEnv.php';
(new DotEnv(ROOT.'/.env'))->load();

//defines
require_once ROOT . '/config/defines.php';

//debug
if (getenv('APP_DEBUG') == 'true') {
    require_once ROOT . '/config/debug.php';
}

//load functions
require_once ROOT . '/functions/global.inc.php';

//load security
require_once ROOT . '/config/security.php';

?>
