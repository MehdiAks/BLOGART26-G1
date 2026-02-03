<?php


session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../../functions/ctrlSaisies.php';


// Vérifier si l'utilisateur a refusé les cookies
if (isset($_COOKIE['cookieConsent']) && $_COOKIE['cookieConsent'] === "rejected") {
    header("Location: " . ROOT_URL . "/index.php");
    exit();
}


$ba_bec_success = $_SESSION['success'] ?? null;
$ba_bec_errorPseudo = $ba_bec_errorPassword = "";
$ba_bec_pseudo = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']);
    $ba_bec_password = ctrlSaisies($_POST['password']);

    if (empty($ba_bec_pseudo)) {
        $ba_bec_errorPseudo = "Le nom d'utilisateur est requis.";
    }

    if (empty($ba_bec_password)) {
        $ba_bec_errorPassword = "Le mot de passe est requis.";
    }

    if (empty($ba_bec_errorPseudo) && empty($ba_bec_errorPassword)) {
        // Vérifier si l'utilisateur existe
        $ba_bec_user = sql_select("MEMBRE", "*", "pseudoMemb = '$ba_bec_pseudo'");

        if ($ba_bec_user && password_verify($ba_bec_password, $ba_bec_user[0]['passMemb'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $ba_bec_user[0]['numMemb'];
            $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb'];
            $_SESSION['numStat'] = $ba_bec_user[0]['numStat']; // ✅ Stocker le statut

            header("Location: " . ROOT_URL . "/index.php");
            exit();
        } else {
            $ba_bec_errorPassword = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
}
?>

<?php include '../../../header.php'; ?>

<main class="auth-page">
    <section class="auth-card">
        <h1 class="text-center">Se connecter</h1>
        <?php if ($ba_bec_success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($ba_bec_success) ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?> <!-- Efface le message après affichage -->
        <?php endif; ?>

        <form action="" method="post" class="auth-form">
            <div class="auth-stack">
                <!-- Nom d'utilisateur -->
                <div class="champ">
                    <label for="pseudo">Nom d'utilisateur :</label>
                    <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($ba_bec_pseudo) ?>" required>
                    <?php if (!empty($ba_bec_errorPseudo)): ?>
                        <div class="alert alert-danger mt-2"><?= $ba_bec_errorPseudo ?></div>
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
                            <img class="icon icon-closed" src="<?php echo ROOT_URL . '/src/images/eye-closed.png'; ?>" alt="Masquer le mot de passe">
                            <img class="icon icon-open" src="<?php echo ROOT_URL . '/src/images/eye-open.png'; ?>" alt="Afficher le mot de passe">
                        </button>
                    </div>
                    <?php if (!empty($ba_bec_errorPassword)): ?>
                        <div class="alert alert-danger mt-2"><?= $ba_bec_errorPassword ?></div>
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
