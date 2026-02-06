<?php // Ouvre le bloc PHP pour la logique serveur.
/*
 * Vue d'administration (édition) pour le module members.
 * - Le formulaire réutilise la structure de création mais avec des valeurs pré-remplies côté serveur.
 * - Les identifiants nécessaires (ID) sont passés via la query string ou des champs cachés.
 * - L'action du formulaire cible la route de mise à jour correspondante.
 * - Les sections HTML isolent les groupes d'attributs pour une édition guidée.
 * - Les actions secondaires permettent de revenir à la liste sans enregistrer.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale du site.
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection/contrôle.
include '../../../header.php'; // Inclut l'en-tête HTML commun.

// Récupération des erreurs flash
$ba_bec_errors = $_SESSION['errors'] ?? []; // Récupère les erreurs stockées en session.
unset($_SESSION['errors']); // Supprime les erreurs de la session après lecture.
$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY'); // Récupère la clé reCAPTCHA depuis l'environnement.
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8'); // Échappe la clé pour l'injection HTML.

// Seulement si tu es admin ou modérateur, tu as accès à cette page
/*if (!isset($_SESSION['numStat']) || $_SESSION['numStat'] !== 1 && $_SESSION['numStat'] !== 2 ) {
    header('Location: ../../../index.php');
    exit();
}*/

// Initialisation des variables
$ba_bec_numMemb = $ba_bec_pseudoMemb = $ba_bec_prenomMemb = $ba_bec_nomMemb = $ba_bec_passMemb = $ba_bec_eMailMemb = ""; // Initialise les champs de membre à vide.
$ba_bec_numStat = 3; // Par défaut, statut "Membre"

if (isset($_GET['numMemb'])) { // Vérifie si un identifiant de membre est fourni.
    $ba_bec_numMemb = $_GET['numMemb']; // Récupère l'identifiant du membre depuis l'URL.
    $ba_bec_membre = sql_select("MEMBRE", "*", "numMemb = $ba_bec_numMemb")[0] ?? []; // Charge les données du membre.

    $ba_bec_pseudoMemb = $ba_bec_membre['pseudoMemb'] ?? ""; // Récupère le pseudo du membre.
    $ba_bec_prenomMemb = $ba_bec_membre['prenomMemb'] ?? ""; // Récupère le prénom du membre.
    $ba_bec_nomMemb = $ba_bec_membre['nomMemb'] ?? ""; // Récupère le nom du membre.
    $ba_bec_passMemb = $ba_bec_membre['passMemb'] ?? ""; // Récupère le mot de passe du membre.
    $ba_bec_eMailMemb = $ba_bec_membre['eMailMemb'] ?? ""; // Récupère l'email du membre.
    $ba_bec_numStat = $ba_bec_membre['numStat'] ?? 3; // Récupère le statut ou met membre par défaut.
} // Ferme la condition de chargement du membre.
?> <!-- Ferme le bloc PHP initial. -->

