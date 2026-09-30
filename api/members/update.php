<?php
/*
 * Endpoint API: api/members/update.php
 * Rôle: met à jour un(e) member existant(e).
 *
 * Déroulé détaillé:
 * 1) Charge la configuration applicative et les helpers (session/DB/sanitisation).
 * 2) Récupère les paramètres POST (et éventuellement FILES) puis les nettoie via ctrlSaisies.
 * 3) Valide les contraintes métier (champs obligatoires, types, formats, tailles).
 * 4) Exécute la requête SQL adaptée (INSERT/UPDATE/DELETE) avec les valeurs préparées.
 * 5) Gère le feedback (flash/session/erreur) et redirige l'utilisateur vers l'écran cible.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: ../../views/backend/members/list.php');
    exit();
}

$ba_bec_errors = [];

// Récupération des données POST et assainissement
$ba_bec_numMemb    = isset($_POST['numMemb'])    ? ctrlSaisies($_POST['numMemb'])    : null;
$ba_bec_prenomMemb = isset($_POST['prenomMemb']) ? ctrlSaisies($_POST['prenomMemb']) : null;
$ba_bec_nomMemb    = isset($_POST['nomMemb'])    ? ctrlSaisies($_POST['nomMemb'])    : null;
$ba_bec_passMemb   = isset($_POST['passMemb'])   ? (string) $_POST['passMemb']   : null;
$ba_bec_passMemb2  = isset($_POST['passMemb2'])  ? (string) $_POST['passMemb2']  : null;
$ba_bec_eMailMemb  = isset($_POST['eMailMemb'])  ? ctrlSaisies($_POST['eMailMemb'])  : null;
$ba_bec_eMailMemb2 = isset($_POST['eMailMemb2']) ? ctrlSaisies($_POST['eMailMemb2']) : null;
$ba_bec_numStat    = isset($_POST['numStat'])    ? (int) $_POST['numStat']    : 0;

$ba_bec_redirectUrl = '../../views/backend/members/edit.php';
if (!empty($ba_bec_numMemb)) {
    $ba_bec_redirectUrl .= '?numMemb=' . urlencode($ba_bec_numMemb);
}

$ba_bec_recaptcha = verifyRecaptcha($_POST['g-recaptcha-response'] ?? '', 'update');
if (!$ba_bec_recaptcha['valid']) {
    $ba_bec_errors[] = $ba_bec_recaptcha['message'] ?: 'Échec de la vérification reCAPTCHA.';
}

// Vérification de l'existence de l'ID membre
if (!$ba_bec_numMemb) {
    $ba_bec_errors[] = "ID du membre manquant.";
} else {
    // Vérifier que le membre existe bien
    $ba_bec_current = sql_select('MEMBRE', 'numMemb, numStat', 'numMemb = ?', null, null, '1', [(int) $ba_bec_numMemb]);
    if (empty($ba_bec_current)) {
        $ba_bec_errors[] = "Le membre spécifié n'existe pas.";
    } else {
        $ba_bec_currentStat = $ba_bec_current[0]['numStat'];
    }
}

// Validation et mise à jour du mot de passe si renseigné
// Si le champ mot de passe est vide, on ne modifie pas le mot de passe existant
if (!empty($ba_bec_passMemb) || !empty($ba_bec_passMemb2)) {
    $ba_bec_pass_length = strlen((string) $ba_bec_passMemb);
    if ($ba_bec_pass_length < 8 || $ba_bec_pass_length > 72) {
        $ba_bec_errors[] = 'Le mot de passe doit contenir entre 8 et 72 caractères.';
    }
    // Vérifier la complexité du mot de passe
    if (!preg_match('/[A-Z]/', $ba_bec_passMemb) || !preg_match('/[a-z]/', $ba_bec_passMemb) || !preg_match('/[0-9]/', $ba_bec_passMemb)) {
        $ba_bec_errors[] = "Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.";
    }
    // Vérifier la confirmation du mot de passe
    if ($ba_bec_passMemb !== $ba_bec_passMemb2) {
        $ba_bec_errors[] = "Les mots de passe doivent être identiques.";
    }
    // Si aucune erreur, hacher le nouveau mot de passe
    if (empty($ba_bec_errors)) {
        $ba_bec_hash_password = password_hash($ba_bec_passMemb, PASSWORD_DEFAULT);
    }
}

// Validation de l'adresse email
if (!filter_var($ba_bec_eMailMemb, FILTER_VALIDATE_EMAIL)) {
    $ba_bec_errors[] = "$ba_bec_eMailMemb n'est pas une adresse mail valide.";
}
if ($ba_bec_eMailMemb !== $ba_bec_eMailMemb2) {
    $ba_bec_errors[] = "Les adresses mail doivent être identiques.";
}

if (!in_array($ba_bec_numStat, [1, 2, 3], true)) {
    $ba_bec_errors[] = 'Statut invalide.';
}

if (isset($ba_bec_currentStat) && (int) $ba_bec_currentStat === 1 && $ba_bec_numStat !== 1
    && (int) $ba_bec_numMemb === current_user_id()) {
    $ba_bec_adminCount = sql_select('MEMBRE', 'COUNT(*) AS total', 'numStat = ?', null, null, null, [1]);
    if ((int) ($ba_bec_adminCount[0]['total'] ?? 0) <= 1) {
        $ba_bec_errors[] = 'Le dernier administrateur ne peut pas se rétrograder.';
    }
}

if (!empty($ba_bec_errors)) {
    $_SESSION['errors'] = $ba_bec_errors;
    header('Location: ' . $ba_bec_redirectUrl);
    exit();
}

// Si aucune erreur, mise à jour du membre
if (isset($ba_bec_numMemb, $ba_bec_prenomMemb, $ba_bec_nomMemb, $ba_bec_eMailMemb, $ba_bec_numStat)) {

    // Construire la chaîne de mise à jour
    // On met à jour les champs prénom, nom, email et statut.
    // Le mot de passe est mis à jour seulement s'il a été renseigné
    if (isset($ba_bec_hash_password)) {
        $ba_bec_updateFields = 'prenomMemb = ?, nomMemb = ?, passMemb = ?, eMailMemb = ?, numStat = ?';
        $ba_bec_updateParams = [$ba_bec_prenomMemb, $ba_bec_nomMemb, $ba_bec_hash_password, $ba_bec_eMailMemb, $ba_bec_numStat, (int) $ba_bec_numMemb];
    } else {
        $ba_bec_updateFields = 'prenomMemb = ?, nomMemb = ?, eMailMemb = ?, numStat = ?';
        $ba_bec_updateParams = [$ba_bec_prenomMemb, $ba_bec_nomMemb, $ba_bec_eMailMemb, $ba_bec_numStat, (int) $ba_bec_numMemb];
    }

    $ba_bec_update_result = sql_update('MEMBRE', $ba_bec_updateFields, 'numMemb = ?', $ba_bec_updateParams);
    if ($ba_bec_update_result['success']) {
        flash_success();
        header('Location: ../../views/backend/members/list.php');
        exit();
    }
    $_SESSION['errors'] = [FLASH_MESSAGE_ERROR];
    header('Location: ' . $ba_bec_redirectUrl);
    exit();
}

$_SESSION['errors'] = ['Erreur lors de la mise à jour du membre.'];
header('Location: ' . $ba_bec_redirectUrl);
exit();

?>
