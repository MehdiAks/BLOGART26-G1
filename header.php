<?php
// Inclut la configuration principale du site depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Inclut la bibliothèque de gestion du consentement aux cookies.
require_once ROOT . '/includes/libs/cookie-consent.php';
// Récupère le pseudo du membre depuis la session ou met null si absent.
$ba_bec_pseudoMemb = $_SESSION['pseudoMemb'] ?? null;
// Récupère le statut du membre depuis la session ou met null si absent.
$ba_bec_numStat = $_SESSION['numStat'] ?? null;
// Indique si la page demande une vidéo de fond ou utilise false par défaut.
$hasBackgroundVideo = $pageHasVideo ?? false;
// Définit la source de la vidéo de fond avec une valeur par défaut.
$backgroundVideoSource = $pageBackgroundVideo ?? (ROOT_URL . '/src/video/Background_index.mp4');
// Définit l'affiche (poster) de la vidéo de fond avec une valeur par défaut.
$backgroundVideoPoster = $pageBackgroundPoster ?? (ROOT_URL . '/src/images/background/background-index-1.webp');
// Récupère le chemin du script courant pour surligner la navigation.
$current_page = $_SERVER['SCRIPT_NAME'];

// Initialise la liste des classes du body selon la présence de la vidéo.
$bodyClasses = [$hasBackgroundVideo ? 'has-site-video' : 'has-solid-bg'];
// Détermine si la page actuelle est la page d'accueil.
$isHomePage = $current_page === '/index.php';
// Ajoute une classe spécifique si on est sur la page d'accueil.
if ($isHomePage) {
    // Ajoute la classe "home-page" dans le tableau des classes du body.
    $bodyClasses[] = 'home-page';
}

// Liste les pages liées au menu "Le club".
$club_pages = [
    // Chemin de la page "Notre histoire".
    '/Pages_supplementaires/notre-histoire.php',
    // Chemin de la page "Bénévoles".
    '/Pages_supplementaires/organigramme-benevoles.php',
    // Chemin de la page "Joueurs".
    '/Pages_supplementaires/joueurs.php',
    // Chemin de la page "Équipes".
    '/Pages_supplementaires/equipes.php',
];

// Initialise la variable de consentement aux cookies à null.
$ba_bec_cookieConsent = null;
// Vérifie si la fonction de connexion SQL existe avant de l'utiliser.
if (function_exists('sql_connect')) {
    // Rend la variable globale $DB accessible dans ce scope.
    global $DB;
    // Connecte la base si l'objet $DB n'est pas encore défini.
    if (!$DB) {
        // Appelle la fonction de connexion à la base de données.
        sql_connect();
    }
    // Vérifie que la connexion est bien disponible.
    if (!empty($DB)) {
        // Récupère le consentement aux cookies depuis la base.
        $ba_bec_cookieConsent = getCookieConsent($DB);
    }
}
?>
<!-- Déclare le type de document HTML. -->
<!DOCTYPE html>
<!-- Ouvre la balise HTML avec la langue définie en français. -->
<html lang="fr">
<!-- Ouvre l'en-tête du document HTML. -->
<head>
    <!-- Définit l'encodage des caractères en UTF-8. -->
    <meta charset="UTF-8">
    <!-- Définit le titre de la page affiché dans l'onglet. -->
    <title>Bordeaux Etudiants Club</title>
    <!-- Rend la page responsive selon la largeur de l'écran. -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Charge la feuille de style Bootstrap depuis un CDN. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Charge la feuille de reset CSS locale. -->
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/reset.css'; ?>" rel="stylesheet">
    <!-- Charge la feuille de style principale locale. -->
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/style.css'; ?>" rel="stylesheet">
    <!-- Charge la feuille de style pour les polices. -->
    <link href="<?php echo ROOT_URL . '/src/css/css-propre/fonts.css'; ?>" rel="stylesheet">
    <!-- Charge la feuille de style dédiée au header et footer. -->
    <link href="<?php echo ROOT_URL . '/src/css/css-header-footer/header-et-footer.css'; ?>" rel="stylesheet">
    <!-- Définit l'icône du site (favicon). -->
    <link rel="icon" type="image/png" href="/src/images/logo/logo-bec/logo.svg" />
    <!-- Vérifie si des styles supplémentaires sont fournis et sont un tableau. -->
    <?php if (!empty($pageStyles) && is_array($pageStyles)) : ?>
        <!-- Parcourt chaque style supplémentaire défini. -->
        <?php foreach ($pageStyles as $stylePath) : ?>
            <!-- Ajoute la feuille de style supplémentaire en échappant le chemin. -->
            <link href="<?php echo htmlspecialchars($stylePath); ?>" rel="stylesheet">
        <!-- Termine la boucle foreach. -->
        <?php endforeach; ?>
    <!-- Termine la condition d'ajout de styles supplémentaires. -->
    <?php endif; ?>

