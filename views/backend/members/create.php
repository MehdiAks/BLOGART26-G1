<?php // Ouvre le bloc PHP pour la logique serveur.
/*
 * Vue d'administration (création) pour le module members.
 * - Cette page expose un formulaire HTML complet permettant de saisir les données métier.
 * - L'action du formulaire pointe vers la route de création côté backend (controller/action).
 * - Les champs sont regroupés par sections pour guider l'utilisateur et faciliter la validation.
 * - Les boutons principaux déclenchent l'envoi et les liens secondaires ramènent au tableau de bord ou à la liste.
 * - Les classes Bootstrap structurent la mise en forme sans logique métier dans la vue.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale du site.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection/contrôle.
include '../../../header.php'; // Inclut l'en-tête HTML commun.


if (isset($_GET['numCom'])) { // Vérifie si un identifiant de commentaire est fourni.
    $ba_bec_numCom = $_GET['numCom']; // Récupère l'identifiant du commentaire depuis l'URL.
    $ba_bec_comment = sql_select('comment', '*', "numCom ='$ba_bec_numCom'")[0]; // Charge les données du commentaire.
    $ba_bec_pseudoMemb = $ba_bec_comment['pseudoMemb']; // Stocke le pseudo du membre lié au commentaire.
    $ba_bec_numArt = $ba_bec_comment['numArt']; // Stocke l'identifiant de l'article lié.
    $ba_bec_libCom = $ba_bec_comment['libCom']; // Stocke le contenu du commentaire.
} else { // Cas où l'identifiant est absent.
    header('/index.php'); // Redirige vers la page d'accueil.
} // Ferme le bloc conditionnel de l'identifiant.

$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY'); // Récupère la clé reCAPTCHA depuis l'environnement.
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8'); // Échappe la clé pour l'injection HTML.

?> <!-- Ferme le bloc PHP initial. -->

<!-- Bootstrap form to create a new member -->
<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Démarre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Colonne pleine largeur. -->
            <h1>Création nouveau Membre</h1> <!-- Titre principal de la page. -->
        </div> <!-- Ferme la colonne du titre. -->
        <div class="col-md-12"> <!-- Colonne pour le formulaire. -->
            <!-- Form to create a new member -->
            <form action="<?php echo ROOT_URL . '/api/members/create.php' ?>" method="post" id="formCreate"> <!-- Déclare le formulaire de création. -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-create"> <!-- Champ caché pour le token reCAPTCHA. -->
                <div class="form-group"> <!-- Groupe de champs du formulaire. -->
                    <!-- NOM D'UTILISATEUR -->

                    <label for="pseudoMemb">Nom d'utilisateur du membre (non modifiable)</label> <!-- Libellé du pseudo. -->
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" autofocus="autofocus"
                        placeholder="Pseudo (ex: leo32)" /> <!-- Champ texte pour le pseudo. -->
                    <p>(entre 6 et 70 caractères)</p> <!-- Indication de longueur du pseudo. -->
                    <!-- PRENOM -->
                    <label for="prenomMemb">Prénom du membre</label> <!-- Libellé du prénom. -->
                    <input id="prenomMemb" name="prenomMemb" class="form-control" type="text" autofocus="autofocus"
                        placeholder="Prénom (ex: Léa)" /> <!-- Champ texte pour le prénom. -->
                    <!-- NOM -->
                    <label for="nomMemb">Nom du membre</label> <!-- Libellé du nom. -->
                    <input id="nomMemb" name="nomMemb" class="form-control" type="text" autofocus="autofocus"
                        placeholder="Nom (ex: Martin)" /> <!-- Champ texte pour le nom. -->
                    <!-- MDP -->
                    <label for="passMemb">Mot de passe du membre</label> <!-- Libellé du mot de passe. -->
                    <input id="passMemb" name="passMemb" class="form-control" type="password" autofocus="autofocus" /> <!-- Champ mot de passe. -->
                    <p>(Entre 8 et 15 car., au moins une majuscule, une minuscule, un chiffre et un caractère spécial)</p> <!-- Indication de complexité. -->
                    <button type="button" id="afficher" class="btn btn-secondary">Afficher le mot de
                        passe</button><br><br> <!-- Bouton pour afficher le mot de passe. -->
                    <!-- MDP VERIFICATION -->
                    <label for="passMemb2">Confirmez mot de passe du membre</label> <!-- Libellé de confirmation. -->
                    <input id="passMemb2" name="passMemb2" class="form-control" type="password" autofocus="autofocus" /> <!-- Champ de confirmation du mot de passe. -->
                    <p>(Entre 8 et 15 car., au moins une majuscule, une minuscule, un chiffre et un caractère spécial)</p> <!-- Indication de complexité. -->
                    <button type="button" id="afficher2" class="btn btn-secondary">Afficher le mot de
                        passe</button><br><br> <!-- Bouton pour afficher la confirmation. -->
                    <!-- EMAIL -->
                    <label for="eMailMemb">Email du membre</label> <!-- Libellé de l'email. -->
                    <input id="eMailMemb" name="eMailMemb" class="form-control" type="email" autofocus="autofocus"
                        placeholder="prenom.nom@example.com" /> <!-- Champ email. -->
                    <!-- EMAIL VERIFICATION -->
                    <label for="eMailMemb2">Confirmez email du membre</label> <!-- Libellé de confirmation email. -->
                    <input id="eMailMemb2" name="eMailMemb2" class="form-control" type="email" autofocus="autofocus"
                        placeholder="prenom.nom@example.com" /> <!-- Champ de confirmation email. -->
                    <!-- PARTAGE DES DONNEES -->
                    <label for="accordMemb">J'accepte que mes données soient conservées :</label> <!-- Libellé du consentement. -->
                    <input type="radio" id="accordMemb" name="accordMemb" value="OUI" /> <!-- Option radio pour oui. -->
                    <label for="accordMemb">Oui</label> <!-- Libellé de l'option oui. -->
                    <input type="radio" id="accordMemb" name="accordMemb" value="NON" checked /> <!-- Option radio pour non (par défaut). -->
                    <label for="accordMemb">Non</label> <!-- Libellé de l'option non. -->
                    <br><br> <!-- Saut de ligne pour espacement. -->
                    <!-- STATUT -->
                    <label for="numStat">Statut :</label> <!-- Libellé du statut. -->
                    <select name="numStat" id="numStat"> <!-- Liste déroulante des statuts. -->
                        <option value="1" <?= ($ba_bec_numStat == 1) ? 'selected' : '' ?>>Administrateur</option> <!-- Option admin. -->
                        <option value="2" <?= ($ba_bec_numStat == 2) ? 'selected' : '' ?>>Modérateur</option> <!-- Option modérateur. -->
                        <option value="3" <?= ($ba_bec_numStat == 3) ? 'selected' : '' ?>>Membre</option> <!-- Option membre. -->
                    </select> <!-- Ferme la liste des statuts. -->
                </div> <!-- Ferme le groupe de champs. -->
                <br /> <!-- Ajoute un saut de ligne. -->
                <div class="form-group mt-2"> <!-- Groupe pour le bouton de soumission. -->
                    <button type="submit" class="btn btn-primary">Confirmer create ?</button> <!-- Bouton de soumission. -->
                </div> <!-- Ferme le groupe du bouton. -->
            </form> <!-- Ferme le formulaire. -->
        </div> <!-- Ferme la colonne du formulaire. -->
    </div> <!-- Ferme la ligne. -->
</div> <!-- Ferme le conteneur. -->

<?php if (!empty($ba_bec_recaptchaSiteKey)): ?> <!-- Vérifie la présence de la clé reCAPTCHA. -->
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>"></script> <!-- Charge la lib reCAPTCHA v3. -->
<?php endif; ?> <!-- Ferme la condition de chargement reCAPTCHA. -->
<!-- JS POUR CACHER/AFFICHER MDP-->
<script> // Ouvre le bloc JavaScript.
    document.getElementById('afficher').addEventListener("click", function () { // Ajoute un écouteur sur le bouton afficher.

        attribut = document.getElementById('passMemb').getAttribute('type'); // Lit le type actuel du champ mot de passe.
        if (attribut == 'password') { // Vérifie si le champ est masqué.
            document.getElementById('passMemb').setAttribute('type', 'text'); // Passe le champ en texte clair.
        } else { // Cas où le champ est déjà en texte clair.
            document.getElementById('passMemb').setAttribute('type', 'password'); // Repasse le champ en mode mot de passe.
        } // Ferme la condition sur le type.

    }); // Ferme l'écouteur du premier bouton.

    document.getElementById('afficher2').addEventListener("click", function () { // Ajoute un écouteur sur le second bouton.

        attribut = document.getElementById('passMemb2').getAttribute('type'); // Lit le type actuel du champ de confirmation.
        if (attribut == 'password') { // Vérifie si le champ est masqué.
            document.getElementById('passMemb2').setAttribute('type', 'text'); // Passe le champ en texte clair.
        } else { // Cas où le champ est déjà en texte clair.
            document.getElementById('passMemb2').setAttribute('type', 'password'); // Repasse le champ en mode mot de passe.
        } // Ferme la condition sur le type.

    }); // Ferme l'écouteur du second bouton.

    (function () { // Démarre une IIFE pour isoler la logique reCAPTCHA.
        var form = document.getElementById('formCreate'); // Récupère l'élément formulaire.
        var tokenInput = document.getElementById('g-recaptcha-response-create'); // Récupère le champ caché de token.
        var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>'; // Stocke la clé reCAPTCHA côté JS.
        if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') { // Vérifie les prérequis.
            return; // Quitte la fonction si un prérequis manque.
        } // Ferme la condition de garde.

        var isSubmitting = false; // Initialise un verrou anti double soumission.
        form.addEventListener('submit', function (event) { // Ajoute un écouteur sur la soumission du formulaire.
            if (isSubmitting) { // Vérifie si une soumission est déjà en cours.
                return; // Stoppe si déjà en soumission.
            } // Ferme la condition de double soumission.
            event.preventDefault(); // Empêche la soumission immédiate.
            if (typeof grecaptcha === 'undefined') { // Vérifie la disponibilité de reCAPTCHA.
                form.submit(); // Soumet directement si reCAPTCHA est absent.
                return; // Quitte le gestionnaire.
            } // Ferme la condition reCAPTCHA.
            grecaptcha.ready(function () { // Attend que reCAPTCHA soit prêt.
                grecaptcha.execute(siteKey, {action: 'create'}) // Exécute reCAPTCHA avec l'action create.
                    .then(function (token) { // Récupère le token généré.
                        tokenInput.value = token; // Place le token dans le champ caché.
                        isSubmitting = true; // Active le verrou de soumission.
                        form.submit(); // Soumet le formulaire avec le token.
                    }); // Ferme la promesse reCAPTCHA.
            }); // Ferme le callback reCAPTCHA ready.
        }); // Ferme l'écouteur de soumission.
    })(); // Exécute immédiatement l'IIFE.

</script> // Ferme le bloc JavaScript.
