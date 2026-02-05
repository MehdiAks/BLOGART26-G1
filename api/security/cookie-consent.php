<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/includes/libs/cookie-consent.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit();
}

$consentRaw = $_POST['consent'] ?? null;
$consent = ($consentRaw === '1' || $consentRaw === 1) ? 1 : 0;

if (function_exists('sql_connect')) {
    global $DB;
    if (!$DB) {
        sql_connect();
    }
}

if (!empty($DB)) {
    saveCookieConsent($DB, $consent);
}

http_response_code(204);
exit();
