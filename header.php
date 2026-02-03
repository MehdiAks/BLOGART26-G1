<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$ba_bec_pseudoMemb = $_SESSION['pseudoMemb'] ?? null;
$ba_bec_numStat = $_SESSION['numStat'] ?? null;
$hasBackgroundVideo = $pageHasVideo ?? false;
$current_page = $_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bordeaux Etudiants Club</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/reset.css'; ?>" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/style.css'; ?>" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/fonts.css'; ?>" rel="stylesheet">
        <link href="<?php echo ROOT_URL . '/src/css/css-header-footer/header-et-footer.css'; ?>" rel="stylesheet">
    <link rel="icon" type="image/png" href="/src/images/logo.png" />
    <?php if (!empty($pageStyles) && is_array($pageStyles)) : ?>
        <?php foreach ($pageStyles as $stylePath) : ?>
            <link href="<?php echo htmlspecialchars($stylePath); ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body class="<?php echo $hasBackgroundVideo ? 'has-site-video' : 'has-solid-bg'; ?>">
    <?php if ($hasBackgroundVideo): ?>
        <div class="site-background" aria-hidden="true">
            <video class="site-background-video" autoplay muted loop playsinline poster="<?php echo ROOT_URL . '/src/images/background/background-index.jpg'; ?>">
                <source src="<?php echo ROOT_URL . '/src/videos/fond.mp4'; ?>" type="video/mp4">
            </video>
            <div class="site-background-overlay"></div>
        </div>
    <?php endif; ?>
    <header class="site-header">
        <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3 py-3">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo ROOT_URL . '/index.php'; ?>">
                <img src="<?php echo ROOT_URL . '/src/images/logo.png'; ?>" alt="BEC" class="site-logo">
                <span>Bordeaux Étudiant Club</span>
            </a>

            <nav class="header-nav" aria-label="Navigation principale">
                <ul>
                    <li>
                        <a href="<?php echo ROOT_URL . '/index.php'; ?>" <?php if ($current_page == '/index.php') echo 'class="current"'; ?>>Accueil</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL . '/notre-histoire.php'; ?>" <?php if ($current_page == '/notre-histoire.php') echo 'class="current"'; ?>>Notre histoire</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL . '/actualites.php'; ?>" <?php if ($current_page == '/actualites.php') echo 'class="current"'; ?>>Actualités</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL . '/matches.php'; ?>" <?php if ($current_page == '/matches.php') echo 'class="current"'; ?>>Matchs</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL . '/anciens-et-amis.php'; ?>" <?php if ($current_page == '/anciens-et-amis.php') echo 'class="current"'; ?>>Anciens et amis</a>
                    </li>
                </ul>
            </nav>

            <div class="header-burger-wrapper">
                <details class="header-burger-menu">
                    <summary class="header-burger-toggle" aria-label="Ouvrir le menu">
                        <span class="header-burger-icon" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </summary>
                    <div class="header-burger-panel">
                        <button type="button" class="header-burger-close" aria-label="Fermer le menu" onclick="this.closest('details').removeAttribute('open')">
                            &times;
                        </button>
                        <div class="header-burger-actions">
                            <p class="header-burger-title">Espace membre</p>
                            <?php if ($ba_bec_pseudoMemb): ?>
                                <div class="header-burger-user">
                                    <span><?php echo htmlspecialchars($ba_bec_pseudoMemb); ?></span>
                                </div>
                                <div class="header-burger-links">
                                    <a href="<?php echo ROOT_URL . '/compte.php'; ?>">Mon compte</a>
                                    <?php if ($ba_bec_numStat === 1 || $ba_bec_numStat === 2): ?>
                                        <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>">Panneau admin</a>
                                    <?php endif; ?>
                                    <a class="header-burger-logout" href="<?php echo ROOT_URL . '/api/security/disconnect.php'; ?>">Déconnexion</a>
                                </div>
                            <?php else: ?>
                                <a class="btn btn-bec-primary w-100" href="<?php echo ROOT_URL . '/views/backend/security/login.php'; ?>">
                                    Connexion / Inscription
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </header>
    <main class="site-main container py-5">
