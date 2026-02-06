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

$pageStyles = [ // Exécute la ligne : $pageStyles = [
    ROOT_URL . '/src/css/signup.css', // Exécute la ligne : ROOT_URL . '/src/css/signup.css',
]; // Exécute la ligne : ];

include '../../../header.php'; // Exécute la ligne : include '../../../header.php';

// Récupération des données de session // Exécute la ligne : // Récupération des données de session
$ba_bec_errors = $_SESSION['errors'] ?? []; // Exécute la ligne : $ba_bec_errors = $_SESSION['errors'] ?? [];
$ba_bec_old = $_SESSION['old'] ?? []; // Exécute la ligne : $ba_bec_old = $_SESSION['old'] ?? [];
$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY'); // Exécute la ligne : $ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY');
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8'); // Exécute la ligne : $ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8');

// Nettoyage des données de session après récupération // Exécute la ligne : // Nettoyage des données de session après récupération
unset($_SESSION['errors'], $_SESSION['old']); // Exécute la ligne : unset($_SESSION['errors'], $_SESSION['old']);
?> <!-- Rend la fermeture du bloc PHP. -->

<main class="auth-page"> <!-- Rend la ligne HTML : <main class="auth-page"> -->
    <section class="auth-card"> <!-- Rend la ligne HTML : <section class="auth-card"> -->
        <h1>Créer mon compte</h1> <!-- Rend la ligne HTML : <h1>Créer mon compte</h1> -->

        <div class="container mb-4"> <!-- Rend la ligne HTML : <div class="container mb-4"> -->
            <?php if (!empty($ba_bec_errors)):  /* Exécute la ligne : <?php if (!empty($ba_bec_errors)): ?> */ ?>
                <div class="alert alert-danger"> <!-- Rend la ligne HTML : <div class="alert alert-danger"> -->
                    <ul class="mb-2"> <!-- Rend la ligne HTML : <ul class="mb-2"> -->
                        <?php foreach ($ba_bec_errors as $ba_bec_error):  /* Exécute la ligne : <?php foreach ($ba_bec_errors as $ba_bec_error): ?> */ ?>
                            <?= htmlspecialchars($ba_bec_error)  /* Exécute la ligne : <?= htmlspecialchars($ba_bec_error) ?><br> */ ?><br>
                        <?php endforeach;  /* Exécute la ligne : <?php endforeach; ?> */ ?>
                    </ul> <!-- Rend la ligne HTML : </ul> -->
                </div> <!-- Rend la ligne HTML : </div> -->
            <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
        </div> <!-- Rend la ligne HTML : </div> -->
        <form action="<?php echo ROOT_URL . '/api/security/signup.php'  /* Exécute la ligne : <form action="<?php echo ROOT_URL . '/api/security/signup.php' ?>" method="post" class="auth-form"> */ ?>" method="post" class="auth-form">
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-signup"> <!-- Rend la ligne HTML : <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-signup"> -->
            <div class="signup-grid"> <!-- Rend la ligne HTML : <div class="signup-grid"> -->
                <!-- Prénom --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ"> <!-- Rend la ligne HTML : <div class="champ"> -->
                    <label for="prenomMemb">Prénom :</label> <!-- Rend la ligne HTML : <label for="prenomMemb">Prénom :</label> -->
                    <input type="text" id="prenomMemb" name="prenomMemb" value="<?= htmlspecialchars($ba_bec_old['prenomMemb'] ?? '')  /* Exécute la ligne : <input type="text" id="prenomMemb" name="prenomMemb" value="<?= htmlspecialchars($ba_bec_old['prenomMemb'] ?? '') ?>" required> */ ?>" required>
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Nom --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ"> <!-- Rend la ligne HTML : <div class="champ"> -->
                    <label for="nomMemb">Nom :</label> <!-- Rend la ligne HTML : <label for="nomMemb">Nom :</label> -->
                    <input type="text" id="nomMemb" name="nomMemb" value="<?= htmlspecialchars($ba_bec_old['nomMemb'] ?? '')  /* Exécute la ligne : <input type="text" id="nomMemb" name="nomMemb" value="<?= htmlspecialchars($ba_bec_old['nomMemb'] ?? '') ?>" required> */ ?>" required>
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Nom d'utilisateur --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ full"> <!-- Rend la ligne HTML : <div class="champ full"> -->
                    <label for="pseudoMemb" placeholder="6 à 70 caractères">Nom d'utilisateur</label> <!-- Rend la ligne HTML : <label for="pseudoMemb" placeholder="6 à 70 caractères">Nom d'utilisateur</label> -->
                    <input type="text" <!-- Rend la ligne HTML : <input type="text" -->
                            id="pseudoMemb" <!-- Rend la ligne HTML : id="pseudoMemb" -->
                            name="pseudoMemb" <!-- Rend la ligne HTML : name="pseudoMemb" -->
                            value="<?= htmlspecialchars($ba_bec_old['pseudoMemb'] ?? '')  /* Exécute la ligne : value="<?= htmlspecialchars($ba_bec_old['pseudoMemb'] ?? '') ?>" */ ?>"
                            required> <!-- Rend la ligne HTML : required> -->
                    <small class="form-text text-muted">6 à 70 caractères</small> <!-- Rend la ligne HTML : <small class="form-text text-muted">6 à 70 caractères</small> -->
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Email --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ full"> <!-- Rend la ligne HTML : <div class="champ full"> -->
                    <label for="eMailMemb">Email :</label> <!-- Rend la ligne HTML : <label for="eMailMemb">Email :</label> -->
                    <input type="email" id="eMailMemb" name="eMailMemb" value="<?= htmlspecialchars($ba_bec_old['eMailMemb'] ?? '')  /* Exécute la ligne : <input type="email" id="eMailMemb" name="eMailMemb" value="<?= htmlspecialchars($ba_bec_old['eMailMemb'] ?? '') ?>" required> */ ?>" required>
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Confirmation Email --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ full offset-right"> <!-- Rend la ligne HTML : <div class="champ full offset-right"> -->
                    <label for="eMailMemb2">Confirmer l'email :</label> <!-- Rend la ligne HTML : <label for="eMailMemb2">Confirmer l'email :</label> -->
                    <input type="email" id="eMailMemb2" name="eMailMemb2" value="<?= htmlspecialchars($ba_bec_old['eMailMemb2'] ?? '')  /* Exécute la ligne : <input type="email" id="eMailMemb2" name="eMailMemb2" value="<?= htmlspecialchars($ba_bec_old['eMailMemb2'] ?? '') ?>" required> */ ?>" required>
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Mot de passe --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ full"> <!-- Rend la ligne HTML : <div class="champ full"> -->
                    <label for="passMemb">Mot de passe :</label> <!-- Rend la ligne HTML : <label for="passMemb">Mot de passe :</label> -->
                    <div class="input-with-icon"> <!-- Rend la ligne HTML : <div class="input-with-icon"> -->
                        <input type="password" id="passMemb" name="passMemb" required> <!-- Rend la ligne HTML : <input type="password" id="passMemb" name="passMemb" required> -->
                        <button <!-- Rend la ligne HTML : <button -->
                            class="password-toggle" <!-- Rend la ligne HTML : class="password-toggle" -->
                            type="button" <!-- Rend la ligne HTML : type="button" -->
                            data-target="passMemb" <!-- Rend la ligne HTML : data-target="passMemb" -->
                            aria-label="Afficher le mot de passe" <!-- Rend la ligne HTML : aria-label="Afficher le mot de passe" -->
                        > <!-- Rend la ligne HTML : > -->
                            <span class="icon icon-closed">Afficher</span> <!-- Rend la ligne HTML : <span class="icon icon-closed">Afficher</span> -->
                            <span class="icon icon-open">Masquer</span> <!-- Rend la ligne HTML : <span class="icon icon-open">Masquer</span> -->
                        </button> <!-- Rend la ligne HTML : </button> -->
                    </div> <!-- Rend la ligne HTML : </div> -->
                    <small class="form-text text-muted">Entre 8 et 15 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial</small> <!-- Rend la ligne HTML : <small class="form-text text-muted">Entre 8 et 15 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial</small> -->
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Confirmation mot de passe --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ full offset-right"> <!-- Rend la ligne HTML : <div class="champ full offset-right"> -->
                    <label for="passMemb2">Confirmation du mot de passe :</label> <!-- Rend la ligne HTML : <label for="passMemb2">Confirmation du mot de passe :</label> -->
                    <div class="input-with-icon"> <!-- Rend la ligne HTML : <div class="input-with-icon"> -->
                        <input type="password" id="passMemb2" name="passMemb2" required> <!-- Rend la ligne HTML : <input type="password" id="passMemb2" name="passMemb2" required> -->
                        <button <!-- Rend la ligne HTML : <button -->
                            class="password-toggle" <!-- Rend la ligne HTML : class="password-toggle" -->
                            type="button" <!-- Rend la ligne HTML : type="button" -->
                            data-target="passMemb2" <!-- Rend la ligne HTML : data-target="passMemb2" -->
                            aria-label="Afficher le mot de passe" <!-- Rend la ligne HTML : aria-label="Afficher le mot de passe" -->
                        > <!-- Rend la ligne HTML : > -->
                            <span class="icon icon-closed">Afficher</span> <!-- Rend la ligne HTML : <span class="icon icon-closed">Afficher</span> -->
                            <span class="icon icon-open">Masquer</span> <!-- Rend la ligne HTML : <span class="icon icon-open">Masquer</span> -->
                        </button> <!-- Rend la ligne HTML : </button> -->
                    </div> <!-- Rend la ligne HTML : </div> -->
                </div> <!-- Rend la ligne HTML : </div> -->
            </div> <!-- Rend la ligne HTML : </div> -->
            <!-- Accord données --> <!-- Ajoute un commentaire HTML. -->
            <div class="champ checkbox-row"> <!-- Rend la ligne HTML : <div class="champ checkbox-row"> -->
                <label for="accordMemb">J'accepte la conservation de mes données conformément au RGPD, aux CGU et aux obligations légales.</label> <!-- Rend la ligne HTML : <label for="accordMemb">J'accepte la conservation de mes données conformément au RGPD, aux CGU et aux obligations légales.</label> -->
                <input type="checkbox" id="accordMemb" name="accordMemb" value="1" <?= isset($ba_bec_old['accordMemb']) ? 'checked' : ''  /* Exécute la ligne : <input type="checkbox" id="accordMemb" name="accordMemb" value="1" <?= isset($ba_bec_old['accordMemb']) ? 'checked' : '' ?> required> */ ?> required>
            </div> <!-- Rend la ligne HTML : </div> -->
            <!-- Boutons --> <!-- Ajoute un commentaire HTML. -->
            <div class="btn-se-connecter"> <!-- Rend la ligne HTML : <div class="btn-se-connecter"> -->
                <button type="submit">Créer mon compte</button> <!-- Rend la ligne HTML : <button type="submit">Créer mon compte</button> -->
            </div> <!-- Rend la ligne HTML : </div> -->

            <p>Vous possédez déjà un compte ? <a href="/views/backend/security/login.php" class="link">Se connecter</a></p> <!-- Rend la ligne HTML : <p>Vous possédez déjà un compte ? <a href="/views/backend/security/login.php" class="link">Se connecter</a></p> -->

        </form> <!-- Rend la ligne HTML : </form> -->
    </section> <!-- Rend la ligne HTML : </section> -->