<!-- Ferme l'en-tête du document HTML. -->
</head>

<!-- Ouvre le corps de la page en ajoutant les classes calculées. -->
<body class="<?php echo implode(' ', $bodyClasses); ?>">
    
    <!-- Vérifie si une vidéo de fond doit être affichée. -->
    <?php if ($hasBackgroundVideo): ?>
        <!-- Conteneur de la vidéo de fond, masqué des lecteurs d'écran. -->
        <div class="site-background" aria-hidden="true">
            <!-- Balise vidéo de fond en lecture automatique et en boucle. -->
            <video class="site-background-video" autoplay muted loop playsinline poster="<?php echo $backgroundVideoPoster; ?>">
                <!-- Source MP4 pour la vidéo de fond. -->
                <source src="<?php echo $backgroundVideoSource; ?>" type="video/mp4">
            <!-- Ferme la balise vidéo. -->
            </video>
            <!-- Ajoute un calque d'overlay sur la vidéo. -->
            <div class="site-background-overlay"></div>
        <!-- Ferme le conteneur de la vidéo de fond. -->
        </div>
    <!-- Termine la condition de vidéo de fond. -->
    <?php endif; ?>
    <!-- Ouvre l'en-tête principal du site. -->
    <header class="site-header">
        <!-- Ajoute un offset visuel pour le header, masqué aux lecteurs d'écran. -->
        <div class="site-header-offset" aria-hidden="true"></div>
        <!-- Conteneur principal du header avec classes utilitaires. -->
        <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3 py-2">
            <!-- Lien vers la page d'accueil avec le logo. -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo ROOT_URL . '/index.php'; ?>">
                <!-- Vidéo du logo en boucle, avec image de fallback. -->
                <video class="site-logo" autoplay muted loop playsinline aria-label="BEC" poster="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.png'; ?>">
                    <!-- Source vidéo pour le logo animé. -->
                    <source src="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo-anime-transparent.mov'; ?>" type="video/quicktime">
                    <!-- Image statique du logo en fallback. -->
                    <img src="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.png'; ?>" alt="Logo BEC">
                <!-- Ferme la balise vidéo du logo. -->
                </video>
                <!-- Affiche le nom du club à côté du logo. -->
                <span>Bordeaux Étudiant Club</span>
            <!-- Ferme le lien de la marque. -->
            </a>

            <!-- navigation principale -->
            <!-- Ouvre la navigation principale du header. -->
            <nav class="header-nav" aria-label="Navigation principale">
                <!-- Ouvre la liste de navigation principale. -->
                <ul>
                    <!-- Élément de menu pour l'accueil. -->
                    <li>
                        <!-- Lien vers la page d'accueil avec classe "current" si actif. -->
                        <a href="<?php echo ROOT_URL . '/index.php'; ?>" <?php if ($current_page == '/index.php') echo 'class="current"'; ?>>Accueil</a>
                    <!-- Ferme l'élément de menu pour l'accueil. -->
                    </li>
                    <!-- Élément de menu pour "Le club". -->
                    <li>
                        <!-- Conteneur du sous-menu "Le club". -->
                        <div class="header-submenu">
                            <!-- Bouton qui ouvre/ferme le sous-menu. -->
                            <button type="button" class="submenu-toggle<?php if (in_array($current_page, $club_pages, true)) echo ' current'; ?>" aria-haspopup="true" aria-expanded="false" aria-controls="submenu-club">
                                <!-- Libellé du bouton de sous-menu. -->
                                Le club
                            <!-- Ferme le bouton de sous-menu. -->
                            </button>
                            <!-- Liste des liens du sous-menu. -->
                            <ul class="submenu-list" id="submenu-club" aria-label="Le club">
                                <!-- Élément de sous-menu pour "Notre histoire". -->
                                <li>
                                    <!-- Lien vers "Notre histoire" avec classe "current" si actif. -->
                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/notre-histoire.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/notre-histoire.php') echo 'class="current"'; ?>>Notre histoire</a>
                                <!-- Ferme l'élément de sous-menu "Notre histoire". -->
                                </li>
                                <!-- Élément de sous-menu pour "Bénévoles". -->
                                <li>
                                    <!-- Lien vers "Bénévoles" avec classe "current" si actif. -->
                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/organigramme-benevoles.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/organigramme-benevoles.php') echo 'class="current"'; ?>>Bénévoles</a>
                                <!-- Ferme l'élément de sous-menu "Bénévoles". -->
                                </li>
                                <!-- Élément de sous-menu pour "Joueurs". -->
                                <li>
                                    <!-- Lien vers "Joueurs" avec classe "current" si actif. -->
                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/joueurs.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/joueurs.php') echo 'class="current"'; ?>>Joueurs</a>
                                <!-- Ferme l'élément de sous-menu "Joueurs". -->
                                </li>
                                <!-- Élément de sous-menu pour "Équipes". -->
                                <li>
                                    <!-- Lien vers "Équipes" avec classe "current" si actif. -->
                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/equipes.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/equipes.php') echo 'class="current"'; ?>>Équipes</a>
                                <!-- Ferme l'élément de sous-menu "Équipes". -->
                                </li>
                            <!-- Ferme la liste du sous-menu "Le club". -->
                            </ul>
                        <!-- Ferme le conteneur du sous-menu "Le club". -->
                        </div>
                    <!-- Ferme l'élément de menu "Le club". -->
                    </li>
                    <!-- Élément de menu pour "Actualités". -->
                    <li>
                        <!-- Lien vers "Actualités" avec classe "current" si actif. -->
                        <a href="<?php echo ROOT_URL . '/actualites.php'; ?>" <?php if ($current_page == '/actualites.php') echo 'class="current"'; ?>>Actualités</a>
                    <!-- Ferme l'élément de menu "Actualités". -->
                    </li>
                    <!-- Élément de menu désactivé pour "Boutique". -->
                    <!--<li>
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/boutique.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/boutique.php') echo 'class="current"'; ?>>Boutique</a>
                    </li>-->
                    <!-- Élément de menu pour "Calendrier". -->
                    <li>
                        <!-- Lien vers "Calendrier" avec classe "current" si actif. -->
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/calendrier.php') echo 'class="current"'; ?>>Calendrier</a>
                    <!-- Ferme l'élément de menu "Calendrier". -->
                    </li>
                    <!-- Élément de menu pour "Anciens et amis". -->
                    <li>
                        <!-- Lien vers "Anciens et amis" avec classe "current" si actif. -->
                        <a href="<?php echo ROOT_URL . '/anciens-et-amis.php'; ?>" <?php if ($current_page == '/anciens-et-amis.php') echo 'class="current"'; ?>>Anciens et amis</a>
                    <!-- Ferme l'élément de menu "Anciens et amis". -->
                    </li>
                    <!-- Élément de menu désactivé pour "Nos partenaires". -->
                    <!--<li>
                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/nos-partenaires.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/nos-partenaires.php') echo 'class="current"'; ?>>Nos partenaires</a>
                    </li>-->
                <!-- Ferme la liste de navigation principale. -->
                </ul>
            <!-- Ferme la navigation principale. -->
            </nav>

                <!-- Menu burger pour le responsive -->
            <!-- Conteneur du menu burger pour mobile. -->
            <div class="header-burger-wrapper">
                <!-- Détails HTML qui contrôlent l'ouverture du menu burger. -->
                <details class="header-burger-menu">
                    <!-- Résumé cliquable qui déclenche le menu burger. -->
                    <summary class="header-burger-toggle" aria-label="Ouvrir le menu">
                        <!-- Conteneur des barres du menu burger. -->
                        <span class="header-burger-icon" aria-hidden="true">
                            <!-- Première barre du menu burger. -->
                            <span></span>
                            <!-- Deuxième barre du menu burger. -->
                            <span></span>
                            <!-- Troisième barre du menu burger. -->
                            <span></span>
                        <!-- Ferme le conteneur des barres du menu burger. -->
                        </span>
                    <!-- Ferme le résumé du menu burger. -->
                    </summary>

                    <!-- Panneau qui contient le contenu du menu burger. -->
                    <div class="header-burger-panel">
                        <!-- Bouton pour fermer le menu burger. -->
                        <button type="button" class="header-burger-close" aria-label="Fermer le menu" onclick="this.closest('details').removeAttribute('open')">
                            <!-- Affiche une croix de fermeture. -->
                            &times;
                        <!-- Ferme le bouton de fermeture du menu burger. -->
                        </button>

                            <!-- Navigation principale dans le menu burger. -->
                            <nav class="header-burger-nav" aria-label="Navigation principale">
                                <!-- Liste des liens dans le menu burger. -->
                                <ul>
                                    <!-- Élément de menu burger pour l'accueil. -->
                                    <li>
                                        <!-- Lien vers l'accueil avec classe "current" si actif. -->
                                        <a href="<?php echo ROOT_URL . '/index.php'; ?>" <?php if ($current_page == '/index.php') echo 'class="current"'; ?>>Accueil</a>
                                    <!-- Ferme l'élément de menu burger pour l'accueil. -->
                                    </li>
                                    <!-- Élément de menu burger pour "Le club". -->
                                    <li>
                                        <!-- Conteneur du sous-menu "Le club" dans le burger. -->
                                        <div class="header-submenu">
                                            <!-- Bouton qui ouvre le sous-menu "Le club". -->
                                            <button type="button" class="submenu-toggle<?php if (in_array($current_page, $club_pages, true)) echo ' current'; ?>" aria-haspopup="true" aria-expanded="false" aria-controls="submenu-club">
                                                <!-- Libellé du bouton "Le club". -->
                                                Le club
                                            <!-- Ferme le bouton "Le club". -->
                                            </button>
                                            <!-- Liste des liens du sous-menu dans le burger. -->
                                            <ul class="submenu-list header-burger-sublist" id="submenu-club" aria-label="Le club">
                                                <!-- Élément du sous-menu burger "Notre histoire". -->
                                                <li>
                                                    <!-- Lien vers "Notre histoire" avec classe "current" si actif. -->
                                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/notre-histoire.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/notre-histoire.php') echo 'class="current"'; ?>>Notre histoire</a>
                                                <!-- Ferme l'élément "Notre histoire". -->
                                                </li>
                                                <!-- Élément du sous-menu burger "Bénévoles". -->
                                                <li>
                                                    <!-- Lien vers "Bénévoles" avec classe "current" si actif. -->
                                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/organigramme-benevoles.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/organigramme-benevoles.php') echo 'class="current"'; ?>>Bénévoles</a>
                                                <!-- Ferme l'élément "Bénévoles". -->
                                                </li>
                                                <!-- Élément du sous-menu burger "Joueurs". -->
                                                <li>
                                                    <!-- Lien vers "Joueurs" avec classe "current" si actif. -->
                                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/joueurs.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/joueurs.php') echo 'class="current"'; ?>>Joueurs</a>
                                                <!-- Ferme l'élément "Joueurs". -->
                                                </li>
                                                <!-- Élément du sous-menu burger "Équipes". -->
                                                <li>
                                                    <!-- Lien vers "Équipes" avec classe "current" si actif. -->
                                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/equipes.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/equipes.php') echo 'class="current"'; ?>>Équipes</a>
                                                <!-- Ferme l'élément "Équipes". -->
                                                </li>
                                            <!-- Ferme la liste des sous-liens du burger. -->
                                            </ul>
                                        <!-- Ferme le conteneur du sous-menu burger. -->
                                        </div>
                                    <!-- Ferme l'élément "Le club" du burger. -->
                                    </li>
                                    <!-- Élément de menu burger "Actualités". -->
                                    <li>
                                        <!-- Lien vers "Actualités" avec classe "current" si actif. -->
                                        <a href="<?php echo ROOT_URL . '/actualites.php'; ?>" <?php if ($current_page == '/actualites.php') echo 'class="current"'; ?>>Actualités</a>
                                    <!-- Ferme l'élément "Actualités" du burger. -->
                                    </li>
                                    
                                    <!-- Élément de menu burger "Calendrier". -->
                                    <li>
                                        <!-- Lien vers "Calendrier" avec classe "current" si actif. -->
                                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/calendrier.php') echo 'class="current"'; ?>>Calendrier</a>
                                    <!-- Ferme l'élément "Calendrier" du burger. -->
                                    </li>
                                    <!-- Élément de menu burger "Anciens et amis". -->
                                    <li>
                                        <!-- Lien vers "Anciens et amis" avec classe "current" si actif. -->
                                        <a href="<?php echo ROOT_URL . '/anciens-et-amis.php'; ?>" <?php if ($current_page == '/anciens-et-amis.php') echo 'class="current"'; ?>>Anciens et amis</a>
                                    <!-- Ferme l'élément "Anciens et amis" du burger. -->
                                    </li>
                                    <!-- Élément de menu burger désactivé "Nos partenaires". -->
                                    <!--<li>
                                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/nos-partenaires.php'; ?>" <?php if ($current_page == '/Pages_supplementaires/nos-partenaires.php') echo 'class="current"'; ?>>Nos partenaires</a>
                                    </li>-->
                                <!-- Ferme la liste du menu burger. -->
                                </ul>
                            <!-- Ferme la navigation du menu burger. -->
                            </nav>
                        
                        <!-- Actions de l'espace membre dans le menu burger. -->
                        <div class="header-burger-actions">
                            <!-- Titre de la zone membre dans le burger. -->
                            <p class="header-burger-title">Espace membre</p>
                            <!-- Vérifie si un membre est connecté. -->
                            <?php if ($ba_bec_pseudoMemb): ?>
                                <!-- Conteneur du nom d'utilisateur dans le burger. -->
                                <div class="header-burger-user">
                                    <!-- Affiche le pseudo en échappant le contenu. -->
                                    <span><?php echo htmlspecialchars($ba_bec_pseudoMemb); ?></span>
                                <!-- Ferme le conteneur utilisateur du burger. -->
                                </div>
                                <!-- Conteneur des liens utilisateur dans le burger. -->
                                <div class="header-burger-links">
                                    <!-- Lien vers le compte du membre. -->
                                    <a href="<?php echo ROOT_URL . '/Pages_supplementaires/compte.php'; ?>">Mon compte</a>
                                    <!-- Vérifie si le membre est admin ou modérateur. -->
                                    <?php if ($ba_bec_numStat === 1 || $ba_bec_numStat === 2): ?>
                                        <!-- Lien vers le panneau d'administration. -->
                                        <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>">Panneau admin</a>
                                    <!-- Termine la condition de statut admin. -->
                                    <?php endif; ?>
                                    <!-- Lien pour se déconnecter. -->
                                    <a class="header-burger-logout" href="<?php echo ROOT_URL . '/api/security/disconnect.php'; ?>">Déconnexion</a>
                                <!-- Ferme le conteneur des liens utilisateur du burger. -->
                                </div>
                            <!-- Cas où aucun membre n'est connecté. -->
                            <?php else: ?>
                                <!-- Bouton pour se connecter ou s'inscrire. -->
                                <a class="btn btn-bec-primary w-100" href="<?php echo ROOT_URL . '/views/backend/security/login.php'; ?>">
                                    <!-- Texte du bouton de connexion/inscription. -->
                                    Connexion / Inscription
                                <!-- Ferme le bouton de connexion/inscription. -->
                                </a>
                            <!-- Termine la condition de connexion membre. -->
                            <?php endif; ?>
                        <!-- Ferme le conteneur des actions du burger. -->
                        </div>
                    <!-- Ferme le panneau du menu burger. -->
                    </div>
                    <!-- Ferme le composant details du burger. -->
                </details>
            <!-- Ferme le wrapper du menu burger. -->
            </div>
                <!-- menu compte -->

                <!-- Conteneur du menu compte sur desktop. -->
                <div class="header-compte-wrapper">
                    <!-- Détails HTML qui contrôlent l'ouverture du menu compte. -->
                    <details class="header-compte-menu">
                        <!-- Résumé cliquable pour ouvrir le menu compte. -->
                        <summary class="btn btn-bec-primary btn-compte" aria-label="Ouvrir le menu">
                            <!-- Affiche le pseudo ou le mot "Compte". -->
                            <?php echo $ba_bec_pseudoMemb ? htmlspecialchars($ba_bec_pseudoMemb) : 'Compte'; ?>
                        <!-- Ferme le résumé du menu compte. -->
                        </summary>
                        
                        <!-- Panneau contenant les actions du compte. -->
                        <div class="header-compte-panel">
                            <!-- Bouton pour fermer le menu compte. -->
                            <button type="button" class="header-compte-close" aria-label="Fermer le menu" onclick="this.closest('details').removeAttribute('open')">
                                <!-- Affiche une croix de fermeture. -->
                                &times;
                            <!-- Ferme le bouton de fermeture du menu compte. -->
                            </button>
                            <!-- Conteneur des actions et infos du compte. -->
                            <div class="header-compte-actions">
                                <!-- Titre de la zone membre dans le menu compte. -->
                                <p class="header-compte-title">Espace membre</p>
                                <!-- Vérifie si un membre est connecté. -->
                                <?php if ($ba_bec_pseudoMemb): ?>
                                    <!-- Conteneur du nom d'utilisateur dans le menu compte. -->
                                    <div class="header-compte-user">
                                        <!-- Affiche le pseudo en échappant le contenu. -->
                                        <span><?php echo htmlspecialchars($ba_bec_pseudoMemb); ?></span>
                                    <!-- Ferme le conteneur utilisateur du menu compte. -->
                                    </div>
                                    <!-- Conteneur des liens du compte. -->
                                    <div class="header-compte-links">
                                        <!-- Lien vers la page du compte. -->
                                        <a href="<?php echo ROOT_URL . '/Pages_supplementaires/compte.php'; ?>">Mon compte</a>
                                        <!-- Vérifie si le membre a un statut admin. -->
                                        <?php if ($ba_bec_numStat === 1 || $ba_bec_numStat === 2): ?>
                                            <!-- Lien vers le panneau admin. -->
                                            <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>">Panneau admin</a>
                                        <!-- Termine la condition admin. -->
                                        <?php endif; ?>
                                        <!-- Lien de déconnexion. -->
                                        <a class="header-compte-logout" href="<?php echo ROOT_URL . '/api/security/disconnect.php'; ?>">Déconnexion</a>
                                    <!-- Ferme le conteneur des liens du compte. -->
                                    </div>
                                <!-- Cas où aucun membre n'est connecté. -->
                                <?php else: ?>
                                    <!-- Bouton pour se connecter ou s'inscrire. -->
                                    <a class="btn btn-bec-primary w-100" href="<?php echo ROOT_URL . '/views/backend/security/login.php'; ?>">
                                        <!-- Texte du bouton de connexion/inscription. -->
                                        Connexion / Inscription
                                    <!-- Ferme le bouton de connexion/inscription. -->
                                    </a>
                                <!-- Termine la condition de connexion. -->
                                <?php endif; ?>
                            <!-- Ferme le conteneur des actions du compte. -->
                            </div>
                        <!-- Ferme le panneau du menu compte. -->
                        </div>
                    <!-- Ferme le composant details du menu compte. -->
                    </details>
                <!-- Ferme le wrapper du menu compte. -->
                </div>
            <!-- Ferme le conteneur principal du header. -->
            </div>

        <!-- Ferme le container global du header. -->
        </div>


    <!-- Ferme la balise header. -->
    </header>
    <!-- Vérifie si aucun choix de cookies n'a été enregistré. -->
    <?php if ($ba_bec_cookieConsent === null): ?>
        <!-- Calque de fond pour la popup cookies. -->
        <div class="cookie-overlay" id="cookie-overlay" hidden></div>
        <!-- Popup de consentement aux cookies, cachée par défaut. -->
        <div class="cookie-popup" id="cookie-popup" role="dialog" aria-modal="true" aria-labelledby="cookie-title" hidden>
            <!-- Contenu de la popup cookies. -->
            <div class="cookie-content">
                <!-- Titre de la popup cookies. -->
                <h2 id="cookie-title">Gestion des cookies</h2>
                <!-- Texte explicatif sur les cookies. -->
                <p>Nous utilisons des cookies pour améliorer votre expérience. Vous pouvez accepter ou refuser.</p>
                <!-- Conteneur des boutons de choix. -->
                <div class="cookie-buttons">
                    <!-- Bouton pour accepter les cookies. -->
                    <button type="button" class="btn btn-light" data-cookie-choice="1">Accepter</button>
                    <!-- Bouton pour refuser les cookies. -->
                    <button type="button" class="btn btn-outline-light" data-cookie-choice="0">Refuser</button>
                <!-- Ferme le conteneur des boutons. -->
                </div>
            <!-- Ferme le contenu de la popup. -->
            </div>
        <!-- Ferme la popup cookies. -->
        </div>
        <!-- Script JS qui gère l'affichage et l'envoi du consentement. -->
        <script>
            // Lance une fonction immédiatement pour isoler le scope.
            (function () {
                // Récupère la popup via son identifiant.
                var popup = document.getElementById('cookie-popup');
                // Récupère l'overlay via son identifiant.
                var overlay = document.getElementById('cookie-overlay');
                // Vérifie que les deux éléments existent.
                if (!popup || !overlay) {
                    // Quitte la fonction si un élément manque.
                    return;
                }
                // Rend la popup visible.
                popup.hidden = false;
                // Rend l'overlay visible.
                overlay.hidden = false;
                // Ajoute une classe au body pour signaler le choix requis.
                document.body.classList.add('cookie-choice-required');

                // Ajoute un écouteur sur chaque bouton de choix.
                popup.querySelectorAll('[data-cookie-choice]').forEach(function (button) {
                    // Ajoute le gestionnaire de clic pour le bouton.
                    button.addEventListener('click', function () {
                        // Lit la valeur du choix stockée sur le bouton.
                        var choice = button.getAttribute('data-cookie-choice');
                        // Crée un objet FormData pour envoyer le choix.
                        var formData = new FormData();
                        // Ajoute le champ "consent" avec la valeur choisie.
                        formData.append('consent', choice);
                        // Envoie la requête POST vers l'API de consentement.
                        fetch('<?php echo ROOT_URL . '/api/security/cookie-consent.php'; ?>', {
                            // Indique la méthode HTTP utilisée.
                            method: 'POST',
                            // Inclut les cookies de session.
                            credentials: 'same-origin',
                            // Envoie le corps de la requête avec les données.
                            body: formData
                        // Après la requête, cache la popup et l'overlay.
                        }).finally(function () {
                            // Cache la popup.
                            popup.hidden = true;
                            // Cache l'overlay.
                            overlay.hidden = true;
                            // Retire la classe indiquant un choix requis.
                            document.body.classList.remove('cookie-choice-required');
                        // Termine le finally du fetch.
                        });
                    // Termine le gestionnaire de clic.
                    });
                // Termine le forEach des boutons.
                });
            // Termine la fonction auto-exécutée.
            })();
        </script>
    <!-- Termine la condition de consentement cookies. -->
    <?php endif; ?>
    <!-- Ouvre la zone principale du contenu de la page. -->
    <main class="site-main container py-5">
