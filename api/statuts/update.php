<?php // Ouvre le mode PHP pour exécuter du code serveur.
/*
 * Endpoint API: api/statuts/update.php
 * Rôle: met à jour un(e) statut existant(e).
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
$ba_bec_libStat = ctrlSaisies($_POST['libStat']); // Récupère libStat depuis POST et le nettoie.

// Ancien appel de suppression laissé en commentaire pour référence.
$ba_bec_result = sql_update(table: 'STATUT', attributs: 'libStat = "'.$ba_bec_libStat.'"' , where: "numStat = $ba_bec_numStat"); // Met à jour le libellé du statut ciblé.
if ($ba_bec_result['success']) { // Vérifie si la mise à jour a réussi.
    flash_success(); // Pose un message flash de succès pour l'utilisateur.
} else { // Branche exécutée en cas d'échec de la mise à jour.
    flash_error(); // Pose un message flash d'erreur pour l'utilisateur.
} // Fin du traitement du résultat de mise à jour.

header(header: 'Location: ../../views/backend/statuts/list.php'); // Redirige vers la liste des statuts côté back-office.

// Fin du script PHP.
?>
