<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ba_bec_pseudo = ctrlSaisies($_POST['pseudo']);
    $ba_bec_password = ctrlSaisies($_POST['password']);

    // Vérifier si l'utilisateur existe avec ce nom d'utilisateur
    $ba_bec_user = sql_select("MEMBRE", "*", "pseudoMemb = '$ba_bec_pseudo'");
    
    if ($ba_bec_user) {
        // Utiliser password_verify pour comparer le mot de passe saisi avec celui haché
        if (password_verify($ba_bec_password, $ba_bec_user[0]['passMemb'])) {
            $_SESSION['user_id'] = $ba_bec_user[0]['numMemb'];
            $_SESSION['pseudoMemb'] = $ba_bec_user[0]['pseudoMemb'];

            header("Location: " . ROOT_URL . "/index.php");
            $_SESSION['pseudoMemb'] = $ba_bec_pseudo; // Stocke le nom d'utilisateur en session
            exit();
        } else {
            header("Location: " . ROOT_URL . "/views/security/login.php?error=Mot de passe incorrect");
            exit();
        }
    } else {
        header("Location: " . ROOT_URL . "/views/security/login.php?error=Nom d'utilisateur ou mot de passe incorrect");
        exit();
    }
}
?>
