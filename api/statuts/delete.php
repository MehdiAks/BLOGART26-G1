<?php // Ouvre le mode PHP pour exécuter du code serveur.
/*
 * Endpoint API: api/statuts/delete.php
 * Rôle: supprime (ou marque supprimé) un(e) statut.
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

$ba_bec_numStat = ctrlSaisies($_POST['numStat']); // Récupère numStat depuis POST et le nettoie.

// Vérifie si le statut est utilisé.
$ba_bec_countnumStat = sql_select("MEMBRE", "COUNT(*) AS total", "numStat = $ba_bec_numStat")[0]['total']; // Compte les membres qui référencent ce statut.

if ($ba_bec_countnumStat > 0) { // Si des membres utilisent ce statut, on bloque la suppression.
    // Redirection avec message d'erreur.
    flash_delete_impossible(); // Définit un message flash indiquant que la suppression est impossible.
    header('Location: ../../views/backend/statuts/list.php'); // Redirige vers la liste des statuts.
    exit; // Stoppe l'exécution pour ne pas continuer la suppression.
} // Fin du bloc de blocage de suppression.

// Si le statut n'est pas utilisé, suppression.
$ba_bec_result = sql_delete('STATUT', "numStat = $ba_bec_numStat"); // Supprime le statut correspondant en base.
if ($ba_bec_result['success']) { // Vérifie si la suppression a réussi.
    flash_success(); // Pose un message flash de succès pour l'utilisateur.
} else { // Branche exécutée en cas d'échec de suppression.
    flash_error(); // Pose un message flash d'erreur pour l'utilisateur.
} // Fin du traitement du résultat de suppression.

header('Location: ../../views/backend/statuts/list.php'); // Redirige vers la liste des statuts côté back-office.
exit; // Termine le script après la redirection.

// Fin du script PHP.
?>
