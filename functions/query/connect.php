<?php
// Gestion de la connexion PDO.
function sql_connect(){
    global $DB;

    // Connexion BDD via PDO avec encodage UTF-8.
    $pdoOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $DB = new PDO('mysql:host=' . SQL_HOST . ';charset=utf8mb4;dbname=' . SQL_DB . ';port=' . SQL_PORT, SQL_USER, SQL_PWD, $pdoOptions);
}


?>
