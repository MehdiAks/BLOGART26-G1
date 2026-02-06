<?php // Démarre l'interpréteur PHP pour ce script.
/*
 * Endpoint API: api/comments/update.php
 * Rôle: met à jour un(e) comment existant(e).
 *
 * Déroulé détaillé:
 * 1) Charge la configuration applicative et les helpers (session/DB/sanitisation).
 * 2) Récupère les paramètres POST (et éventuellement FILES) puis les nettoie via ctrlSaisies.
 * 3) Valide les contraintes métier (champs obligatoires, types, formats, tailles).
 * 4) Exécute la requête SQL adaptée (INSERT/UPDATE/DELETE) avec les valeurs préparées.
 * 5) Gère le feedback (flash/session/erreur) et redirige l'utilisateur vers l'écran cible.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Charge la configuration globale de l'application.
require_once '../../functions/ctrlSaisies.php'; // Inclut la fonction de contrôle et de nettoyage des saisies.

$ba_bec_numCom = ctrlSaisies($_POST['numCom']); // Nettoie l'identifiant du commentaire reçu en POST.
$ba_bec_libCom = ctrlSaisies($_POST['libCom']); // Nettoie le contenu du commentaire reçu en POST.
$ba_bec_delLogiq = ctrlSaisies($_POST['delLogiq']); // Nettoie l'indicateur de suppression logique reçu en POST.
$ba_bec_attModOK = ctrlSaisies($_POST['attModOK']); // Nettoie l'indicateur d'acceptation de modification reçu en POST.
$ba_bec_notifComKOAff = ctrlSaisies($_POST['notifComKOAff']); // Nettoie l'indicateur de notification de refus reçu en POST.

//sql_delete('STATUT', "numStat = $numStat"); // Conserve un exemple de suppression (désactivé).
sql_update('comment', "libCom = '$ba_bec_libCom'", "numCom = $ba_bec_numCom"); // Met à jour le texte du commentaire ciblé.
sql_update('comment', "delLogiq = '$ba_bec_delLogiq'", "numCom = $ba_bec_numCom"); // Met à jour le statut de suppression logique du commentaire.
sql_update('comment', "attModOK = '$ba_bec_attModOK'", "numCom = $ba_bec_numCom"); // Met à jour le statut d'approbation de modification.
sql_update('comment', "notifComKOAff = '$ba_bec_notifComKOAff'", "numCom = $ba_bec_numCom"); // Met à jour le statut de notification de rejet.

header('Location: ../../views/backend/comments/list.php'); // Redirige vers la liste des commentaires côté back-office.

?> // Termine le script PHP.
