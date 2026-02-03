<?php
// Commentaire: Fichier PHP pour config.
//define ROOT_PATH
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']);

// Ensure session is available across the app
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
