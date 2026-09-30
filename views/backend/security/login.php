<?php
/*
 * Vue d'administration (authentification/inscription).
 * - Cette page expose un formulaire de sécurité pour se connecter, s'inscrire ou réinitialiser un mot de passe.
 * - Les champs sont validés via les attributs HTML et envoyés vers la route d'authentification dédiée.
 * - Les messages d'aide guident l'utilisateur sur la procédure à suivre.
 * - La vue reste passive : elle ne fait que collecter les données et afficher les retours serveur.
 */


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../../functions/ctrlSaisies.php';


$ba_bec_success = $_SESSION['success'] ?? null;
$ba_bec_errorPseudo = $ba_bec_errorPassword = $ba_bec_errorCaptcha = "";
$ba_bec_pseudo = "";
$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY');
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']);
    $ba_bec_password = (string) ($_POST['password'] ?? '');

    if (empty($ba_bec_pseudo)) {
        $ba_bec_errorPseudo = "Le nom d'utilisateur est requis.";
    }

    if (empty($ba_bec_password)) {
        $ba_bec_errorPassword = "Le mot de passe est requis.";
    }

    if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword)) {
        $ba_bec_recaptcha = verifyRecaptcha($_POST['g-recaptcha-response'] ?? '', 'login');
        if (!$ba_bec_recaptcha['valid']) {
            $ba_bec_errorCaptcha = $ba_bec_recaptcha['message'] ?: 'Échec de la vérification reCAPTCHA.';
        }
    }

    if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword) && empty($ba_bec_errorCaptcha)) {
        // Applique la limitation par adresse avant toute lecture du compte.
        if (login_throttle_blocked($ba_bec_pseudo)) {
            $ba_bec_errorPassword = 'Trop de tentatives, réessayez dans 15 minutes';
        }
        $ba_bec_user = empty($ba_bec_errorPassword)
            ? sql_select('MEMBRE', '*', 'pseudoMemb = ?', null, null, '1', [$ba_bec_pseudo])
            : [];
        $ba_bec_validRaw = $ba_bec_user && password_verify($ba_bec_password, $ba_bec_user[0]['passMemb']);
        // Reproduit la transformation historique uniquement comme solution de compatibilité.
        $ba_bec_validLegacy = !$ba_bec_validRaw && $ba_bec_user
            && password_verify(legacy_password_variant($ba_bec_password), $ba_bec_user[0]['passMemb']);

        if ($ba_bec_validRaw || $ba_bec_validLegacy) {
            // Remplace les anciens hash par un hash du mot de passe brut.
            if ($ba_bec_validLegacy || password_needs_rehash($ba_bec_user[0]['passMemb'], PASSWORD_DEFAULT)) {
                sql_update('MEMBRE', 'passMemb = ?', 'numMemb = ?', [password_hash($ba_bec_password, PASSWORD_DEFAULT), (int) $ba_bec_user[0]['numMemb']]);
            }
            login_throttle_clear();
            session_regenerate_id(true);
            // Connexion réussie
            $_SESSION['user_id'] = (int) $ba_bec_user[0]['numMemb'];
            $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb'];
            $_SESSION['numStat'] = (int) $ba_bec_user[0]['numStat'];
            header("Location: " . ROOT_URL . "/index.php");
            exit();
        } else {
            if (empty($ba_bec_errorPassword)) {
                login_throttle_fail($ba_bec_pseudo);
                $ba_bec_errorPassword = "Nom d'utilisateur ou mot de passe incorrect";
            }
        }
    }
}
?>

<?php
$pageStyles = [
    ROOT_URL . '/src/css/login.css',
];
$pageTitle = 'Connexion';
include '../../../header.php'; ?>


<main class="auth-page">
    <section class="auth-card">
        <h1 class="text-center">Se connecter</h1>
        <?php if ($ba_bec_success): ?>
                <div class="alert alert-success"><?= e($ba_bec_success) ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?> <!-- Efface le message après affichage -->
        <?php endif; ?>

        <form action="" method="post" class="auth-form">
            <?= csrf_field() ?>
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-login">
            <div class="auth-stack">
                <!-- Nom d'utilisateur -->
                <div class="champ">
                    <label for="pseudo">Nom d'utilisateur :</label>
                    <input type="text" id="pseudo" name="pseudo" value="<?= e($ba_bec_pseudo) ?>" required>
                    <?php if (!empty($ba_bec_errorPseudo)): ?>
                        <div class="alert alert-danger mt-2"><?= e($ba_bec_errorPseudo) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Mot de passe -->
                <div class="champ">
                    <label for="mdp">Mot de passe :</label>
                    <div class="input-with-icon">
                        <input type="password" id="mdp" name="password" required>
                        <button
                            class="password-toggle"
                            type="button"
                            data-target="mdp"
                            aria-label="Afficher le mot de passe"
                        >
                            <span class="icon icon-closed">Afficher</span>
                            <span class="icon icon-open">Masquer</span>
                        </button>
                    </div>
                    <?php if (!empty($ba_bec_errorPassword)): ?>
                        <div class="alert alert-danger mt-2"><?= e($ba_bec_errorPassword) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($ba_bec_errorCaptcha)): ?>
                        <div class="alert alert-danger mt-2"><?= e($ba_bec_errorCaptcha) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Boutons -->
            <div class="btn-se-connecter">
                <button type="submit">Se connecter</button>
                <a  href="/views/backend/security/mdpoublié.php" class="link">Mot de passe oublié ?</a>
            </div>

            <p>Vous aimez le BEC ? <Inscrivez-vous>!</Inscrivez-vous> <br>
                <a href="/views/backend/security/signup.php" class="link">Créez un compte</a>
            </p>
        </form>
    </section>
</main>

<?php if (!empty($ba_bec_recaptchaSiteKey)): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>"></script>
<?php endif; ?>

<script>
    document.querySelectorAll('.password-toggle').forEach((button) => {
        const input = document.getElementById(button.dataset.target);
        const show = () => {
            input.type = 'text';
            button.classList.add('is-visible');
        };
        const hide = () => {
            input.type = 'password';
            button.classList.remove('is-visible');
        };

        button.addEventListener('pointerdown', (event) => {
            event.preventDefault();
            show();
        });
        button.addEventListener('pointerleave', hide);
        button.addEventListener('pointercancel', hide);
        button.addEventListener('keydown', (event) => {
            if (event.code === 'Space' || event.code === 'Enter') {
                show();
            }
        });
        button.addEventListener('keyup', hide);

        document.addEventListener('pointerup', hide);
        document.addEventListener('pointercancel', hide);
        document.addEventListener('touchend', hide);
    });
</script>
<script>
    (function () {
        var form = document.querySelector('.auth-form');
        var tokenInput = document.getElementById('g-recaptcha-response-login');
        var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>';
        if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') {
            return;
        }

        var isSubmitting = false;
        form.addEventListener('submit', function (event) {
            if (isSubmitting) {
                return;
            }
            event.preventDefault();
            if (typeof grecaptcha === 'undefined') {
                form.submit();
                return;
            }
            grecaptcha.ready(function () {
                grecaptcha.execute(siteKey, {action: 'login'})
                    .then(function (token) {
                        tokenInput.value = token;
                        isSubmitting = true;
                        form.submit();
                    });
            });
        });
    })();
</script>
