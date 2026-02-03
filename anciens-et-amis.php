<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once 'header.php';
?>

<main class="container py-5" id="Anciens-et-amis">
    <div class="mb-5">
        <h1 class="mb-3">Anciens et amis du BEC</h1>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi notez que nos anciens et amis
            partagent la même passion pour le club et continuent d'écrire son histoire. Integer nec lectus sed
            ligula gravida commodo in sed neque.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="article-content h-100">
                <img
                    src="src/images/background/background-actualite.jpg"
                    class="article-image mb-3"
                    alt="Ancien joueur en entraînement"
                >
                <h2 class="h5">Portraits d'anciens</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse potenti. Vestibulum ante
                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.
                </p>
                <a href="src/images/background/background-actualite.jpg">
                    Voir la galerie anciens-joueurs.jpg
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="article-content h-100">
                <img
                    src="src/images/background/background-article.jpg"
                    class="article-image mb-3"
                    alt="Supporters réunis"
                >
                <h2 class="h5">Réseau des amis</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent feugiat, lorem ac aliquet
                    commodo, lorem ipsum consequat lectus, vitae commodo urna mauris nec metus.
                </p>
                <a href="src/images/background/background-article.jpg">
                    Découvrir supporters-bec.jpg
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="article-content h-100">
                <img
                    src="src/images/background/background-index.jpg"
                    class="article-image mb-3"
                    alt="Moment de convivialité"
                >
                <h2 class="h5">Événements & retrouvailles</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tristique, tellus id consequat
                    sodales, nisl neque aliquet urna, ut viverra turpis leo non quam.
                </p>
                <a href="src/images/background/background-index.jpg">
                    Voir retrouvailles-anciens.jpg
                </a>
            </div>
        </div>
    </div>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
