<?php
// Insertion d'un enregistrement en base.
function sql_insert($table, $attributs, $values, array $params = []){
    global $DB;
    sql_clear_last_error();

    // Connexion à la base si nécessaire.
    if(!$DB){
        sql_connect();
    }

    try{
        // Transaction pour assurer la cohérence.
        $DB->beginTransaction();

        // Préparation de la requête INSERT.
        $query = "INSERT INTO $table ($attributs) VALUES ($values);";
        $request = $DB->prepare($query);
        $request->execute($params);
        // Capture l'identifiant avant le commit pour les pilotes qui le réinitialisent ensuite.
        $ba_bec_insertId = (int) $DB->lastInsertId();
        $DB->commit();
        $request->closeCursor();
    }
    catch(PDOException $ba_bec_e){
        if ($DB->inTransaction()) {
            $DB->rollBack();
        }
        if (isset($request)) {
            $request->closeCursor();
        }
        $ba_bec_message = $ba_bec_e->getMessage();
        error_log('Erreur SQL INSERT: ' . $ba_bec_message);
        sql_set_last_error('Une erreur de base de données est survenue.');
        return ['success' => false, 'message' => 'Une erreur de base de données est survenue.', 'id' => 0];
    }

    $ba_bec_error = $DB->errorInfo();
    if($ba_bec_error[0] != 0){
        // Remonte l'erreur SQL si elle existe.
        $ba_bec_message = $ba_bec_error[2];
        error_log('Erreur SQL INSERT: ' . $ba_bec_message);
        sql_set_last_error('Une erreur de base de données est survenue.');
        return ['success' => false, 'message' => 'Une erreur de base de données est survenue.', 'id' => 0];
    }
    // Retourne un statut explicite pour l'appelant.
    return ['success' => true, 'message' => 'Opération réalisée avec succès.', 'id' => $ba_bec_insertId];
}
?>
