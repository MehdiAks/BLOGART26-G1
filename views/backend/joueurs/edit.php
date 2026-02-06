<?php // Ouvre le bloc PHP pour exécuter du code serveur.
/* // Démarre un commentaire de documentation multi-lignes.
 * Vue d'administration (édition) pour le module joueurs. // Décrit l'objectif général de la vue.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur. // Explique la réutilisation avec données préremplies.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés. // Indique la provenance des identifiants.
 * - L'action du formulaire cible la route de mise à jour correspondante. // Indique l'URL de mise à jour.
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée. // Décrit l'organisation des sections.
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer. // Explique les liens de retour.
 */ // Ferme le commentaire de documentation multi-lignes.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utiles au backend.
include '../../../header.php'; // Inclut l'en-tête commun de l'interface d'administration.

if (!isset($_GET['numJoueur'])) { // Vérifie que l'identifiant du joueur est présent en query string.
    header('Location: ' . ROOT_URL . '/views/backend/joueurs/list.php'); // Redirige vers la liste si l'ID manque.
    exit; // Arrête l'exécution du script après la redirection.
} // Ferme le bloc conditionnel d'ID manquant.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_numJoueur = (int) $_GET['numJoueur']; // Convertit l'identifiant reçu en entier.
$ba_bec_joueur = sql_select('JOUEUR', '*', "numJoueur = '$ba_bec_numJoueur'"); // Récupère les données du joueur ciblé.
$ba_bec_joueur = $ba_bec_joueur[0] ?? null; // Sélectionne le premier résultat ou null.
$ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Récupère la liste des équipes.

$ba_bec_posteChoices = [ // Démarre la déclaration du tableau des choix de poste.
    'Poste 1 : meneur (point guard)', // Définit le libellé pour le poste 1.
    'Poste 2 : arrière (shooting guard)', // Définit le libellé pour le poste 2.
    'Poste 3 : ailier (small forward)', // Définit le libellé pour le poste 3.
    'Poste 4 : ailier fort (power forward)', // Définit le libellé pour le poste 4.
    'Poste 5 : pivot (center)', // Définit le libellé pour le poste 5.
]; // Ferme le tableau des choix de poste.

$ba_bec_selectedPoste = null; // Initialise la variable du poste sélectionné.
if (!empty($ba_bec_joueur['posteJoueur'])) { // Vérifie si un poste est renseigné pour le joueur.
    $ba_bec_selectedPoste = (int) $ba_bec_joueur['posteJoueur']; // Convertit le poste en entier pour comparaison.
} // Ferme la condition de poste renseigné.

$ba_bec_clubs = []; // Initialise la liste des clubs précédents.
if (!empty($ba_bec_joueur['clubsPrecedents'])) { // Vérifie si des clubs précédents sont renseignés.
    $ba_bec_clubs = array_filter(array_map('trim', explode(',', (string) $ba_bec_joueur['clubsPrecedents']))); // Transforme la chaîne en tableau nettoyé.
} // Ferme la condition des clubs précédents.

if (!$ba_bec_joueur) { // Vérifie si aucun joueur n'a été trouvé.
    header('Location: ' . ROOT_URL . '/views/backend/joueurs/list.php'); // Redirige vers la liste si le joueur est introuvable.
    exit; // Arrête l'exécution du script après la redirection.
} // Ferme la condition de joueur introuvable.

function ba_bec_formatEquipeLabel(array $ba_bec_equipe): string // Déclare une fonction qui formate le label d'équipe.
{ // Ouvre le bloc de la fonction.
    $label = $ba_bec_equipe['nomEquipe'] ?? ''; // Récupère le nom d'équipe ou une chaîne vide.
    $code = $ba_bec_equipe['codeEquipe'] ?? ''; // Récupère le code d'équipe ou une chaîne vide.
    return $code !== '' ? $label . ' (' . $code . ')' : $label; // Retourne un libellé avec code si disponible.
} // Ferme le bloc de la fonction.
?> <!-- Ferme le bloc PHP pour repasser en HTML. -->

