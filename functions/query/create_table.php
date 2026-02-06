<?php
// Gestionnaire de création de schémas pour les tables SQL.
function sql_create_table($table){
    global $DB;

    // S'assure que la connexion PDO est initialisée.
    if(!$DB){
        sql_connect();
    }

    // Normalise le nom de table pour l'index des schémas.
    $table = strtoupper($table);
    // Définition des schémas disponibles (par domaine fonctionnel).
    $schemas = [
        'EQUIPE' => [
            "CREATE TABLE IF NOT EXISTS `CLUB` (
                `numClub` int NOT NULL AUTO_INCREMENT,
                `nomClub` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `villeClub` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estClubMaison` tinyint(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`numClub`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `CATEGORIE_EQUIPE` (
                `numCategorie` int NOT NULL AUTO_INCREMENT,
                `libCategorie` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`numCategorie`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `SECTION_EQUIPE` (
                `numSection` int NOT NULL AUTO_INCREMENT,
                `libSection` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`numSection`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `NIVEAU_EQUIPE` (
                `numNiveau` int NOT NULL AUTO_INCREMENT,
                `libNiveau` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`numNiveau`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `EQUIPE` (
                `numEquipe` int NOT NULL AUTO_INCREMENT,
                `numClub` int NOT NULL,
                `codeEquipe` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `libEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `libEquipeComplet` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `numCategorie` int NOT NULL,
                `numSection` int NOT NULL,
                `numNiveau` int NOT NULL,
                `descriptionEquipe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                `urlPhotoEquipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `urlPhotoStaff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`numEquipe`),
                KEY `idx_equipe_club` (`numClub`),
                KEY `idx_equipe_categorie` (`numCategorie`),
                KEY `idx_equipe_section` (`numSection`),
                KEY `idx_equipe_niveau` (`numNiveau`),
                CONSTRAINT `fk_equipe_club` FOREIGN KEY (`numClub`) REFERENCES `CLUB` (`numClub`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_equipe_categorie` FOREIGN KEY (`numCategorie`) REFERENCES `CATEGORIE_EQUIPE` (`numCategorie`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_equipe_section` FOREIGN KEY (`numSection`) REFERENCES `SECTION_EQUIPE` (`numSection`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_equipe_niveau` FOREIGN KEY (`numNiveau`) REFERENCES `NIVEAU_EQUIPE` (`numNiveau`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        ],
        'JOUEUR' => [
            "CREATE TABLE IF NOT EXISTS `POSTE` (
                `numPoste` int NOT NULL AUTO_INCREMENT,
                `libPoste` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`numPoste`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `SAISON` (
                `numSaison` int NOT NULL AUTO_INCREMENT,
                `libSaison` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `dateDebut` date DEFAULT NULL,
                `dateFin` date DEFAULT NULL,
                `estCourante` tinyint(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`numSaison`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `JOUEUR` (
                `numJoueur` int NOT NULL AUTO_INCREMENT,
                `prenomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `nomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `urlPhotoJoueur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `dateNaissance` date DEFAULT NULL,
                PRIMARY KEY (`numJoueur`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `JOUEUR_AFFECTATION` (
                `numAffectation` int NOT NULL AUTO_INCREMENT,
                `numJoueur` int NOT NULL,
                `numEquipe` int NOT NULL,
                `numSaison` int NOT NULL,
                `numPoste` int DEFAULT NULL,
                `numMaillot` int DEFAULT NULL,
                `dateDebut` date DEFAULT NULL,
                `dateFin` date DEFAULT NULL,
                PRIMARY KEY (`numAffectation`),
                KEY `idx_affectation_joueur` (`numJoueur`),
                KEY `idx_affectation_equipe` (`numEquipe`),
                KEY `idx_affectation_saison` (`numSaison`),
                KEY `idx_affectation_poste` (`numPoste`),
                CONSTRAINT `fk_affectation_joueur` FOREIGN KEY (`numJoueur`) REFERENCES `JOUEUR` (`numJoueur`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_equipe` FOREIGN KEY (`numEquipe`) REFERENCES `EQUIPE` (`numEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_saison` FOREIGN KEY (`numSaison`) REFERENCES `SAISON` (`numSaison`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_poste` FOREIGN KEY (`numPoste`) REFERENCES `POSTE` (`numPoste`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `JOUEUR_AFFECTATION_POSTE` (
                `numAffectation` int NOT NULL,
                `numPoste` int NOT NULL,
                PRIMARY KEY (`numAffectation`, `numPoste`),
                KEY `idx_affectation_poste_poste` (`numPoste`),
                CONSTRAINT `fk_affectation_poste_affectation` FOREIGN KEY (`numAffectation`) REFERENCES `JOUEUR_AFFECTATION` (`numAffectation`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_poste_poste` FOREIGN KEY (`numPoste`) REFERENCES `POSTE` (`numPoste`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `JOUEUR_CLUB` (
                `numJoueurClub` int NOT NULL AUTO_INCREMENT,
                `numJoueur` int NOT NULL,
                `numClub` int NOT NULL,
                `dateDebut` date DEFAULT NULL,
                `dateFin` date DEFAULT NULL,
                `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                PRIMARY KEY (`numJoueurClub`),
                KEY `idx_joueur_club_joueur` (`numJoueur`),
                KEY `idx_joueur_club_club` (`numClub`),
                CONSTRAINT `fk_joueur_club_joueur` FOREIGN KEY (`numJoueur`) REFERENCES `JOUEUR` (`numJoueur`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_joueur_club_club` FOREIGN KEY (`numClub`) REFERENCES `CLUB` (`numClub`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        ],
        'JOUEUR_AFFECTATION_POSTE' => [
            "CREATE TABLE IF NOT EXISTS `JOUEUR_AFFECTATION_POSTE` (
                `numAffectation` int NOT NULL,
                `numPoste` int NOT NULL,
                PRIMARY KEY (`numAffectation`, `numPoste`),
                KEY `idx_affectation_poste_poste` (`numPoste`),
                CONSTRAINT `fk_affectation_poste_affectation` FOREIGN KEY (`numAffectation`) REFERENCES `JOUEUR_AFFECTATION` (`numAffectation`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_poste_poste` FOREIGN KEY (`numPoste`) REFERENCES `POSTE` (`numPoste`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        ],
        'PERSONNEL' => [
            "CREATE TABLE IF NOT EXISTS `ROLE_PERSONNEL` (
                `numRolePersonnel` int NOT NULL AUTO_INCREMENT,
                `libRolePersonnel` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`numRolePersonnel`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `PERSONNEL` (
                `numPersonnel` int NOT NULL AUTO_INCREMENT,
                `prenomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `nomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `urlPhotoPersonnel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `emailPersonnel` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `telephonePersonnel` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estStaffEquipe` tinyint(1) NOT NULL DEFAULT 0,
                `numEquipeStaff` int DEFAULT NULL,
                `roleStaffEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estDirection` tinyint(1) NOT NULL DEFAULT 0,
                `posteDirection` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estCommissionTechnique` tinyint(1) NOT NULL DEFAULT 0,
                `posteCommissionTechnique` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estCommissionAnimation` tinyint(1) NOT NULL DEFAULT 0,
                `posteCommissionAnimation` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estCommissionCommunication` tinyint(1) NOT NULL DEFAULT 0,
                `posteCommissionCommunication` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`numPersonnel`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `AFFECTATION_PERSONNEL_EQUIPE` (
                `numAffectation` int NOT NULL AUTO_INCREMENT,
                `numPersonnel` int NOT NULL,
                `numEquipe` int NOT NULL,
                `numSaison` int NOT NULL,
                `numRolePersonnel` int NOT NULL,
                `dateDebut` date DEFAULT NULL,
                `dateFin` date DEFAULT NULL,
                PRIMARY KEY (`numAffectation`),
                KEY `idx_affectation_personnel` (`numPersonnel`),
                KEY `idx_affectation_equipe` (`numEquipe`),
                KEY `idx_affectation_saison` (`numSaison`),
                KEY `idx_affectation_role` (`numRolePersonnel`),
                CONSTRAINT `fk_affectation_personnel` FOREIGN KEY (`numPersonnel`) REFERENCES `PERSONNEL` (`numPersonnel`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_personnel_equipe` FOREIGN KEY (`numEquipe`) REFERENCES `EQUIPE` (`numEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_personnel_saison` FOREIGN KEY (`numSaison`) REFERENCES `SAISON` (`numSaison`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_affectation_personnel_role` FOREIGN KEY (`numRolePersonnel`) REFERENCES `ROLE_PERSONNEL` (`numRolePersonnel`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        ],
        'MATCH' => [
            "CREATE TABLE IF NOT EXISTS `COMPETITION` (
                `numCompetition` int NOT NULL AUTO_INCREMENT,
                `numSaison` int NOT NULL,
                `libCompetition` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`numCompetition`),
                KEY `idx_competition_saison` (`numSaison`),
                CONSTRAINT `fk_competition_saison` FOREIGN KEY (`numSaison`) REFERENCES `SAISON` (`numSaison`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `PHASE_COMPETITION` (
                `numPhase` int NOT NULL AUTO_INCREMENT,
                `numCompetition` int NOT NULL,
                `libPhase` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `ordrePhase` int DEFAULT NULL,
                PRIMARY KEY (`numPhase`),
                KEY `idx_phase_competition` (`numCompetition`),
                CONSTRAINT `fk_phase_competition` FOREIGN KEY (`numCompetition`) REFERENCES `COMPETITION` (`numCompetition`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `JOURNEE` (
                `numJournee` int NOT NULL AUTO_INCREMENT,
                `numPhase` int NOT NULL,
                `libJournee` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `numeroJournee` int DEFAULT NULL,
                PRIMARY KEY (`numJournee`),
                KEY `idx_journee_phase` (`numPhase`),
                CONSTRAINT `fk_journee_phase` FOREIGN KEY (`numPhase`) REFERENCES `PHASE_COMPETITION` (`numPhase`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `MATCH` (
                `numMatch` int NOT NULL AUTO_INCREMENT,
                `numSaison` int NOT NULL,
                `numCompetition` int NOT NULL,
                `numPhase` int DEFAULT NULL,
                `numJournee` int DEFAULT NULL,
                `dateMatch` date NOT NULL,
                `heureMatch` time DEFAULT NULL,
                `lieuMatch` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`numMatch`),
                KEY `idx_match_saison` (`numSaison`),
                KEY `idx_match_competition` (`numCompetition`),
                KEY `idx_match_phase` (`numPhase`),
                KEY `idx_match_journee` (`numJournee`),
                CONSTRAINT `fk_match_saison` FOREIGN KEY (`numSaison`) REFERENCES `SAISON` (`numSaison`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_match_competition` FOREIGN KEY (`numCompetition`) REFERENCES `COMPETITION` (`numCompetition`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_match_phase` FOREIGN KEY (`numPhase`) REFERENCES `PHASE_COMPETITION` (`numPhase`) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT `fk_match_journee` FOREIGN KEY (`numJournee`) REFERENCES `JOURNEE` (`numJournee`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE IF NOT EXISTS `MATCH_PARTICIPANT` (
                `numMatchParticipant` int NOT NULL AUTO_INCREMENT,
                `numMatch` int NOT NULL,
                `numEquipe` int DEFAULT NULL,
                `cote` enum('domicile','exterieur') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                `score` int DEFAULT NULL,
                `nomEquipeAdverse` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `numeroEquipeAdverse` int DEFAULT NULL,
                PRIMARY KEY (`numMatchParticipant`),
                KEY `idx_match_participant_match` (`numMatch`),
                KEY `idx_match_participant_equipe` (`numEquipe`),
                CONSTRAINT `fk_match_participant_match` FOREIGN KEY (`numMatch`) REFERENCES `MATCH` (`numMatch`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_match_participant_equipe` FOREIGN KEY (`numEquipe`) REFERENCES `EQUIPE` (`numEquipe`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        ],
    ];

    // Si aucun schéma n'est défini, on sort proprement.
    if(!isset($schemas[$table])){
        return false;
    }

    try{
        // Exécute toutes les requêtes de création associées.
        $schema = $schemas[$table];
        if (is_array($schema)) {
            foreach ($schema as $statement) {
                $DB->exec($statement);
            }
        } else {
            $DB->exec($schema);
        }
        return true;
    }catch(PDOException $exception){
        // En cas d'erreur, on signale l'échec.
        return false;
    }
}
?>
