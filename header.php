<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/includes/libs/cookie-consent.php';
$ba_bec_headerStat = current_user_id() !== null ? current_user_stat() : null;
$ba_bec_headerPseudo = $ba_bec_headerStat !== null ? ($_SESSION['pseudoMemb'] ?? null) : null;
$current_page = $_SERVER['SCRIPT_NAME'];
$pageTitle = $pageTitle ?? null;
if ($pageTitle === null && strpos($current_page, '/views/backend/') !== false) {
    $ba_bec_adminSections = [
        'articles' => 'Articles', 'benevoles' => 'Bénévoles', 'boutique' => 'Boutique',
        'comments' => 'Commentaires', 'equipes' => 'Équipes', 'joueurs' => 'Joueurs',
        'keywords' => 'Mots-clés', 'likes' => 'Likes', 'matches' => 'Matchs',
        'members' => 'Membres', 'statuts' => 'Statuts', 'thematiques' => 'Thématiques',
    ];
    $ba_bec_adminSection = basename(dirname($current_page));
    $pageTitle = ($ba_bec_adminSections[$ba_bec_adminSection] ?? 'Administration') . ' · Administration';
}
$pageDescription = $pageDescription ?? 'Site officiel du Bordeaux Étudiant Club Basket : matchs, résultats, équipes et actualités du club.';
$documentTitle = $pageTitle ? $pageTitle . ' · Bordeaux Étudiant Club' : 'Bordeaux Étudiant Club · Basket à Bordeaux';
$ogImage = ROOT_URL . '/src/images/background/background-index-1.webp';
$club_pages = ['/Pages_supplementaires/notre-histoire.php', '/Pages_supplementaires/organigramme-benevoles.php', '/Pages_supplementaires/equipes.php', '/Pages_supplementaires/equipe.php', '/Pages_supplementaires/joueurs.php', '/Pages_supplementaires/nos-partenaires.php'];
$isClubPage = in_array($current_page, $club_pages, true);
$ba_bec_cookieConsent = null;
if (function_exists('sql_connect')) {
    global $DB;
    if (!$DB) { sql_connect(); }
    if (!empty($DB)) { $ba_bec_cookieConsent = getCookieConsent($DB); }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($documentTitle); ?></title>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($documentTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:image" content="<?php echo e($ogImage); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.svg'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/tokens.css'; ?>" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/fonts.css'; ?>" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/style.css'; ?>" rel="stylesheet">
    <link href="<?php echo ROOT_URL . '/src/css/css-header-footer/header-et-footer.css'; ?>" rel="stylesheet">
    <?php if (!empty($pageStyles) && is_array($pageStyles)) : ?>
        <?php foreach ($pageStyles as $stylePath) : ?><link href="<?php echo e($stylePath); ?>" rel="stylesheet"><?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <a class="skip-link" href="#main-content">Aller au contenu</a>
    <header class="site-header">
        <div class="container site-header__inner">
            <a class="site-brand" href="<?php echo ROOT_URL . '/index.php'; ?>" aria-label="Bordeaux Étudiant Club, accueil">
                <img class="site-logo" src="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.svg'; ?>" alt="">
                <span class="site-brand__full">Bordeaux Étudiant Club</span><span class="site-brand__short">BEC</span>
            </a>
            <nav class="header-nav" aria-label="Navigation principale">
                <a href="<?php echo ROOT_URL . '/index.php'; ?>"<?php echo $current_page === '/index.php' ? ' class="current" aria-current="page"' : ''; ?>>Accueil</a>
                <details class="header-submenu">
                    <summary class="submenu-toggle<?php echo $isClubPage ? ' current' : ''; ?>">Le club <span aria-hidden="true">⌄</span></summary>
                    <div class="submenu-list" id="submenu-club-desktop">
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/notre-histoire.php'; ?>">Notre histoire</a>
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/organigramme-benevoles.php'; ?>">Bénévoles</a>
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/equipes.php'; ?>">Équipes</a>
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/joueurs.php'; ?>">Joueurs</a>
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/nos-partenaires.php'; ?>">Partenaires</a>
                    </div>
                </details>
                <a href="<?php echo ROOT_URL . '/actualites.php'; ?>"<?php echo $current_page === '/actualites.php' || $current_page === '/article.php' ? ' class="current" aria-current="page"' : ''; ?>>Actualités</a>
                <a href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>"<?php echo $current_page === '/Pages_supplementaires/calendrier.php' ? ' class="current" aria-current="page"' : ''; ?>>Calendrier</a>
                <a href="<?php echo ROOT_URL . '/anciens-et-amis.php'; ?>"<?php echo $current_page === '/anciens-et-amis.php' ? ' class="current" aria-current="page"' : ''; ?>>Anciens et amis</a>
            </nav>
            <div class="header-actions">
                <a class="btn btn-boutique-header" href="<?php echo ROOT_URL . '/Pages_supplementaires/boutique.php'; ?>">Boutique</a>
                <details class="header-account">
                    <summary class="btn btn-compte"><?php echo $ba_bec_headerPseudo ? e($ba_bec_headerPseudo) : 'Compte'; ?></summary>
                    <div class="header-account__panel">
                        <?php if ($ba_bec_headerPseudo): ?>
                            <strong><?php echo e($ba_bec_headerPseudo); ?></strong>
                            <a href="<?php echo ROOT_URL . '/Pages_supplementaires/compte.php'; ?>">Mon compte</a>
                            <?php if ($ba_bec_headerStat === 1): ?><a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>">Panneau admin</a><?php endif; ?>
                            <?php if ($ba_bec_headerStat === 2): ?><a href="<?php echo ROOT_URL . '/views/backend/comments/list.php'; ?>">Modération</a><?php endif; ?>
                            <form action="<?php echo ROOT_URL . '/api/security/disconnect.php'; ?>" method="post"><?php echo csrf_field(); ?><button class="header-logout" type="submit">Déconnexion</button></form>
                        <?php else: ?><a href="<?php echo ROOT_URL . '/views/backend/security/login.php'; ?>">Se connecter</a><?php endif; ?>
                    </div>
                </details>
            </div>
            <details class="mobile-menu">
                <summary class="mobile-menu__toggle" aria-label="Ouvrir le menu"><span></span><span></span><span></span></summary>
                <div class="mobile-menu__panel">
                    <div class="mobile-menu__top"><span>Menu</span><button class="mobile-menu__close" type="button" aria-label="Fermer le menu" onclick="this.closest('details').removeAttribute('open')">×</button></div>
                    <nav aria-label="Navigation mobile">
                        <a href="<?php echo ROOT_URL . '/index.php'; ?>">Accueil</a>
                        <details class="mobile-club-menu"><summary>Le club</summary><div id="submenu-club-mobile">
                            <a href="<?php echo ROOT_URL . '/Pages_supplementaires/notre-histoire.php'; ?>">Notre histoire</a><a href="<?php echo ROOT_URL . '/Pages_supplementaires/organigramme-benevoles.php'; ?>">Bénévoles</a><a href="<?php echo ROOT_URL . '/Pages_supplementaires/equipes.php'; ?>">Équipes</a><a href="<?php echo ROOT_URL . '/Pages_supplementaires/joueurs.php'; ?>">Joueurs</a><a href="<?php echo ROOT_URL . '/Pages_supplementaires/nos-partenaires.php'; ?>">Partenaires</a>
                        </div></details>
                        <a href="<?php echo ROOT_URL . '/actualites.php'; ?>">Actualités</a><a href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>">Calendrier</a><a href="<?php echo ROOT_URL . '/anciens-et-amis.php'; ?>">Anciens et amis</a>
                    </nav>
                    <div class="mobile-menu__actions"><a class="btn btn-boutique-header" href="<?php echo ROOT_URL . '/Pages_supplementaires/boutique.php'; ?>">Boutique</a><a class="btn btn-bec-primary" href="<?php echo $ba_bec_headerPseudo ? ROOT_URL . '/Pages_supplementaires/compte.php' : ROOT_URL . '/views/backend/security/login.php'; ?>"><?php echo $ba_bec_headerPseudo ? 'Mon compte' : 'Compte'; ?></a></div>
                </div>
            </details>
        </div>
    </header>
    <?php if ($ba_bec_cookieConsent === null): ?>
        <section class="cookie-popup" id="cookie-popup" aria-labelledby="cookie-title" hidden>
            <div class="cookie-content"><div><h2 id="cookie-title">Vos préférences de cookies</h2><p>Le site utilise uniquement les cookies nécessaires à son fonctionnement et à votre choix de consentement.</p></div><div class="cookie-buttons"><button type="button" class="btn btn-outline-light" data-cookie-choice="0">Refuser</button><button type="button" class="btn btn-light" data-cookie-choice="1">Accepter</button></div></div>
        </section>
        <script>
            (function () { var popup = document.getElementById('cookie-popup'); if (!popup) return; popup.hidden = false; popup.querySelectorAll('[data-cookie-choice]').forEach(function (button) { button.addEventListener('click', function () { var formData = new FormData(); formData.append('consent', button.getAttribute('data-cookie-choice')); fetch('<?php echo ROOT_URL . '/api/security/cookie-consent.php'; ?>', {method: 'POST', credentials: 'same-origin', headers: {'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content}, body: formData}).finally(function () { popup.hidden = true; }); }); }); })();
        </script>
    <?php endif; ?>
    <script>
        (function () {
            var menu = document.querySelector('.mobile-menu');
            if (!menu) return;
            menu.addEventListener('toggle', function () {
                document.body.classList.toggle('mobile-menu-open', menu.open);
            });
            menu.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () { menu.removeAttribute('open'); });
            });
        })();
    </script>
    <div class="site-main" id="main-content">
