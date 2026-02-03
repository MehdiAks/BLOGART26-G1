<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once 'header.php';
?>

<main class="container py-5">
    <div class="row align-items-start g-5">
        <div class="col-lg-6">
            <h1 class="mb-3">Contact</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque laoreet feugiat lorem, sed
                pharetra mi pulvinar nec. Sed accumsan dolor ut orci dignissim, non faucibus neque egestas.
            </p>
            <div class="article-content mt-4">
                <h2 class="h5">Nous écrire</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in suscipit erat. Curabitur
                    condimentum luctus justo, id consequat arcu luctus sed.
                </p>
                <p>
                    <strong>Email :</strong> contact@bec-bordeaux.fr<br>
                    <strong>Téléphone :</strong> 06 71 94 23 80
                </p>
                <a href="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=80">
                    Télécharger equipe-contact.jpg
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="article-content">
                <img
                    src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80"
                    class="article-image mb-3"
                    alt="Équipe du BEC en discussion"
                >
                <h2 class="h5">Notre permanence</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque habitant morbi tristique
                    senectus et netus et malesuada fames ac turpis egestas.
                </p>
                <a href="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80">
                    Voir lieu-bec.jpg
                </a>
                <div class="mt-3">
                    <img
                        src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=900&q=80"
                        class="article-image"
                        alt="Bureau du club"
                    >
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
