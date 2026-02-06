<?php // Démarre l'interpréteur PHP pour ce script.
/*
 * Endpoint API: api/comments/delete.php
 * Rôle: supprime (ou marque supprimé) un(e) comment.
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

sql_delete('comment', "numCom = $ba_bec_numCom"); // Supprime le commentaire correspondant en base.

header('Location: ../../views/backend/comments/list.php'); // Redirige vers la liste des commentaires côté back-office.

?> // Termine le script PHP.
