<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
include '../../header.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    
    // Vérification des champs
    $ba_bec_pseudoMemb = isset($_POST['pseudoMemb']) ? ctrlSaisies($_POST['pseudoMemb']) : null;
    $ba_bec_prenomMemb = isset($_POST['prenomMemb']) ? ctrlSaisies($_POST['prenomMemb']) : null;
    $ba_bec_nomMemb = isset($_POST['nomMemb']) ? ctrlSaisies($_POST['nomMemb']) : null;
    $ba_bec_passMemb = $_POST['passMemb'] ?? '';
    $ba_bec_passMemb2 = $_POST['passMemb2'] ?? '';
    $ba_bec_eMailMemb = isset($_POST['eMailMemb']) ? ctrlSaisies($_POST['eMailMemb']) : null;
    $ba_bec_eMailMemb2 = isset($_POST['eMailMemb2']) ? ctrlSaisies($_POST['eMailMemb2']) : null;
    $ba_bec_accordMemb = isset($_POST['accordMemb']) ? ctrlSaisies($_POST['accordMemb']) : null;
    $ba_bec_numStat = isset($_POST['numStat']) ? ctrlSaisies($_POST['numStat']) : null;

    $ba_bec_errors = [];

    $ba_bec_recaptcha = verifyRecaptcha($_POST['g-recaptcha-response'] ?? '', 'create');
    if (!$ba_bec_recaptcha['valid']) {
        $ba_bec_errors[] = $ba_bec_recaptcha['message'] ?: 'Échec de la vérification reCAPTCHA.';
    }

    // Vérification nom et prénom
    if (empty($ba_bec_prenomMemb)) {
        $ba_bec_errors[] = "Le prénom est obligatoire.";
    }

    if (empty($ba_bec_nomMemb)) {
        $ba_bec_errors[] = "Le nom est obligatoire.";
    }

    // Vérification nom d'utilisateur
    if (strlen($ba_bec_pseudoMemb) < 6 || strlen($ba_bec_pseudoMemb) > 70) {
        $ba_bec_errors[] = "Erreur, le nom d'utilisateur doit contenir entre 6 et 70 caractères.";
    } else {
        $ba_bec_verif = sql_select('MEMBRE', 'pseudoMemb', "pseudoMemb = '$ba_bec_pseudoMemb'");
        if (!empty($ba_bec_verif)) {
            $ba_bec_errors[] = "Veuillez choisir un nom d'utilisateur disponible.";
            $ba_bec_pseudoMemb = null;
        }
    }

    // Vérification mot de passe
    if (strlen($ba_bec_passMemb) < 8 || strlen($ba_bec_passMemb) > 15) {
        $ba_bec_errors[] = "Le mot de passe doit contenir entre 8 et 15 caractères.";
        $ba_bec_passMemb = null;
    } elseif (
        !preg_match('/[A-Z]/', $ba_bec_passMemb) ||
        !preg_match('/[a-z]/', $ba_bec_passMemb) ||
        !preg_match('/[0-9]/', $ba_bec_passMemb) ||
        !preg_match('/[^a-zA-Z0-9]/', $ba_bec_passMemb)
    ) {
        $ba_bec_errors[] = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.";
        $ba_bec_passMemb = null;
    }

    if ($ba_bec_passMemb !== $ba_bec_passMemb2) {
        $ba_bec_errors[] = "Les mots de passe doivent être identiques.";
        $ba_bec_passMemb = null;

    }

    if ($ba_bec_passMemb) {
        $ba_bec_hash_password = password_hash($ba_bec_passMemb, PASSWORD_DEFAULT);
    }

    // Vérification Email
    if (!filter_var($ba_bec_eMailMemb, FILTER_VALIDATE_EMAIL)) {
        $ba_bec_errors[] = "$ba_bec_eMailMemb n'est pas une adresse mail valide.";
    }

    if ($ba_bec_eMailMemb !== $ba_bec_eMailMemb2) {
        $ba_bec_errors[] = "Les adresses mail doivent être identiques.";
        $ba_bec_eMailMemb = null;
    } elseif (!empty(sql_select('MEMBRE', 'eMailMemb', "eMailMemb = '$ba_bec_eMailMemb'"))) {
        $ba_bec_errors[] = "Cette adresse email est déjà utilisée.";
        $ba_bec_eMailMemb = null;
    }

    // Vérification Accord
    if ($ba_bec_accordMemb !== 'OUI') {
        $ba_bec_errors[] = "Veuillez accepter de partager vos données.";
    }
    $ba_bec_admin_exist = sql_select('MEMBRE', 'numMemb', "numStat = 1");

    if (!empty($ba_bec_admin_exist) && $ba_bec_numStat == 1) { 
        $ba_bec_errors[] = "Il y a déjà un administrateur, vous ne pouvez pas en créer un autre.";
        $ba_bec_numStat = null;
    }


    // Vérification complète avant insertion
    if (empty($ba_bec_errors) && isset($ba_bec_pseudoMemb, $ba_bec_prenomMemb, $ba_bec_nomMemb, $ba_bec_hash_password, $ba_bec_eMailMemb, $ba_bec_numStat)) {
        $ba_bec_dtCreaMemb = date('Y-m-d H:i:s');
        sql_insert(
            'MEMBRE',
            'prenomMemb, nomMemb, pseudoMemb, passMemb, eMailMemb, dtCreaMemb, accordMemb, numStat',
            "'$ba_bec_prenomMemb', '$ba_bec_nomMemb', '$ba_bec_pseudoMemb', '$ba_bec_hash_password', '$ba_bec_eMailMemb', '$ba_bec_dtCreaMemb', '1', '$ba_bec_numStat'"
        );
        header('Location: ../../views/backend/members/list.php');
        exit();

    }

}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($ba_bec_errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($ba_bec_errors as $ba_bec_error): ?>
                            <li><?= $ba_bec_error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
