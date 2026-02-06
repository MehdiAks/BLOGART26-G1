<?php
// Ouvre le bloc PHP.
/*
 * Vue d'administration (suppression) pour le module keywords.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher.
 * - Le bouton principal déclenche la route de suppression côté backend.
 * - Un lien de retour évite la suppression et renvoie vers la liste.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface.
 */
// Charge le fichier de configuration principal.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Charge le fichier de redirection utilitaire.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
// Inclut l'en-tête commun du site.
include '../../../header.php';

// Vérifie si le paramètre numMotCle est présent dans l'URL.
if (isset($_GET['numMotCle'])) {
    // Stocke l'identifiant du mot-clé depuis la query string.
    $ba_bec_numMotCle = $_GET['numMotCle'];
    // Récupère le libellé du mot-clé depuis la base de données.
    $ba_bec_libMotCle = sql_select("MOTCLE", "libMotCle", "numMotCle = $ba_bec_numMotCle")[0]['libMotCle'];

    // Vérifie si le mot-clé est utilisé par au moins un article.
    $ba_bec_countnumMotCle = sql_select("MOTCLEARTICLE", "COUNT(*) AS total", "numMotCle = $ba_bec_numMotCle")[0]['total'];
    // Détermine si le mot-clé est utilisé ou non.
    $ba_bec_ifnumMotCleUsed = $ba_bec_countnumMotCle > 0; // true si au moins un membre a ce statut
}
// Ferme le bloc PHP.
?>
<!-- Décrit le commentaire HTML : formulaire Bootstrap de suppression. -->
<!-- Bootstrap form to delete a statut -->
<!-- Ouvre un conteneur Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur. -->
        <div class="col-md-12">
            <!-- Titre de la page de suppression. -->
            <h1>Suppression Mot-clé</h1>
            <!-- Ouvre une condition PHP si le mot-clé est utilisé. -->
            <?php if ($ba_bec_ifnumMotCleUsed) : ?>
                <!-- Ouvre une alerte Bootstrap. -->
                <div class="alert alert-danger">
                    <!-- Ouvre une condition PHP si plusieurs articles utilisent le mot-clé. -->
                    <?php if ($ba_bec_countnumMotCle > 1) : ?>
                        <!-- Message d'erreur pour plusieurs articles. -->
                        ⚠ Impossible de supprimer ce Mot-clé car il est utilisés par <?php echo $ba_bec_countnumMotCle; ?> articles.
                    <!-- Sinon, message pour un seul article. -->
                    <?php else : ?>
                        <!-- Message d'erreur pour un seul article. -->
                        ⚠ Impossible de supprimer ce Mot-clé car il est utilisé par <?php echo $ba_bec_countnumMotCle; ?> article.
                    <!-- Ferme la condition PHP interne. -->
                    <?php endif; ?>
                <!-- Ferme l'alerte. -->
                </div>
            <!-- Ferme la condition PHP externe. -->
            <?php endif; ?>
        <!-- Ferme la colonne. -->
        </div>
        <!-- Ouvre une colonne pleine largeur pour le formulaire. -->
        <div class="col-md-12">
            <!-- Ouvre le formulaire de suppression. -->
            <form action="<?php echo ROOT_URL . '/api/keywords/delete.php' ?>" method="post">
                <!-- Ouvre le groupe de champs. -->
                <div class="form-group">
                    <!-- Libellé du champ libMotCle. -->
                    <label for="libMotCle">Nom du Mot-clé</label>
                    <!-- Champ caché contenant l'identifiant. -->
                    <input id="numMotCle" name="numMotCle" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numMotCle); ?>" readonly />
                    <!-- Champ affichant le libellé en lecture seule. -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($ba_bec_libMotCle); ?>" readonly disabled />
                <!-- Ferme le groupe de champs. -->
                </div>
                <!-- Saut de ligne HTML. -->
                <br />
                <!-- Ouvre le groupe de boutons. -->
                <div class="form-group mt-2">
                    <!-- Lien de retour vers la liste. -->
                    <a href="list.php" class="btn btn-primary">Retour à la liste</a>
                    <!-- Bouton de confirmation de suppression, potentiellement désactivé. -->
                    <button type="submit" class="btn btn-danger" <?php echo ($ba_bec_ifnumMotCleUsed ? 'disabled' : ''); ?>>
                        <!-- Texte du bouton. -->
                        Confirmer delete ?
                    <!-- Ferme le bouton. -->
                    </button>
                <!-- Ferme le groupe de boutons. -->
                </div>
            <!-- Ferme le formulaire. -->
            </form>
        <!-- Ferme la colonne. -->
        </div>
    <!-- Ferme la ligne. -->
    </div>
<!-- Ferme le conteneur. -->
</div>
