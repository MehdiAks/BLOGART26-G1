<?php // Ouvre le bloc PHP pour exécuter du code serveur.
/* // Démarre un commentaire de documentation multi-lignes.
 * Vue d'administration (création) pour le module joueurs. // Décrit l'objectif général de la vue.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier. // Explique la fonction du formulaire.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action). // Indique la cible de soumission.
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation. // Précise l'organisation des champs.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste. // Décrit les actions disponibles.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue. // Explique l'usage des classes CSS.
 */ // Ferme le commentaire de documentation multi-lignes.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale depuis la racine du serveur.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les fonctions de redirection utiles au backend.
include '../../../header.php'; // Inclut l'en-tête commun de l'interface d'administration.

sql_connect(); // Ouvre la connexion à la base de données.

$ba_bec_equipes = sql_select('EQUIPE', 'codeEquipe, nomEquipe', null, null, 'nomEquipe ASC'); // Récupère la liste des équipes triées par nom.

$ba_bec_posteChoices = [ // Démarre la déclaration du tableau des choix de poste.
    'Poste 1 : meneur (point guard)', // Définit le libellé pour le poste 1.
    'Poste 2 : arrière (shooting guard)', // Définit le libellé pour le poste 2.
    'Poste 3 : ailier (small forward)', // Définit le libellé pour le poste 3.
    'Poste 4 : ailier fort (power forward)', // Définit le libellé pour le poste 4.
    'Poste 5 : pivot (center)', // Définit le libellé pour le poste 5.
]; // Ferme le tableau des choix de poste.

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
            <h1>Ajouter un joueur</h1> <!-- Affiche le titre de la page. -->
        </div> <!-- Ferme la colonne de titre. -->
        <div class="col-md-12"> <!-- Ouvre la colonne du formulaire. -->
            <form action="<?php echo ROOT_URL . '/api/joueurs/create.php'; ?>" method="post" enctype="multipart/form-data"> <!-- Ouvre le formulaire de création. -->
                <div class="form-group"> <!-- Ouvre un groupe de champ. -->
                    <label for="surnomJoueur">Surnom</label> <!-- Associe un libellé au champ de surnom. -->
                    <input id="surnomJoueur" name="surnomJoueur" class="form-control" type="text" <!-- Déclare le champ texte du surnom. -->
                        placeholder="Surnom (ex: Ace)" required /> <!-- Ajoute un placeholder et rend le champ obligatoire. -->
                </div> <!-- Ferme le groupe de champ du surnom. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="prenomJoueur">Prénom</label> <!-- Associe un libellé au champ du prénom. -->
                    <input id="prenomJoueur" name="prenomJoueur" class="form-control" type="text" <!-- Déclare le champ texte du prénom. -->
                        placeholder="Prénom (ex: Léa)" required /> <!-- Ajoute un placeholder et rend le champ obligatoire. -->
                </div> <!-- Ferme le groupe du prénom. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="nomJoueur">Nom</label> <!-- Associe un libellé au champ du nom. -->
                    <input id="nomJoueur" name="nomJoueur" class="form-control" type="text" <!-- Déclare le champ texte du nom. -->
                        placeholder="Nom (ex: Martin)" required /> <!-- Ajoute un placeholder et rend le champ obligatoire. -->
                </div> <!-- Ferme le groupe du nom. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="photoJoueur">Photo (upload)</label> <!-- Associe un libellé au champ photo. -->
                    <input id="photoJoueur" name="photoJoueur" class="form-control" type="file" <!-- Déclare le champ d'upload de fichier. -->
                        accept=".png, .jpeg, .jpg, .avif, .svg" /> <!-- Limite les formats acceptés. -->
                </div> <!-- Ferme le groupe photo. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="dateNaissance">Date de naissance</label> <!-- Associe un libellé au champ de date de naissance. -->
                    <input id="dateNaissance" name="dateNaissance" class="form-control" type="date" <!-- Déclare le champ date de naissance. -->
                        placeholder="JJ/MM/AAAA" /> <!-- Ajoute un placeholder de format. -->
                </div> <!-- Ferme le groupe date de naissance. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="numEquipe">Équipe</label> <!-- Associe un libellé au sélecteur d'équipe. -->
                    <select id="numEquipe" name="codeEquipe" class="form-control" required> <!-- Déclare la liste déroulante des équipes. -->
                        <option value="">Sélectionnez une équipe</option> <!-- Ajoute l'option vide par défaut. -->
                        <?php foreach ($ba_bec_equipes as $ba_bec_equipe): ?> <!-- Démarre la boucle sur les équipes. -->
                            <option value="<?php echo htmlspecialchars($ba_bec_equipe['codeEquipe']); ?>"> <!-- Définit la valeur d'option avec le code équipe. -->
                                <?php echo htmlspecialchars(ba_bec_formatEquipeLabel($ba_bec_equipe)); ?> <!-- Affiche le libellé de l'équipe. -->
                            </option> <!-- Ferme l'option d'équipe. -->
                        <?php endforeach; ?> <!-- Termine la boucle sur les équipes. -->
                    </select> <!-- Ferme la liste déroulante des équipes. -->
                </div> <!-- Ferme le groupe d'équipe. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="posteJoueur">Poste</label> <!-- Associe un libellé au sélecteur de poste. -->
                    <select id="posteJoueur" name="posteJoueur" class="form-control" required> <!-- Déclare la liste déroulante des postes. -->
                        <option value="">Sélectionnez un poste</option> <!-- Ajoute l'option vide par défaut. -->
                        <?php foreach ($ba_bec_posteChoices as $index => $ba_bec_posteChoice): ?> <!-- Démarre la boucle sur les choix de poste. -->
                            <option value="<?php echo htmlspecialchars((string) ($index + 1)); ?>"> <!-- Définit la valeur numérique du poste. -->
                                <?php echo htmlspecialchars($ba_bec_posteChoice); ?> <!-- Affiche le libellé du poste. -->
                            </option> <!-- Ferme l'option de poste. -->
                        <?php endforeach; ?> <!-- Termine la boucle sur les postes. -->
                    </select> <!-- Ferme la liste déroulante des postes. -->
                </div> <!-- Ferme le groupe de poste. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="numeroMaillot">Numéro de maillot (saison)</label> <!-- Associe un libellé au champ numéro de maillot. -->
                    <input id="numeroMaillot" name="numeroMaillot" class="form-control" type="number" min="0" max="99" <!-- Déclare le champ numérique avec bornes. -->
                        placeholder="Numéro (0-99)" /> <!-- Ajoute un placeholder. -->
                </div> <!-- Ferme le groupe du numéro de maillot. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="dateRecrutement">Date de recrutement</label> <!-- Associe un libellé au champ date de recrutement. -->
                    <input id="dateRecrutement" name="dateRecrutement" class="form-control" type="date" <!-- Déclare le champ date de recrutement. -->
                        placeholder="JJ/MM/AAAA" /> <!-- Ajoute un placeholder de format. -->
                </div> <!-- Ferme le groupe date de recrutement. -->
                <div class="form-group mt-2"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <label for="clubsPrecedents">Clubs précédents</label> <!-- Associe un libellé aux clubs précédents. -->
                    <div id="clubsPrecedentsList" class="d-grid gap-2"> <!-- Ouvre la liste des champs clubs avec espacement. -->
                        <input name="clubsPrecedents[]" class="form-control" type="text" <!-- Déclare un champ texte de club précédent. -->
                            placeholder="Nom du club (ex: BEC Basket)" /> <!-- Ajoute un placeholder pour le club. -->
                    </div> <!-- Ferme la liste des clubs. -->
                    <button type="button" id="addClubButton" class="btn btn-outline-secondary btn-sm mt-2"> <!-- Déclare le bouton d'ajout de club. -->
                        Ajouter un club <!-- Affiche le texte du bouton d'ajout. -->
                    </button> <!-- Ferme le bouton d'ajout. -->
                </div> <!-- Ferme le groupe des clubs précédents. -->
                <div class="form-group mt-3"> <!-- Ouvre un groupe de champ avec marge haute. -->
                    <button type="submit" class="btn btn-primary">Créer</button> <!-- Déclare le bouton de soumission. -->
                </div> <!-- Ferme le groupe du bouton créer. -->
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
