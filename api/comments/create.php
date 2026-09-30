<?php
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
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$ba_bec_libCom = ctrlSaisies($_POST['libCom'] ?? '');
$ba_bec_numArt = (int) ($_POST['numArt'] ?? 0);
$ba_bec_numMemb = array_key_exists('numMemb', $_POST)
    ? (int) $_POST['numMemb']
    : current_user_id();

// Valide le contenu et les deux clés étrangères avant la création modérée.
if ($ba_bec_libCom === '' || $ba_bec_numArt <= 0 || !$ba_bec_numMemb) {
    http_response_code(400);
    exit('Commentaire, article ou membre invalide.');
}
$ba_bec_article = sql_select('ARTICLE', 'numArt', 'numArt = ?', null, null, '1', [$ba_bec_numArt])[0] ?? null;
$ba_bec_member = sql_select('MEMBRE', 'numMemb', 'numMemb = ?', null, null, '1', [$ba_bec_numMemb])[0] ?? null;
if (!$ba_bec_article || !$ba_bec_member) {
    http_response_code(400);
    exit('Article ou membre introuvable.');
}

$ba_bec_result = sql_insert('COMMENT', 'libCom, numArt, numMemb', '?, ?, ?', [$ba_bec_libCom, $ba_bec_numArt, $ba_bec_numMemb]);
if (!$ba_bec_result['success']) {
    http_response_code(500);
    exit('Impossible de créer le commentaire.');
}

header('Location: ../../views/backend/comments/list.php');
exit();

?>
