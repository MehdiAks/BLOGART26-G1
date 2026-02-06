<?php // Démarre l'exécution du script en mode PHP.
/*
 * Vue d'administration (suppression) pour le module benevoles.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher.
 * - Le bouton principal déclenche la route de suppression côté backend.
 * - Un lien de retour évite la suppression et renvoie vers la liste.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection.
include '../../../header.php'; // Inclut l'en-tête HTML partagé.

if (!isset($_GET['numPersonnel'])) { // Vérifie que l'identifiant est fourni dans l'URL.
    header('Location: ' . ROOT_URL . '/views/backend/benevoles/list.php'); // Redirige vers la liste si l'identifiant manque.
    exit(); // Arrête l'exécution après la redirection.
}

$ba_bec_numPersonnel = $_GET['numPersonnel']; // Récupère l'identifiant du personnel depuis la query string.
$ba_bec_benevole = sql_select('PERSONNEL', '*', "numPersonnel = '$ba_bec_numPersonnel'"); // Cherche le bénévole correspondant dans la base.
$ba_bec_benevole = $ba_bec_benevole[0] ?? null; // Prend le premier résultat ou null si aucun.

if (!$ba_bec_benevole) { // Vérifie que le bénévole existe.
    header('Location: ' . ROOT_URL . '/views/backend/benevoles/list.php'); // Redirige vers la liste si aucun bénévole trouvé.
    exit(); // Arrête l'exécution après la redirection.
}
?>

<!-- Ouvre le conteneur principal Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap pour la grille. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur pour le contenu. -->
        <div class="col-md-12">
            <!-- Ouvre un bloc avec marge basse pour le lien de retour. -->
            <div class="mb-3">
                <!-- Ouvre un lien vers la liste des bénévoles. -->
                <a href="<?php echo ROOT_URL . '/views/backend/benevoles/list.php'; ?>" class="btn btn-secondary">
                    <!-- Affiche le texte du lien de retour. -->
                    Retour à la liste
                <!-- Ferme le lien de retour. -->
                </a>
            <!-- Ferme le bloc de marge basse. -->
            </div>
            <!-- Affiche le titre principal de la page de suppression. -->
            <h1>Supprimer un bénévole</h1>
            <!-- Affiche la phrase de confirmation avec le nom et prénom échappés. -->
            <p>Confirmez la suppression de <?php echo htmlspecialchars($ba_bec_benevole['prenomPersonnel'] . ' ' . $ba_bec_benevole['nomPersonnel']); ?>.</p>
            <!-- Ouvre le formulaire qui déclenchera la suppression. -->
            <form action="<?php echo ROOT_URL . '/api/benevoles/delete.php'; ?>" method="post">
                <!-- Champ caché qui envoie l'identifiant du bénévole à supprimer. -->
                <input type="hidden" name="numPersonnel" value="<?php echo htmlspecialchars($ba_bec_benevole['numPersonnel']); ?>" />
                <!-- Bouton de soumission pour confirmer la suppression. -->
                <button type="submit" class="btn btn-danger">Supprimer</button>
            <!-- Ferme le formulaire. -->
            </form>
        <!-- Ferme la colonne. -->
        </div>
    <!-- Ferme la ligne Bootstrap. -->
    </div>
<!-- Ferme le conteneur principal. -->
</div>
