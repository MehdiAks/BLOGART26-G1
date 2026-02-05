<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Charger les styles spécifiques à cette page
$pageStyles = [
    ROOT_URL . '/src/css/anciens-et-amis.css',
];

require_once 'header.php';
?>

<style>
.bouton{
    background-color: #67081d;
    color: #ddd;
    padding: 10px;
    border-radius: 25px;
}
</style>

<h2>Erreur 404</h2>
<br>
<h3>Une erreur s'est produite. La developpeuse a sans doute du se faire écraser par un bus</h3>
<br>
<h4>Cette page est indisponible pour le moment ou est actuellement en cours de développement.</h4>
<br>
<a href="<?php echo ROOT_URL . '/index.php'; ?>"><button class="bouton">Revenir à l'accueil</button></a>
<br>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>