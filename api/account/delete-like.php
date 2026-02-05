<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$ba_bec_numMemb = $_SESSION['user_id'] ?? null;
if (!$ba_bec_numMemb) {
    $_SESSION['error'] = 'Vous devez être connecté pour supprimer un like.';
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requête invalide.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

$ba_bec_numArt = isset($_POST['numArt']) ? (int) $_POST['numArt'] : 0;
if ($ba_bec_numArt <= 0) {
    $_SESSION['error'] = 'Like introuvable.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

$ba_bec_like = sql_select('LIKEART', 'numArt', "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb")[0] ?? null;
if (!$ba_bec_like) {
    $_SESSION['error'] = 'Vous ne pouvez pas supprimer ce like.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

sql_delete('LIKEART', "numArt = $ba_bec_numArt AND numMemb = $ba_bec_numMemb");
$_SESSION['success'] = 'Votre like a été supprimé.';
header('Location: ' . ROOT_URL . '/compte.php');
exit();

?>