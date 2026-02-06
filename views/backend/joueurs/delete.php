<?php // Ouvre le bloc PHP pour exécuter du code serveur.
/* // Démarre un commentaire de documentation multi-lignes.
 * Vue d'administration (suppression) pour le module joueurs. // Décrit l'objectif général de la vue.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement. // Explique l'objectif de confirmation.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher. // Indique la provenance de l'ID.
 * - Le bouton principal déclenche la route de suppression côté backend. // Décrit l'action principale.
 * - Un lien de retour évite la suppression et renvoie vers la liste. // Explique le lien de retour.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface. // Précise l'absence de logique métier.
 */ // Ferme le commentaire de documentation multi-lignes.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utiles au backend.
include '../../../header.php'; // Inclut l'en-tête commun de l'interface d'administration.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_joueur = null; // Initialise la variable du joueur.
if (isset($_GET['numJoueur'])) { // Vérifie si l'identifiant du joueur est fourni.
    $ba_bec_numJoueur = (int) $_GET['numJoueur']; // Convertit l'identifiant en entier.
    $ba_bec_joueur = sql_select('JOUEUR', '*', "numJoueur = '$ba_bec_numJoueur'"); // Récupère le joueur correspondant.
    $ba_bec_joueur = $ba_bec_joueur[0] ?? null; // Sélectionne le premier résultat ou null.
} // Ferme la condition de récupération du joueur.
?> <!-- Ferme le bloc PHP pour repasser en HTML. -->

<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <h1>Suppression joueur</h1> <!-- Affiche le titre de la page. -->
        </div> <!-- Ferme la colonne du titre. -->
        <div class="col-md-12"> <!-- Ouvre la colonne du contenu. -->
            <?php if ($ba_bec_joueur) : ?> <!-- Vérifie que le joueur a été trouvé. -->
                <form action="<?php echo ROOT_URL . '/api/joueurs/delete.php' ?>" method="post"> <!-- Ouvre le formulaire de suppression. -->
                    <div class="form-group"> <!-- Ouvre un groupe de champ. -->
                        <label for="numJoueur">ID joueur</label> <!-- Associe un libellé au champ ID. -->
                        <input id="numJoueur" name="numJoueur" class="form-control" type="text" value="<?php echo $ba_bec_joueur['numJoueur']; ?>" readonly /> <!-- Affiche l'ID en lecture seule. -->
                    </div> <!-- Ferme le groupe de l'ID. -->
                    <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                        <label for="summary">Nom</label> <!-- Associe un libellé au champ nom. -->
                        <input id="summary" name="summary" class="form-control" type="text" value="<?php echo htmlspecialchars($ba_bec_joueur['prenomJoueur'] . ' ' . $ba_bec_joueur['nomJoueur']); ?>" readonly /> <!-- Affiche le nom complet en lecture seule. -->
                    </div> <!-- Ferme le groupe du nom. -->
                    <br /> <!-- Insère un saut de ligne. -->
                    <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                        <a href="list.php" class="btn btn-primary">Retour à la liste</a> <!-- Ajoute un lien de retour à la liste. -->
                        <button type="submit" class="btn btn-danger">Confirmer delete ?</button> <!-- Ajoute le bouton de confirmation. -->
                    </div> <!-- Ferme le groupe des actions. -->
                </form> <!-- Ferme le formulaire de suppression. -->
            <?php else : ?> <!-- Ouvre la branche de joueur introuvable. -->
                <div class="alert alert-danger">Joueur introuvable.</div> <!-- Affiche un message d'erreur. -->
                <a href="list.php" class="btn btn-primary">Retour</a> <!-- Ajoute un lien de retour. -->
            <?php endif; ?> <!-- Ferme la condition de joueur existant. -->
        </div> <!-- Ferme la colonne du contenu. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->
