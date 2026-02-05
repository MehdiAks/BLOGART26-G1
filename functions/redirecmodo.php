<?php
$ba_bec_numStat = $_SESSION['numStat'] ?? null;

if ($ba_bec_numStat === null) {
    header("Location: " . ROOT_URL . "/views/backend/security/login.php");
    exit();
}

if ((int)$ba_bec_numStat !== 1) {
    header("Location: " . ROOT_URL . "/views/backend/security/login.php");
    exit();
}
?>
