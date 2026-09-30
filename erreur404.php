<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Charger les styles spécifiques à cette page
$pageStyles = [
    ROOT_URL . '/src/css/anciens-et-amis.css',
];
$pageTitle = 'Page introuvable';

require_once 'header.php';
?>


<section class="container error-page">
    <p class="error-page__code">404</p>
    <h1>Page introuvable</h1>
    <p>La page demandée n'est pas disponible.</p>
    <nav class="error-page__links" aria-label="Continuer la navigation">
        <a class="btn btn-primary" href="<?php echo ROOT_URL . '/index.php'; ?>">Accueil</a>
        <a class="btn btn-outline-primary" href="<?php echo ROOT_URL . '/Pages_supplementaires/calendrier.php'; ?>">Calendrier</a>
        <a class="btn btn-outline-primary" href="<?php echo ROOT_URL . '/actualites.php'; ?>">Actualités</a>
    </nav>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