</main> <!-- Rend la ligne HTML : </main> -->
<?php if (!empty($ba_bec_recaptchaSiteKey)):  /* Exécute la ligne : <?php if (!empty($ba_bec_recaptchaSiteKey)): ?> */ ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped;  /* Exécute la ligne : <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>"></script> */ ?>"></script>
<?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
<script> <!-- Rend la ligne HTML : <script> -->
    document.querySelectorAll('.password-toggle').forEach((button) => { // Exécute la ligne : document.querySelectorAll('.password-toggle').forEach((button) => {
        const input = document.getElementById(button.dataset.target); // Exécute la ligne : const input = document.getElementById(button.dataset.target);
        const show = () => { // Exécute la ligne : const show = () => {
            input.type = 'text'; // Exécute la ligne : input.type = 'text';
            button.classList.add('is-visible'); // Exécute la ligne : button.classList.add('is-visible');
        }; // Exécute la ligne : };
        const hide = () => { // Exécute la ligne : const hide = () => {
            input.type = 'password'; // Exécute la ligne : input.type = 'password';
            button.classList.remove('is-visible'); // Exécute la ligne : button.classList.remove('is-visible');
        }; // Exécute la ligne : };

        button.addEventListener('pointerdown', (event) => { // Exécute la ligne : button.addEventListener('pointerdown', (event) => {
            event.preventDefault(); // Exécute la ligne : event.preventDefault();
            show(); // Exécute la ligne : show();
        }); // Exécute la ligne : });
        button.addEventListener('pointerleave', hide); // Exécute la ligne : button.addEventListener('pointerleave', hide);
        button.addEventListener('pointercancel', hide); // Exécute la ligne : button.addEventListener('pointercancel', hide);
        button.addEventListener('keydown', (event) => { // Exécute la ligne : button.addEventListener('keydown', (event) => {
            if (event.code === 'Space' || event.code === 'Enter') { // Exécute la ligne : if (event.code === 'Space' || event.code === 'Enter') {
                show(); // Exécute la ligne : show();
            } // Exécute la ligne : }
        }); // Exécute la ligne : });
        button.addEventListener('keyup', hide); // Exécute la ligne : button.addEventListener('keyup', hide);

        document.addEventListener('pointerup', hide); // Exécute la ligne : document.addEventListener('pointerup', hide);
        document.addEventListener('pointercancel', hide); // Exécute la ligne : document.addEventListener('pointercancel', hide);
        document.addEventListener('touchend', hide); // Exécute la ligne : document.addEventListener('touchend', hide);
    }); // Exécute la ligne : });
