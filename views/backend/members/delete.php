<?php // Ouvre le bloc PHP pour la logique serveur.
/*
 * Vue d'administration (suppression) pour le module members.
 * - Cette page sert de confirmation avant la suppression définitive d'un enregistrement.
 * - L'ID ciblé est transmis par la query string afin de récupérer les détails à afficher.
 * - Le bouton principal déclenche la route de suppression côté backend.
 * - Un lien de retour évite la suppression et renvoie vers la liste.
 * - Aucun traitement métier n'est exécuté ici : la vue décrit seulement l'interface.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale du site.

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/redirec.php'; // Charge les helpers de redirection/contrôle.
include '../../../header.php'; // Inclut l'en-tête HTML commun.

// Récupération des erreurs flash
$ba_bec_errors = $_SESSION['errors'] ?? []; // Récupère les erreurs stockées en session.
unset($_SESSION['errors']); // Supprime les erreurs de la session après lecture.
$ba_bec_recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY'); // Récupère la clé reCAPTCHA depuis l'environnement.
$ba_bec_recaptchaSiteKeyEscaped = htmlspecialchars($ba_bec_recaptchaSiteKey ?? '', ENT_QUOTES, 'UTF-8'); // Échappe la clé pour l'injection HTML.

if(isset($_GET['numMemb'])){ // Vérifie si un identifiant de membre est fourni.
    $ba_bec_numMemb = $_GET['numMemb']; // Récupère l'identifiant du membre depuis l'URL.
    $ba_bec_member = sql_select('MEMBRE', '*', "numMemb = '$ba_bec_numMemb'")[0]; // Charge les données du membre.
    $ba_bec_pseudoMemb = $ba_bec_member['pseudoMemb']; // Récupère le pseudo du membre.
    $ba_bec_prenomMemb = $ba_bec_member['prenomMemb']; // Récupère le prénom du membre.
    $ba_bec_nomMemb = $ba_bec_member['nomMemb']; // Récupère le nom du membre.
    $ba_bec_eMailMemb = $ba_bec_member['eMailMemb']; // Récupère l'email du membre.
    $ba_bec_dtCreaMemb = $ba_bec_member['dtCreaMemb']; // Récupère la date de création.
    $ba_bec_numStat = $ba_bec_member['numStat']; // Récupère le statut du membre.
?> <!-- Ferme le bloc PHP initial. -->
<!-- Formulaire Bootstrap pour supprimer un membre -->
<div class="container"> <!-- Ouvre le conteneur Bootstrap principal. -->
    <div class="row"> <!-- Démarre une ligne Bootstrap. -->
        <div class="col-md-12"> <!-- Colonne pleine largeur. -->
            <h1>Suppression du membre</h1> <!-- Titre principal de la page. -->
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
            <!-- Formulaire pour supprimer le membre -->
            <form action="<?php echo ROOT_URL . '/api/members/delete.php' ?>" method="post"> <!-- Formulaire de suppression. -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-delete"> <!-- Champ caché pour reCAPTCHA. -->
                <div class="form-group"> <!-- Groupe de champs du formulaire. -->
                    <!-- NUM -->
                    <label for="numMemb">Numéro du membre</label> <!-- Libellé du numéro. -->
                    <input id="numMemb" name="numMemb" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numMemb); ?>" readonly="readonly" /> <!-- Champ caché avec l'ID. -->
                    <!-- PRENOM -->
                    <label for="prenomMemb">Prénom du membre</label> <!-- Libellé du prénom. -->
                    <input id="prenomMemb" name="prenomMemb" class="form-control" type="text" value="<?php echo($ba_bec_prenomMemb); ?>" readonly="readonly" disabled /> <!-- Champ prénom en lecture seule. -->
                    <!-- NOM -->
                    <label for="nomMemb">Nom du membre</label> <!-- Libellé du nom. -->
                    <input id="nomMemb" name="nomMemb" class="form-control" type="text" value="<?php echo($ba_bec_nomMemb); ?>" readonly="readonly" disabled /> <!-- Champ nom en lecture seule. -->
                    <!-- NOM D'UTILISATEUR -->
                    <label for="pseudoMemb">Nom d'utilisateur du membre</label> <!-- Libellé du pseudo. -->
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value="<?php echo($ba_bec_pseudoMemb); ?>" readonly="readonly" disabled /> <!-- Champ pseudo en lecture seule. -->
                    <!-- MAIL -->
                    <label for="eMailMemb">Adresse e-mail du membre</label> <!-- Libellé de l'email. -->
                    <input id="eMailMemb" name="eMailMemb" class="form-control" type="text" value="<?php echo($ba_bec_eMailMemb); ?>" readonly="readonly" disabled /> <!-- Champ email en lecture seule. -->
                    <!-- DATE CREA -->
                    <label for="dtCreaMemb">Date de création du membre</label> <!-- Libellé de la date de création. -->
                    <input id="dtCreaMemb" name="dtCreaMemb" class="form-control" type="text" value="<?php echo($ba_bec_dtCreaMemb); ?>" readonly="readonly" disabled /> <!-- Champ date en lecture seule. -->
                    <!-- STATUT -->
                    <label for="numStat">Statut du membre</label> <!-- Libellé du statut. -->
                    <input id="statutMemb" name="statutMemb" class="form-control" type="text" value="<?php 
                        if ($ba_bec_numStat == '1'){ // Vérifie si le statut est administrateur.
                            echo 'Administrateur'; // Affiche le libellé administrateur.
                        } 
                        if ($ba_bec_numStat == '2'){ // Vérifie si le statut est modérateur.
                            echo 'Modérateur'; // Affiche le libellé modérateur.
                        }
                        if ($ba_bec_numStat == '3'){ // Vérifie si le statut est membre.
                            echo 'Membre'; // Affiche le libellé membre.
                        }
                     ?>" readonly="readonly" disabled /> <!-- Champ statut en lecture seule. -->
                     <input id="idMemb" name="idMemb" class="form-control" style="display: none" type="text" value="<?php echo($ba_bec_numStat); ?>" readonly="readonly" /> <!-- Champ caché pour le statut. -->
                </div> <!-- Ferme le groupe de champs. -->
                <br /> <!-- Ajoute un saut de ligne. -->
            <?php // Ouvre un bloc PHP pour décider de l'affichage du bouton.
                if ($ba_bec_numStat == 1){ // Vérifie si le membre est administrateur.
                    echo '<p>Un administrateur ne peut pas être supprimé.</p>'; // Affiche un message d'interdiction.
                } else { ?> <!-- Cas où le membre n'est pas administrateur. -->
                    <div class="form-group mt-2"> <!-- Groupe pour le bouton de suppression. -->
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr(e) de vouloir supprimer ce membre ?')">Confirmer la suppression</button> <!-- Bouton de suppression avec confirmation. -->
                    </div> <!-- Ferme le groupe du bouton. -->
                <?php } ?> <!-- Ferme la condition d'affichage du bouton. -->
            </form> <!-- Ferme le formulaire. -->
        </div> <!-- Ferme la colonne du formulaire. -->
    </div> <!-- Ferme la ligne. -->
</div> <!-- Ferme le conteneur. -->
<?php // Rouvre un bloc PHP pour gérer le cas d'absence d'identifiant.
} else { // Cas où l'identifiant est absent.
    header('Location: list.php'); // Redirige vers la liste des membres.
    exit(); // Stoppe l'exécution après redirection.
} // Ferme la condition initiale.
?> <!-- Ferme le bloc PHP final. -->

<?php if (!empty($ba_bec_recaptchaSiteKey)): ?> <!-- Vérifie la présence de la clé reCAPTCHA. -->
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $ba_bec_recaptchaSiteKeyEscaped; ?>"></script> <!-- Charge la lib reCAPTCHA v3. -->
<?php endif; ?> <!-- Ferme la condition de chargement reCAPTCHA. -->
<script> // Ouvre le bloc JavaScript.
    (function () { // Démarre une IIFE pour isoler la logique reCAPTCHA.
        var form = document.querySelector('form'); // Récupère le formulaire.
        var tokenInput = document.getElementById('g-recaptcha-response-delete'); // Récupère le champ caché de token.
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
                grecaptcha.execute(siteKey, {action: 'delete'}) // Exécute reCAPTCHA avec l'action delete.
                    .then(function (token) { // Récupère le token généré.
                        tokenInput.value = token; // Place le token dans le champ caché.
                        isSubmitting = true; // Active le verrou de soumission.
                        form.submit(); // Soumet le formulaire avec le token.
                    }); // Ferme la promesse reCAPTCHA.
            }); // Ferme le callback reCAPTCHA ready.
        }); // Ferme l'écouteur de soumission.
    })(); // Exécute immédiatement l'IIFE.
</script> // Ferme le bloc JavaScript.
