<?php
// Ouvre le bloc PHP.
/*
 * Vue d'administration (édition) pour le module keywords.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
 * - L'action du formulaire cible la route de mise à jour correspondante.
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée.
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer.
 */
// Charge le fichier de configuration principal.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Charge le fichier de redirection utilitaire.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
// Inclut l'en-tête commun du site.
include '../../../header.php';

// Vérifie si le paramètre numMotCle est présent dans l'URL.
if(isset($_GET['numMotCle'])){
    // Stocke l'identifiant du mot-clé depuis la query string.
    $ba_bec_numMotCle = $_GET['numMotCle'];
    // Récupère le libellé du mot-clé depuis la base de données.
    $ba_bec_libMotCle = sql_select("MOTCLE", "libMotCle", "numMotCle = $ba_bec_numMotCle")[0]['libMotCle'];
}

// Ferme le bloc PHP.
?>
<!-- Ouvre un conteneur Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur. -->
        <div class="col-md-12">
            <!-- Titre de la page d'édition. -->
            <h1> Mot-Clé</h1>
        <!-- Ferme la colonne. -->
        </div>
        <!-- Ouvre une colonne pleine largeur pour le formulaire. -->
        <div class="col-md-12">
            <!-- Commentaire HTML indiquant le formulaire. -->
            <!-- Form to create a new statut -->
            <!-- Ouvre le formulaire de mise à jour. -->
            <form action="<?php echo ROOT_URL . '/api/keywords/update.php' ?>" method="post">
                <!-- Ouvre le groupe de champs. -->
                <div class="form-group">
                    <!-- Libellé du champ libMotCle. -->
                    <label for="libMotCle">Nom du mots-clés</label>
                    <!-- Champ caché contenant l'identifiant. -->
                    <input id="numMotCle" name="numMotCle" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numMotCle); ?>" readonly="readonly" />
                    <!-- Champ de saisie du libellé. -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text"
                        value="<?php echo($ba_bec_libMotCle); ?>" placeholder="Nom du mot-clé..."/>
                <!-- Ferme le groupe de champs. -->
                </div>
                <!-- Saut de ligne HTML. -->
                <br />
                <!-- Ouvre le groupe de boutons. -->
                <div class="form-group mt-2">
                    <!-- Lien d'annulation vers la liste. -->
                    <a href="list.php" class="btn btn-primary">Annuler</a>
                    <!-- Bouton de soumission de la modification. -->
                    <button type="submit" class="btn btn-danger">Confirmer Edit ?</button>
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
