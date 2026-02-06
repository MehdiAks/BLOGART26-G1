<?php
// Ouvre le bloc PHP.
/*
 * Vue d'administration (création) pour le module keywords.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */
// Charge le fichier de configuration principal.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
// Charge le fichier de redirection utilitaire.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php';
// Inclut l'en-tête commun du site.
include '../../../header.php';
// Ferme le bloc PHP.
?>


<!-- Décrit le commentaire HTML : formulaire Bootstrap. -->
<!-- Bootstrap form to create a new statut -->
<!-- Ouvre un conteneur Bootstrap. -->
<div class="container">
    <!-- Ouvre une ligne Bootstrap. -->
    <div class="row">
        <!-- Ouvre une colonne pleine largeur. -->
        <div class="col-md-12">
            <!-- Titre de la page de création. -->
            <h1>Création nouveau Mot-clé </h1>
        <!-- Ferme la colonne. -->
        </div>
        <!-- Ouvre une colonne pleine largeur pour le formulaire. -->
        <div class="col-md-12">
            <!-- Commentaire HTML indiquant le formulaire. -->
            <!-- Form to create a new statut -->
            <!-- Ouvre le formulaire HTML. -->
            <form action="<?php echo ROOT_URL . '/api/keywords/create.php' ?>" method="post">
                <!-- Ouvre le groupe de champs. -->
                <div class="form-group">
                    <!-- Libellé du champ libMotCle. -->
                    <label for="libMotCle">Nom du Mot-clé</label>
                    <!-- Champ de saisie du mot-clé. -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" autofocus="autofocus"
                        placeholder="Nom du mot-clé..." required />
                <!-- Ferme le groupe de champs. -->
                </div>
                <!-- Saut de ligne HTML. -->
                <br />
                <!-- Ouvre le groupe de boutons. -->
                <div class="form-group mt-2">
                    <!-- Lien d'annulation vers la liste. -->
                    <a href="list.php" class="btn btn-primary">Annuler</a>
                    <!-- Bouton de soumission du formulaire. -->
                    <button type="submit" class="btn btn-success">Confirmer create ?</button>
                <!-- Ferme le groupe de boutons. -->
                </div>
            <!-- Ferme le formulaire HTML. -->
            </form>
        <!-- Ferme la colonne du formulaire. -->
        </div>
    <!-- Ferme la ligne. -->
    </div>
<!-- Ferme le conteneur. -->
</div>
