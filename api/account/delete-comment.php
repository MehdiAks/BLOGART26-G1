<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$ba_bec_numMemb = $_SESSION['user_id'] ?? null;
if (!$ba_bec_numMemb) {
    $_SESSION['error'] = 'Vous devez être connecté pour supprimer un commentaire.';
    header('Location: ' . ROOT_URL . '/views/backend/security/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requête invalide.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

$ba_bec_numCom = isset($_POST['numCom']) ? (int) $_POST['numCom'] : 0;
if ($ba_bec_numCom <= 0) {
    $_SESSION['error'] = 'Commentaire introuvable.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

$ba_bec_comment = sql_select('comment', 'numCom', "numCom = $ba_bec_numCom AND numMemb = $ba_bec_numMemb")[0] ?? null;
if (!$ba_bec_comment) {
    $_SESSION['error'] = 'Vous ne pouvez pas supprimer ce commentaire.';
    header('Location: ' . ROOT_URL . '/compte.php');
    exit();
}

sql_update('comment', "delLogiq = 1, dtDelLogCom = NOW()", "numCom = $ba_bec_numCom AND numMemb = $ba_bec_numMemb");
$_SESSION['success'] = 'Votre commentaire a été masqué.';
header('Location: ' . ROOT_URL . '/compte.php');
exit();
