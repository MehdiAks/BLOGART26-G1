<?php // Ouvre le mode PHP pour exécuter du code serveur.
/*
 * Endpoint API: api/statuts/create.php
 * Rôle: crée un(e) statut en base.
 *
 * Déroulé détaillé:
 * 1) Charge la configuration applicative et les helpers (session/DB/sanitisation).
 * 2) Récupère les paramètres POST (et éventuellement FILES) puis les nettoie via ctrlSaisies.
 * 3) Valide les contraintes métier (champs obligatoires, types, formats, tailles).
 * 4) Exécute la requête SQL adaptée (INSERT/UPDATE/DELETE) avec les valeurs préparées.
 * 5) Gère le feedback (flash/session/erreur) et redirige l'utilisateur vers l'écran cible.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale via un chemin absolu du serveur.
require_once '../../functions/ctrlSaisies.php'; // Importe la fonction de nettoyage/sécurisation des saisies.

$ba_bec_libStat = ctrlSaisies($_POST['libStat'] ?? ''); // Récupère libStat depuis POST, valeur vide si absente, puis la nettoie.

if ($ba_bec_libStat === '') { // Vérifie que le libellé n'est pas vide.
    http_response_code(400); // Définit le code HTTP 400 pour signaler une mauvaise requête.
    echo "Le nom du statut est requis."; // Envoie un message d'erreur au client.
    exit; // Stoppe immédiatement l'exécution du script.
} // Fin du contrôle du champ obligatoire.

$ba_bec_currentMax = sql_select('STATUT', 'MAX(numStat) AS maxStat'); // Demande le plus grand numStat existant.
$ba_bec_nextNumStat = 1; // Initialise la valeur par défaut du prochain numéro de statut.
if (!empty($ba_bec_currentMax) && isset($ba_bec_currentMax[0]['maxStat'])) { // Vérifie que la requête a retourné un résultat exploitable.
    $ba_bec_nextNumStat = (int)$ba_bec_currentMax[0]['maxStat'] + 1; // Calcule le prochain numéro en incrémentant le maximum.
} // Fin du calcul conditionnel du prochain numéro.

$ba_bec_result = sql_insert('STATUT', 'numStat, libStat', "'$ba_bec_nextNumStat', '$ba_bec_libStat'"); // Insère le nouveau statut en base.
if ($ba_bec_result['success']) { // Vérifie si l'insertion a réussi.
    flash_success(); // Pose un message flash de succès pour l'utilisateur.
} else { // Branche exécutée en cas d'échec de l'insertion.
    flash_error(); // Pose un message flash d'erreur pour l'utilisateur.
} // Fin du traitement du résultat d'insertion.

header('Location: ../../views/backend/statuts/list.php'); // Redirige vers la liste des statuts côté back-office.

// Fin du script PHP.
?>
