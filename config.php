<?php
// Ouvre le bloc PHP pour exécuter du code côté serveur.
// Commentaire : ce fichier centralise la configuration globale de l'application.
// Il est inclus en début de page (via require_once) afin d'initialiser l'environnement.

// Définition du chemin racine du site (ex : /var/www/html) à partir du DOCUMENT_ROOT serveur.
define('ROOT', $_SERVER['DOCUMENT_ROOT']); // Crée la constante ROOT avec le chemin du document root.
// Définition de l'URL de base du site (ex : http://example.com) à partir du Host HTTP.
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']); // Crée la constante ROOT_URL en concaténant le protocole et l'hôte.

// S'assure que la session PHP est démarrée pour toutes les pages de l'application.
// La session sert notamment à stocker l'ID de l'utilisateur connecté et d'autres états.
if (session_status() === PHP_SESSION_NONE) { // Vérifie si aucune session n'est active.
    // Démarre la session (création du cookie PHPSESSID si nécessaire).
    session_start(); // Lance la session PHP.
} // Termine le bloc conditionnel de démarrage de session.

// Récupère le chemin du script courant (ex : /api/security/login.php).
// L'opérateur ?? '' évite un Notice si SCRIPT_NAME n'est pas défini.
$scriptName = $_SERVER['SCRIPT_NAME'] ?? ''; // Stocke le chemin du script courant ou une chaîne vide.
// Si la page appartient à l'API (préfixe /api/), on applique des règles d'accès.
if (strpos($scriptName, '/api/') === 0) { // Teste si le script est dans le dossier API.
    // Liste blanche des endpoints accessibles sans authentification.
    $publicApiEndpoints = [ // Déclare un tableau d'URLs publiques.
        '/api/security/signup.php', // Autorise l'inscription sans session.
        '/api/security/login.php', // Autorise la connexion sans session.
        '/api/security/disconnect.php', // Autorise la déconnexion sans session.
        '/api/security/cookie-consent.php', // Autorise la gestion du consentement cookies sans session.
    ]; // Termine la déclaration du tableau d'URLs publiques.

    // Vérifie si l'endpoint courant est public (comparaison stricte).
    $isPublicEndpoint = in_array($scriptName, $publicApiEndpoints, true); // Retourne true si le script est dans la liste blanche.
    // Vérifie si l'utilisateur est authentifié (ID utilisateur en session).
    $isAuthenticated = !empty($_SESSION['user_id']); // Vérifie que l'ID utilisateur est présent en session.

    // Si l'endpoint n'est pas public ET que l'utilisateur n'est pas connecté :
    if (!$isPublicEndpoint && !$isAuthenticated) { // Entre dans le bloc si l'accès doit être refusé.
        // Retourne un code HTTP 403 (Forbidden).
        http_response_code(403); // Définit le code HTTP à 403.
        // Stoppe l'exécution en renvoyant un message d'erreur.
        exit('Accès interdit.'); // Interrompt le script et affiche le message.
    } // Termine le bloc de contrôle d'accès API.
} // Termine le bloc conditionnel API.

// Charge la classe DotEnv (bibliothèque interne) pour lire le fichier .env.
require_once ROOT . '/includes/libs/DotEnv.php'; // Inclut la classe DotEnv une seule fois.
// Instancie DotEnv avec le chemin du fichier .env et charge les variables d'environnement.
(new DotEnv(ROOT . '/.env'))->load(); // Crée l'objet DotEnv et charge les variables.

// Charge les constantes de configuration de la base de données (hôte, user, etc.).
require_once ROOT . '/config/defines.php'; // Inclut les constantes de configuration BDD.

// Si l'environnement indique qu'on est en mode debug, on active l'affichage des erreurs.
if (getenv('APP_DEBUG') == 'true') { // Teste la variable d'environnement APP_DEBUG.
    // Active les paramètres d'erreurs PHP (définis dans config/debug.php).
    require_once ROOT . '/config/debug.php'; // Inclut le fichier de debug.
} // Termine le bloc conditionnel de debug.

// Charge les fonctions utilitaires globales de l'application.
require_once ROOT . '/functions/global.inc.php'; // Inclut les fonctions globales.

// Charge la configuration sécurité (ex : helpers/constantes de sécurité).
require_once ROOT . '/config/security.php'; // Inclut la configuration sécurité.

?> // Ferme le bloc PHP.
