<?php // Ouvre le contexte PHP pour exécuter du code côté serveur.
/*
 * Vue d'administration (création) pour le module thematiques.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utilisées par l'admin.
include '../../../header.php'; // Inclut l'en-tête HTML partagé de l'interface.
?> <!-- Ferme le bloc PHP. -->

<!-- Bootstrap form to create a new statut -->
<div class="container"><!-- Ouvre le conteneur principal Bootstrap. -->
    <div class="row"><!-- Démarre une ligne Bootstrap pour organiser les colonnes. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le titre. -->
            <h1>Création nouvelle Thematique</h1><!-- Affiche le titre de la page. -->
        </div><!-- Ferme la colonne du titre. -->
        <div class="col-md-12"><!-- Colonne pleine largeur pour le formulaire. -->
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/thematiques/create.php' ?>" method="post"><!-- Déclare le formulaire et sa destination backend. -->
                <div class="form-group"><!-- Groupe de champs pour le libellé. -->
                    <label for="libThem">Nom de thematique</label><!-- Étiquette associée au champ libThem. -->
                    <input id="libThem" name="libThem" class="form-control" type="text" autofocus="autofocus" placeholder="Nom de la thématique..." required /><!-- Champ texte requis pour le nom. -->
                </div><!-- Ferme le groupe de champs. -->
                <br /><!-- Ajoute un espace vertical entre sections. -->
                <div class="form-group mt-2"><!-- Groupe des boutons d'action. -->
                    <a href="list.php" class="btn btn-primary">Annuler</a><!-- Lien pour revenir à la liste sans créer. -->
                    <button type="submit" class="btn btn-success">Confirmer create ?</button><!-- Bouton pour soumettre le formulaire. -->
                </div><!-- Ferme le groupe des boutons. -->
            </form><!-- Ferme le formulaire. -->
        </div><!-- Ferme la colonne du formulaire. -->
    </div><!-- Ferme la ligne Bootstrap. -->
</div><!-- Ferme le conteneur principal. -->
