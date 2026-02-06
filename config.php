<?php
// Commentaire : ce fichier centralise la configuration globale de l'application.
// Il est inclus en début de page (via require_once) afin d'initialiser l'environnement.

// Définition du chemin racine du site (ex : /var/www/html) à partir du DOCUMENT_ROOT serveur.
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
// Définition de l'URL de base du site (ex : http://example.com) à partir du Host HTTP.
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']);

// S'assure que la session PHP est démarrée pour toutes les pages de l'application.
// La session sert notamment à stocker l'ID de l'utilisateur connecté et d'autres états.
if (session_status() === PHP_SESSION_NONE) {
    // Démarre la session (création du cookie PHPSESSID si nécessaire).
    session_start();
}

// Récupère le chemin du script courant (ex : /api/security/login.php).
// L'opérateur ?? '' évite un Notice si SCRIPT_NAME n'est pas défini.
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
// Si la page appartient à l'API (préfixe /api/), on applique des règles d'accès.
if (strpos($scriptName, '/api/') === 0) {
    // Liste blanche des endpoints accessibles sans authentification.
    $publicApiEndpoints = [
        '/api/security/signup.php',
        '/api/security/login.php',
        '/api/security/disconnect.php',
        '/api/security/cookie-consent.php',
    ];

    // Vérifie si l'endpoint courant est public (comparaison stricte).
    $isPublicEndpoint = in_array($scriptName, $publicApiEndpoints, true);
    // Vérifie si l'utilisateur est authentifié (ID utilisateur en session).
    $isAuthenticated = !empty($_SESSION['user_id']);

    // Si l'endpoint n'est pas public ET que l'utilisateur n'est pas connecté :
    if (!$isPublicEndpoint && !$isAuthenticated) {
        // Retourne un code HTTP 403 (Forbidden).
        http_response_code(403);
        // Stoppe l'exécution en renvoyant un message d'erreur.
        exit('Accès interdit.');
    }
}

// Charge la classe DotEnv (bibliothèque interne) pour lire le fichier .env.
require_once ROOT . '/includes/libs/DotEnv.php';
// Instancie DotEnv avec le chemin du fichier .env et charge les variables d'environnement.
(new DotEnv(ROOT . '/.env'))->load();

// Charge les constantes de configuration de la base de données (hôte, user, etc.).
require_once ROOT . '/config/defines.php';

// Si l'environnement indique qu'on est en mode debug, on active l'affichage des erreurs.
if (getenv('APP_DEBUG') == 'true') {
    // Active les paramètres d'erreurs PHP (définis dans config/debug.php).
    require_once ROOT . '/config/debug.php';
}

// Charge les fonctions utilitaires globales de l'application.
require_once ROOT . '/functions/global.inc.php';

// Charge la configuration sécurité (ex : helpers/constantes de sécurité).
require_once ROOT . '/config/security.php';

?>
