<?php
// update instance
function sql_update($table, $attributs, $where) {
    global $DB;
    sql_clear_last_error();

    //connect to database
    if(!$DB){
        sql_connect();
    }

    try{
        $DB->beginTransaction();

        //prepare query for PDO
        $query = "UPDATE $table SET $attributs WHERE $where;";
        $request = $DB->prepare($query);
        $request->execute();
        $DB->commit();
        $request->closeCursor();
    }
    catch(PDOException $ba_bec_e){
        $DB->rollBack();
        if (isset($request)) {
            $request->closeCursor();
        }
        $ba_bec_message = $ba_bec_e->getMessage();
        sql_set_last_error($ba_bec_message);
        return ['success' => false, 'message' => $ba_bec_message];
    }

    $ba_bec_error = $DB->errorInfo();
    if($ba_bec_error[0] != 0){
        $ba_bec_message = $ba_bec_error[2];
        sql_set_last_error($ba_bec_message);
        return ['success' => false, 'message' => $ba_bec_message];
    }
    return ['success' => true, 'message' => 'Opération réalisée avec succès.'];
}

?>