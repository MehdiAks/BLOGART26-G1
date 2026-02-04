<?php
function sql_register_missing_table($table){
    if(!$table){
        return;
    }
    if(!isset($GLOBALS['SQL_MISSING_TABLES'])){
        $GLOBALS['SQL_MISSING_TABLES'] = [];
    }
    $table = strtoupper($table);
    if(!in_array($table, $GLOBALS['SQL_MISSING_TABLES'], true)){
        $GLOBALS['SQL_MISSING_TABLES'][] = $table;
    }
}

function sql_is_missing_table($table){
    $table = strtoupper($table);
    return in_array($table, $GLOBALS['SQL_MISSING_TABLES'] ?? [], true);
}

function sql_parse_missing_table($message){
    if(preg_match("/Table '.*?\\.([^']+)' doesn't exist/i", $message, $matches)){
        return $matches[1];
    }
    return null;
}

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

    try{
        $ba_bec_result = $DB->query($query);
        
        $ba_bec_error = $DB->errorInfo();
        if($ba_bec_error[0] != 0){
            echo("Error: " . $ba_bec_error[2]);
        }else{
            $ba_bec_result = $ba_bec_result->fetchAll();
        }
    }catch(PDOException $exception){
        $ba_bec_error_message = $exception->getMessage();
        if($exception->getCode() === '42S02' || stripos($ba_bec_error_message, 'Base table or view not found') !== false){
            $ba_bec_missing_table = sql_parse_missing_table($ba_bec_error_message);
            if(!$ba_bec_missing_table){
                $ba_bec_missing_table = $table;
            }
            sql_register_missing_table($ba_bec_missing_table);
            $ba_bec_result = [];
        }else{
            echo("Error: " . $ba_bec_error_message);
            $ba_bec_result = [];
        }
    }

    if(!$ba_bec_result){
        $ba_bec_result = array();
    }

    //return result
    return $ba_bec_result;
}
?>
