<?php
// Ouvre le bloc PHP pour exécuter du code côté serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Charge le fichier de configuration situé à la racine du document.
$pageStyles = [ROOT_URL . '/src/css/contact.css'];
// Définit la liste des feuilles de style à injecter pour cette page.
require_once 'header.php';
// Inclut l'en-tête commun du site.

// Ferme temporairement le bloc PHP pour afficher du HTML.
?>

<!-- Démarre la zone principale du contenu de la page. -->
<main class="container py-5">
    <!-- Crée une ligne Bootstrap avec des éléments alignés en haut et un espacement. -->
    <div class="row align-items-start g-5">
        <!-- Crée une colonne prenant la moitié de la largeur sur grand écran. -->
        <div class="col-lg-6">
            <!-- Affiche le titre principal de la page. -->
            <h1 class="mb-3">Contact</h1>
            <!-- Ouvre un paragraphe de texte descriptif. -->
            <p>
                <!-- Insère la première partie du texte de présentation. -->
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque laoreet feugiat lorem, sed
                <!-- Continue le texte de présentation sur la ligne suivante. -->
                pharetra mi pulvinar nec. Sed accumsan dolor ut orci dignissim, non faucibus neque egestas.
            <!-- Ferme le paragraphe de texte descriptif. -->
            </p>
            <!-- Ouvre un bloc de contenu spécifique à l'article avec une marge supérieure. -->
            <div class="article-content mt-4">
                <!-- Affiche un sous-titre de niveau 2 stylé en h5. -->
                <h2 class="h5">Nous écrire</h2>
                <!-- Ouvre un paragraphe pour les informations de contact. -->
                <p>
                    <!-- Met en gras l'étiquette pour l'email. -->
                    <strong>Email :</strong> contact@bec-bordeaux.fr<br>
                    <!-- Met en gras l'étiquette pour le téléphone. -->
                    <strong>Téléphone :</strong> <a href="tel:+33671942380">06 71 94 23 80</a> <a> - </a>
                    <!-- Affiche un deuxième lien téléphone cliquable. -->
                    <a href="tel:+33556918350">05 56 91 83 50</a>
                <!-- Ferme le paragraphe des informations de contact. -->
                </p>
            <!-- Ferme le bloc de contenu des coordonnées. -->
            </div>
        <!-- Ferme la colonne de gauche. -->
        </div>

        <!-- Ouvre la colonne de droite pour le formulaire. -->
        <div class="col-lg-6">
            <!-- Ouvre un formulaire HTML. -->
            <form>
        <!-- Ouvre un groupe de formulaire pour l'email. -->
        <div class="form-group , champ">
            <!-- Ajoute un champ texte avec un placeholder pour l'email. -->
            <input type="text" placeholder="Email">
        <!-- Ferme le groupe de formulaire de l'email. -->
        </div>
        <!-- Insère un saut de ligne. -->
        <br>
        <!-- Ouvre un groupe de formulaire pour le téléphone. -->
        <div class="form-group , champ">
            <!-- Ajoute un champ texte pour le numéro de téléphone. -->
            <input type="text" placeholder="Numéro de Téléphone">
            <!-- Affiche un texte d'aide sous le champ. -->
            <small>Ces informations ne seront pas communiquées à des tiers .</small>
        <!-- Ferme le groupe de formulaire du téléphone. -->
        </div>
        <!-- Insère un saut de ligne. -->
        <br>
        <!-- Ouvre un groupe de formulaire pour le message. -->
        <div class="form-group , champ">
            <!-- Ajoute un champ texte pour le message de l'utilisateur. -->
            <input type="text" class="msg" placeholder="Votre message">
        <!-- Ferme le groupe de formulaire du message. -->
        </div>
        <!-- Insère un saut de ligne. -->
        <br>
        <!-- Ajoute le bouton d'envoi du formulaire. -->
        <button type="submit" class="btn_envoyer">Envoyer</button>
    <!-- Ferme le formulaire HTML. -->
    </form>
    <!-- Ferme la colonne de droite. -->
    </div>
<!-- Ferme la zone principale du contenu. -->
</main>

<?php
// Rouvre le bloc PHP pour inclure le pied de page.
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
// Charge le pied de page commun du site.
?>
