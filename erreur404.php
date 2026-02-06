<?php // Démarre le bloc PHP.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge le fichier de configuration global en utilisant le chemin racine du document.

// Charger les styles spécifiques à cette page
$pageStyles = [ // Définit un tableau pour les feuilles de style spécifiques à cette page.
    ROOT_URL . '/src/css/anciens-et-amis.css', // Ajoute l'URL de la feuille de style au tableau.
]; // Ferme la définition du tableau des styles.

require_once 'header.php'; // Inclut l'en-tête commun de la page.
?>


<style> /* Démarre un bloc de styles CSS intégré. */
.bouton{ /* Cible la classe CSS "bouton". */
    background-color: #67081d; /* Définit la couleur de fond du bouton. */
    color: #ddd; /* Définit la couleur du texte du bouton. */
    padding: 10px; /* Ajoute un espace intérieur autour du texte du bouton. */
    border-radius: 25px; /* Arrondit les coins du bouton. */
} /* Termine la règle CSS de la classe "bouton". */
.logo-anime-wrapper{ /* Cible le conteneur du logo animé. */
    display: flex; /* Utilise Flexbox pour la mise en page du conteneur. */
    justify-content: center; /* Centre horizontalement le contenu du conteneur. */
    margin: 20px 0; /* Ajoute une marge verticale de 20px et aucune marge horizontale. */
} /* Termine la règle CSS du conteneur du logo animé. */
.logo-anime{ /* Cible l'image du logo animé. */
    max-width: 320px; /* Limite la largeur maximale de l'image à 320px. */
    width: 100%; /* Rend l'image responsive en prenant 100% de la largeur disponible. */
    height: auto; /* Conserve les proportions de l'image. */
} /* Termine la règle CSS de l'image du logo animé. */
.error404-image{ /* Cible l'image de l'erreur 404. */
    display: block; /* Affiche l'image comme un bloc pour éviter l'espacement inline. */
    max-width: 180px; /* Limite la largeur maximale de l'image à 180px. */
    width: 100%; /* Rend l'image responsive en prenant 100% de la largeur disponible. */
    height: auto; /* Conserve les proportions de l'image. */
    z-index: 1; /* Place l'image au-dessus d'éventuels éléments en arrière-plan. */
} /* Termine la règle CSS de l'image d'erreur 404. */
.error404-image-wrapper{ /* Cible le conteneur de l'image d'erreur 404. */
    display: flex; /* Utilise Flexbox pour la mise en page du conteneur. */
    justify-content: flex-end; /* Aligne le contenu à droite du conteneur. */
    margin-top: 24px; /* Ajoute une marge en haut du conteneur. */
    margin-bottom: 24px; /* Ajoute une marge en bas du conteneur. */
} /* Termine la règle CSS du conteneur de l'image d'erreur 404. */
</style> <!-- Termine le bloc de styles CSS intégré. -->

<h2>Erreur 404</h2> <!-- Affiche le titre principal de la page d'erreur. -->
<br> <!-- Insère un saut de ligne après le titre principal. -->
<h3>Une erreur s'est produite. La developpeuse a sans doute du se faire écraser par un bus</h3> <!-- Affiche un message d'erreur humoristique. -->
<br> <!-- Insère un saut de ligne après le message. -->
<h4>Cette page est indisponible pour le moment ou est actuellement en cours de développement.</h4> <!-- Informe que la page est indisponible ou en développement. -->
<br> <!-- Insère un saut de ligne avant le bouton. -->
<a href="<?php echo ROOT_URL . '/index.php'; ?>"><button class="bouton">Revenir à l'accueil</button></a> <!-- Affiche un bouton de retour vers la page d'accueil. -->
<br> <!-- Insère un saut de ligne après le bouton. -->
<div class="error404-image-wrapper"> <!-- Démarre le conteneur de l'image d'erreur 404. -->
    <img class="error404-image" src="<?php echo ROOT_URL . '/src/images/error404.png'; ?>" alt="Illustration erreur 404"> <!-- Affiche l'image illustrative de l'erreur 404. -->
</div> <!-- Ferme le conteneur de l'image d'erreur 404. -->

<?php // Démarre un nouveau bloc PHP pour la fermeture.
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; // Inclut le pied de page commun de la page.
