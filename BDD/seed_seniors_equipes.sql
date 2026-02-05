-- Script d'injection pour phpMyAdmin : équipes seniors + personnel + journées
-- Base cible : BLOGART26 (schéma sportif normalisé)

START TRANSACTION;

-- Club
INSERT INTO CLUB (nomClub, villeClub, estClubMaison)
SELECT 'BEC Basket', 'Bordeaux', 1
WHERE NOT EXISTS (
  SELECT 1 FROM CLUB WHERE nomClub = 'BEC Basket'
);
SET @numClub := (SELECT numClub FROM CLUB WHERE nomClub = 'BEC Basket' LIMIT 1);

-- Référentiels équipe
INSERT INTO CATEGORIE_EQUIPE (libCategorie)
SELECT 'Seniors'
WHERE NOT EXISTS (
  SELECT 1 FROM CATEGORIE_EQUIPE WHERE libCategorie = 'Seniors'
);
SET @numCategorieSeniors := (
  SELECT numCategorie FROM CATEGORIE_EQUIPE WHERE libCategorie = 'Seniors' LIMIT 1
);

INSERT INTO SECTION_EQUIPE (libSection)
SELECT 'Garçons'
WHERE NOT EXISTS (
  SELECT 1 FROM SECTION_EQUIPE WHERE libSection = 'Garçons'
);
INSERT INTO SECTION_EQUIPE (libSection)
SELECT 'Filles'
WHERE NOT EXISTS (
  SELECT 1 FROM SECTION_EQUIPE WHERE libSection = 'Filles'
);
SET @numSectionGarcons := (
  SELECT numSection FROM SECTION_EQUIPE WHERE libSection = 'Garçons' LIMIT 1
);
SET @numSectionFilles := (
  SELECT numSection FROM SECTION_EQUIPE WHERE libSection = 'Filles' LIMIT 1
);

INSERT INTO NIVEAU_EQUIPE (libNiveau)
SELECT 'Niveau 1'
WHERE NOT EXISTS (
  SELECT 1 FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 1'
);
INSERT INTO NIVEAU_EQUIPE (libNiveau)
SELECT 'Niveau 2'
WHERE NOT EXISTS (
  SELECT 1 FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 2'
);
INSERT INTO NIVEAU_EQUIPE (libNiveau)
SELECT 'Niveau 3'
WHERE NOT EXISTS (
  SELECT 1 FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 3'
);
INSERT INTO NIVEAU_EQUIPE (libNiveau)
SELECT 'Niveau 4'
WHERE NOT EXISTS (
  SELECT 1 FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 4'
);
SET @numNiveau1 := (SELECT numNiveau FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 1' LIMIT 1);
SET @numNiveau2 := (SELECT numNiveau FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 2' LIMIT 1);
SET @numNiveau3 := (SELECT numNiveau FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 3' LIMIT 1);
SET @numNiveau4 := (SELECT numNiveau FROM NIVEAU_EQUIPE WHERE libNiveau = 'Niveau 4' LIMIT 1);

-- Saison
INSERT INTO SAISON (libSaison, dateDebut, dateFin, estCourante)
SELECT '2025-2026', '2025-09-01', '2026-06-30', 1
WHERE NOT EXISTS (
  SELECT 1 FROM SAISON WHERE libSaison = '2025-2026'
);
SET @numSaison := (SELECT numSaison FROM SAISON WHERE libSaison = '2025-2026' LIMIT 1);

-- Équipes seniors garçons (1 à 4)
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SG1', 'Seniors Garçons 1', 'Seniors Garçons 1', @numCategorieSeniors, @numSectionGarcons, @numNiveau1, 'Équipe seniors garçons 1'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Garçons 1');
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SG2', 'Seniors Garçons 2', 'Seniors Garçons 2', @numCategorieSeniors, @numSectionGarcons, @numNiveau2, 'Équipe seniors garçons 2'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Garçons 2');
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SG3', 'Seniors Garçons 3', 'Seniors Garçons 3', @numCategorieSeniors, @numSectionGarcons, @numNiveau3, 'Équipe seniors garçons 3'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Garçons 3');
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SG4', 'Seniors Garçons 4', 'Seniors Garçons 4', @numCategorieSeniors, @numSectionGarcons, @numNiveau4, 'Équipe seniors garçons 4'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Garçons 4');

