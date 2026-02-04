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

    <!-- Articles avec alternance et option image -->
    <section class="timeline-horizontal">

        <!-- Article 1 : image droite -->
        <div class="article-horizontal row align-items-center my-5 has-image">
            <div class="col-md-6">
                <h2>1897 : des origines étudiantes</h2>
                <p>
                    Fondé en 1897, le BEC s'est construit autour des étudiants de Bordeaux. Très tôt, le club s'impose
                    comme une référence locale pour le sport universitaire.
                </p>
            </div>
            <div class="col-md-6">
                <img src="/src/images/image1.jpg" class="img-fluid rounded" alt="1897 : des origines étudiantes">
            </div>
        </div>

        <!-- Article 2 : image gauche -->
        <div class="article-horizontal row align-items-center my-5 has-image">
            <div class="col-md-6 order-md-2">
                <h2>Un club omnisports ancré à Bordeaux</h2>
                <p>
                    Le BEC fédère plusieurs disciplines et rassemble des générations de sportifs dans un cadre associatif et exigeant.
                </p>
            </div>
            <div class="col-md-6 order-md-1">
                <img src="/src/images/image2.jpg" class="img-fluid rounded" alt="Un club omnisports ancré à Bordeaux">
            </div>
        </div>

        <!-- Article 3 : pas d’image -->
        <div class="article-horizontal row align-items-center my-5 no-image">
            <div class="col-12">
                <h2>Des pages marquantes</h2>
                <p>
                    Certaines sections du club ont marqué l'histoire locale, notamment grâce à des équipes engagées dans les compétitions nationales.
                </p>
            </div>
        </div>

        <!-- Article 4 : image droite -->
        <div class="article-horizontal row align-items-center my-5 has-image">
            <div class="col-md-6">
                <h2>Un esprit qui continue d'inspirer</h2>
                <p>
                    Aujourd'hui, le BEC poursuit son développement en restant fidèle à ses valeurs fondatrices et à l'esprit d'équipe.
                </p>
            </div>
            <div class="col-md-6">
                <img src="/src/images/image3.jpg" class="img-fluid rounded" alt="Un esprit qui continue d'inspirer">
            </div>
        </div>

    </section>
</main>





<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
