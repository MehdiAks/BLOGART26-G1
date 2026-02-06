<?php // Démarre le bloc PHP serveur.
/*
 * Vue d'administration (suppression) pour le module equipes. // Présente l'objectif de la vue.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement. // Explique le rôle de confirmation.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher. // Décrit la source de l'ID.
 * - Le bouton principal déclenche la route de suppression côté backend. // Explique l'action du bouton.
 * - Un lien de retour évite la suppression et renvoie vers la liste. // Explique l'action secondaire.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface. // Rappelle l'absence de logique métier.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection.
include '../../../header.php'; // Inclut l'en-tête commun.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_equipe = null; // Initialise la variable d'équipe.
if (isset($_GET['numEquipe'])) { // Vérifie si l'identifiant est dans l'URL.
    $ba_bec_numEquipe = (int) $_GET['numEquipe']; // Convertit l'ID en entier.
    $ba_bec_equipe = sql_select('EQUIPE', '*', "numEquipe = '$ba_bec_numEquipe'"); // Récupère l'équipe correspondante.
    $ba_bec_equipe = $ba_bec_equipe[0] ?? null; // Prend le premier résultat ou null.
} // Ferme la condition de récupération.
?> <!-- Ferme le bloc PHP avant le HTML. -->

<div class="container"> <!-- Ouvre le conteneur principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <h1>Suppression équipe</h1> <!-- Titre de la page de suppression. -->
        </div> <!-- Ferme la colonne du titre. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pour le contenu. -->
            <?php if ($ba_bec_equipe) : ?> <!-- Vérifie qu'une équipe a été trouvée. -->
                <form action="<?php echo ROOT_URL . '/api/equipes/delete.php' ?>" method="post"> <!-- Ouvre le formulaire de suppression. -->
                    <div class="form-group"> <!-- Ouvre le groupe ID équipe. -->
                        <label for="numEquipe">ID équipe</label> <!-- Étiquette du champ ID. -->
                        <input id="numEquipe" name="numEquipe" class="form-control" type="text" value="<?php echo $ba_bec_equipe['numEquipe']; ?>" readonly /> <!-- Champ ID en lecture seule. -->
                    </div> <!-- Ferme le groupe ID. -->
                    <div class="form-group mt-2"> <!-- Ouvre le groupe nom équipe. -->
                        <label for="summary">Nom</label> <!-- Étiquette du champ nom. -->
                        <input id="summary" name="summary" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_equipe['nomEquipe']); ?>" readonly /> <!-- Champ nom en lecture seule. -->
                    </div> <!-- Ferme le groupe nom. -->
                    <br /> <!-- Ajoute un saut de ligne visuel. -->
                    <div class="form-group mt-2"> <!-- Ouvre le groupe actions. -->
                        <a href="list.php" class="btn btn-primary">Retour à la liste</a> <!-- Lien de retour vers la liste. -->
                        <button type="submit" class="btn btn-danger">Confirmer delete ?</button> <!-- Bouton pour confirmer la suppression. -->
                    </div> <!-- Ferme le groupe actions. -->
                </form> <!-- Ferme le formulaire de suppression. -->
            <?php else : ?> <!-- Branche affichée si aucune équipe. -->
                <div class="alert alert-danger">Équipe introuvable.</div> <!-- Message d'erreur si équipe absente. -->
                <a href="list.php" class="btn btn-primary">Retour</a> <!-- Lien de retour simple. -->
            <?php endif; ?> <!-- Termine la condition d'affichage. -->
        </div> <!-- Ferme la colonne contenu. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->
