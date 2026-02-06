<?php // Ouvre le bloc PHP pour exécuter du code serveur.
/* // Démarre un commentaire de documentation multi-lignes.
 * Vue d'administration (liste) pour le module joueurs. // Décrit l'objectif général de la vue.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées. // Explique la base de rendu.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base. // Décrit l'utilisation des filtres.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression. // Décrit la présentation des résultats.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow. // Explique les liens d'action.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections. // Explique l'usage des classes CSS.
 */ // Ferme le commentaire de documentation multi-lignes.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utiles au backend.
include '../../../header.php'; // Inclut l'en-tête commun de l'interface d'administration.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_is_missing_table = [ // Initialise le tableau des tables manquantes.
    'JOUEUR' => sql_is_missing_table('JOUEUR'), // Vérifie l'existence de la table JOUEUR.
    'EQUIPE' => sql_is_missing_table('EQUIPE'), // Vérifie l'existence de la table EQUIPE.
]; // Ferme le tableau des tables manquantes.

$ba_bec_missing_table_labels = [ // Initialise les libellés à afficher pour les tables manquantes.
    'JOUEUR' => 'JOUEUR', // Définit le libellé pour la table JOUEUR.
    'EQUIPE' => 'EQUIPE', // Définit le libellé pour la table EQUIPE.
]; // Ferme le tableau des libellés de tables.

$ba_bec_players = []; // Initialise la liste des joueurs.
$ba_bec_sort = isset($_GET['tri']) ? (string) $_GET['tri'] : 'nom'; // Lit le tri demandé ou applique le tri par nom.
$ba_bec_allowed_sorts = ['nom', 'equipe']; // Définit les tris autorisés.
if (!in_array($ba_bec_sort, $ba_bec_allowed_sorts, true)) { // Vérifie que le tri demandé est autorisé.
    $ba_bec_sort = 'nom'; // Replie sur le tri par nom si le tri est invalide.
} // Ferme la validation du tri.
if (!in_array(true, $ba_bec_is_missing_table, true)) { // Vérifie que toutes les tables nécessaires existent.
    $orderBy = $ba_bec_sort === 'equipe' // Commence la construction de la clause ORDER BY.
        ? 'e.nomEquipe IS NULL, e.nomEquipe ASC, j.nomJoueur ASC, j.prenomJoueur ASC' // Définit l'ordre de tri par équipe.
        : 'j.nomJoueur ASC, j.prenomJoueur ASC'; // Définit l'ordre de tri par nom.
    $playersQuery = "SELECT
            j.numJoueur,
            j.prenomJoueur,
            j.nomJoueur,
            j.urlPhotoJoueur,
            j.dateNaissance,
            j.numeroMaillot,
            j.posteJoueur,
            e.nomEquipe
        FROM JOUEUR j
        LEFT JOIN EQUIPE e ON j.codeEquipe = e.codeEquipe
        ORDER BY {$orderBy}"; // Définit la requête SQL pour récupérer les joueurs.
    $ba_bec_players = $DB->query($playersQuery)->fetchAll(PDO::FETCH_ASSOC); // Exécute la requête et récupère les résultats.
} // Ferme la condition d'existence des tables.

function format_poste(?int $poste): string // Déclare une fonction de formatage du poste.
{ // Ouvre le bloc de la fonction.
    $labels = [ // Initialise les libellés de postes.
        1 => 'Meneur', // Associe l'ID 1 au libellé Meneur.
        2 => 'Arrière', // Associe l'ID 2 au libellé Arrière.
        3 => 'Ailier', // Associe l'ID 3 au libellé Ailier.
        4 => 'Ailier fort', // Associe l'ID 4 au libellé Ailier fort.
        5 => 'Pivot', // Associe l'ID 5 au libellé Pivot.
    ]; // Ferme le tableau des libellés.
    if (!$poste) { // Vérifie si le poste est nul ou vide.
        return 'Non renseigné'; // Retourne un libellé de poste manquant.
    } // Ferme la condition du poste manquant.
    return $labels[$poste] ?? ('Poste ' . $poste); // Retourne le libellé correspondant ou un libellé par défaut.
} // Ferme la fonction format_poste.

