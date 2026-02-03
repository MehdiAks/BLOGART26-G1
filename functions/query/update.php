<?php
// update instance
function sql_update($table, $attributs, $where) {
    global $DB;

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
        $request->closeCursor();
        die('Error: ' . $ba_bec_e->getMessage());
    }

    $ba_bec_error = $DB->errorInfo();
    if($ba_bec_error[0] != 0){
        echo "Error: " . $ba_bec_error[2];
    }else{
        return true;
    }
}