</script> <!-- Rend la ligne HTML : </script> -->
<script> <!-- Rend la ligne HTML : <script> -->
    (function () { // Exécute la ligne : (function () {
        var form = document.querySelector('.auth-form'); // Exécute la ligne : var form = document.querySelector('.auth-form');
        var tokenInput = document.getElementById('g-recaptcha-response-signup'); // Exécute la ligne : var tokenInput = document.getElementById('g-recaptcha-response-signup');
        var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped;  /* Exécute la ligne : var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>'; */ ?>';
        if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') { // Exécute la ligne : if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') {
            return; // Exécute la ligne : return;
        } // Exécute la ligne : }

        var isSubmitting = false; // Exécute la ligne : var isSubmitting = false;
        form.addEventListener('submit', function (event) { // Exécute la ligne : form.addEventListener('submit', function (event) {
            if (isSubmitting) { // Exécute la ligne : if (isSubmitting) {
                return; // Exécute la ligne : return;
            } // Exécute la ligne : }
            event.preventDefault(); // Exécute la ligne : event.preventDefault();
            if (typeof grecaptcha === 'undefined') { // Exécute la ligne : if (typeof grecaptcha === 'undefined') {
                form.submit(); // Exécute la ligne : form.submit();
                return; // Exécute la ligne : return;
            } // Exécute la ligne : }
            grecaptcha.ready(function () { // Exécute la ligne : grecaptcha.ready(function () {
                grecaptcha.execute(siteKey, {action: 'signup'}) // Exécute la ligne : grecaptcha.execute(siteKey, {action: 'signup'})
                    .then(function (token) { // Exécute la ligne : .then(function (token) {
                        tokenInput.value = token; // Exécute la ligne : tokenInput.value = token;
                        isSubmitting = true; // Exécute la ligne : isSubmitting = true;
                        form.submit(); // Exécute la ligne : form.submit();
                    }); // Exécute la ligne : });
            }); // Exécute la ligne : });
        }); // Exécute la ligne : });
    })(); // Exécute la ligne : })();
</script> <!-- Rend la ligne HTML : </script> -->