<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Ouvre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Ouvre une colonne pleine largeur. -->
            <div class="mb-3"> <!-- Ouvre un bloc avec marge basse. -->
                <a href="<?php echo ROOT_URL . '/views/backend/joueurs/list.php'; ?>" class="btn btn-secondary"> <!-- Crée un lien vers la liste des joueurs. -->
                    Retour à la liste <!-- Affiche le texte du lien de retour. -->
                </a> <!-- Ferme le lien de retour. -->
            </div> <!-- Ferme le bloc de marge. -->
            <h1>Modifier un joueur</h1> <!-- Affiche le titre de la page. -->
        </div> <!-- Ferme la colonne de titre. -->
        <div class="col-md-12"> <!-- Ouvre la colonne du formulaire. -->
            <form action="<?php echo ROOT_URL . '/api/joueurs/update.php'; ?>" method="post" enctype="multipart/form-data"> <!-- Ouvre le formulaire de mise à jour. -->
                <input type="hidden" name="numJoueur" value="<?php echo htmlspecialchars($ba_bec_joueur['numJoueur']); ?>" /> <!-- Ajoute un champ caché pour l'ID. -->
                <input type="hidden" name="photoActuelle" value="<?php echo htmlspecialchars($ba_bec_joueur['urlPhotoJoueur'] ?? ''); ?>" /> <!-- Ajoute un champ caché pour la photo actuelle. -->
                <div class="form-group"> <!-- Ouvre un groupe de champ. -->
                    <label for="surnomJoueur">Surnom</label> <!-- Associe un libellé au champ de surnom. -->
                    <input id="surnomJoueur" name="surnomJoueur" class="form-control" type="text" <!-- Déclare le champ texte du surnom. -->
                        value="<?php echo htmlspecialchars($ba_bec_joueur['surnomJoueur'] ?? ''); ?>" <!-- Pré-remplit le champ avec la valeur existante. -->
                        placeholder="Surnom (ex: Ace)" required /> <!-- Ajoute un placeholder et rend le champ obligatoire. -->
                </div> <!-- Ferme le groupe de champ du surnom. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="prenomJoueur">Prénom</label> <!-- Associe un libellé au champ du prénom. -->
                    <input id="prenomJoueur" name="prenomJoueur" class="form-control" type="text" <!-- Déclare le champ texte du prénom. -->
                        value="<?php echo htmlspecialchars($ba_bec_joueur['prenomJoueur']); ?>" <!-- Pré-remplit le champ avec la valeur existante. -->
                        placeholder="Prénom (ex: Léa)" required /> <!-- Ajoute un placeholder et rend le champ obligatoire. -->
                </div> <!-- Ferme le groupe du prénom. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="nomJoueur">Nom</label> <!-- Associe un libellé au champ du nom. -->
                    <input id="nomJoueur" name="nomJoueur" class="form-control" type="text" <!-- Déclare le champ texte du nom. -->
                        value="<?php echo htmlspecialchars($ba_bec_joueur['nomJoueur']); ?>" <!-- Pré-remplit le champ avec la valeur existante. -->
                        placeholder="Nom (ex: Martin)" required /> <!-- Ajoute un placeholder et rend le champ obligatoire. -->
                </div> <!-- Ferme le groupe du nom. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="posteJoueur">Postes</label> <!-- Associe un libellé au sélecteur de poste. -->
                    <select id="posteJoueur" name="posteJoueur" class="form-control" required> <!-- Déclare la liste déroulante des postes. -->
                        <option value="">Sélectionnez un poste</option> <!-- Ajoute l'option vide par défaut. -->
                        <?php foreach ($ba_bec_posteChoices as $index => $ba_bec_posteChoice): ?> <!-- Démarre la boucle sur les choix de poste. -->
                            <?php $ba_bec_value = $index + 1; ?> <!-- Calcule la valeur numérique du poste. -->
                            <option value="<?php echo htmlspecialchars((string) $ba_bec_value); ?>" <!-- Définit la valeur de l'option. -->
                                <?php echo ($ba_bec_selectedPoste === $ba_bec_value) ? 'selected' : ''; ?>> <!-- Marque l'option sélectionnée si nécessaire. -->
                                <?php echo htmlspecialchars($ba_bec_posteChoice); ?> <!-- Affiche le libellé du poste. -->
                            </option> <!-- Ferme l'option de poste. -->
                        <?php endforeach; ?> <!-- Termine la boucle sur les postes. -->
                    </select> <!-- Ferme la liste déroulante des postes. -->
                </div> <!-- Ferme le groupe de poste. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="photoJoueur">Photo (upload)</label> <!-- Associe un libellé au champ photo. -->
                    <input id="photoJoueur" name="photoJoueur" class="form-control" type="file" <!-- Déclare le champ d'upload de fichier. -->
                        accept=".png, .jpeg, .jpg, .avif, .svg" /> <!-- Limite les formats acceptés. -->
                    <?php if (!empty($ba_bec_joueur['urlPhotoJoueur'])): ?> <!-- Vérifie s'il existe déjà une photo. -->
                        <?php // Ouvre un bloc PHP pour préparer l'URL de la photo.
                        $ba_bec_photo = $ba_bec_joueur['urlPhotoJoueur']; // Récupère la valeur de la photo.
                        $ba_bec_photoUrl = preg_match('/^(https?:\/\/|\/)/', $ba_bec_photo) // Teste si la photo est déjà une URL ou un chemin absolu.
                            ? $ba_bec_photo // Utilise la valeur telle quelle si c'est une URL.
                            : ROOT_URL . '/src/uploads/' . $ba_bec_photo; // Construit l'URL locale sinon.
                        ?> <!-- Ferme le bloc PHP de préparation. -->
                        <div class="mt-2"> <!-- Ouvre un bloc avec marge pour l'aperçu. -->
                            <img src="<?php echo htmlspecialchars($ba_bec_photoUrl); ?>" alt="Photo actuelle" style="max-width: 120px;" /> <!-- Affiche la photo actuelle. -->
                        </div> <!-- Ferme le bloc de l'aperçu. -->
                    <?php endif; ?> <!-- Ferme la condition d'affichage de la photo. -->
                </div> <!-- Ferme le groupe photo. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="numeroMaillot">Numéro de maillot (saison)</label> <!-- Associe un libellé au champ numéro de maillot. -->
                    <input id="numeroMaillot" name="numeroMaillot" class="form-control" type="number" min="0" max="99" <!-- Déclare le champ numérique avec bornes. -->
                        value="<?php echo htmlspecialchars($ba_bec_joueur['numeroMaillot'] ?? ''); ?>" <!-- Pré-remplit le champ avec la valeur existante. -->
                        placeholder="Numéro (0-99)" /> <!-- Ajoute un placeholder. -->
                </div> <!-- Ferme le groupe du numéro de maillot. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="numEquipe">Équipe</label> <!-- Associe un libellé au sélecteur d'équipe. -->
                    <select id="numEquipe" name="codeEquipe" class="form-control" required> <!-- Déclare la liste déroulante des équipes. -->
                        <option value="">Sélectionnez une équipe</option> <!-- Ajoute l'option vide par défaut. -->
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?> <!-- Démarre la boucle sur les équipes. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>" <!-- Définit la valeur d'option avec le code équipe. -->
                                <?php echo (($ba_bec_joueur['codeEquipe'] ?? '') === $ba_bec_equipe['codeEquipe']) ? 'selected' : ''; ?>> <!-- Sélectionne l'équipe actuelle si nécessaire. -->
                                <?php echo htmlspecialchars(ba_bec_formatEquipeLabel($ba_bec_equipe)); ?> <!-- Affiche le libellé de l'équipe. -->
                            </option> <!-- Ferme l'option d'équipe. -->
                        <?php endforeach; ?> <!-- Termine la boucle sur les équipes. -->
                    </select> <!-- Ferme la liste déroulante des équipes. -->
                </div> <!-- Ferme le groupe d'équipe. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="dateRecrutement">Date de recrutement</label> <!-- Associe un libellé au champ date de recrutement. -->
                    <input id="dateRecrutement" name="dateRecrutement" class="form-control" type="date" <!-- Déclare le champ date de recrutement. -->
                        value="<?php echo htmlspecialchars($ba_bec_joueur['dateRecrutement'] ?? ''); ?>" <!-- Pré-remplit le champ avec la valeur existante. -->
                        placeholder="JJ/MM/AAAA" /> <!-- Ajoute un placeholder de format. -->
                </div> <!-- Ferme le groupe date de recrutement. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="dateNaissance">Date de naissance</label> <!-- Associe un libellé au champ date de naissance. -->
                    <input id="dateNaissance" name="dateNaissance" class="form-control" type="date" <!-- Déclare le champ date de naissance. -->
                        value="<?php echo htmlspecialchars($ba_bec_joueur['dateNaissance'] ?? ''); ?>" <!-- Pré-remplit le champ avec la valeur existante. -->
                        placeholder="JJ/MM/AAAA" /> <!-- Ajoute un placeholder de format. -->
                </div> <!-- Ferme le groupe date de naissance. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="clubsPrecedents">Clubs précédents</label> <!-- Associe un libellé aux clubs précédents. -->
                    <?php // Ouvre un bloc PHP pour préparer la liste des clubs.
                    $ba_bec_clubsList = $ba_bec_clubs; // Duplique la liste des clubs pour affichage.
                    if (empty($ba_bec_clubsList)) { // Vérifie si la liste est vide.
                        $ba_bec_clubsList = ['']; // Initialise avec une entrée vide pour le champ.
                    } // Ferme la condition de liste vide.
                    ?> <!-- Ferme le bloc PHP de préparation. -->
                    <div id="clubsPrecedentsList" class="d-grid gap-2"> <!-- Ouvre la liste des champs clubs avec espacement. -->
                        <?php foreach ($ba_bec_clubsList as $ba_bec_club): ?> <!-- Démarre la boucle sur les clubs. -->
                            <input name="clubsPrecedents[]" class="form-control" type="text" <!-- Déclare un champ texte de club précédent. -->
                                value="<?php echo htmlspecialchars($ba_bec_club); ?>" <!-- Pré-remplit avec la valeur du club. -->
                                placeholder="Nom du club (ex: BEC Basket)" /> <!-- Ajoute un placeholder pour le club. -->
                        <?php endforeach; ?> <!-- Termine la boucle sur les clubs. -->
                    </div> <!-- Ferme la liste des clubs. -->
                    <button type="button" id="addClubButton" class="btn btn-outline-secondary btn-sm mt-2"> <!-- Déclare le bouton d'ajout de club. -->
                        Ajouter un club <!-- Affiche le texte du bouton d'ajout. -->
                    </button> <!-- Ferme le bouton d'ajout. -->
                </div> <!-- Ferme le groupe des clubs précédents. -->
                <div class="form-group mt-3"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button> <!-- Déclare le bouton de soumission. -->
                </div> <!-- Ferme le groupe du bouton enregistrer. -->
            </form> <!-- Ferme le formulaire. -->
        </div> <!-- Ferme la colonne du formulaire. -->
    </div> <!-- Ferme la ligne Bootstrap. -->
