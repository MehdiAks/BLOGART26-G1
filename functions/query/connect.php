<?php
// Gestion de la connexion PDO.
function sql_connect(){
    global $DB;

    // Connexion BDD via PDO avec encodage UTF-8.
    if (strpos($_SERVER['HTTP_HOST'], 'scalingo') !== false) {
        // Sur Scalingo, le port est fourni séparément.
        $DB = new PDO('mysql:host=' . SQL_HOST . ';charset=utf8;dbname=' . SQL_DB . ';port='. SQL_PORT, SQL_USER, SQL_PWD);
    } else {
        // En local, on garde la configuration standard.
        $DB = new PDO('mysql:host=' . SQL_HOST . ';charset=utf8;dbname=' . SQL_DB, SQL_USER, SQL_PWD);
    }

    

}

?>
