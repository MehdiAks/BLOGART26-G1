<?php
// Mise à jour d'enregistrements en base.
function sql_update($table, $attributs, $where, array $params = []) {
    global $DB;
    sql_clear_last_error();

    // Connexion à la base si nécessaire.
    if(!$DB){
        sql_connect();
    }

    try{
        // Transaction pour sécuriser la mise à jour.
        $DB->beginTransaction();

        // Préparation de la requête UPDATE.
        $query = "UPDATE $table SET $attributs WHERE $where;";
        $request = $DB->prepare($query);
        $request->execute($params);
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
        error_log('Erreur SQL UPDATE: ' . $ba_bec_message);
        sql_set_last_error('Une erreur de base de données est survenue.');
        return ['success' => false, 'message' => 'Une erreur de base de données est survenue.'];
    }

    $ba_bec_error = $DB->errorInfo();
    if($ba_bec_error[0] != 0){
        // Remonte l'erreur SQL si elle existe.
        $ba_bec_message = $ba_bec_error[2];
        error_log('Erreur SQL UPDATE: ' . $ba_bec_message);
        sql_set_last_error('Une erreur de base de données est survenue.');
        return ['success' => false, 'message' => 'Une erreur de base de données est survenue.'];
    }
    // Retourne un statut explicite pour l'appelant.
    return ['success' => true, 'message' => 'Opération réalisée avec succès.'];
}

?>
