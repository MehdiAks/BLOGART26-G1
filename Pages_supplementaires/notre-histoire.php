<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$pageStyles = [ROOT_URL . '/src/css/notre-histoire.css'];
$pageTitle = 'Notre histoire';
require_once $_SERVER['DOCUMENT_ROOT'] . '/header.php';
?>

<main id="notre-histoire">

    <!-- Hero -->
    <section class="hero-section text-center">
        <img class="hero-logo mb-3" src="<?php echo ROOT_URL . '/src/images/logo/logo-bec/logo.svg'; ?>" alt="Blason du Bordeaux Étudiant Club">
        <h1>Notre histoire</h1>
        <p class="lead mx-auto">
            Depuis la fin du XIXᵉ siècle, le Bordeaux Étudiants Club (BEC) rassemble les passionnés de sport
            dans un esprit de partage, d’effort et de convivialité, fidèle à ses racines universitaires.
        </p>
    </section>

    <!-- Timeline / Histoire -->
    <section class="timeline container">

        <!-- Article 1 -->
        <div class="timeline-item">
            <div class="timeline-content">
                <h2>1897 : des origines étudiantes</h2>
                <p>Fondé en 1897, le BEC s'est construit autour des étudiants de Bordeaux.</p>
                <p>Très tôt, le club s'impose comme référence locale pour le sport universitaire.</p>
            </div>
            <div class="timeline-image">
                <img src="/src/images/notre-histoire/notre-histoire-4.webp" alt="1897 : origines" loading="lazy" decoding="async">
            </div>
        </div>

        <!-- Article 2 -->
        <div class="timeline-item reverse">
            <div class="timeline-content">
                <h2>Un club omnisports</h2>
                <p>Le BEC fédère plusieurs disciplines et rassemble des générations de sportifs.</p>
            </div>
            <div class="timeline-image">
                <img src="/src/images/notre-histoire/notre-histoire-3.webp" alt="Club omnisports" loading="lazy" decoding="async">
            </div>
        </div>

        <!-- Article 3 -->
        <div class="timeline-item">
            <div class="timeline-content">
                <h2>Des pages marquantes</h2>
                <p>Certaines sections du club ont marqué l'histoire locale grâce à des équipes engagées.</p>
            </div>
        </div>

        <!-- Article 4 -->
        <div class="timeline-item reverse">
            <div class="timeline-content">
                <h2>Ouverture vers l'avenir</h2>
                <p>Aujourd'hui, le BEC continue de former et rassembler les sportifs.</p>
            </div>
            <div class="timeline-image">
                <img src="/src/images/notre-histoire/notre-histoire-2.webp" alt="Esprit inspirant" loading="lazy" decoding="async">
            </div>
        </div>

    </section>

    <!-- Banner full-width -->
    <section class="banner banner-center my-5">
        <img src="/src/images/notre-histoire/notre-histoire-1.webp" alt="Banniere center" loading="lazy" decoding="async">
        <div class="banner-text">
            <h2>Un esprit qui perdure</h2>
        </div>
    </section>

</main>



<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
