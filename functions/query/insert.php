<?php
// insert instance
function sql_insert($table, $attributs, $values){
    global $DB;

    //connect to database
    if(!$DB){
        sql_connect();
    }

    try{
        $DB->beginTransaction();

        //prepare query for PDO
        $query = "INSERT INTO $table ($attributs) VALUES ($values);";
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