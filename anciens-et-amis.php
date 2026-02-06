<?php
// Ouvre le bloc PHP pour exécuter du code côté serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Inclut une seule fois le fichier de configuration global depuis la racine du site.

// Commente que les styles suivants sont spécifiques à cette page.
$pageStyles = [
    // Définit un tableau contenant l'URL complète vers la feuille de style de cette page.
    ROOT_URL . '/src/css/anciens-et-amis.css',
    // Termine le tableau des styles de page.
];

// Inclut une seule fois l'en-tête commun de la page.
require_once 'header.php';
// Ferme le bloc PHP pour repasser en HTML.
?>

<!-- Ouvre la zone principale de contenu avec des classes de mise en page et un identifiant. -->
<main class="container py-5" id="Anciens-et-amis">
    <!-- Ouvre un conteneur avec une marge basse pour l'introduction. -->
    <div class="mb-5">
        <!-- Affiche le titre principal de la page. -->
        <h1 class="mb-3">Anciens et amis du BEC</h1>
        <!-- Ouvre un paragraphe de présentation. -->
        <p>
            <!-- Affiche une phrase d'accroche sur l'histoire du BEC. -->
            Depuis plus de 125 ans, le BEC rayonne !
        <!-- Ferme le paragraphe de présentation. -->
        </p>
        <!-- Ouvre un second paragraphe d'invitation. -->
        <p>
            <!-- Affiche une invitation à rejoindre l'association et un chiffre de membres. -->
            Rejoignez l’association des Anciens et Amis du Bordeaux Etudiants Club. Près de 1000 membres sont déjà inscrits, alors pourquoi pas vous ?
        <!-- Ferme le second paragraphe. -->
        </p>
        <!-- Ajoute un bouton lien vers le site externe des anciens, avec ouverture dans un nouvel onglet. -->
        <a class="btn btn-primary" href="https://anciensbec-bordeaux.fr" target="_blank" rel="noopener noreferrer">
            <!-- Texte visible du bouton vers le site des anciens. -->
            Accéder au site des Anciens du BEC
        <!-- Ferme le lien bouton. -->
        </a>
    <!-- Ferme le conteneur d'introduction. -->
    </div>

    <!-- Ouvre une rangée Bootstrap avec espacement entre colonnes. -->
    <div class="row g-4">
        <!-- Ouvre la première colonne responsive. -->
        <div class="col-lg-4 col-md-6">
            <!-- Ouvre une carte de contenu qui prend toute la hauteur disponible. -->
            <div class="article-content h-100">
                <!-- Déclare une image illustrant l'annuaire. -->
                <img
                    <!-- Indique le chemin de l'image de fond de l'actualité. -->
                    src="src/images/background/background-actualite.jpg"
                    <!-- Ajoute des classes pour le style de l'image et la marge basse. -->
                    class="article-image mb-3"
                    <!-- Fournit un texte alternatif pour l'accessibilité. -->
                    alt="Ancien joueur en entraînement"
                <!-- Ferme la balise image auto-fermante. -->
                >
                <!-- Affiche le titre de la section annuaire. -->
                <h2 class="h5">Annuaire</h2>
                <!-- Ouvre un paragraphe descriptif de l'annuaire. -->
                <p>
                    <!-- Texte indiquant où retrouver les anciens et mention du lien. -->
                    Retrouvez les anciens du BEC sur notre annuaire ! Vous voulez nous rejoindre ? Retrouvez les tarifs et informations sur le lien suivant :
                <!-- Ferme le paragraphe descriptif. -->
                </p>
                <!-- Lien vers la page de l'annuaire des anciens. -->
                <a href="https://anciensbec-bordeaux.fr/lannuaire/">
                    <!-- Texte du lien vers l'annuaire. -->
                    Annuaire du BEC 
                <!-- Ferme le lien vers l'annuaire. -->
                </a>
            <!-- Ferme la carte de contenu de la première colonne. -->
            </div>
        <!-- Ferme la première colonne responsive. -->
        </div>

        <!-- Ouvre la deuxième colonne responsive. -->
        <div class="col-lg-4 col-md-6">
            <!-- Ouvre une carte de contenu qui prend toute la hauteur disponible. -->
            <div class="article-content h-100">
                <!-- Déclare une image illustrant les amis et événements. -->
                <img
                    <!-- Indique le chemin de l'image de fond de l'article. -->
                    src="src/images/background/background-article.jpg"
                    <!-- Ajoute des classes pour le style de l'image et la marge basse. -->
                    class="article-image mb-3"
                    <!-- Fournit un texte alternatif pour l'accessibilité. -->
                    alt="Supporters réunis"
                <!-- Ferme la balise image auto-fermante. -->
                >
                <!-- Affiche le titre de la section amis et événements. -->
                <h2 class="h5">Amis et événements</h2>
                <!-- Ouvre un paragraphe descriptif de la section Facebook. -->
                <p>
                    <!-- Texte indiquant de retrouver les amis et événements sur Facebook. -->
                    Retrouvez nos amis et événements sur Facebook 
                <!-- Ferme le paragraphe descriptif. -->
                </p>
                <!-- Lien vers la page Facebook officielle. -->
                <a href="https://www.facebook.com/becofficiel/?locale=fr_FR">
                    <!-- Texte du lien vers Facebook. -->
                    Notre Facebook
                <!-- Ferme le lien vers Facebook. -->
                </a>
            <!-- Ferme la carte de contenu de la deuxième colonne. -->
            </div>
        <!-- Ferme la deuxième colonne responsive. -->
        </div>

        <!-- Ouvre la troisième colonne responsive. -->
        <div class="col-lg-4 col-md-6">
            <!-- Ouvre une carte de contenu qui prend toute la hauteur disponible. -->
            <div class="article-content h-100">
                <!-- Déclare une image illustrant les retrouvailles. -->
                <img
                    <!-- Indique le chemin de l'image de fond de l'index. -->
                    src="src/images/background/background-index-1.webp"
                    <!-- Ajoute des classes pour le style de l'image et la marge basse. -->
                    class="article-image mb-3"
                    <!-- Fournit un texte alternatif pour l'accessibilité. -->
                    alt="Moment de convivialité"
                <!-- Ferme la balise image auto-fermante. -->
                >
                <!-- Affiche le titre de la section retrouvailles. -->
                <h2 class="h5">Retrouvailles et évenements</h2>
                <!-- Ouvre un paragraphe descriptif de la section retrouvailles. -->
                <p>
                    <!-- Texte posant la question sur la date des retrouvailles. -->
                    Quand est-ce qu'on se retrouve ? 
                <!-- Ferme le paragraphe descriptif. -->
                </p>
                <!-- Lien vers une page de retrouvailles (actuellement erreur 404). -->
                <a href="erreur404.php">
                    <!-- Texte du lien vers les retrouvailles. -->
                    Retrouvailles
                <!-- Ferme le lien vers les retrouvailles. -->
                </a>
            <!-- Ferme la carte de contenu de la troisième colonne. -->
            </div>
        <!-- Ferme la troisième colonne responsive. -->
        </div>
    <!-- Ferme la rangée Bootstrap. -->
    </div>
<!-- Ferme la zone principale de contenu. -->
</main>

<?php
// Ouvre à nouveau un bloc PHP pour inclure le pied de page.
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
// Inclut une seule fois le pied de page commun depuis la racine du site.
// Ferme le bloc PHP.
?>
