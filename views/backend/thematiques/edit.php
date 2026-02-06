<?php // Ouvre le contexte PHP pour exécuter du code côté serveur.
/*
 * Vue d'administration (édition) pour le module thematiques.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
 * - L'action du formulaire cible la route de mise à jour correspondante.
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée.
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utilisées par l'admin.
include '../../../header.php'; // Inclut l'en-tête HTML partagé de l'interface.

if (isset($_GET['numThem'])) { // Vérifie si l'identifiant est présent dans l'URL.
    $ba_bec_numThem = $_GET['numThem']; // Stocke l'identifiant reçu dans une variable locale.
    $ba_bec_libThem = sql_select("THEMATIQUE", "libThem", "numThem = $ba_bec_numThem")[0]['libThem']; // Récupère le libellé de la thématique ciblée.
}

?> <!-- Ferme le bloc PHP. -->
<div class="container"><!-- Ouvre le conteneur principal Bootstrap. -->
    <div class="row"><!-- Démarre une ligne Bootstrap pour organiser les colonnes. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le titre. -->
            <h1>Thematique</h1><!-- Affiche le titre de la page. -->
        </div><!-- Ferme la colonne du titre. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le formulaire. -->
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/thematiques/update.php' ?>" method="post"><!-- Formulaire pointant vers la mise à jour. -->
                <div class="form-group"><!-- Groupe de champs pour la thématique. -->
                    <label for="libThem">Nom de Thematique </label><!-- Étiquette du champ libellé. -->
                    <input id="numThem" name="numThem" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numThem); ?>" readonly="readonly" /><!-- Champ caché pour l'identifiant. -->
                    <input id="libThem" name="libThem" class="form-control" type="text" value="<?php echo($ba_bec_libThem); ?>" placeholder="Nom de la thématique..."/><!-- Champ modifiable du libellé. -->
                </div><!-- Ferme le groupe de champs. -->
                <br /><!-- Ajoute un espace vertical. -->
                <div class="form-group mt-2"><!-- Groupe des boutons d'action. -->
                    <a href="list.php" class="btn btn-primary">Annuler</a><!-- Lien de retour sans modification. -->
                    <button type="submit" class="btn btn-danger">Confirmer Edit ?</button><!-- Bouton pour soumettre la mise à jour. -->
                </div><!-- Ferme le groupe des boutons. -->
            </form><!-- Ferme le formulaire. -->
        </div><!-- Ferme la colonne du formulaire. -->
    </div><!-- Ferme la ligne Bootstrap. -->
</div><!-- Ferme le conteneur principal. -->
