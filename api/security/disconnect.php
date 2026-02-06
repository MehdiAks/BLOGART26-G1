<?php // Exécute la ligne : <?php
/* // Exécute la ligne : /*
 * Endpoint API: api/security/disconnect.php // Exécute la ligne : * Endpoint API: api/security/disconnect.php
 * Rôle: déconnecter l'utilisateur en détruisant sa session. // Exécute la ligne : * Rôle: déconnecter l'utilisateur en détruisant sa session.
 * // Exécute la ligne : *
 * Déroulé détaillé: // Exécute la ligne : * Déroulé détaillé:
 * 1) Démarre la session PHP pour accéder aux données existantes. // Exécute la ligne : * 1) Démarre la session PHP pour accéder aux données existantes.
 * 2) Vide toutes les variables de session puis détruit la session côté serveur. // Exécute la ligne : * 2) Vide toutes les variables de session puis détruit la session côté serveur.
 * 3) Redirige vers la page d'accueil. // Exécute la ligne : * 3) Redirige vers la page d'accueil.
 */ // Exécute la ligne : */
session_start();  // Exécute la ligne : session_start();
// Étape 1: suppression des données de session. // Exécute la ligne : // Étape 1: suppression des données de session.
session_unset(); // Exécute la ligne : session_unset();
session_destroy(); // Exécute la ligne : session_destroy();

// Étape 2: redirection après déconnexion. // Exécute la ligne : // Étape 2: redirection après déconnexion.
header("Location: /index.php"); // Exécute la ligne : header("Location: /index.php");
exit(); // Exécute la ligne : exit();

?> <!-- Rend la fermeture du bloc PHP. -->
