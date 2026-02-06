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
require_once '../../../functions/ctrlSaisies.php'; // Exécute la ligne : require_once '../../../functions/ctrlSaisies.php';


$ba_bec_success = $_SESSION['success'] ?? null; // Exécute la ligne : $ba_bec_success = $_SESSION['success'] ?? null;
$ba_bec_errorPseudo = $ba_bec_errorPassword = $ba_bec_errorCaptcha = ""; // Exécute la ligne : $ba_bec_errorPseudo = $ba_bec_errorPassword = $ba_bec_errorCaptcha = "";
$ba_bec_pseudo = ""; // Exécute la ligne : $ba_bec_pseudo = "";
$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY'); // Exécute la ligne : $ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY');
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8'); // Exécute la ligne : $ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") { // Exécute la ligne : if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']); // Exécute la ligne : $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']);
    $ba_bec_password = ctrlSaisies($_POST['password']); // Exécute la ligne : $ba_bec_password = ctrlSaisies($_POST['password']);

    if (empty($ba_bec_pseudo)) { // Exécute la ligne : if (empty($ba_bec_pseudo)) {
        $ba_bec_errorPseudo = "Le nom d'utilisateur est requis."; // Exécute la ligne : $ba_bec_errorPseudo = "Le nom d'utilisateur est requis.";
    } // Exécute la ligne : }

    if (empty($ba_bec_password)) { // Exécute la ligne : if (empty($ba_bec_password)) {
        $ba_bec_errorPassword = "Le mot de passe est requis."; // Exécute la ligne : $ba_bec_errorPassword = "Le mot de passe est requis.";
    } // Exécute la ligne : }

    if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword)) { // Exécute la ligne : if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword)) {
        $ba_bec_recaptcha = verifyRecaptcha($_POST['g-recaptcha-response'] ?? '', 'login'); // Exécute la ligne : $ba_bec_recaptcha = verifyRecaptcha($_POST['g-recaptcha-response'] ?? '', 'login');
        if (!$ba_bec_recaptcha['valid']) { // Exécute la ligne : if (!$ba_bec_recaptcha['valid']) {
            $ba_bec_errorCaptcha = $ba_bec_recaptcha['message'] ?: 'Échec de la vérification reCAPTCHA.'; // Exécute la ligne : $ba_bec_errorCaptcha = $ba_bec_recaptcha['message'] ?: 'Échec de la vérification reCAPTCHA.';
        } // Exécute la ligne : }
    } // Exécute la ligne : }

    if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword) && empty($ba_bec_errorCaptcha)) { // Exécute la ligne : if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword) && empty($ba_bec_errorCaptcha)) {
        // Vérifier si l'utilisateur existe // Exécute la ligne : // Vérifier si l'utilisateur existe
        $ba_bec_user = sql_select("MEMBRE", "*", "pseudoMemb = '$ba_bec_pseudo'"); // Exécute la ligne : $ba_bec_user = sql_select("MEMBRE", "*", "pseudoMemb = '$ba_bec_pseudo'");

        if ($ba_bec_user && password_verify($ba_bec_password, $ba_bec_user[0]['passMemb'])) { // Exécute la ligne : if ($ba_bec_user && password_verify($ba_bec_password, $ba_bec_user[0]['passMemb'])) {
            // Connexion réussie // Exécute la ligne : // Connexion réussie
            $_SESSION['user_id'] = $ba_bec_user[0]['numMemb']; // Exécute la ligne : $_SESSION['user_id'] = $ba_bec_user[0]['numMemb'];
            $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb']; // Exécute la ligne : $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb'];
            $_SESSION['numStat'] = $ba_bec_user[0]['numStat']; // ✅ Stocker le statut // Exécute la ligne : $_SESSION['numStat'] = $ba_bec_user[0]['numStat']; // ✅ Stocker le statut
            header("Location: " . ROOT_URL . "/index.php"); // Exécute la ligne : header("Location: " . ROOT_URL . "/index.php");
            exit(); // Exécute la ligne : exit();
        } else { // Exécute la ligne : } else {
            $ba_bec_errorPassword = "Nom d'utilisateur ou mot de passe incorrect."; // Exécute la ligne : $ba_bec_errorPassword = "Nom d'utilisateur ou mot de passe incorrect.";
        } // Exécute la ligne : }
    } // Exécute la ligne : }
} // Exécute la ligne : }
?> <!-- Rend la fermeture du bloc PHP. -->

