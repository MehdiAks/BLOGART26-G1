<?php
//ctrl saisies form avant import bdd
function ctrlSaisies($saisie){
    if ($saisie === null) {
        return '';
    }

    // Convertion caractères spéciaux en entités HTML => peu performant
    // Préférer htmlentities()
    $saisie = htmlspecialchars((string) $saisie, ENT_QUOTES);
    // Suppression des espaces (ou d'autres caractères) en début et fin de chaîne
    $saisie = trim($saisie);
    // Suppression des antislashs d'une chaîne
    $saisie = stripslashes($saisie);
    // Conversion des caractères spéciaux en entités HTML
    return $saisie;
}
?>