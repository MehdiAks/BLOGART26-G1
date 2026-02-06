<?php // Ouvre le contexte PHP pour exécuter du code côté serveur.
/*
 * Vue d'administration (suppression) pour le module thematiques.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher.
 * - Le bouton principal déclenche la route de suppression côté backend.
 * - Un lien de retour évite la suppression et renvoie vers la liste.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utilisées par l'admin.
include '../../../header.php'; // Inclut l'en-tête HTML partagé de l'interface.

if (isset($_GET['numThem'])) { // Vérifie si l'identifiant est présent dans l'URL.
    $ba_bec_numThem = $_GET['numThem']; // Stocke l'identifiant reçu dans une variable locale.
    $ba_bec_libThem = sql_select("THEMATIQUE", "libThem", "numThem = $ba_bec_numThem")[0]['libThem']; // Récupère le libellé de la thématique ciblée.

    // Vérifie si le statut est utilisé par au moins un membre
    $ba_bec_countnumThem = sql_select("ARTICLE", "COUNT(*) AS total", "numThem = $ba_bec_numThem")[0]['total']; // Compte les articles qui utilisent cette thématique.
    $ba_bec_numThemUsed = $ba_bec_countnumThem > 0; // Indique si la thématique est utilisée au moins une fois.
}
?> <!-- Ferme le bloc PHP. -->

<!-- Bootstrap form to delete a statut -->

<div class="container"><!-- Ouvre le conteneur principal Bootstrap. -->
    <div class="row"><!-- Démarre une ligne Bootstrap pour organiser les colonnes. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le titre et l'alerte. -->
            <h1>Suppression Thematique</h1><!-- Affiche le titre de la page. -->
            <?php if ($ba_bec_numThemUsed) : ?><!-- Si la thématique est utilisée, affiche un message. -->
                <div class="alert alert-danger"><!-- Zone d'alerte Bootstrap en rouge. -->
                    <?php if ($ba_bec_countnumThem > 01) : ?><!-- Adapte le message au pluriel. -->
                        ⚠ Impossible de supprimer cette thematique car elle est utilisées par <?php echo $ba_bec_countnumThem; ?> articles.<!-- Affiche le nombre d'articles. -->
                    <?php else : ?><!-- Branche pour le singulier. -->
                        ⚠ Impossible de supprimer cette thematique car elle est utilisée par <?php echo $ba_bec_countnumThem; ?> article.<!-- Affiche le nombre d'article. -->
                    <?php endif; ?><!-- Termine la condition interne. -->
                    
                </div><!-- Ferme la zone d'alerte. -->
            <?php endif; ?><!-- Termine la condition principale. -->
        </div><!-- Ferme la colonne du titre/alerte. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le formulaire. -->
            <form action="<?php echo ROOT_URL . '/api/thematiques/delete.php' ?>" method="post"><!-- Formulaire pointant vers la suppression. -->
                <div class="form-group"><!-- Groupe de champs pour afficher la thématique. -->
                    <label for="libThem">Nom de Thematique</label><!-- Étiquette du champ libellé. -->
                    <input id="numThem" name="numThem" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numThem); ?>" readonly /><!-- Champ caché pour envoyer l'identifiant. -->
                    <input id="libThem" name="libThem" class="form-control" type="text" value="<?php echo($ba_bec_libThem); ?>" readonly disabled /><!-- Champ en lecture seule pour afficher le libellé. -->
                </div><!-- Ferme le groupe de champs. -->
                <br /><!-- Ajoute un espace vertical. -->
                <div class="form-group mt-2"><!-- Groupe des boutons d'action. -->
                    <a href="list.php" class="btn btn-primary">Retour à la liste</a><!-- Lien de retour sans suppression. -->
                    <button type="submit" class="btn btn-danger" <?php echo ($ba_bec_numThemUsed ? 'disabled' : ''); ?>><!-- Ouvre le bouton de confirmation. -->
                        Confirmer delete ?<!-- Texte affiché dans le bouton. -->
                    </button><!-- Bouton de suppression désactivé si la thématique est utilisée. -->
                </div><!-- Ferme le groupe des boutons. -->
            </form><!-- Ferme le formulaire. -->
        </div><!-- Ferme la colonne du formulaire. -->
    </div><!-- Ferme la ligne Bootstrap. -->
</div><!-- Ferme le conteneur principal. -->