-- Équipes seniors filles (1 à 3)
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SF1', 'Seniors Filles 1', 'Seniors Filles 1', @numCategorieSeniors, @numSectionFilles, @numNiveau1, 'Équipe seniors filles 1'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Filles 1');
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SF2', 'Seniors Filles 2', 'Seniors Filles 2', @numCategorieSeniors, @numSectionFilles, @numNiveau2, 'Équipe seniors filles 2'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Filles 2');
INSERT INTO EQUIPE (numClub, codeEquipe, libEquipe, libEquipeComplet, numCategorie, numSection, numNiveau, descriptionEquipe)
SELECT @numClub, 'SF3', 'Seniors Filles 3', 'Seniors Filles 3', @numCategorieSeniors, @numSectionFilles, @numNiveau3, 'Équipe seniors filles 3'
WHERE NOT EXISTS (SELECT 1 FROM EQUIPE WHERE libEquipe = 'Seniors Filles 3');

SET @equipeSG1 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SG1' LIMIT 1);
SET @equipeSG2 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SG2' LIMIT 1);
SET @equipeSG3 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SG3' LIMIT 1);
SET @equipeSG4 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SG4' LIMIT 1);
SET @equipeSF1 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SF1' LIMIT 1);
SET @equipeSF2 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SF2' LIMIT 1);
SET @equipeSF3 := (SELECT numEquipe FROM EQUIPE WHERE codeEquipe = 'SF3' LIMIT 1);

-- Rôles du personnel
INSERT INTO ROLE_PERSONNEL (libRolePersonnel)
SELECT 'Membre du bureau'
WHERE NOT EXISTS (SELECT 1 FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Membre du bureau');
INSERT INTO ROLE_PERSONNEL (libRolePersonnel)
SELECT 'Coach'
WHERE NOT EXISTS (SELECT 1 FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Coach');
INSERT INTO ROLE_PERSONNEL (libRolePersonnel)
SELECT 'Commission technique'
WHERE NOT EXISTS (SELECT 1 FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Commission technique');
INSERT INTO ROLE_PERSONNEL (libRolePersonnel)
SELECT 'Team animation'
WHERE NOT EXISTS (SELECT 1 FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Team animation');
INSERT INTO ROLE_PERSONNEL (libRolePersonnel)
SELECT 'Team communication'
WHERE NOT EXISTS (SELECT 1 FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Team communication');

SET @roleBureau := (SELECT numRolePersonnel FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Membre du bureau' LIMIT 1);
SET @roleCoach := (SELECT numRolePersonnel FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Coach' LIMIT 1);
SET @roleCommission := (SELECT numRolePersonnel FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Commission technique' LIMIT 1);
SET @roleAnimation := (SELECT numRolePersonnel FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Team animation' LIMIT 1);
SET @roleCommunication := (SELECT numRolePersonnel FROM ROLE_PERSONNEL WHERE libRolePersonnel = 'Team communication' LIMIT 1);

-- Personnel : bureau
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Alex', 'Martin', 'alex.martin@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'alex.martin@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Camille', 'Durand', 'camille.durand@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'camille.durand@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Yanis', 'Bernard', 'yanis.bernard@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'yanis.bernard@becbasket.test');

SET @bureau1 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'alex.martin@becbasket.test' LIMIT 1);
SET @bureau2 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'camille.durand@becbasket.test' LIMIT 1);
SET @bureau3 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'yanis.bernard@becbasket.test' LIMIT 1);

-- Personnel : coaches
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Lina', 'Lopez', 'coach.sg1@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sg1@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Hugo', 'Petit', 'coach.sg2@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sg2@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Sarah', 'Morel', 'coach.sg3@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sg3@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Noah', 'Roux', 'coach.sg4@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sg4@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Chloé', 'Lefevre', 'coach.sf1@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sf1@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Emma', 'Garnier', 'coach.sf2@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sf2@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Lucas', 'Nguyen', 'coach.sf3@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'coach.sf3@becbasket.test');

SET @coachSG1 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sg1@becbasket.test' LIMIT 1);
SET @coachSG2 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sg2@becbasket.test' LIMIT 1);
SET @coachSG3 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sg3@becbasket.test' LIMIT 1);
SET @coachSG4 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sg4@becbasket.test' LIMIT 1);
SET @coachSF1 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sf1@becbasket.test' LIMIT 1);
SET @coachSF2 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sf2@becbasket.test' LIMIT 1);
SET @coachSF3 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'coach.sf3@becbasket.test' LIMIT 1);

-- Personnel : commission technique
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Marie', 'Blanc', 'commission1@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'commission1@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Nicolas', 'Faure', 'commission2@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'commission2@becbasket.test');
SET @commission1 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'commission1@becbasket.test' LIMIT 1);
SET @commission2 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'commission2@becbasket.test' LIMIT 1);

-- Personnel : team animation
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Julie', 'Renard', 'animation1@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'animation1@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Omar', 'Perrin', 'animation2@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'animation2@becbasket.test');
SET @animation1 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'animation1@becbasket.test' LIMIT 1);
SET @animation2 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'animation2@becbasket.test' LIMIT 1);

