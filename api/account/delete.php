<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$ba_bec_numMemb = $_SESSION['user_id'] ?? null;
if (!$ba_bec_numMemb) {
    $_SESSION['error'] = 'Vous devez être connecté pour supprimer votre compte.';
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requête invalide.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

$ba_bec_confirm = isset($_POST['confirmDeleteAccount']) ? (int) $_POST['confirmDeleteAccount'] : 0;
if ($ba_bec_confirm !== 1) {
    $_SESSION['error'] = 'Vous devez confirmer la suppression de votre compte.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

$ba_bec_member = sql_select('MEMBRE', 'numMemb', "numMemb = $ba_bec_numMemb")[0] ?? null;
if (!$ba_bec_member) {
    $_SESSION['error'] = 'Compte introuvable.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

sql_delete('LIKEART', "numMemb = $ba_bec_numMemb");
sql_delete('comment', "numMemb = $ba_bec_numMemb");
sql_delete('MEMBRE', "numMemb = $ba_bec_numMemb");

$_SESSION = [];
$_SESSION['success'] = 'Votre compte a bien été supprimé.';
header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
exit();