<?php // Exécute la ligne : <?php
$pageStyles = [ // Exécute la ligne : $pageStyles = [
    ROOT_URL . '/src/css/login.css', // Exécute la ligne : ROOT_URL . '/src/css/login.css',
]; // Exécute la ligne : ];
include '../../../header.php';  /* Exécute la ligne : include '../../../header.php'; ?> */ ?>


<main class="auth-page"> <!-- Rend la ligne HTML : <main class="auth-page"> -->
    <section class="auth-card"> <!-- Rend la ligne HTML : <section class="auth-card"> -->
        <h1 class="text-center">Se connecter</h1> <!-- Rend la ligne HTML : <h1 class="text-center">Se connecter</h1> -->
        <?php if ($ba_bec_success):  /* Exécute la ligne : <?php if ($ba_bec_success): ?> */ ?>
                <div class="alert alert-success"><?= htmlspecialchars($ba_bec_success)  /* Exécute la ligne : <div class="alert alert-success"><?= htmlspecialchars($ba_bec_success) ?></div> */ ?></div>
        <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
        <?php if (isset($_SESSION['error'])):  /* Exécute la ligne : <?php if (isset($_SESSION['error'])): ?> */ ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error'])  /* Exécute la ligne : <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div> */ ?></div>
            <?php unset($_SESSION['error']);  /* Exécute la ligne : <?php unset($_SESSION['error']); ?> <!-- Efface le message après affichage --> */ ?> <!-- Efface le message après affichage -->
        <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>

        <form action="" method="post" class="auth-form"> <!-- Rend la ligne HTML : <form action="" method="post" class="auth-form"> -->
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-login"> <!-- Rend la ligne HTML : <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-login"> -->
            <div class="auth-stack"> <!-- Rend la ligne HTML : <div class="auth-stack"> -->
                <!-- Nom d'utilisateur --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ"> <!-- Rend la ligne HTML : <div class="champ"> -->
                    <label for="pseudo">Nom d'utilisateur :</label> <!-- Rend la ligne HTML : <label for="pseudo">Nom d'utilisateur :</label> -->
                    <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($ba_bec_pseudo)  /* Exécute la ligne : <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($ba_bec_pseudo) ?>" required> */ ?>" required>
                    <?php if (!empty($ba_bec_errorPseudo)):  /* Exécute la ligne : <?php if (!empty($ba_bec_errorPseudo)): ?> */ ?>
                        <div class="alert alert-danger mt-2"><?= $ba_bec_errorPseudo  /* Exécute la ligne : <div class="alert alert-danger mt-2"><?= $ba_bec_errorPseudo ?></div> */ ?></div>
                    <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
                </div> <!-- Rend la ligne HTML : </div> -->

                <!-- Mot de passe --> <!-- Ajoute un commentaire HTML. -->
                <div class="champ"> <!-- Rend la ligne HTML : <div class="champ"> -->
                    <label for="mdp">Mot de passe :</label> <!-- Rend la ligne HTML : <label for="mdp">Mot de passe :</label> -->
                    <div class="input-with-icon"> <!-- Rend la ligne HTML : <div class="input-with-icon"> -->
                        <input type="password" id="mdp" name="password" required> <!-- Rend la ligne HTML : <input type="password" id="mdp" name="password" required> -->
                        <button <!-- Rend la ligne HTML : <button -->
                            class="password-toggle" <!-- Rend la ligne HTML : class="password-toggle" -->
                            type="button" <!-- Rend la ligne HTML : type="button" -->
                            data-target="mdp" <!-- Rend la ligne HTML : data-target="mdp" -->
                            aria-label="Afficher le mot de passe" <!-- Rend la ligne HTML : aria-label="Afficher le mot de passe" -->
                        > <!-- Rend la ligne HTML : > -->
                            <span class="icon icon-closed">Afficher</span> <!-- Rend la ligne HTML : <span class="icon icon-closed">Afficher</span> -->
                            <span class="icon icon-open">Masquer</span> <!-- Rend la ligne HTML : <span class="icon icon-open">Masquer</span> -->
                        </button> <!-- Rend la ligne HTML : </button> -->
                    </div> <!-- Rend la ligne HTML : </div> -->
                    <?php if (!empty($ba_bec_errorPassword)):  /* Exécute la ligne : <?php if (!empty($ba_bec_errorPassword)): ?> */ ?>
                        <div class="alert alert-danger mt-2"><?= $ba_bec_errorPassword  /* Exécute la ligne : <div class="alert alert-danger mt-2"><?= $ba_bec_errorPassword ?></div> */ ?></div>
                    <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
                    <?php if (!empty($ba_bec_errorCaptcha)):  /* Exécute la ligne : <?php if (!empty($ba_bec_errorCaptcha)): ?> */ ?>
                        <div class="alert alert-danger mt-2"><?= $ba_bec_errorCaptcha  /* Exécute la ligne : <div class="alert alert-danger mt-2"><?= $ba_bec_errorCaptcha ?></div> */ ?></div>
                    <?php endif;  /* Exécute la ligne : <?php endif; ?> */ ?>
                </div> <!-- Rend la ligne HTML : </div> -->
            </div> <!-- Rend la ligne HTML : </div> -->

            <!-- Boutons --> <!-- Ajoute un commentaire HTML. -->
            <div class="btn-se-connecter"> <!-- Rend la ligne HTML : <div class="btn-se-connecter"> -->
                <button type="submit">Se connecter</button> <!-- Rend la ligne HTML : <button type="submit">Se connecter</button> -->
                <a  href="/views/backend/security/mdpoublié.php" class="link">Mot de passe oublié ?</a> <!-- Rend la ligne HTML : <a  href="/views/backend/security/mdpoublié.php" class="link">Mot de passe oublié ?</a> -->
            </div> <!-- Rend la ligne HTML : </div> -->

            <p>Vous aimez le BEC ? <Inscrivez-vous>!</Inscrivez-vous> <br> <!-- Rend la ligne HTML : <p>Vous aimez le BEC ? <Inscrivez-vous>!</Inscrivez-vous> <br> -->
                <a href="/views/backend/security/signup.php" class="link">Créez un compte</a> <!-- Rend la ligne HTML : <a href="/views/backend/security/signup.php" class="link">Créez un compte</a> -->
            </p> <!-- Rend la ligne HTML : </p> -->
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
        var tokenInput = document.getElementById('g-recaptcha-response-login'); // Exécute la ligne : var tokenInput = document.getElementById('g-recaptcha-response-login');
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
                grecaptcha.execute(siteKey, {action: 'login'}) // Exécute la ligne : grecaptcha.execute(siteKey, {action: 'login'})
                    .then(function (token) { // Exécute la ligne : .then(function (token) {
                        tokenInput.value = token; // Exécute la ligne : tokenInput.value = token;
                        isSubmitting = true; // Exécute la ligne : isSubmitting = true;
                        form.submit(); // Exécute la ligne : form.submit();
                    }); // Exécute la ligne : });
            }); // Exécute la ligne : });
        }); // Exécute la ligne : });
    })(); // Exécute la ligne : })();
</script> <!-- Rend la ligne HTML : </script> -->
