<?php
// ===============================
// BOOTSTRAP
// ===============================
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/includes/libs/cookie-consent.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===============================
// DB CONNECTION (PDO)
// ===============================
if (!isset($DB)) {
    sql_connect();
}
$pdo = $DB ?? null;

// ===============================
// TRAITEMENT COOKIE (POST)
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept_cookies'])) {
        saveCookieConsent($pdo, 1);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if (isset($_POST['reject_cookies'])) {
        saveCookieConsent($pdo, 0);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// ===============================
// DONNÉES SESSION / PAGE
// ===============================
$ba_bec_pseudoMemb = $_SESSION['pseudoMemb'] ?? null;
$ba_bec_numStat    = $_SESSION['numStat'] ?? null;
$hasBackgroundVideo = $pageHasVideo ?? false;
$current_page = $_SERVER['SCRIPT_NAME'];

// ===============================
// CONSENTEMENT COOKIES
// ===============================
$cookieConsent = getCookieConsent($pdo); // NULL | 0 | 1
$ba_bec_cookieChoiceRequired = ($cookieConsent === null);

// ===============================
// CLASSES BODY
// ===============================
$bodyClasses = [
    $hasBackgroundVideo ? 'has-site-video' : 'has-solid-bg'
];

if ($ba_bec_cookieChoiceRequired) {
    $bodyClasses[] = 'cookie-choice-required';
}

// ===============================
// PAGES CLUB
// ===============================
$club_pages = [
    '/notre-histoire.php',
    '/organigramme-benevoles.php',
    '/equipes.php',
    '/joueurs.php',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bordeaux Étudiant Club</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>/src/css/css-propre/reset.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>/src/css/css-propre/style.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>/src/css/css-propre/fonts.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>/src/css/css-header-footer/header-et-footer.css" rel="stylesheet">

    <?php if (!empty($pageStyles) && is_array($pageStyles)) : ?>
        <?php foreach ($pageStyles as $stylePath) : ?>
            <link href="<?= htmlspecialchars($stylePath) ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>

    <link rel="icon" type="image/png" href="/src/images/logo/logo-bec/logo.svg">
</head>

<body class="<?= implode(' ', $bodyClasses) ?>">

<?php if ($ba_bec_cookieChoiceRequired): ?>
    <!-- COOKIE POPUP -->
    <div class="cookie-overlay" aria-hidden="true"></div>
    <div class="cookie-popup" role="dialog" aria-modal="true"
         aria-labelledby="cookie-title" aria-describedby="cookie-description">
        <div class="cookie-content">
            <h2 id="cookie-title">Préférences cookies</h2>
            <p id="cookie-description">
                Nous utilisons des cookies pour améliorer votre expérience.
                Merci de choisir une option pour continuer votre navigation.
            </p>

            <form method="post" class="cookie-buttons">
                <button type="submit" name="accept_cookies" class="btn btn-light">
                    Accepter
                </button>
                <button type="submit" name="reject_cookies" class="btn btn-outline-light">
                    Refuser
                </button>
            </form>

            <a href="<?= ROOT_URL ?>/infoleg/rgpd.php"
               class="text-white-50 small d-block mt-3">
                En savoir plus
            </a>
        </div>
    </div>
<?php endif; ?>

<?php if ($hasBackgroundVideo): ?>
    <!-- BACKGROUND VIDEO -->
    <div class="site-background" aria-hidden="true">
        <video class="site-background-video" autoplay muted loop playsinline
               poster="<?= ROOT_URL ?>/src/images/background/background-index-1.webp">
            <source src="<?= ROOT_URL ?>/src/videos/fond.mp4" type="video/mp4">
        </video>
        <div class="site-background-overlay"></div>
    </div>
<?php endif; ?>

<header class="site-header">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3 py-2">
        <a class="navbar-brand d-flex align-items-center gap-2"
           href="<?= ROOT_URL ?>/index.php">
            <img src="<?= ROOT_URL ?>/src/images/logo/logo-bec/logo.png"
                 alt="BEC" class="site-logo">
            <span>Bordeaux Étudiant Club</span>
        </a>

        <!-- NAVIGATION DESKTOP -->
        <nav class="header-nav" aria-label="Navigation principale">
            <ul>
                <li><a href="<?= ROOT_URL ?>/index.php"
                       <?= $current_page === '/index.php' ? 'class="current"' : '' ?>>
                    Accueil</a></li>

                <li>
                    <div class="header-submenu">
                        <button type="button"
                                class="submenu-toggle<?= in_array($current_page, $club_pages, true) ? ' current' : '' ?>"
                                aria-haspopup="true" aria-expanded="false">
                            Le club
                        </button>
                        <ul class="submenu-list">
                            <li><a href="<?= ROOT_URL ?>/notre-histoire.php">Notre histoire</a></li>
                            <li><a href="<?= ROOT_URL ?>/organigramme-benevoles.php">Bénévoles</a></li>
                            <li><a href="<?= ROOT_URL ?>/joueurs.php">Joueurs</a></li>
                            <li><a href="<?= ROOT_URL ?>/equipes.php">Équipes</a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="<?= ROOT_URL ?>/actualites.php">Actualités</a></li>
                <li><a href="<?= ROOT_URL ?>/calendrier.php">Calendrier</a></li>
                <li><a href="<?= ROOT_URL ?>/anciens-et-amis.php">Anciens et amis</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="site-main container py-5">
