<?php // Démarre l'interpréteur PHP pour ce script.
/*
 * Endpoint API: api/comments/create.php
 * Rôle: crée un(e) comment en base.
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

$ba_bec_libCom = ctrlSaisies($_POST['libCom']); // Nettoie le texte du commentaire reçu en POST.
$ba_bec_numArt = ctrlSaisies($_POST['numArt']); // Nettoie l'identifiant de l'article reçu en POST.
$ba_bec_numMemb = ctrlSaisies($_POST['numMemb']); // Nettoie l'identifiant du membre reçu en POST.

sql_insert('comment', 'libCom, numArt, numMemb', "'$ba_bec_libCom', '$ba_bec_numArt', '$ba_bec_numMemb'"); // Insère le commentaire en base avec les valeurs nettoyées.

header('Location: ../../views/backend/comments/list.php'); // Redirige vers la liste des commentaires côté back-office.

?> // Termine le script PHP.
