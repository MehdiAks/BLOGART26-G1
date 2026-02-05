<?php
require_once __DIR__ . '/../config.php';

$ba_bec_numStat = $_SESSION['numStat'] ?? null;
if ($ba_bec_numStat === null || (int) $ba_bec_numStat !== 1) {
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit;
}

$controllerKey = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? 'list';

$controllerMap = [
    'statut' => 'StatutController',
    'article' => 'ArticleController',
];

if (!isset($controllerMap[$controllerKey])) {
    http_response_code(404);
    echo 'Contrôleur introuvable.';
    exit;
}

$controllerClass = $controllerMap[$controllerKey];
$controllerPath = __DIR__ . '/../controllers/' . $controllerClass . '.php';

if (!file_exists($controllerPath)) {
    http_response_code(404);
    echo 'Fichier contrôleur introuvable.';
    exit;
}

require_once $controllerPath;

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Action introuvable.';
    exit;
}

$controller->$action();

?>
