<?php // Démarre le bloc PHP pour exécuter la logique serveur.
/*
 * Vue d'administration (création) pour le module equipes. // Décrit le rôle général de la vue.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier. // Résume l'objectif du formulaire.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action). // Explique la cible de soumission.
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation. // Explique l'organisation des champs.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste. // Explique les actions UI.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue. // Explique le rôle des classes CSS.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale du projet.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection.
include '../../../header.php'; // Inclut l'en-tête HTML commun au backend.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_clubs = []; // Initialise la liste des clubs.
$ba_bec_categories = []; // Initialise la liste des catégories.
$ba_bec_sections = []; // Initialise la liste des sections.
$ba_bec_niveaux = []; // Initialise la liste des niveaux.
$ba_bec_clubs = array_column( // Extrait la colonne club dans un tableau simple.
    sql_select('EQUIPE', 'DISTINCT club', "club <> ''", null, 'club ASC'), // Récupère les clubs distincts non vides.
    'club' // Sélectionne la colonne "club" du résultat.
); // Termine l'affectation des clubs.
$ba_bec_categories = array_column( // Extrait la colonne categorie dans un tableau simple.
    sql_select('EQUIPE', 'DISTINCT categorie', "categorie <> ''", null, 'categorie ASC'), // Récupère les catégories distinctes non vides.
    'categorie' // Sélectionne la colonne "categorie" du résultat.
); // Termine l'affectation des catégories.
$ba_bec_sections = array_column( // Extrait la colonne section dans un tableau simple.
    sql_select('EQUIPE', 'DISTINCT section', "section <> ''", null, 'section ASC'), // Récupère les sections distinctes non vides.
    'section' // Sélectionne la colonne "section" du résultat.
); // Termine l'affectation des sections.
$ba_bec_niveaux = array_column( // Extrait la colonne niveau dans un tableau simple.
    sql_select('EQUIPE', 'DISTINCT niveau', "niveau <> ''", null, 'niveau ASC'), // Récupère les niveaux distincts non vides.
    'niveau' // Sélectionne la colonne "niveau" du résultat.
); // Termine l'affectation des niveaux.
?> <!-- Ferme le bloc PHP avant le HTML. -->

<div class="container"> <!-- Ouvre un conteneur Bootstrap principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <div class="mb-3"> <!-- Ouvre un conteneur avec marge basse. -->
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/list.php'; ?>" class="btn btn-secondary"> <!-- Crée un lien de retour vers la liste. -->
                    Retour à la liste <!-- Texte du lien de retour. -->
                </a> <!-- Ferme le lien de retour. -->
            </div> <!-- Ferme le bloc de marge. -->
            <h1>Ajouter une équipe</h1> <!-- Titre de la page de création. -->
        </div> <!-- Ferme la colonne du titre. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pour le formulaire. -->
            <form action="<?php echo ROOT_URL . '/api/equipes/create.php'; ?>" method="post" enctype="multipart/form-data"> <!-- Ouvre le formulaire de création avec envoi de fichiers. -->
                <div class="form-group"> <!-- Ouvre le groupe de champ code équipe. -->
                    <label for="codeEquipe">Code équipe</label> <!-- Étiquette du champ code équipe. -->
                    <input id="codeEquipe" name="codeEquipe" class="form-control" type="text"
                        placeholder="Code équipe (ex: U18F)" required /> <!-- Champ texte obligatoire pour le code. -->
                </div> <!-- Ferme le groupe code équipe. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe nom équipe avec marge haute. -->
                    <label for="nomEquipe">Nom de l'équipe</label> <!-- Étiquette du champ nom. -->
                    <input id="nomEquipe" name="nomEquipe" class="form-control" type="text"
                        placeholder="Nom de l'équipe..." required /> <!-- Champ texte obligatoire pour le nom. -->
                </div> <!-- Ferme le groupe nom équipe. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe club. -->
                    <label for="club">Club</label> <!-- Étiquette du champ club. -->
                    <input id="club" name="club" class="form-control" type="text" list="clubList"
                        placeholder="Club (ex: Bordeaux étudiant club)" required /> <!-- Champ texte avec liste de suggestions. -->
                    <datalist id="clubList"> <!-- Ouvre la liste de suggestions pour les clubs. -->
                        <?php foreach ($ba_bec_clubs as $ba_bec_club): ?> <!-- Boucle sur les clubs disponibles. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_club); ?>"></option> <!-- Ajoute une option de club sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle des clubs. -->
                    </datalist> <!-- Ferme la liste de clubs. -->
                </div> <!-- Ferme le groupe club. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe catégorie. -->
                    <label for="categorie">Catégorie</label> <!-- Étiquette du champ catégorie. -->
                    <input id="categorie" name="categorie" class="form-control" type="text" list="categorieList"
                        placeholder="Catégorie (ex: Seniors)" /> <!-- Champ texte optionnel avec liste. -->
                    <datalist id="categorieList"> <!-- Ouvre la liste de suggestions catégories. -->
                        <?php foreach ($ba_bec_categories as $ba_bec_categorie): ?> <!-- Boucle sur les catégories disponibles. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_categorie); ?>"></option> <!-- Ajoute une option catégorie sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle des catégories. -->
                    </datalist> <!-- Ferme la liste de catégories. -->
                </div> <!-- Ferme le groupe catégorie. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe section. -->
                    <label for="section">Section</label> <!-- Étiquette du champ section. -->
                    <input id="section" name="section" class="form-control" type="text" list="sectionList"
                        placeholder="Section (ex: Féminine)" /> <!-- Champ texte optionnel avec liste. -->
                    <datalist id="sectionList"> <!-- Ouvre la liste de suggestions sections. -->
                        <?php foreach ($ba_bec_sections as $ba_bec_section): ?> <!-- Boucle sur les sections disponibles. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_section); ?>"></option> <!-- Ajoute une option section sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle des sections. -->
                    </datalist> <!-- Ferme la liste de sections. -->
                </div> <!-- Ferme le groupe section. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe niveau. -->
                    <label for="niveau">Niveau</label> <!-- Étiquette du champ niveau. -->
                    <input id="niveau" name="niveau" class="form-control" type="text" list="niveauList"
                        placeholder="Niveau (ex: Régional)" /> <!-- Champ texte optionnel avec liste. -->
                    <datalist id="niveauList"> <!-- Ouvre la liste de suggestions niveaux. -->
                        <?php foreach ($ba_bec_niveaux as $ba_bec_niveau): ?> <!-- Boucle sur les niveaux disponibles. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_niveau); ?>"></option> <!-- Ajoute une option niveau sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle des niveaux. -->
                    </datalist> <!-- Ferme la liste de niveaux. -->
                </div> <!-- Ferme le groupe niveau. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe description. -->
                    <label for="descriptionEquipe">Description</label> <!-- Étiquette du champ description. -->
                    <textarea id="descriptionEquipe" name="descriptionEquipe" class="form-control" rows="4"
                        placeholder="Description de l'équipe..."></textarea> <!-- Zone de texte pour la description. -->
                </div> <!-- Ferme le groupe description. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe photo équipe. -->
                    <label for="photoDLequipe">Photo de l'équipe (upload)</label> <!-- Étiquette du champ photo équipe. -->
                    <input id="photoDLequipe" name="photoDLequipe" class="form-control" type="file"
                        accept=".png, .jpeg, .jpg, .avif, .svg, .webp, .gif" /> <!-- Champ fichier pour la photo d'équipe. -->
                </div> <!-- Ferme le groupe photo équipe. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe photo staff. -->
                    <label for="photoStaff">Photo staff (upload)</label> <!-- Étiquette du champ photo staff. -->
                    <input id="photoStaff" name="photoStaff" class="form-control" type="file"
                        accept=".png, .jpeg, .jpg, .avif, .svg, .webp, .gif" /> <!-- Champ fichier pour la photo staff. -->
                </div> <!-- Ferme le groupe photo staff. -->
                <div class="form-group mt-3"> <!-- Ouvre le groupe bouton d'envoi. -->
                    <button type="submit" class="btn btn-primary">Créer</button> <!-- Bouton pour soumettre le formulaire. -->
                </div> <!-- Ferme le groupe bouton. -->
            </form> <!-- Ferme le formulaire de création. -->
        </div> <!-- Ferme la colonne du formulaire. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->
