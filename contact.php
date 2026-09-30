<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$pageStyles = [ROOT_URL . '/src/css/contact.css'];
$pageTitle = 'Contact';
$pageDescription = 'Coordonnées et contact du Bordeaux Étudiant Club Basket à la salle Barbey.';
require_once 'header.php';

?>

<main class="container py-5">
    <div class="row align-items-start g-5">
        <div class="col-lg-6">
            <h1 class="mb-3">Contact</h1>
            <p>Retrouvez le BEC Basket à la salle Barbey, 8 cours Barbey à Bordeaux. Pour toute question sur le club, contactez le secrétariat.</p>
            <div class="article-content mt-4">
                <h2 class="h5">Nous écrire</h2>
                <p>
                    <strong>Email :</strong> contact@bec-bordeaux.fr<br>
                    <strong>Téléphone :</strong> <a href="tel:+33671942380">06 71 94 23 80</a> <a> - </a>
                    <a href="tel:+33556918350">05 56 91 83 50</a>
                </p>
            </div>
        </div>

        <div class="col-lg-6">
            <form>
        <div class="form-group , champ">
            <input type="text" placeholder="Email">
        </div>
        <br>
        <div class="form-group , champ">
            <input type="text" placeholder="Numéro de Téléphone">
            <small>Ces informations ne seront pas communiquées à des tiers .</small>
        </div>
        <br>
        <div class="form-group , champ">
            <input type="text" class="msg" placeholder="Votre message">
        </div>
        <br>
        <button type="submit" class="btn_envoyer">Envoyer</button>
    </form>
    </div>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>
