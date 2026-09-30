<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once ROOT . '/functions/ctrlSaisies.php';

// Lit le pseudo nettoyé tout en conservant le mot de passe brut pour sa vérification.
$ba_bec_pseudo = ctrlSaisies($_POST['pseudo'] ?? '');
$ba_bec_password = (string) ($_POST['password'] ?? '');
$ba_bec_error = "Nom d'utilisateur ou mot de passe incorrect";

// Bloque temporairement l'adresse après cinq échecs récents.
if (login_throttle_blocked($ba_bec_pseudo)) {
    $_SESSION['error'] = 'Trop de tentatives, réessayez dans 15 minutes';
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

// Vérifie d'abord le mot de passe brut, puis la variante historique exacte.
$ba_bec_user = sql_select('MEMBRE', '*', 'pseudoMemb = ?', null, null, '1', [$ba_bec_pseudo]);
$ba_bec_validRaw = !empty($ba_bec_user) && password_verify($ba_bec_password, $ba_bec_user[0]['passMemb']);
$ba_bec_validLegacy = !$ba_bec_validRaw && !empty($ba_bec_user)
    && password_verify(legacy_password_variant($ba_bec_password), $ba_bec_user[0]['passMemb']);

if (!$ba_bec_validRaw && !$ba_bec_validLegacy) {
    login_throttle_fail($ba_bec_pseudo);
    $_SESSION['error'] = $ba_bec_error;
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

// Remplace les anciens hash par un hash du mot de passe brut.
if ($ba_bec_validLegacy || password_needs_rehash($ba_bec_user[0]['passMemb'], PASSWORD_DEFAULT)) {
    sql_update('MEMBRE', 'passMemb = ?', 'numMemb = ?', [password_hash($ba_bec_password, PASSWORD_DEFAULT), (int) $ba_bec_user[0]['numMemb']]);
}

// Régénère la session avant d'enregistrer l'identité authentifiée.
login_throttle_clear();
session_regenerate_id(true);
$_SESSION['user_id'] = (int) $ba_bec_user[0]['numMemb'];
$_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb'];
$_SESSION['numStat'] = (int) $ba_bec_user[0]['numStat'];
header('Location: ' . ROOT_URL . '/index.php');
exit();
?>