function format_age(?string $birthDate): string // Déclare une fonction de formatage de l'âge.
{ // Ouvre le bloc de la fonction.
    if (!$birthDate) { // Vérifie si la date de naissance est absente.
        return 'Non renseigné'; // Retourne un libellé d'âge manquant.
    } // Ferme la condition d'absence de date.
    $date = DateTime::createFromFormat('Y-m-d', $birthDate); // Convertit la date de naissance en objet DateTime.
    if (!$date) { // Vérifie que la conversion a réussi.
        return 'Non renseigné'; // Retourne un libellé d'âge manquant si conversion échoue.
    } // Ferme la condition d'échec de conversion.
    return (string) $date->diff(new DateTime())->y; // Calcule et retourne l'âge en années.
} // Ferme la fonction format_age.
?> <!-- Ferme le bloc PHP pour repasser en HTML. -->

<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <div class="mb-3"> <!-- Ouvre un bloc avec marge basse. -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> <!-- Crée un lien vers le panneau admin. -->
                    Retour au panneau admin <!-- Affiche le texte du lien de retour. -->
                </a> <!-- Ferme le lien de retour. -->
                <a href="<?php echo ROOT_URL . '/views/backend/joueurs/create.php'; ?>" class="btn btn-success"> <!-- Crée un lien vers la création d'un joueur. -->
                    Ajouter un joueur <!-- Affiche le texte du lien d'ajout. -->
                </a> <!-- Ferme le lien d'ajout. -->
            </div> <!-- Ferme le bloc de marge. -->

            <?php foreach ($ba_bec_is_missing_table as $ba_bec_table => $ba_bec_missing): ?> <!-- Démarre la boucle sur les tables manquantes. -->
                <?php if ($ba_bec_missing): ?> <!-- Vérifie si la table est manquante. -->
                    <div class="alert alert-warning"> <!-- Ouvre une alerte de warning. -->
                        <div>La table <?php echo htmlspecialchars($ba_bec_missing_table_labels[$ba_bec_table]); ?> est manquante. Veuillez téléchargé la derniere base de donné fournis.</div> <!-- Affiche le message d'absence de table. -->
                    </div> <!-- Ferme l'alerte de warning. -->
                <?php endif; ?> <!-- Ferme la condition de table manquante. -->
            <?php endforeach; ?> <!-- Termine la boucle sur les tables manquantes. -->

            <h1>Liste des joueurs</h1> <!-- Affiche le titre de la page. -->
            <form method="get" class="row g-3 align-items-end mb-3"> <!-- Ouvre le formulaire de tri. -->
                <div class="col-md-4"> <!-- Ouvre une colonne pour le champ de tri. -->
                    <label for="tri" class="form-label">Trier par</label> <!-- Associe un libellé au champ de tri. -->
                    <select name="tri" id="tri" class="form-select"> <!-- Déclare la liste déroulante de tri. -->
                        <option value="nom" <?php echo $ba_bec_sort === 'nom' ? 'selected' : ''; ?>>Nom</option> <!-- Définit l'option de tri par nom. -->
                        <option value="equipe" <?php echo $ba_bec_sort === 'equipe' ? 'selected' : ''; ?>>Équipe</option> <!-- Définit l'option de tri par équipe. -->
                    </select> <!-- Ferme la liste déroulante de tri. -->
                </div> <!-- Ferme la colonne du tri. -->
                <div class="col-md-4"> <!-- Ouvre une colonne pour le bouton. -->
                    <button type="submit" class="btn btn-primary">Appliquer</button> <!-- Déclare le bouton d'application du tri. -->
                </div> <!-- Ferme la colonne du bouton. -->
            </form> <!-- Ferme le formulaire de tri. -->
            <?php if (empty($ba_bec_players)) : ?> <!-- Vérifie si la liste des joueurs est vide. -->
                <div class="alert alert-info">Aucun joueur trouvé.</div> <!-- Affiche un message d'absence de joueurs. -->
            <?php else : ?> <!-- Ouvre la branche avec des joueurs. -->
                <table class="table table-striped"> <!-- Ouvre le tableau des joueurs. -->
                    <thead> <!-- Ouvre l'en-tête du tableau. -->
                        <tr> <!-- Ouvre la ligne d'en-tête. -->
                            <th>#</th> <!-- Affiche l'entête de colonne ID. -->
                            <th>Nom</th> <!-- Affiche l'entête de colonne nom. -->
                            <th>Âge</th> <!-- Affiche l'entête de colonne âge. -->
                            <th>Équipe</th> <!-- Affiche l'entête de colonne équipe. -->
                            <th>Poste</th> <!-- Affiche l'entête de colonne poste. -->
                            <th>Maillot</th> <!-- Affiche l'entête de colonne maillot. -->
                            <th>Actions</th> <!-- Affiche l'entête de colonne actions. -->
                        </tr> <!-- Ferme la ligne d'en-tête. -->
                    </thead> <!-- Ferme l'en-tête du tableau. -->
                    <tbody> <!-- Ouvre le corps du tableau. -->
                        <?php $ba_bec_current_team = null; ?> <!-- Initialise le groupe d'équipe courant. -->
                        <?php foreach ($ba_bec_players as $ba_bec_player): ?> <!-- Démarre la boucle sur les joueurs. -->
                            <?php if ($ba_bec_sort === 'equipe') : ?> <!-- Vérifie si le tri est par équipe. -->
                                <?php $ba_bec_team_label = $ba_bec_player['nomEquipe'] ?? 'Non affecté'; ?> <!-- Définit le libellé de l'équipe du joueur. -->
                                <?php if ($ba_bec_team_label !== $ba_bec_current_team) : ?> <!-- Vérifie si on change de groupe d'équipe. -->
                                    <tr class="table-secondary"> <!-- Ouvre une ligne de séparation d'équipe. -->
                                        <td colspan="7"> <!-- Ouvre la cellule qui span toutes les colonnes. -->
                                            <strong><?php echo htmlspecialchars($ba_bec_team_label); ?></strong> <!-- Affiche le nom de l'équipe. -->
                                        </td> <!-- Ferme la cellule de l'équipe. -->
                                    </tr> <!-- Ferme la ligne de séparation. -->
                                    <?php $ba_bec_current_team = $ba_bec_team_label; ?> <!-- Met à jour l'équipe courante. -->
                                <?php endif; ?> <!-- Ferme la condition de changement d'équipe. -->
                            <?php endif; ?> <!-- Ferme la condition de tri par équipe. -->
                            <tr> <!-- Ouvre une ligne de joueur. -->
                                <td><?php echo htmlspecialchars($ba_bec_player['numJoueur']); ?></td> <!-- Affiche l'identifiant du joueur. -->
                                <td><?php echo htmlspecialchars($ba_bec_player['prenomJoueur'] . ' ' . $ba_bec_player['nomJoueur']); ?></td> <!-- Affiche le prénom et le nom. -->
                                <td><?php echo htmlspecialchars(format_age($ba_bec_player['dateNaissance'] ?? null)); ?></td> <!-- Affiche l'âge calculé. -->
                                <td><?php echo htmlspecialchars($ba_bec_player['nomEquipe'] ?? 'Non affecté'); ?></td> <!-- Affiche le nom de l'équipe. -->
                                <td><?php echo htmlspecialchars(format_poste($ba_bec_player['posteJoueur'] ?? null)); ?></td> <!-- Affiche le poste formaté. -->
                                <td><?php echo htmlspecialchars($ba_bec_player['numeroMaillot'] ?? ''); ?></td> <!-- Affiche le numéro de maillot. -->
                                <td> <!-- Ouvre la cellule des actions. -->
                                    <a href="edit.php?numJoueur=<?php echo $ba_bec_player['numJoueur']; ?>" class="btn btn-primary">Edit</a> <!-- Lien vers la modification. -->
                                    <a href="delete.php?numJoueur=<?php echo $ba_bec_player['numJoueur']; ?>" class="btn btn-danger">Delete</a> <!-- Lien vers la suppression. -->
                                </td> <!-- Ferme la cellule des actions. -->
                            </tr> <!-- Ferme la ligne de joueur. -->
                        <?php endforeach; ?> <!-- Termine la boucle sur les joueurs. -->
                    </tbody> <!-- Ferme le corps du tableau. -->
                </table> <!-- Ferme le tableau. -->
            <?php endif; ?> <!-- Ferme la condition d'affichage du tableau. -->
        </div> <!-- Ferme la colonne principale. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->