-- Personnel : team communication
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Lea', 'Benoit', 'communication1@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'communication1@becbasket.test');
INSERT INTO PERSONNEL (prenomPersonnel, nomPersonnel, emailPersonnel)
SELECT 'Theo', 'Carre', 'communication2@becbasket.test'
WHERE NOT EXISTS (SELECT 1 FROM PERSONNEL WHERE emailPersonnel = 'communication2@becbasket.test');
SET @communication1 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'communication1@becbasket.test' LIMIT 1);
SET @communication2 := (SELECT numPersonnel FROM PERSONNEL WHERE emailPersonnel = 'communication2@becbasket.test' LIMIT 1);

-- Affectations du bureau (toutes équipes)
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @bureau1, e.numEquipe, @numSaison, @roleBureau, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @bureau1 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleBureau AND a.numSaison = @numSaison
  );
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @bureau2, e.numEquipe, @numSaison, @roleBureau, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @bureau2 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleBureau AND a.numSaison = @numSaison
  );
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @bureau3, e.numEquipe, @numSaison, @roleBureau, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @bureau3 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleBureau AND a.numSaison = @numSaison
  );

-- Affectations des coachs par équipe
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSG1, @equipeSG1, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSG1 AND numEquipe = @equipeSG1 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSG2, @equipeSG2, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSG2 AND numEquipe = @equipeSG2 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSG3, @equipeSG3, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSG3 AND numEquipe = @equipeSG3 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSG4, @equipeSG4, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSG4 AND numEquipe = @equipeSG4 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSF1, @equipeSF1, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSF1 AND numEquipe = @equipeSF1 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSF2, @equipeSF2, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSF2 AND numEquipe = @equipeSF2 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @coachSF3, @equipeSF3, @numSaison, @roleCoach, '2025-09-01'
WHERE NOT EXISTS (
  SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE
  WHERE numPersonnel = @coachSF3 AND numEquipe = @equipeSF3 AND numRolePersonnel = @roleCoach AND numSaison = @numSaison
);

-- Commission technique (toutes équipes)
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @commission1, e.numEquipe, @numSaison, @roleCommission, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @commission1 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleCommission AND a.numSaison = @numSaison
  );
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @commission2, e.numEquipe, @numSaison, @roleCommission, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @commission2 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleCommission AND a.numSaison = @numSaison
  );

-- Team animation (toutes équipes)
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @animation1, e.numEquipe, @numSaison, @roleAnimation, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @animation1 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleAnimation AND a.numSaison = @numSaison
  );
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @animation2, e.numEquipe, @numSaison, @roleAnimation, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @animation2 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleAnimation AND a.numSaison = @numSaison
  );

-- Team communication (toutes équipes)
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @communication1, e.numEquipe, @numSaison, @roleCommunication, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @communication1 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleCommunication AND a.numSaison = @numSaison
  );
