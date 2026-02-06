<?php // Exécute la ligne : <?php
/* // Exécute la ligne : /*
 * Endpoint API: api/security/login.php // Exécute la ligne : * Endpoint API: api/security/login.php
 * Rôle: authentifier un membre et initialiser sa session. // Exécute la ligne : * Rôle: authentifier un membre et initialiser sa session.
 * // Exécute la ligne : *
 * Déroulé détaillé: // Exécute la ligne : * Déroulé détaillé:
 * 1) Charge la configuration et les helpers de sanitisation. // Exécute la ligne : * 1) Charge la configuration et les helpers de sanitisation.
 * 2) Démarre la session PHP pour stocker l'identité de l'utilisateur. // Exécute la ligne : * 2) Démarre la session PHP pour stocker l'identité de l'utilisateur.
 * 3) Nettoie les champs pseudo/mot de passe soumis via POST. // Exécute la ligne : * 3) Nettoie les champs pseudo/mot de passe soumis via POST.
 * 4) Récupère le membre en base puis vérifie le mot de passe via password_verify. // Exécute la ligne : * 4) Récupère le membre en base puis vérifie le mot de passe via password_verify.
 * 5) Stocke l'identité en session et redirige vers la page d'accueil (ou renvoie une erreur). // Exécute la ligne : * 5) Stocke l'identité en session et redirige vers la page d'accueil (ou renvoie une erreur).
 */ // Exécute la ligne : */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Exécute la ligne : require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php'; // Exécute la ligne : require_once '../../functions/ctrlSaisies.php';
session_start(); // Exécute la ligne : session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Exécute la ligne : if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Étape 1: nettoyer les entrées utilisateur. // Exécute la ligne : // Étape 1: nettoyer les entrées utilisateur.
    $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']); // Exécute la ligne : $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']);
    $ba_bec_password = ctrlSaisies($_POST['password']); // Exécute la ligne : $ba_bec_password = ctrlSaisies($_POST['password']);

    // Vérifier si l'utilisateur existe avec ce nom d'utilisateur // Exécute la ligne : // Vérifier si l'utilisateur existe avec ce nom d'utilisateur
    $ba_bec_user = sql_select("MEMBRE", "*", "pseudoMemb = '$ba_bec_pseudo'"); // Exécute la ligne : $ba_bec_user = sql_select("MEMBRE", "*", "pseudoMemb = '$ba_bec_pseudo'");
    
    if ($ba_bec_user) { // Exécute la ligne : if ($ba_bec_user) {
        // Utiliser password_verify pour comparer le mot de passe saisi avec celui haché // Exécute la ligne : // Utiliser password_verify pour comparer le mot de passe saisi avec celui haché
        if (password_verify($ba_bec_password, $ba_bec_user[0]['passMemb'])) { // Exécute la ligne : if (password_verify($ba_bec_password, $ba_bec_user[0]['passMemb'])) {
            // Étape 2: ouvrir la session applicative et conserver l'identifiant membre. // Exécute la ligne : // Étape 2: ouvrir la session applicative et conserver l'identifiant membre.
            $_SESSION['user_id'] = $ba_bec_user[0]['numMemb']; // Exécute la ligne : $_SESSION['user_id'] = $ba_bec_user[0]['numMemb'];
            $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb']; // Exécute la ligne : $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb'];

            // Étape 3: rediriger après authentification réussie. // Exécute la ligne : // Étape 3: rediriger après authentification réussie.
            header("Location: " . ROOT_URL . "/index.php"); // Exécute la ligne : header("Location: " . ROOT_URL . "/index.php");
            $_SESSION['pseudoMemb'] = $ba_bec_pseudo; // Stocke le nom d'utilisateur en session // Exécute la ligne : $_SESSION['pseudoMemb'] = $ba_bec_pseudo; // Stocke le nom d'utilisateur en session
            exit(); // Exécute la ligne : exit();
        } else { // Exécute la ligne : } else {
            // Mot de passe invalide: renvoyer une erreur explicite. // Exécute la ligne : // Mot de passe invalide: renvoyer une erreur explicite.
            header("Location: " . ROOT_URL . "/views/security/login.php?error=Mot de passe incorrect"); // Exécute la ligne : header("Location: " . ROOT_URL . "/views/security/login.php?error=Mot de passe incorrect");
            exit(); // Exécute la ligne : exit();
        } // Exécute la ligne : }
    } else { // Exécute la ligne : } else {
        // Aucun utilisateur trouvé avec ce pseudo: renvoyer l'erreur générique. // Exécute la ligne : // Aucun utilisateur trouvé avec ce pseudo: renvoyer l'erreur générique.
        header("Location: " . ROOT_URL . "/views/security/login.php?error=Nom d'utilisateur ou mot de passe incorrect"); // Exécute la ligne : header("Location: " . ROOT_URL . "/views/security/login.php?error=Nom d'utilisateur ou mot de passe incorrect");
        exit(); // Exécute la ligne : exit();
    } // Exécute la ligne : }
} // Exécute la ligne : }
?> <!-- Rend la fermeture du bloc PHP. -->
