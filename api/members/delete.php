<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/backend/members/list.php');
    exit();
}

$ba_bec_numMemb = ctrlSaisies($_POST['numMemb'] ?? '');
$ba_bec_redirectUrl = '../../views/backend/members/delete.php';
if (!empty($ba_bec_numMemb)) {
    $ba_bec_redirectUrl .= '?numMemb=' . urlencode($ba_bec_numMemb);
}

$ba_bec_recaptcha = verifyRecaptcha($_POST['g-recaptcha-response'] ?? '', 'delete');
if (!$ba_bec_recaptcha['valid']) {
    $_SESSION['errors'] = [$ba_bec_recaptcha['message'] ?: 'Échec de la vérification reCAPTCHA.'];
    header('Location: ' . $ba_bec_redirectUrl);
    exit();
}

if (empty($ba_bec_numMemb)) {
    $_SESSION['errors'] = ['ID du membre manquant.'];
    header('Location: ' . $ba_bec_redirectUrl);
    exit();
}

$ba_bec_member = sql_select('MEMBRE', 'numStat', "numMemb = $ba_bec_numMemb");
if (empty($ba_bec_member)) {
    $_SESSION['errors'] = ['Membre introuvable.'];
    header('Location: ' . $ba_bec_redirectUrl);
    exit();
}

if ((int) $ba_bec_member[0]['numStat'] === 1) {
    $_SESSION['errors'] = ['Un administrateur ne peut pas être supprimé.'];
    header('Location: ' . $ba_bec_redirectUrl);
    exit();
}

sql_delete('COMMENT', "numMemb = $ba_bec_numMemb");
sql_delete('LIKEART', "numMemb = $ba_bec_numMemb");
sql_delete('MEMBRE', "numMemb = $ba_bec_numMemb");

header('Location: ../../views/backend/members/list.php');
