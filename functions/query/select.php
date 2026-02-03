<?php
// select instances
function sql_select($table, $attributs = '*', $where = null, $group = null, $order = null, $limit = null){
    global $DB;

    //connect to database
    if(!$DB){
        sql_connect();
    }

    //no prepare query for PDO
    $query = "SELECT " . $attributs . " FROM $table";
    if($where){
        $query .= " WHERE $where";
    }
    if($group){
        $query .= " GROUP BY $group";
    }
    if($order){
        $query .= " ORDER BY $order";
    }
    if($limit){
        $query .= " LIMIT $limit";
    }

    $ba_bec_result = $DB->query($query);
    
    $ba_bec_error = $DB->errorInfo();
    if($ba_bec_error[0] != 0){
        echo("Error: " . $ba_bec_error[2]);
    }else{
        $ba_bec_result = $ba_bec_result->fetchAll();
    }

    if(!$ba_bec_result){
        $ba_bec_result = array();
    }

    //return result
    return $ba_bec_result;
}
?>
