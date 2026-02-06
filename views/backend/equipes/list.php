<?php // Démarre le bloc PHP serveur.
/*
 * Vue d'administration (liste) pour le module equipes. // Présente le rôle de la page.
 * - Le gabarit est rendu côté serveur et s'appuie sur les inclusions globales (config/header) déjà chargées. // Explique le rendu serveur.
 * - Les filtres éventuels sont lus via la query string (GET) pour limiter l'affichage sans modifier l'URL de base. // Explique le filtrage.
 * - Les résultats sont présentés dans un tableau structuré, avec des actions de consultation/modification/suppression. // Explique la présentation.
 * - Les liens d'action pointent vers les routes backend correspondantes afin d'enchaîner le workflow. // Explique les actions.
 * - Les classes utilitaires (Bootstrap) gèrent la mise en page et la hiérarchie visuelle des sections. // Explique le style.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection.
include '../../../header.php'; // Inclut l'en-tête commun.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_is_missing_table = sql_is_missing_table('EQUIPE'); // Vérifie si la table EQUIPE est absente.
$ba_bec_equipes = []; // Initialise la liste des équipes.

function ba_bec_equipe_photo_url(?string $path): string // Déclare un helper de normalisation d'URL photo.
{ // Ouvre le corps de la fonction.
    if (!$path) { // Vérifie si le chemin est vide.
        return ''; // Retourne une chaîne vide si rien.
    } // Ferme la condition chemin vide.

    if (preg_match('/^(https?:\/\/|\/)/', $path)) { // Détecte une URL absolue.
        return $path; // Retourne l'URL telle quelle.
    } // Ferme la condition URL absolue.

    if (strpos($path, 'photos-equipes/') === 0) { // Détecte un chemin déjà préfixé.
        return ROOT_URL . '/src/uploads/' . ltrim($path, '/'); // Reconstruit l'URL avec uploads.
    } // Ferme la condition de préfixe.

    return ROOT_URL . '/src/uploads/photos-equipes/' . ltrim($path, '/'); // Construit l'URL par défaut.
} // Ferme la fonction helper.

if (!$ba_bec_is_missing_table) { // Vérifie que la table existe.
    $teamsStmt = $DB->prepare( // Prépare la requête SQL de listing.
        'SELECT numEquipe, codeEquipe, nomEquipe, club, categorie, section, niveau, photoDLequipe, photoStaff
         FROM EQUIPE
         ORDER BY nomEquipe ASC' // Définit la requête SQL avec tri.
    ); // Termine la préparation.
    $teamsStmt->execute(); // Exécute la requête.
    $ba_bec_equipes = $teamsStmt->fetchAll(PDO::FETCH_ASSOC); // Charge toutes les équipes.
} // Ferme la condition de chargement.
?> <!-- Ferme le bloc PHP avant le HTML. -->

<div class="container"> <!-- Ouvre le conteneur principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <div class="mb-3"> <!-- Ouvre un bloc avec marge basse. -->
                <a href="<?php echo ROOT_URL . '/views/backend/dashboard.php'; ?>" class="btn btn-secondary"> <!-- Lien vers le dashboard. -->
                    Retour au panneau admin <!-- Texte du lien dashboard. -->
                </a> <!-- Ferme le lien dashboard. -->
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/create.php'; ?>" class="btn btn-success"> <!-- Lien vers la création. -->
                    Ajouter une équipe <!-- Texte du lien création. -->
                </a> <!-- Ferme le lien création. -->
            </div> <!-- Ferme le bloc marge. -->

            <?php if ($ba_bec_is_missing_table) : ?> <!-- Vérifie si la table est manquante. -->
                <div class="alert alert-warning"> <!-- Ouvre l'alerte d'avertissement. -->
                    <div>La table EQUIPE est manquante. Veuillez téléchargé la derniere base de donné fournis.</div> <!-- Message d'alerte. -->
                </div> <!-- Ferme l'alerte d'avertissement. -->
            <?php endif; ?> <!-- Termine la condition table manquante. -->

            <h1>Liste des équipes</h1> <!-- Titre de la page liste. -->
            <?php
            $ba_bec_flash_messages = flash_get(); // Récupère les messages flash.
            $ba_bec_alert_map = ['success' => 'success', 'error' => 'danger', 'warning' => 'warning']; // Mappe les types d'alerte.
            ?> <!-- Ferme le bloc PHP des messages. -->
            <?php foreach ($ba_bec_flash_messages as $ba_bec_flash): ?> <!-- Boucle sur les messages flash. -->
                <div class="alert alert-<?php echo $ba_bec_alert_map[$ba_bec_flash['type']] ?? 'info'; ?>" role="alert"> <!-- Affiche une alerte. -->
                    <?php echo htmlspecialchars($ba_bec_flash['message']); ?> <!-- Affiche le message sécurisé. -->
                </div> <!-- Ferme l'alerte. -->
            <?php endforeach; ?> <!-- Termine la boucle des messages. -->
            <?php if (empty($ba_bec_equipes)) : ?> <!-- Vérifie si aucune équipe. -->
                <div class="alert alert-info">Aucune équipe trouvée.</div> <!-- Message d'info si vide. -->
            <?php else : ?> <!-- Branche si des équipes existent. -->
                <table class="table table-striped"> <!-- Ouvre le tableau des équipes. -->
                    <thead> <!-- Ouvre l'en-tête du tableau. -->
                        <tr> <!-- Ouvre la ligne d'en-tête. -->
                            <th>#</th> <!-- Colonne ID. -->
                            <th>Code</th> <!-- Colonne code. -->
                            <th>Nom</th> <!-- Colonne nom. -->
                            <th>Club</th> <!-- Colonne club. -->
                            <th>Catégorie</th> <!-- Colonne catégorie. -->
                            <th>Section</th> <!-- Colonne section. -->
                            <th>Niveau</th> <!-- Colonne niveau. -->
                            <th>Photo équipe</th> <!-- Colonne photo équipe. -->
                            <th>Photo staff</th> <!-- Colonne photo staff. -->
                            <th>Actions</th> <!-- Colonne actions. -->
                        </tr> <!-- Ferme la ligne d'en-tête. -->
                    </thead> <!-- Ferme l'en-tête du tableau. -->
                    <tbody> <!-- Ouvre le corps du tableau. -->
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?> <!-- Boucle sur chaque équipe. -->
                            <?php
                            $ba_bec_photoEquipeUrl = ba_bec_equipe_photo_url($ba_bec_equipe['photoDLequipe'] ?? ''); // Calcule l'URL photo équipe.
                            $ba_bec_photoStaffUrl = ba_bec_equipe_photo_url($ba_bec_equipe['photoStaff'] ?? ''); // Calcule l'URL photo staff.
                            ?> <!-- Ferme le bloc PHP des URLs. -->
                            <tr> <!-- Ouvre la ligne de l'équipe. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?></td> <!-- Affiche l'ID équipe. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?></td> <!-- Affiche le code équipe. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['nomEquipe']); ?></td> <!-- Affiche le nom équipe. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['club']); ?></td> <!-- Affiche le club. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['categorie']); ?></td> <!-- Affiche la catégorie. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['section']); ?></td> <!-- Affiche la section. -->
                                <td><?php echo htmlspecialchars($ba_bec_equipe['niveau']); ?></td> <!-- Affiche le niveau. -->
                                <td> <!-- Ouvre la cellule photo équipe. -->
                                    <?php if ($ba_bec_photoEquipeUrl): ?> <!-- Vérifie si une photo équipe existe. -->
                                        <img src="<?php echo htmlspecialchars($ba_bec_photoEquipeUrl); ?>" alt="Photo équipe"
                                            style="max-width: 80px; height: auto;"> <!-- Affiche la photo équipe. -->
                                    <?php else : ?> <!-- Branche si pas de photo équipe. -->
                                        <span class="text-muted">—</span> <!-- Affiche un tiret grisé. -->
                                    <?php endif; ?> <!-- Termine la condition photo équipe. -->
                                </td> <!-- Ferme la cellule photo équipe. -->
                                <td> <!-- Ouvre la cellule photo staff. -->
                                    <?php if ($ba_bec_photoStaffUrl): ?> <!-- Vérifie si une photo staff existe. -->
                                        <img src="<?php echo htmlspecialchars($ba_bec_photoStaffUrl); ?>" alt="Photo staff"
                                            style="max-width: 80px; height: auto;"> <!-- Affiche la photo staff. -->
                                    <?php else : ?> <!-- Branche si pas de photo staff. -->
                                        <span class="text-muted">—</span> <!-- Affiche un tiret grisé. -->
                                    <?php endif; ?> <!-- Termine la condition photo staff. -->
                                </td> <!-- Ferme la cellule photo staff. -->
                                <td> <!-- Ouvre la cellule actions. -->
                                    <a href="edit.php?numEquipe=<?php echo $ba_bec_equipe['numEquipe']; ?>" class="btn btn-primary">Edit</a> <!-- Lien vers l'édition. -->
                                    <a href="delete.php?numEquipe=<?php echo $ba_bec_equipe['numEquipe']; ?>" class="btn btn-danger">Delete</a> <!-- Lien vers la suppression. -->
                                </td> <!-- Ferme la cellule actions. -->
                            </tr> <!-- Ferme la ligne équipe. -->
                        <?php endforeach; ?> <!-- Termine la boucle des équipes. -->
                    </tbody> <!-- Ferme le corps du tableau. -->
                </table> <!-- Ferme le tableau. -->
            <?php endif; ?> <!-- Termine la condition d'affichage. -->
        </div> <!-- Ferme la colonne principale. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->
