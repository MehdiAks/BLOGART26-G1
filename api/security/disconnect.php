<?php
/*
 * Endpoint API: api/security/disconnect.php
 * Rôle: déconnecter l'utilisateur en détruisant sa session.
 *
 * Déroulé détaillé:
 * 1) Démarre la session PHP pour accéder aux données existantes.
 * 2) Vide toutes les variables de session puis détruit la session côté serveur.
 * 3) Redirige vers la page d'accueil.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Étape 1: suppression des données de session.
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $ba_bec_params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $ba_bec_params['path'], $ba_bec_params['domain'], $ba_bec_params['secure'], $ba_bec_params['httponly']);
}
session_destroy();

// Étape 2: redirection après déconnexion.
header("Location: /index.php");
exit();

?>
