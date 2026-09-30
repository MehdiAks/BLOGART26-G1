<?php
/*
 * Endpoint API: api/thematiques/update.php
 * Rôle: met à jour un(e) thematique existant(e).
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

$ba_bec_numThem = (int) ($_POST['numThem'] ?? 0);
$ba_bec_libThem = ctrlSaisies($_POST['libThem']);

$ba_bec_result = sql_update('THEMATIQUE', 'libThem = ?', 'numThem = ?', [$ba_bec_libThem, $ba_bec_numThem]);
if ($ba_bec_result['success']) {
    flash_success();
} else {
    flash_error();
}

header('Location: ../../views/backend/thematiques/list.php');

?>