<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Démarre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Colonne pleine largeur. -->
            <h1>Modification Membre</h1> <!-- Titre principal de la page. -->
        </div> <!-- Ferme la colonne du titre. -->
        <?php if (!empty($ba_bec_errors)): ?> <!-- Vérifie la présence d'erreurs. -->
            <div class="col-md-12"> <!-- Colonne pour afficher les erreurs. -->
                <div class="alert alert-danger"> <!-- Conteneur d'alerte Bootstrap. -->
                    <ul class="mb-0"> <!-- Liste des erreurs sans marge basse. -->
                        <?php foreach ($ba_bec_errors as $ba_bec_error): ?> <!-- Boucle sur chaque erreur. -->
                            <li><?= htmlspecialchars($ba_bec_error) ?></li> <!-- Affiche l'erreur échappée. -->
                        <?php endforeach; ?> <!-- Termine la boucle des erreurs. -->
                    </ul> <!-- Ferme la liste. -->
                </div> <!-- Ferme l'alerte. -->
            </div> <!-- Ferme la colonne des erreurs. -->
        <?php endif; ?> <!-- Ferme la condition d'erreurs. -->
        <div class="col-md-12"> <!-- Colonne pour le formulaire. -->
            <form action="<?php echo ROOT_URL . '/api/members/update.php' ?>" method="post"> <!-- Formulaire de mise à jour. -->
                <input name="numMemb" class="form-control" type="hidden"
                    value="<?php echo htmlspecialchars($ba_bec_numMemb); ?>" /> <!-- Champ caché pour l'identifiant. -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-update"> <!-- Champ caché pour reCAPTCHA. -->

                <div class="form-group"> <!-- Groupe de champs du formulaire. -->
                    <!-- NOM D'UTILISATEUR -->
                    <label for="pseudoMemb">Nom d'utilisateur du membre (non modifiable)</label> <!-- Libellé du pseudo. -->
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_pseudoMemb); ?>" readonly disabled /> <!-- Champ pseudo en lecture seule. -->

                    <!-- PRENOM -->
                    <label for="prenomMemb">Prénom du membre</label> <!-- Libellé du prénom. -->
                    <input id="prenomMemb" name="prenomMemb" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_prenomMemb); ?>" placeholder="Prénom (ex: Léa)" /> <!-- Champ prénom prérempli. -->

                    <!-- NOM -->
                    <label for="nomMemb">Nom du membre</label> <!-- Libellé du nom. -->
                    <input id="nomMemb" name="nomMemb" class="form-control" type="text"
                        value="<?php echo htmlspecialchars($ba_bec_nomMemb); ?>" placeholder="Nom (ex: Martin)" /> <!-- Champ nom prérempli. -->

                    <!-- MDP -->
                    <label for="passMemb">Mot de Passe</label> <!-- Libellé du mot de passe. -->
                    <input id="passMemb" name="passMemb" class="form-control" type="password"
                        value="<?php echo htmlspecialchars($ba_bec_passMemb); ?>" /> <!-- Champ mot de passe prérempli. -->
                    <p>(Entre 8 et 15 car., au moins une majuscule, une minuscule, un chiffre, caractères spéciaux
                        acceptés)</p> <!-- Indication de complexité. -->
                    <button type="button" id="afficher" class="btn btn-secondary">Afficher le mot de
                        passe</button><br><br> <!-- Bouton pour afficher le mot de passe. -->

                    <!-- MDP VERIFICATION -->
                    <label for="passMemb2">Confirmez le mot de passe</label> <!-- Libellé de confirmation. -->
                    <input id="passMemb2" name="passMemb2" class="form-control" type="password"
                        value="<?php echo htmlspecialchars($ba_bec_passMemb); ?>" /> <!-- Champ confirmation prérempli. -->
                    <button type="button" id="afficher2" class="btn btn-secondary">Afficher le mot de
                        passe</button><br><br> <!-- Bouton pour afficher la confirmation. -->

                    <!-- EMAIL -->
                    <label for="eMailMemb">Email du membre</label> <!-- Libellé de l'email. -->
                    <input id="eMailMemb" name="eMailMemb" class="form-control" type="email"
                        value="<?php echo htmlspecialchars($ba_bec_eMailMemb); ?>"
                        placeholder="prenom.nom@example.com" /> <!-- Champ email prérempli. -->

                    <!-- EMAIL VERIFICATION -->
                    <label for="eMailMemb2">Confirmez l'email du membre</label> <!-- Libellé de confirmation email. -->
                    <input id="eMailMemb2" name="eMailMemb2" class="form-control" type="email"
                        value="<?php echo htmlspecialchars($ba_bec_eMailMemb); ?>"
                        placeholder="prenom.nom@example.com" /> <!-- Champ confirmation email prérempli. -->
                    <br><br> <!-- Saut de ligne pour espacement. -->

                    <!-- STATUT -->
                    <label for="numStat">Statut :</label> <!-- Libellé du statut. -->
                    <select name="numStat" id="numStat" class="form-control"> <!-- Liste déroulante des statuts. -->
                        <option value="1" <?= ($ba_bec_numStat == 1) ? 'selected' : '' ?>>Administrateur</option> <!-- Option admin. -->
                        <option value="2" <?= ($ba_bec_numStat == 2) ? 'selected' : '' ?>>Modérateur</option> <!-- Option modérateur. -->
                        <option value="3" <?= ($ba_bec_numStat == 3) ? 'selected' : '' ?>>Membre</option> <!-- Option membre. -->
                    </select> <!-- Ferme la liste des statuts. -->
                </div> <!-- Ferme le groupe de champs. -->

                <br /> <!-- Ajoute un saut de ligne. -->
                <div class="form-group mt-2"> <!-- Groupe pour le bouton de soumission. -->
                    <button type="submit" class="btn btn-primary">Confirmer update</button> <!-- Bouton de mise à jour. -->
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
        let passInput = document.getElementById('passMemb'); // Récupère le champ mot de passe.
        passInput.type = (passInput.type === 'password') ? 'text' : 'password'; // Bascule le type du champ.
    }); // Ferme l'écouteur du premier bouton.

    document.getElementById('afficher2').addEventListener("click", function () { // Ajoute un écouteur sur le second bouton.
        let passInput2 = document.getElementById('passMemb2'); // Récupère le champ de confirmation.
        passInput2.type = (passInput2.type === 'password') ? 'text' : 'password'; // Bascule le type du champ.
    }); // Ferme l'écouteur du second bouton.

    (function () { // Démarre une IIFE pour isoler la logique reCAPTCHA.
        var form = document.querySelector('form'); // Récupère le formulaire.
        var tokenInput = document.getElementById('g-recaptcha-response-update'); // Récupère le champ caché de token.
        var siteKey = '<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>'; // Stocke la clé reCAPTCHA côté JS.
        if (!form || !tokenInput || !siteKey || typeof grecaptcha === 'undefined') { // Vérifie les prérequis.
            return; // Quitte la fonction si un prérequis manque.
        } // Ferme la condition de garde.

        var isSubmitting = false; // Initialise un verrou anti double soumission.
        form.addEventListener('submit', function (event) { // Ajoute un écouteur sur la soumission.
            if (isSubmitting) { // Vérifie si une soumission est déjà en cours.
                return; // Stoppe si déjà en soumission.
            } // Ferme la condition de double soumission.
            event.preventDefault(); // Empêche la soumission immédiate.
            if (typeof grecaptcha === 'undefined') { // Vérifie la disponibilité de reCAPTCHA.
                form.submit(); // Soumet directement si reCAPTCHA est absent.
                return; // Quitte le gestionnaire.
            } // Ferme la condition reCAPTCHA.
            grecaptcha.ready(function () { // Attend que reCAPTCHA soit prêt.
                grecaptcha.execute(siteKey, {action: 'update'}) // Exécute reCAPTCHA avec l'action update.
                    .then(function (token) { // Récupère le token généré.
                        tokenInput.value = token; // Place le token dans le champ caché.
                        isSubmitting = true; // Active le verrou de soumission.
                        form.submit(); // Soumet le formulaire avec le token.
                    }); // Ferme la promesse reCAPTCHA.
            }); // Ferme le callback reCAPTCHA ready.
        }); // Ferme l'écouteur de soumission.
    })(); // Exécute immédiatement l'IIFE.
</script> // Ferme le bloc JavaScript.