INSERT INTO AFFECTATION_PERSONNEL_EQUIPE (numPersonnel, numEquipe, numSaison, numRolePersonnel, dateDebut)
SELECT @communication2, e.numEquipe, @numSaison, @roleCommunication, '2025-09-01'
FROM EQUIPE e
WHERE e.codeEquipe IN ('SG1','SG2','SG3','SG4','SF1','SF2','SF3')
  AND NOT EXISTS (
    SELECT 1 FROM AFFECTATION_PERSONNEL_EQUIPE a
    WHERE a.numPersonnel = @communication2 AND a.numEquipe = e.numEquipe AND a.numRolePersonnel = @roleCommunication AND a.numSaison = @numSaison
  );

-- Journées : 2 par équipe (compétition + phase + journées)
INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Garçons 1'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 1');
SET @compSG1 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 1' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSG1, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSG1 AND libPhase = 'Phase régulière'
);
SET @phaseSG1 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSG1 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG1, 'Journée 1 - Seniors Garçons 1', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG1 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG1, 'Journée 2 - Seniors Garçons 1', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG1 AND numeroJournee = 2);

INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Garçons 2'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 2');
SET @compSG2 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 2' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSG2, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSG2 AND libPhase = 'Phase régulière'
);
SET @phaseSG2 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSG2 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG2, 'Journée 1 - Seniors Garçons 2', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG2 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG2, 'Journée 2 - Seniors Garçons 2', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG2 AND numeroJournee = 2);

INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Garçons 3'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 3');
SET @compSG3 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 3' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSG3, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSG3 AND libPhase = 'Phase régulière'
);
SET @phaseSG3 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSG3 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG3, 'Journée 1 - Seniors Garçons 3', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG3 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG3, 'Journée 2 - Seniors Garçons 3', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG3 AND numeroJournee = 2);

INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Garçons 4'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 4');
SET @compSG4 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Garçons 4' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSG4, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSG4 AND libPhase = 'Phase régulière'
);
SET @phaseSG4 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSG4 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG4, 'Journée 1 - Seniors Garçons 4', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG4 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSG4, 'Journée 2 - Seniors Garçons 4', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSG4 AND numeroJournee = 2);

INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Filles 1'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Filles 1');
SET @compSF1 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Filles 1' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSF1, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSF1 AND libPhase = 'Phase régulière'
);
SET @phaseSF1 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSF1 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSF1, 'Journée 1 - Seniors Filles 1', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSF1 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSF1, 'Journée 2 - Seniors Filles 1', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSF1 AND numeroJournee = 2);

INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Filles 2'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Filles 2');
SET @compSF2 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Filles 2' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSF2, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSF2 AND libPhase = 'Phase régulière'
);
SET @phaseSF2 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSF2 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSF2, 'Journée 1 - Seniors Filles 2', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSF2 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSF2, 'Journée 2 - Seniors Filles 2', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSF2 AND numeroJournee = 2);

INSERT INTO COMPETITION (numSaison, libCompetition)
SELECT @numSaison, 'Championnat Seniors Filles 3'
WHERE NOT EXISTS (SELECT 1 FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Filles 3');
SET @compSF3 := (SELECT numCompetition FROM COMPETITION WHERE libCompetition = 'Championnat Seniors Filles 3' LIMIT 1);
INSERT INTO PHASE_COMPETITION (numCompetition, libPhase, ordrePhase)
SELECT @compSF3, 'Phase régulière', 1
WHERE NOT EXISTS (
  SELECT 1 FROM PHASE_COMPETITION WHERE numCompetition = @compSF3 AND libPhase = 'Phase régulière'
);
SET @phaseSF3 := (SELECT numPhase FROM PHASE_COMPETITION WHERE numCompetition = @compSF3 AND libPhase = 'Phase régulière' LIMIT 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSF3, 'Journée 1 - Seniors Filles 3', 1
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSF3 AND numeroJournee = 1);
INSERT INTO JOURNEE (numPhase, libJournee, numeroJournee)
SELECT @phaseSF3, 'Journée 2 - Seniors Filles 3', 2
WHERE NOT EXISTS (SELECT 1 FROM JOURNEE WHERE numPhase = @phaseSF3 AND numeroJournee = 2);

COMMIT;
