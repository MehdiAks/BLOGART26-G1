<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$pageStyles = [ROOT_URL . '/src/css/notre-histoire.css'];
require_once 'header.php';
?>

<main class="container py-5" id="notre-histoire">

    <!-- Hero / Intro -->
    <section class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Notre histoire</h1>
        <p class="lead mx-auto" style="max-width: 800px; color: #212529;">
            Depuis la fin du XIXᵉ siècle, le Bordeaux Étudiants Club (BEC) rassemble les passionnés de sport
            dans un esprit de partage, d’effort et de convivialité, fidèle à ses racines universitaires.
        </p>
    </section>

    <section class="storyline">

        <!-- Article classique : texte gauche / image droite -->
        <div class="article-horizontal row align-items-center my-5 has-image">
            <div class="col-md-6">
                <h2>1897 : des origines étudiantes</h2>
                <p>Fondé en 1897, le BEC s'est construit autour des étudiants de Bordeaux.</p>
            </div>
            <div class="col-md-6">
                <img src="/src/images/image1.jpg" class="img-fluid img-wide rounded" alt="1897 : origines">
            </div>
        </div>

        <!-- Article classique : texte droite / image gauche -->
        <div class="article-horizontal row align-items-center my-5 has-image">
            <div class="col-md-6 order-md-2">
                <h2>Un club omnisports</h2>
                <p>Le BEC fédère plusieurs disciplines et rassemble des générations de sportifs.</p>
            </div>
            <div class="col-md-6 order-md-1">
                <img src="/src/images/image2.jpg" class="img-fluid img-tall rounded" alt="Club omnisports">
            </div>
        </div>

        <!-- Banniere full-width : texte top -->
        <div class="banner my-5 banner-top">
            <img src="/src/images/banner1.jpg" class="img-fluid rounded" alt="Banniere top">
            <div class="banner-text">
                <h2>Des moments historiques</h2>
                <p>Le BEC a marqué l’histoire du sport bordelais.</p>
            </div>
        </div>

        <!-- Article classique sans image -->
        <div class="article-horizontal row align-items-center my-5 no-image">
            <div class="col-12">
                <h2>Des pages marquantes</h2>
                <p>Certaines sections du club ont marqué l'histoire locale grâce à des équipes engagées.</p>
            </div>
        </div>

        <!-- Banniere full-width : texte center -->
        <div class="banner my-5 banner-center">
            <img src="/src/images/banner2.jpg" class="img-fluid rounded" alt="Banniere center">
            <div class="banner-text">
                <h2>Un esprit qui perdure</h2>
            </div>
        </div>

        <!-- Article classique : texte gauche / image droite carré -->
        <div class="article-horizontal row align-items-center my-5 has-image">
            <div class="col-md-6">
                <h2>Ouverture vers l'avenir</h2>
                <p>Aujourd'hui, le BEC continue de former et rassembler les sportifs.</p>
            </div>
            <div class="col-md-6">
                <img src="/src/images/image3.jpg" class="img-fluid img-square rounded" alt="Esprit inspirant">
            </div>
        </div>

        <!-- Banniere full-width : texte bottom -->
        <div class="banner my-5 banner-bottom">
            <img src="/src/images/banner3.jpg" class="img-fluid rounded" alt="Banniere bottom">
            <div class="banner-text">
                <h2>Une histoire vivante</h2>
                <p>Chaque saison ajoute un chapitre à cette grande aventure.</p>
            </div>
        </div>

    </section>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
