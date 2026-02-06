<?php // Démarre le bloc PHP pour la logique serveur.
/*
 * Vue d'administration (édition) pour le module equipes. // Présente l'objectif de la page.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur. // Explique la pré-remplissage.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés. // Indique la source des identifiants.
 * - L'action du formulaire cible la route de mise à jour correspondante. // Décrit la cible de soumission.
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée. // Explique l'organisation visuelle.
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer. // Explique les actions secondaires.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection.
include '../../../header.php'; // Inclut l'en-tête commun.

if (!isset($_GET['numEquipe'])) { // Vérifie la présence de l'identifiant dans l'URL.
    header('Location: ' . ROOT_URL . '/views/backend/equipes/list.php'); // Redirige vers la liste si absent.
    exit; // Stoppe l'exécution pour éviter une page incohérente.
}

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_numEquipe = (int) $_GET['numEquipe']; // Convertit l'identifiant en entier.
$ba_bec_equipe = null; // Initialise la variable d'équipe.
if ($ba_bec_numEquipe) { // Continue uniquement si l'identifiant est valide.
    $stmt = $DB->prepare( // Prépare la requête SQL de sélection.
        'SELECT * FROM EQUIPE WHERE numEquipe = :numEquipe' // Requête paramétrée par numEquipe.
    ); // Termine la préparation.
    $stmt->execute([':numEquipe' => $ba_bec_numEquipe]); // Exécute la requête avec le paramètre.
    $ba_bec_equipe = $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Récupère l'équipe ou null.
} // Termine la condition de chargement.

if (!$ba_bec_equipe) { // Vérifie que l'équipe a été trouvée.
    header('Location: ' . ROOT_URL . '/views/backend/equipes/list.php'); // Redirige si aucune équipe.
    exit; // Arrête l'exécution.
}

$ba_bec_photoEquipe = $ba_bec_equipe['photoDLequipe'] ?? ''; // Récupère le chemin photo équipe.
$ba_bec_photoStaff = $ba_bec_equipe['photoStaff'] ?? ''; // Récupère le chemin photo staff.

function ba_bec_equipe_photo_url(?string $path): string // Déclare un helper de normalisation d'URL photo.
{ // Ouvre le corps de la fonction.
    if (!$path) { // Vérifie si le chemin est vide.
        return ''; // Retourne une chaîne vide si pas de chemin.
    } // Ferme la condition chemin vide.

    if (preg_match('/^(https?:\/\/|\/)/', $path)) { // Détecte un chemin déjà absolu.
        return $path; // Retourne directement le chemin absolu.
    } // Ferme la condition d'URL absolue.

    return ROOT_URL . '/src/uploads/photos-equipes/' . ltrim($path, '/'); // Construit une URL relative par défaut.
} // Ferme la fonction helper.

$ba_bec_photoEquipeUrl = ba_bec_equipe_photo_url($ba_bec_photoEquipe); // Normalise l'URL photo équipe.
$ba_bec_photoStaffUrl = ba_bec_equipe_photo_url($ba_bec_photoStaff); // Normalise l'URL photo staff.

$ba_bec_clubs = []; // Initialise le tableau des clubs.
$ba_bec_categories = []; // Initialise le tableau des catégories.
$ba_bec_sections = []; // Initialise le tableau des sections.
$ba_bec_niveaux = []; // Initialise le tableau des niveaux.
$ba_bec_clubs = array_column( // Extrait les clubs distincts.
    sql_select('EQUIPE', 'DISTINCT club', "club <> ''", null, 'club ASC'), // Sélectionne les clubs non vides.
    'club' // Garde la colonne club.
); // Termine l'affectation des clubs.
$ba_bec_categories = array_column( // Extrait les catégories distinctes.
    sql_select('EQUIPE', 'DISTINCT categorie', "categorie <> ''", null, 'categorie ASC'), // Sélectionne les catégories non vides.
    'categorie' // Garde la colonne categorie.
); // Termine l'affectation des catégories.
$ba_bec_sections = array_column( // Extrait les sections distinctes.
    sql_select('EQUIPE', 'DISTINCT section', "section <> ''", null, 'section ASC'), // Sélectionne les sections non vides.
    'section' // Garde la colonne section.
); // Termine l'affectation des sections.
$ba_bec_niveaux = array_column( // Extrait les niveaux distincts.
    sql_select('EQUIPE', 'DISTINCT niveau', "niveau <> ''", null, 'niveau ASC'), // Sélectionne les niveaux non vides.
    'niveau' // Garde la colonne niveau.
); // Termine l'affectation des niveaux.

function ba_bec_photo_url(string $codeEquipe, string $suffix): ?string // Déclare un helper pour retrouver une photo.
{ // Ouvre le corps de la fonction.
    $codeEquipe = preg_replace('/[^A-Za-z0-9_-]+/', '', $codeEquipe); // Nettoie le code équipe.
    if ($codeEquipe === '') { // Vérifie si le code est vide.
        return null; // Retourne null si le code est invalide.
    } // Ferme la condition de code vide.
    $extensions = ['jpg', 'jpeg', 'png', 'avif', 'svg', 'webp', 'gif']; // Liste des extensions possibles.
    foreach ($extensions as $extension) { // Parcourt chaque extension.
        $fileName = $codeEquipe . '-' . $suffix . '.' . $extension; // Construit le nom de fichier attendu.
        $path = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/photos-equipes/' . $fileName; // Construit le chemin disque.
        if (file_exists($path)) { // Vérifie si le fichier existe.
            return ROOT_URL . '/src/uploads/photos-equipes/' . $fileName; // Retourne l'URL du fichier trouvé.
        } // Ferme la condition d'existence.
    } // Ferme la boucle sur les extensions.
    return null; // Retourne null si aucune photo trouvée.
} // Ferme la fonction helper.

$ba_bec_photoEquipeUrl = $ba_bec_photoEquipeUrl ?: ba_bec_photo_url($ba_bec_equipe['codeEquipe'] ?? '', 'photo-equipe'); // Utilise une URL de secours pour la photo équipe.
$ba_bec_photoStaffUrl = $ba_bec_photoStaffUrl ?: ba_bec_photo_url($ba_bec_equipe['codeEquipe'] ?? '', 'photo-staff'); // Utilise une URL de secours pour la photo staff.
?> <!-- Ferme le bloc PHP avant le HTML. -->

<div class="container"> <!-- Ouvre le conteneur principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <div class="mb-3"> <!-- Ouvre un bloc avec marge basse. -->
                <a href="<?php echo ROOT_URL . '/views/backend/equipes/list.php'; ?>" class="btn btn-secondary"> <!-- Lien de retour vers la liste. -->
                    Retour à la liste <!-- Texte du lien. -->
                </a> <!-- Ferme le lien retour. -->
            </div> <!-- Ferme le bloc marge. -->
            <h1>Modifier une équipe</h1> <!-- Titre de la page d'édition. -->
        </div> <!-- Ferme la colonne du titre. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pour le formulaire. -->
            <form action="<?php echo ROOT_URL . '/api/equipes/update.php'; ?>" method="post" enctype="multipart/form-data"> <!-- Ouvre le formulaire d'édition. -->
                <input type="hidden" name="numEquipe" value="<?php echo htmlspecialchars($ba_bec_equipe['numEquipe']); ?>" /> <!-- Champ caché pour l'ID équipe. -->
                <div class="form-group"> <!-- Ouvre le groupe code équipe. -->
                    <label for="codeEquipe">Code équipe</label> <!-- Étiquette du champ code. -->
                    <input id="codeEquipe" name="codeEquipe" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>"
                        placeholder="Code équipe (ex: U18F)" required /> <!-- Champ texte code équipe pré-rempli. -->
                </div> <!-- Ferme le groupe code. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe nom. -->
                    <label for="nomEquipe">Nom de l'équipe</label> <!-- Étiquette du champ nom. -->
                    <input id="nomEquipe" name="nomEquipe" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['nomEquipe']); ?>" placeholder="Nom de l'équipe..."
                        required /> <!-- Champ texte nom équipe pré-rempli. -->
                </div> <!-- Ferme le groupe nom. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe club. -->
                    <label for="club">Club</label> <!-- Étiquette du champ club. -->
                    <input id="club" name="club" class="form-control" type="text" list="clubList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['club'] ?? ''); ?>"
                        placeholder="Club (ex: Bordeaux étudiant club)" required /> <!-- Champ club pré-rempli. -->
                    <datalist id="clubList"> <!-- Ouvre la liste des clubs. -->
                        <?php foreach ($ba_bec_clubs as $ba_bec_club): ?> <!-- Boucle sur les clubs. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_club); ?>"></option> <!-- Option club sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle clubs. -->
                    </datalist> <!-- Ferme la liste des clubs. -->
                </div> <!-- Ferme le groupe club. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe catégorie. -->
                    <label for="categorie">Catégorie</label> <!-- Étiquette du champ catégorie. -->
                    <input id="categorie" name="categorie" class="form-control" type="text" list="categorieList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['categorie'] ?? ''); ?>"
                        placeholder="Catégorie (ex: Seniors)" /> <!-- Champ catégorie pré-rempli. -->
                    <datalist id="categorieList"> <!-- Ouvre la liste des catégories. -->
                        <?php foreach ($ba_bec_categories as $ba_bec_categorie): ?> <!-- Boucle sur les catégories. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_categorie); ?>"></option> <!-- Option catégorie sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle catégories. -->
                    </datalist> <!-- Ferme la liste catégories. -->
                </div> <!-- Ferme le groupe catégorie. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe section. -->
                    <label for="section">Section</label> <!-- Étiquette du champ section. -->
                    <input id="section" name="section" class="form-control" type="text" list="sectionList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['section'] ?? ''); ?>"
                        placeholder="Section (ex: Féminine)" /> <!-- Champ section pré-rempli. -->
                    <datalist id="sectionList"> <!-- Ouvre la liste des sections. -->
                        <?php foreach ($ba_bec_sections as $ba_bec_section): ?> <!-- Boucle sur les sections. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_section); ?>"></option> <!-- Option section sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle sections. -->
                    </datalist> <!-- Ferme la liste sections. -->
                </div> <!-- Ferme le groupe section. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe niveau. -->
                    <label for="niveau">Niveau</label> <!-- Étiquette du champ niveau. -->
                    <input id="niveau" name="niveau" class="form-control" type="text" list="niveauList"
                        value="<?php echo htmlspecialchars($ba_bec_equipe['niveau'] ?? ''); ?>"
                        placeholder="Niveau (ex: Régional)" /> <!-- Champ niveau pré-rempli. -->
                    <datalist id="niveauList"> <!-- Ouvre la liste des niveaux. -->
                        <?php foreach ($ba_bec_niveaux as $ba_bec_niveau): ?> <!-- Boucle sur les niveaux. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_niveau); ?>"></option> <!-- Option niveau sécurisée. -->
                        <?php endforeach; ?> <!-- Termine la boucle niveaux. -->
                    </datalist> <!-- Ferme la liste niveaux. -->
                </div> <!-- Ferme le groupe niveau. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe description. -->
                    <label for="descriptionEquipe">Description</label> <!-- Étiquette du champ description. -->
                    <textarea id="descriptionEquipe" name="descriptionEquipe" class="form-control" rows="4"
                        placeholder="Description de l'équipe..."><?php echo htmlspecialchars($ba_bec_equipe['descriptionEquipe'] ?? ''); ?></textarea> <!-- Zone de texte description pré-remplie. -->
                </div> <!-- Ferme le groupe description. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe photo équipe. -->
                    <label for="photoDLequipe">Photo de l'équipe (upload)</label> <!-- Étiquette photo équipe. -->
                    <input id="photoDLequipe" name="photoDLequipe" class="form-control" type="file"
                        accept=".png, .jpeg, .jpg, .avif, .svg, .webp, .gif" /> <!-- Champ fichier photo équipe. -->
                    <?php if ($ba_bec_photoEquipeUrl): ?> <!-- Vérifie si une photo équipe existe. -->
                        <div class="mt-2"> <!-- Ouvre un conteneur pour la prévisualisation. -->
                            <img src="<?php echo htmlspecialchars($ba_bec_photoEquipeUrl); ?>" alt="Photo équipe" style="max-width: 160px;" /> <!-- Affiche la photo équipe. -->
                        </div> <!-- Ferme le conteneur de prévisualisation. -->
                    <?php endif; ?> <!-- Termine la condition photo équipe. -->
                </div> <!-- Ferme le groupe photo équipe. -->
                <div class="form-group mt-2"> <!-- Ouvre le groupe photo staff. -->
                    <label for="photoStaff">Photo staff (upload)</label> <!-- Étiquette photo staff. -->
                    <input id="photoStaff" name="photoStaff" class="form-control" type="file"
                        accept=".png, .jpeg, .jpg, .avif, .svg, .webp, .gif" /> <!-- Champ fichier photo staff. -->
                    <?php if ($ba_bec_photoStaffUrl): ?> <!-- Vérifie si une photo staff existe. -->
                        <div class="mt-2"> <!-- Ouvre un conteneur pour la prévisualisation. -->
                            <img src="<?php echo htmlspecialchars($ba_bec_photoStaffUrl); ?>" alt="Photo staff" style="max-width: 160px;" /> <!-- Affiche la photo staff. -->
                        </div> <!-- Ferme le conteneur de prévisualisation. -->
                    <?php endif; ?> <!-- Termine la condition photo staff. -->
                </div> <!-- Ferme le groupe photo staff. -->
                <div class="form-group mt-3"> <!-- Ouvre le groupe bouton. -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button> <!-- Bouton pour enregistrer. -->
                </div> <!-- Ferme le groupe bouton. -->
            </form> <!-- Ferme le formulaire d'édition. -->
        </div> <!-- Ferme la colonne du formulaire. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->
