<?php
function sql_create_table($table){
    global $DB;

    if(!$DB){
        sql_connect();
    }

    $table = strtoupper($table);
    $schemas = [
        'EQUIPE' => "CREATE TABLE IF NOT EXISTS `EQUIPE` (
            `numEquipe` int NOT NULL AUTO_INCREMENT,
            `libEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `categorieEquipe` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `sectionEquipe` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `niveauEquipe` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `pointsMarquesDomicile` int NOT NULL DEFAULT 0,
            `pointsEncaissesDomicile` int NOT NULL DEFAULT 0,
            `pointsMarquesExterieur` int NOT NULL DEFAULT 0,
            `pointsEncaissesExterieur` int NOT NULL DEFAULT 0,
            PRIMARY KEY (`numEquipe`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        'EQUIPE_JOUEUR' => "CREATE TABLE IF NOT EXISTS `EQUIPE_JOUEUR` (
            `numEquipe` int NOT NULL,
            `numJoueur` int NOT NULL,
            PRIMARY KEY (`numEquipe`,`numJoueur`),
            KEY `idx_equipe_joueur` (`numJoueur`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        'EQUIPE_PERSONNEL' => "CREATE TABLE IF NOT EXISTS `EQUIPE_PERSONNEL` (
            `numEquipe` int NOT NULL,
            `numPersonnel` int NOT NULL,
            `libRoleEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`numEquipe`,`numPersonnel`,`libRoleEquipe`),
            KEY `idx_equipe_personnel` (`numPersonnel`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        'JOUEUR' => "CREATE TABLE IF NOT EXISTS `JOUEUR` (
            `numJoueur` int NOT NULL AUTO_INCREMENT,
            `prenomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `nomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `urlPhotoJoueur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `posteJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `numMaillot` int DEFAULT NULL,
            `anneeArrivee` year DEFAULT NULL,
            `clubsPrecedents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `dateNaissance` date DEFAULT NULL,
            PRIMARY KEY (`numJoueur`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        'PERSONNEL' => "CREATE TABLE IF NOT EXISTS `PERSONNEL` (
            `numPersonnel` int NOT NULL AUTO_INCREMENT,
            `prenomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `nomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `urlPhotoPersonnel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`numPersonnel`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    ];

    if(!isset($schemas[$table])){
        return false;
    }

    try{
        $DB->exec($schemas[$table]);
        return true;
    }catch(PDOException $exception){
        return false;
    }
}
?>
