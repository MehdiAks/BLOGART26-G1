<?php
// On charge la configuration globale du site (connexion DB, constantes, etc.).
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// On prépare la liste des feuilles de style spécifiques à cette page.
$pageStyles = [
    ROOT_URL . '/src/css/style.css',
];

// On inclut l'en-tête HTML (balises <head>, menu, etc.).
require_once 'header.php';

// On ouvre la connexion à la base de données.
sql_connect();

// On prépare la requête SQL pour récupérer 3 articles au hasard.
// - ORDER BY RAND() mélange aléatoirement les lignes.
// - LIMIT 3 garantit qu'on n'affiche jamais plus de 3 articles.

$articleStmt = $DB->prepare(
    'SELECT numArt, libTitrArt, libChapoArt, urlPhotArt, dtCreaArt
     FROM ARTICLE
     ORDER BY RAND()
     LIMIT 3'
);
// On exécute la requête préparée.
$articleStmt->execute();
// On récupère les résultats sous forme de tableau associatif.
$ba_bec_articles = $articleStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="site-main">
    <div class="container-fluid px-0">
        <div id="carouselExampleAutoplaying" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?php echo ROOT_URL . '/src/images/background/background-actualite.jpg'; ?>" class="d-block w-100"
                        alt="Première image du carrousel">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo ROOT_URL . '/src/images/background/background-article.jpg'; ?>" class="d-block w-100"
                        alt="Deuxième image du carrousel">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo ROOT_URL . '/src/images/background/background-index.jpg'; ?>" class="d-block w-100"
                        alt="Troisième image du carrousel">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container py-5">
        <section class="p-4 p-md-5 bg-white border rounded-3 shadow-sm mb-5">
            <h1 class="mb-3">Bienvenue au BEC</h1>
            <p class="lead mb-4">
                Une page d'accueil simple, construite uniquement avec Bootstrap.
            </p>
            <div class="d-flex gap-2">
                <a class="btn btn-primary" href="actualites.php">Voir les actualités</a>
                <a class="btn btn-outline-secondary" href="contact.php">Nous contacter</a>
            </div>
        </section>

        <section aria-label="Dernières actualités" class="row g-4">
        <!-- Si on a au moins un article récupéré, on les affiche. -->
        <?php if (!empty($ba_bec_articles)): ?>
            <!-- On parcourt les 3 articles aléatoires récupérés depuis la base. -->
            <?php foreach ($ba_bec_articles as $index => $ba_bec_article): ?>
                <?php
                // 1) On détermine l'image à afficher :
                //    - si l'article a une image, on utilise celle-ci
                //    - sinon on utilise l'image par défaut.
                $ba_bec_imagePath = !empty($ba_bec_article['urlPhotArt'])
                    ? ROOT_URL . '/src/uploads/' . htmlspecialchars($ba_bec_article['urlPhotArt'])
                    : ROOT_URL . '/src/images/article.png';
                // 2) On récupère le chapo (texte d'accroche) ou une chaîne vide si absent.
                $chapo = $ba_bec_article['libChapoArt'] ?? '';
                // 3) On fixe la longueur max de l'extrait affiché.
                $maxLength = 160;
                // 4) On tronque le chapo proprement (multibyte si disponible).
                $excerptBase = function_exists('mb_substr') ? mb_substr($chapo, 0, $maxLength) : substr($chapo, 0, $maxLength);
                // 5) On calcule la longueur réelle du chapo.
                $chapoLength = function_exists('mb_strlen') ? mb_strlen($chapo) : strlen($chapo);
                // 6) On ajoute "..." seulement si le chapo dépassait la limite.
                $excerpt = $excerptBase . ($chapoLength > $maxLength ? '...' : '');
                ?>
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card mb-3 w-100" style="max-width: 540px;">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <img src="<?php echo $ba_bec_imagePath; ?>"
                                    class="img-fluid rounded-start h-100 object-fit-cover"
                                    alt="<?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title"><?php echo htmlspecialchars($ba_bec_article['libTitrArt']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($excerpt); ?></p>
                                    <p class="card-text mt-auto">
                                        <small class="text-body-secondary">
                                            <?php echo htmlspecialchars($ba_bec_article['dtCreaArt']); ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Si aucun article n'est disponible, on affiche un message d'information. -->
            <div class="col-12">
                <div class="alert alert-info mb-0" role="status">
                    Aucune actualité disponible pour le moment.
                </div>
            </div>
        <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once 'footer.php'; ?>

<p></p>
