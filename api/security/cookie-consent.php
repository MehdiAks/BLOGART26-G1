<?php // Exécute la ligne : <?php
/* // Exécute la ligne : /*
 * Endpoint API: api/security/cookie-consent.php // Exécute la ligne : * Endpoint API: api/security/cookie-consent.php
 * Rôle: enregistrer le consentement cookies côté serveur. // Exécute la ligne : * Rôle: enregistrer le consentement cookies côté serveur.
 * // Exécute la ligne : *
 * Déroulé détaillé: // Exécute la ligne : * Déroulé détaillé:
 * 1) Charge la config et la librairie de consentement. // Exécute la ligne : * 1) Charge la config et la librairie de consentement.
 * 2) Accepte uniquement les requêtes POST. // Exécute la ligne : * 2) Accepte uniquement les requêtes POST.
 * 3) Normalise la valeur du consentement en 0/1. // Exécute la ligne : * 3) Normalise la valeur du consentement en 0/1.
 * 4) Ouvre une connexion DB si nécessaire, puis enregistre le consentement. // Exécute la ligne : * 4) Ouvre une connexion DB si nécessaire, puis enregistre le consentement.
 * 5) Retourne un 204 (pas de contenu) pour signifier le succès silencieux. // Exécute la ligne : * 5) Retourne un 204 (pas de contenu) pour signifier le succès silencieux.
 */ // Exécute la ligne : */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Exécute la ligne : require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/includes/libs/cookie-consent.php'; // Exécute la ligne : require_once ROOT . '/includes/libs/cookie-consent.php';

// Étape 1: bloquer les méthodes non POST. // Exécute la ligne : // Étape 1: bloquer les méthodes non POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // Exécute la ligne : if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Exécute la ligne : http_response_code(405);
    exit(); // Exécute la ligne : exit();
} // Exécute la ligne : }

// Étape 2: normaliser la valeur envoyée (1/0). // Exécute la ligne : // Étape 2: normaliser la valeur envoyée (1/0).
$consentRaw = $_POST['consent'] ?? null; // Exécute la ligne : $consentRaw = $_POST['consent'] ?? null;
$consent = ($consentRaw === '1' || $consentRaw === 1) ? 1 : 0; // Exécute la ligne : $consent = ($consentRaw === '1' || $consentRaw === 1) ? 1 : 0;

// Étape 3: s'assurer que la connexion SQL est disponible. // Exécute la ligne : // Étape 3: s'assurer que la connexion SQL est disponible.
if (function_exists('sql_connect')) { // Exécute la ligne : if (function_exists('sql_connect')) {
    global $DB; // Exécute la ligne : global $DB;
    if (!$DB) { // Exécute la ligne : if (!$DB) {
        sql_connect(); // Exécute la ligne : sql_connect();
    } // Exécute la ligne : }
} // Exécute la ligne : }

// Étape 4: persister le choix utilisateur en base si possible. // Exécute la ligne : // Étape 4: persister le choix utilisateur en base si possible.
if (!empty($DB)) { // Exécute la ligne : if (!empty($DB)) {
    saveCookieConsent($DB, $consent); // Exécute la ligne : saveCookieConsent($DB, $consent);
} // Exécute la ligne : }

// Étape 5: statut 204 pour un retour sans payload. // Exécute la ligne : // Étape 5: statut 204 pour un retour sans payload.
http_response_code(204); // Exécute la ligne : http_response_code(204);
exit(); // Exécute la ligne : exit();
