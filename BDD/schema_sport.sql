-- Schéma dédié aux tables sportives (Equipes, Joueurs, Matchs, Benevoles)

CREATE TABLE `EQUIPE` (
  `numEquipe` int NOT NULL AUTO_INCREMENT,
  `codeEquipe` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `club` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bordeaux étudiant club',
  `categorie` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionEquipe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photoDLequipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photoStaff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codeEquipe`),
  UNIQUE KEY `uniq_equipe_num` (`numEquipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `JOUEUR` (
  `numJoueur` int NOT NULL AUTO_INCREMENT,
  `surnomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlPhotoJoueur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `codeEquipe` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posteJoueur` tinyint UNSIGNED NOT NULL,
  `numeroMaillot` int DEFAULT NULL,
  `dateRecrutement` date DEFAULT NULL,
  `clubsPrecedents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`surnomJoueur`),
  UNIQUE KEY `uniq_joueur_num` (`numJoueur`),
  KEY `idx_joueur_equipe` (`codeEquipe`),
  CONSTRAINT `fk_joueur_equipe` FOREIGN KEY (`codeEquipe`) REFERENCES `EQUIPE` (`codeEquipe`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `PERSONNEL` (
  `numPersonnel` int NOT NULL AUTO_INCREMENT,
  `surnomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlPhotoPersonnel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailPersonnel` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephonePersonnel` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estStaffEquipe` tinyint(1) NOT NULL DEFAULT 0,
  `numEquipeStaff` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roleStaffEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estDirection` tinyint(1) NOT NULL DEFAULT 0,
  `posteDirection` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estCommissionTechnique` tinyint(1) NOT NULL DEFAULT 0,
  `posteCommissionTechnique` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estCommissionAnimation` tinyint(1) NOT NULL DEFAULT 0,
  `posteCommissionAnimation` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estCommissionCommunication` tinyint(1) NOT NULL DEFAULT 0,
  `posteCommissionCommunication` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`surnomPersonnel`),
  UNIQUE KEY `uniq_personnel_num` (`numPersonnel`),
  KEY `idx_personnel_equipe` (`numEquipeStaff`),
  CONSTRAINT `fk_personnel_equipe` FOREIGN KEY (`numEquipeStaff`) REFERENCES `EQUIPE` (`codeEquipe`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `MATCH` (
  `numMatch` int NOT NULL AUTO_INCREMENT,
  `codeEquipe` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clubAdversaire` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numEquipeAdverse` int DEFAULT NULL,
  `saison` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phase` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `journee` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateMatch` date NOT NULL,
  `heureMatch` time DEFAULT NULL,
  `lieuMatch` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scoreBec` int DEFAULT NULL,
  `scoreAdversaire` int DEFAULT NULL,
  PRIMARY KEY (`numMatch`),
  KEY `idx_match_equipe` (`codeEquipe`),
  CONSTRAINT `fk_match_equipe` FOREIGN KEY (`codeEquipe`) REFERENCES `EQUIPE` (`codeEquipe`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