</div> <!-- Ferme le conteneur principal. -->

<script> // Ouvre un bloc de script JavaScript.
    (function () { // Démarre une fonction immédiatement invoquée.
        const clubList = document.getElementById('clubsPrecedentsList'); // Récupère le conteneur des clubs.
        const addClubButton = document.getElementById('addClubButton'); // Récupère le bouton d'ajout de club.

        const addClubField = () => { // Déclare une fonction pour ajouter un champ de club.
            const wrapper = document.createElement('div'); // Crée un conteneur pour un champ et son bouton.
            wrapper.className = 'd-flex gap-2'; // Ajoute des classes de mise en page flex.

            const input = document.createElement('input'); // Crée un élément input pour le club.
            input.name = 'clubsPrecedents[]'; // Définit le nom du champ pour l'envoi en tableau.
            input.className = 'form-control'; // Ajoute la classe Bootstrap du champ.
            input.type = 'text'; // Définit le type du champ en texte.
            input.placeholder = 'Nom du club (ex: BEC Basket)'; // Définit le placeholder du champ.

            const removeButton = document.createElement('button'); // Crée le bouton de suppression du club.
            removeButton.type = 'button'; // Définit le type de bouton pour éviter la soumission.
            removeButton.className = 'btn btn-outline-danger'; // Ajoute la classe Bootstrap du bouton.
            removeButton.textContent = 'Retirer'; // Définit le texte du bouton.
            removeButton.addEventListener('click', () => wrapper.remove()); // Supprime le bloc au clic.

            wrapper.appendChild(input); // Ajoute le champ texte au conteneur.
            wrapper.appendChild(removeButton); // Ajoute le bouton au conteneur.
            clubList.appendChild(wrapper); // Ajoute le conteneur à la liste des clubs.
        }; // Ferme la fonction d'ajout de champ.

        addClubButton.addEventListener('click', addClubField); // Lie le clic du bouton à l'ajout d'un champ.
    })(); // Exécute immédiatement la fonction auto-invoquée.
</script> // Ferme le bloc de script JavaScript.
