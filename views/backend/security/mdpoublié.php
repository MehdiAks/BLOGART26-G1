<?php // Exécute la ligne : <?php
/* // Exécute la ligne : /*
 * Vue d'administration (authentification/inscription). // Exécute la ligne : * Vue d'administration (authentification/inscription).
 * - Cette page expose un formulaire de sécurité pour se connecter, s'inscrire ou réinitialiser un mot de passe. // Exécute la ligne : * - Cette page expose un formulaire de sécurité pour se connecter, s'inscrire ou réinitialiser un mot de passe.
 * - Les champs sont validés via les attributs HTML et envoyés vers la route d'authentification dédiée. // Exécute la ligne : * - Les champs sont validés via les attributs HTML et envoyés vers la route d'authentification dédiée.
 * - Les messages d'aide guident l'utilisateur sur la procédure à suivre. // Exécute la ligne : * - Les messages d'aide guident l'utilisateur sur la procédure à suivre.
 * - La vue reste passive : elle ne fait que collecter les données et afficher les retours serveur. // Exécute la ligne : * - La vue reste passive : elle ne fait que collecter les données et afficher les retours serveur.
 */ // Exécute la ligne : */
session_start(); // Exécute la ligne : session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Exécute la ligne : require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php'; // Exécute la ligne : require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

$ba_bec_email = ''; // Exécute la ligne : $ba_bec_email = '';
$ba_bec_errorEmail = ''; // Exécute la ligne : $ba_bec_errorEmail = '';
$ba_bec_success = ''; // Exécute la ligne : $ba_bec_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Exécute la ligne : if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ba_bec_email = ctrlSaisies($_POST['email'] ?? ''); // Exécute la ligne : $ba_bec_email = ctrlSaisies($_POST['email'] ?? '');

    if (empty($ba_bec_email)) { // Exécute la ligne : if (empty($ba_bec_email)) {
        $ba_bec_errorEmail = "L'adresse email est requise."; // Exécute la ligne : $ba_bec_errorEmail = "L'adresse email est requise.";
    } elseif (!filter_var($ba_bec_email, FILTER_VALIDATE_EMAIL)) { // Exécute la ligne : } elseif (!filter_var($ba_bec_email, FILTER_VALIDATE_EMAIL)) {
        $ba_bec_errorEmail = "L'adresse email n'est pas valide."; // Exécute la ligne : $ba_bec_errorEmail = "L'adresse email n'est pas valide.";
    } else { // Exécute la ligne : } else {
        $ba_bec_success = "Si un compte est associé à cet email, un lien de réinitialisation vient d'être envoyé."; // Exécute la ligne : $ba_bec_success = "Si un compte est associé à cet email, un lien de réinitialisation vient d'être envoyé.";
    } // Exécute la ligne : }
} // Exécute la ligne : }

$pageStyles = [ // Exécute la ligne : $pageStyles = [
    ROOT_URL . '/src/css/login.css', // Exécute la ligne : ROOT_URL . '/src/css/login.css',
]; // Exécute la ligne : ];

include '../../../header.php'; // Exécute la ligne : include '../../../header.php';
?> <!-- Rend la fermeture du bloc PHP. -->

<main class="auth-page"> <!-- Rend la ligne HTML : <main class="auth-page"> -->
    <section class="auth-card"> <!-- Rend la ligne HTML : <section class="auth-card"> -->
        <h1>Mot de passe oublié</h1> <!-- Rend la ligne HTML : <h1>Mot de passe oublié</h1> -->
        <p class="text-muted text-center">Indiquez votre adresse email pour recevoir un lien de réinitialisation.</p> <!-- Rend la ligne HTML : <p class="text-muted text-center">Indiquez votre adresse email pour recevoir un lien de réinitialisation.</p> -->

        <?php if (!empty($ba_bec_success)):  /* Exécute la ligne : <?php if (!empty($ba_bec_success)): ?> */ ?>
            <div class="alert alert-success"> <!-- Rend la ligne HTML : <div class="alert alert-success"> -->
                <?= htmlspecialchars($ba_bec_success)  /* Exécute la ligne : <?= htmlspecialchars($ba_bec_success) ?> */ ?>
            </div> <!-- Rend la ligne HTML : </div> -->
        <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>

        <form action="" method="post" class="auth-form"> <!-- Rend la ligne HTML : <form action="" method="post" class="auth-form"> -->
            <div class="auth-stack"> <!-- Rend la ligne HTML : <div class="auth-stack"> -->
                <div class="champ"> <!-- Rend la ligne HTML : <div class="champ"> -->
                    <label for="email">Adresse email :</label> <!-- Rend la ligne HTML : <label for="email">Adresse email :</label> -->
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($ba_bec_email)  /* Exécute la ligne : <input type="email" id="email" name="email" value="<?= htmlspecialchars($ba_bec_email) ?>" required> */ ?>" required>
                    <?php if (!empty($ba_bec_errorEmail)):  /* Exécute la ligne : <?php if (!empty($ba_bec_errorEmail)): ?> */ ?>
                        <div class="alert alert-danger mt-2"><?= htmlspecialchars($ba_bec_errorEmail)  /* Exécute la ligne : <div class="alert alert-danger mt-2"><?= htmlspecialchars($ba_bec_errorEmail) ?></div> */ ?></div>
                    <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
                </div> <!-- Rend la ligne HTML : </div> -->
            </div> <!-- Rend la ligne HTML : </div> -->

            <div class="btn-se-connecter"> <!-- Rend la ligne HTML : <div class="btn-se-connecter"> -->
                <button type="submit">Envoyer le lien</button> <!-- Rend la ligne HTML : <button type="submit">Envoyer le lien</button> -->
                <a href="/views/backend/security/login.php" class="link">Retour à la connexion</a> <!-- Rend la ligne HTML : <a href="/views/backend/security/login.php" class="link">Retour à la connexion</a> -->
            </div> <!-- Rend la ligne HTML : </div> -->
        </form> <!-- Rend la ligne HTML : </form> -->
    </section> <!-- Rend la ligne HTML : </section> -->
</main> <!-- Rend la ligne HTML : </main> -->
