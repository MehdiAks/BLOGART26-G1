-- Inserts des matchs de la saison 2025-2026 (FFBB)
-- Mapping demandé:
-- NF3/PRF -> SF3 (numEquipe 7, numCompetition 7)
-- PNF -> SF2 (numEquipe 6, numCompetition 6)
-- PNM/RM2 -> SG2 (numEquipe 2, numCompetition 2)
-- DM3 -> SG3 (numEquipe 3, numCompetition 3)
-- DM4 -> SG4 (numEquipe 9, numCompetition 4)

START TRANSACTION;

-- PNM | Saison régulière | J1 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-09-20', '22:00:00', 'US CHARTRONS BORDEAUX');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 43, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 81, 'US CHARTRONS BORDEAUX', NULL);

-- RM2 | Saison régulière | J1 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-09-20', '22:00:00', 'BORDEAUX BASTIDE BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 67, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 60, 'BORDEAUX BASTIDE BASKET', NULL);

-- PRF | Saison régulière | J1 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-09-20', '22:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 64, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 50, 'SA GAZINET CESTAS', NULL);

-- DM3 | Saison régulière | J1 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-09-21', '15:00:00', 'ENTENTE SPORTIVE BLANQUEFORT - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', 102, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 48, 'ENTENTE SPORTIVE BLANQUEFORT - 2', NULL);

-- PNF | Saison régulière | J1 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-09-21', '17:00:00', 'BRESSUIRE LE REVEIL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BRESSUIRE LE REVEIL', NULL);

-- NF3 | Saison régulière | J1 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-09-21', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 75, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 40, 'ABB CORNEBARRIEU', NULL);

-- RM2 | Saison régulière | J2 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-09-27', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 69, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 88, 'UNION SPORTIVE TULLE CORREZE', NULL);

-- PRF | Saison régulière | J2 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-09-27', '22:00:00', 'US CHARTRONS BORDEAUX');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 79, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 33, 'US CHARTRONS BORDEAUX', NULL);

-- PNM | Saison régulière | J2 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-09-27', '22:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 68, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 52, 'AYTRE BASKET BALL', NULL);

-- DM3 | Saison régulière | J2 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-09-28', '15:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 61, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 60, 'STADE BORDELAIS', NULL);

-- PNF | Saison régulière | J2 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-09-28', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', 52, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 57, 'AYTRE BASKET BALL', NULL);

-- NF3 | Saison régulière | J2 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-09-28', '17:30:00', 'COTEAUX DU LUY BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 72, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 76, 'COTEAUX DU LUY BASKET', NULL);

-- PNM | Saison régulière | J3 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-10-04', '22:00:00', 'CASTELNAU MEDOC BC');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 90, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 105, 'CASTELNAU MEDOC BC', NULL);

-- RM2 | Saison régulière | J3 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-10-04', '22:00:00', 'UNION SAINT BRUNO BORDEAUX');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 52, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 70, 'UNION SAINT BRUNO BORDEAUX', NULL);

-- PRF | Saison régulière | J3 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-10-04', '22:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 45, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 52, 'US TALENCE', NULL);

-- PNF | Saison régulière | J3 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-10-05', '17:00:00', 'AMICALE LOISIRS CASTILLONNES BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', 52, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 47, 'AMICALE LOISIRS CASTILLONNES BASKET', NULL);

-- NF3 | Saison régulière | J3 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-10-05', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 82, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 62, 'ENTENTE PESSAC BASKET CLUB - 1', NULL);

-- DM3 | Saison régulière | J3 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-10-05', '19:00:00', 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', 72, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 49, 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3', NULL);

-- DM4 | Saison régulière | J3 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-10-05', '19:00:00', 'B.IZON - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', 34, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 41, 'B.IZON - 2', NULL);

-- RM2 | Saison régulière | J4 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-10-11', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 73, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 64, 'AIXE BC VAL DE VIENNE', NULL);

-- PNM | Saison régulière | J4 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-10-11', '22:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 57, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 67, 'CEP POITIERS', NULL);

-- PRF | Saison régulière | J4 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-10-11', '23:00:00', 'STE EULALIE BASKET BALL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 57, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 60, 'STE EULALIE BASKET BALL', NULL);

-- DM4 | Saison régulière | J4 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-10-12', '15:00:00', 'BC ST AVIT ST NAZAIRE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', 63, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 57, 'BC ST AVIT ST NAZAIRE', NULL);

-- PNF | Saison régulière | J4 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-10-12', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', 49, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 53, 'LIMOGES ABC EN LIMOUSIN - 2', NULL);

-- NF3 | Saison régulière | J4 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-10-12', '17:30:00', 'AS ST DELPHIN - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 74, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 73, 'AS ST DELPHIN - 2', NULL);

-- DM4 | Saison régulière | J1 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-10-19', '15:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', 46, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 49, 'COUTRAS GUITRES BASKET', NULL);

-- DM3 | Saison régulière | J4 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-10-19', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 83, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 64, 'BASKET CLUB MARCHEPRIME', NULL);

-- NF3 | Saison régulière | J5 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-10-26', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 69, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 53, 'HAGETMAU MOMUY CASTAIGNOS BASKET', NULL);

-- PNM | Saison régulière | J5 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-01', '21:00:00', 'JSA BORDEAUX BASKET - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 72, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 57, 'JSA BORDEAUX BASKET - 2', NULL);

-- RM2 | Saison régulière | J5 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-01', '21:00:00', 'AS ST DELPHIN');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 62, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 75, 'AS ST DELPHIN', NULL);

-- PRF | Saison régulière | J5 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-01', '21:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 54, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 42, 'IE - CTC SMB - SAM - SA MERIGNACAIS', NULL);

-- DM3 | Saison régulière | J5 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-11-02', '15:00:00', 'AS MARTIGNAS - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', 53, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 31, 'AS MARTIGNAS - 2', NULL);

-- PNF | Saison régulière | J5 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-11-02', '16:00:00', 'POUZIOUX VOUNEUIL/BIARD BC');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', 46, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 76, 'POUZIOUX VOUNEUIL/BIARD BC', NULL);

-- DM4 | Saison régulière | J5 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-11-02', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', 38, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 58, 'STE EULALIE BASKET BALL', NULL);

-- NF3 | Saison régulière | J6 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-02', '16:30:00', 'IE - AUCH BASKET CLUB - 1');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 75, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 42, 'IE - AUCH BASKET CLUB - 1', NULL);

-- DM3 | Saison régulière | J6 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-11-08', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 111, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 42, 'ENTENTE SPORTIVE BLANQUEFORT - 2', NULL);

-- RM2 | Saison régulière | J6 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-08', '21:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 79, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 65, 'CA BRIVE CORREZE SECTION BASKET', NULL);

-- PRF | Saison régulière | J6 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-08', '22:00:00', 'UNION SPORTIVE BREDOISE BASKET - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 48, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 58, 'UNION SPORTIVE BREDOISE BASKET - 2', NULL);

-- PNF | Saison régulière | J6 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-11-09', '14:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', 54, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 45, 'CA BRIVE CORREZE SECTION BASKET', NULL);

-- DM4 | Saison régulière | J6 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-11-09', '16:00:00', 'COUTRAS GUITRES BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', 34, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 48, 'COUTRAS GUITRES BASKET', NULL);

-- NF3 | Saison régulière | J7 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-09', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 95, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 43, 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', NULL);

-- PRF | Saison régulière | J7 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-15', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 49, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 52, 'LE TAILLAN BASKET - 2', NULL);

-- RM2 | Saison régulière | J7 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-15', '19:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 81, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 55, 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', NULL);

-- PNM | Saison régulière | J7 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-15', '21:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 74, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 66, 'COGNAC BASKET AVENIR', NULL);

-- PNF | Saison régulière | J7 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-11-16', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', 42, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 58, 'CA BEGLES', NULL);

-- DM3 | Saison régulière | J7 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-11-16', '16:00:00', 'STADE BORDELAIS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', 58, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 66, 'STADE BORDELAIS', NULL);

-- NF3 | Saison régulière | J8 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-16', '16:30:00', 'B. COMMINGES SALIES DU SALAT - 1');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 89, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 84, 'B. COMMINGES SALIES DU SALAT - 1', NULL);

-- PNM | Saison régulière | J8 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-27', '22:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 77, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 69, 'US CENON RIVE DROITE', NULL);

-- RM2 | Saison régulière | J8 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-11-29', '21:00:00', 'ES ST FRONT DE PRADOUX');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 74, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 61, 'ES ST FRONT DE PRADOUX', NULL);

-- PRF | Saison régulière | J8 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-29', '21:30:00', 'SA GAZINET CESTAS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 54, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 41, 'SA GAZINET CESTAS', NULL);

-- DM3 | Saison régulière | J8 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-11-30', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 75, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 60, 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3', NULL);

-- PNF | Saison régulière | J8 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-11-30', '16:00:00', 'CHAURAY BASKET CLUB - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', 52, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 42, 'CHAURAY BASKET CLUB - 2', NULL);

-- DM4 | Saison régulière | J8 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-11-30', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', 51, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 28, 'B.IZON - 2', NULL);

-- NF3 | Saison régulière | J9 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-11-30', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 86, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 40, 'LE TAILLAN BASKET', NULL);

-- PRF | Saison régulière | J9 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-12-06', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 65, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 46, 'US CHARTRONS BORDEAUX', NULL);

-- RM2 | Saison régulière | J9 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-12-06', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 63, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 70, 'BEAUNE-RILHAC-BONNAC BASKET', NULL);

-- PNM | Saison régulière | J9 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-12-06', '21:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 71, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 57, 'BOULAZAC BASKET DORDOGNE - 2', NULL);

-- NF3 | Saison régulière | J10 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-12-07', '14:00:00', 'FEYTIAT BASKET 87');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 82, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 53, 'FEYTIAT BASKET 87', NULL);

-- DM4 | Saison régulière | J9 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-12-07', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', 59, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 56, 'BC ST AVIT ST NAZAIRE', NULL);

-- PNF | Saison régulière | J9 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-12-07', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', 43, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 49, 'UNION SPORTIVE BREDOISE BASKET', NULL);

-- DM3 | Saison régulière | J9 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-12-07', '16:00:00', 'BASKET CLUB MARCHEPRIME');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', 69, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 64, 'BASKET CLUB MARCHEPRIME', NULL);

-- PRF | Saison régulière | J10 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2025-12-13', '20:00:00', 'US TALENCE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 66, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 71, 'US TALENCE', NULL);

-- DM4 | Saison régulière | J10 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2025-12-13', '20:00:00', 'STE EULALIE BASKET BALL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', 48, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 60, 'STE EULALIE BASKET BALL', NULL);

-- PNM | Saison régulière | J10 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-12-13', '21:00:00', 'ASPTT LIMOGES');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 85, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 68, 'ASPTT LIMOGES', NULL);

-- RM2 | Saison régulière | J10 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2025-12-13', '21:30:00', 'LIMOGES LANDOUGE LOISIRS BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 68, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 83, 'LIMOGES LANDOUGE LOISIRS BASKET', NULL);

-- PNF | Saison régulière | J10 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2025-12-14', '16:00:00', 'ASPTT LIMOGES');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', 58, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 79, 'ASPTT LIMOGES', NULL);

-- DM3 | Saison régulière | J10 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2025-12-14', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 68, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 54, 'AS MARTIGNAS - 2', NULL);

-- PRF | Saison régulière | J11 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-01-10', '21:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 46, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 39, 'STE EULALIE BASKET BALL', NULL);

-- PNM | Saison régulière | J11 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-01-10', '22:00:00', 'ENTENTE PESSAC BASKET CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 60, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 70, 'ENTENTE PESSAC BASKET CLUB', NULL);

-- RM2 | Saison régulière | J11 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-01-10', '22:00:00', 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 62, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 84, 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', NULL);

-- DM3 | Phase 2 / Playoffs | J1 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-01-11', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 77, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 71, 'STADE BORDELAIS', NULL);

-- PNF | Saison régulière | J11 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-01-11', '16:00:00', 'IE - CTC UBVP - VILLENEUVE BASKET CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', 54, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 49, 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', NULL);

-- DM4 | Phase 2 / Playoffs | J1 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-01-11', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', 36, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 51, 'COUTRAS GUITRES BASKET', NULL);

-- NF3 | Saison régulière | J11 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-01-11', '16:30:00', 'ELAN CHALOSSAIS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 66, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 70, 'ELAN CHALOSSAIS', NULL);

-- RM2 | Saison régulière | J12 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-01-17', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 65, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 62, 'BORDEAUX BASTIDE BASKET', NULL);

-- PNM | Saison régulière | J12 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-01-17', '21:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', 72, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 85, 'US CHARTRONS BORDEAUX', NULL);

-- PRF | Saison régulière | J12 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-01-17', '21:30:00', 'IE - CTC SMB - SAM - SA MERIGNACAIS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 49, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 51, 'IE - CTC SMB - SAM - SA MERIGNACAIS', NULL);

-- DM3 | Phase 2 / Playoffs | J2 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-01-18', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 50, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 81, 'BOULIAC BASKET CLUB - 2', NULL);

-- PNF | Saison régulière | J12 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-01-18', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', 67, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 46, 'BRESSUIRE LE REVEIL', NULL);

-- DM4 | Phase 2 / Playoffs | J2 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-01-18', '16:00:00', 'CA CARBON BLANC OMNISPORT');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', 42, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 82, 'CA CARBON BLANC OMNISPORT', NULL);

-- NF3 | Saison régulière | J12 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-01-18', '16:30:00', 'ABB CORNEBARRIEU');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', 85, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 65, 'ABB CORNEBARRIEU', NULL);

-- PRF | Saison régulière | J13 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-01-31', '21:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 58, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 54, 'UNION SPORTIVE BREDOISE BASKET - 2', NULL);

-- RM2 | Saison régulière | J13 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-01-31', '21:00:00', 'UNION SPORTIVE TULLE CORREZE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 68, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 77, 'UNION SPORTIVE TULLE CORREZE', NULL);

-- PNM | Saison régulière | J13 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-01-31', '22:00:00', 'AYTRE BASKET BALL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', 56, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 68, 'AYTRE BASKET BALL', NULL);

-- DM3 | Phase 2 / Playoffs | J3 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-02-01', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', 72, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 63, 'ENTENTE PESSAC BASKET CLUB - 3', NULL);

-- PNF | Saison régulière | J13 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-02-01', '16:00:00', 'AYTRE BASKET BALL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', 54, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 67, 'AYTRE BASKET BALL', NULL);

-- DM4 | Phase 2 / Playoffs | J3 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-02-01', '16:00:00', 'CA BEGLES - 3');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', 36, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', 67, 'CA BEGLES - 3', NULL);

-- NF3 | Saison régulière | J13 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-01', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', 57, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', 59, 'COTEAUX DU LUY BASKET', NULL);

-- RM2 | Saison régulière | J14 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-07', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'UNION SAINT BRUNO BORDEAUX', NULL);

-- PNM | Saison régulière | J14 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-07', '21:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CASTELNAU MEDOC BC', NULL);

-- PRF | Saison régulière | J14 | SF3 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-07', '21:30:00', 'LE TAILLAN BASKET - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'LE TAILLAN BASKET - 2', NULL);

-- DM4 | Phase 2 / Playoffs | J4 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-02-08', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'STE EULALIE BASKET BALL', NULL);

-- PNF | Saison régulière | J14 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-02-08', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AMICALE LOISIRS CASTILLONNES BASKET', NULL);

-- DM3 | Phase 2 / Playoffs | J4 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-02-08', '16:00:00', 'AGJA CAUDERAN - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'AGJA CAUDERAN - 2', NULL);

-- NF3 | Saison régulière | J14 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-08', '16:30:00', 'ENTENTE PESSAC BASKET CLUB - 1');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'ENTENTE PESSAC BASKET CLUB - 1', NULL);

-- NF3 | Saison régulière | J15 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-22', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AS ST DELPHIN - 2', NULL);

-- PNM | Saison régulière | J15 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-28', '21:00:00', 'CEP POITIERS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CEP POITIERS', NULL);

-- RM2 | Saison régulière | J15 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-28', '21:00:00', 'AIXE BC VAL DE VIENNE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'AIXE BC VAL DE VIENNE', NULL);

-- PNF | Saison régulière | J15 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-01', '16:00:00', 'LIMOGES ABC EN LIMOUSIN - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'LIMOGES ABC EN LIMOUSIN - 2', NULL);

-- DM3 | Phase 2 / Playoffs | J5 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-01', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'BLEUETS ILLATS - 2', NULL);

-- DM4 | Phase 2 / Playoffs | J5 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-01', '16:00:00', 'CASTELNAU MEDOC BC - 3');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CASTELNAU MEDOC BC - 3', NULL);

-- NF3 | Saison régulière | J16 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-01', '16:30:00', 'HAGETMAU MOMUY CASTAIGNOS BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'HAGETMAU MOMUY CASTAIGNOS BASKET', NULL);

-- RM2 | Saison régulière | J16 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-07', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AS ST DELPHIN', NULL);

-- PNM | Saison régulière | J16 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-07', '21:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'JSA BORDEAUX BASKET - 2', NULL);

-- PNF | Saison régulière | J16 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-08', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'POUZIOUX VOUNEUIL/BIARD BC', NULL);

-- DM3 | Phase 2 / Playoffs | J6 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-08', '16:00:00', 'STADE BORDELAIS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'STADE BORDELAIS', NULL);

-- DM4 | Phase 2 / Playoffs | J6 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-08', '16:00:00', 'COUTRAS GUITRES BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'COUTRAS GUITRES BASKET', NULL);

-- NF3 | Saison régulière | J17 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-08', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'IE - AUCH BASKET CLUB - 1', NULL);

-- PNF | Saison régulière | J17 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-21', '19:00:00', 'CA BRIVE CORREZE SECTION BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CA BRIVE CORREZE SECTION BASKET', NULL);

-- RM2 | Saison régulière | J17 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-21', '21:00:00', 'CA BRIVE CORREZE SECTION BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CA BRIVE CORREZE SECTION BASKET', NULL);

-- DM3 | Phase 2 / Playoffs | J7 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-21', '21:30:00', 'BOULIAC BASKET CLUB - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BOULIAC BASKET CLUB - 2', NULL);

-- DM4 | Phase 2 / Playoffs | J7 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-22', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CA CARBON BLANC OMNISPORT', NULL);

-- NF3 | Saison régulière | J18 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-22', '16:30:00', 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', NULL);

-- PNM | Saison régulière | J18 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-28', '21:00:00', 'COGNAC BASKET AVENIR');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'COGNAC BASKET AVENIR', NULL);

-- RM2 | Saison régulière | J18 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-28', '21:00:00', 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', NULL);

-- PNF | Saison régulière | J18 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-29', '17:00:00', 'CA BEGLES');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CA BEGLES', NULL);

-- DM3 | Phase 2 / Playoffs | J8 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-29', '17:00:00', 'ENTENTE PESSAC BASKET CLUB - 3');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'ENTENTE PESSAC BASKET CLUB - 3', NULL);

-- DM4 | Phase 2 / Playoffs | J8 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-29', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CA BEGLES - 3', NULL);

-- NF3 | Saison régulière | J19 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-29', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'B. COMMINGES SALIES DU SALAT - 1', NULL);

-- RM2 | Saison régulière | J19 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-04', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ES ST FRONT DE PRADOUX', NULL);

-- DM4 | Phase 2 / Playoffs | J9 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-04-04', '21:00:00', 'STE EULALIE BASKET BALL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'STE EULALIE BASKET BALL', NULL);

-- PNM | Saison régulière | J19 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-04', '22:15:00', 'US CENON RIVE DROITE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'US CENON RIVE DROITE', NULL);

-- PNF | Saison régulière | J19 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-04-05', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CHAURAY BASKET CLUB - 2', NULL);

-- DM3 | Phase 2 / Playoffs | J9 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-04-05', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AGJA CAUDERAN - 2', NULL);

-- NF3 | Saison régulière | J20 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-04-05', '17:30:00', 'LE TAILLAN BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'LE TAILLAN BASKET', NULL);

-- NF3 | Saison régulière | J21 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-04-12', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'FEYTIAT BASKET 87', NULL);

-- NF3 | Saison régulière | J22 | SF1 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-04-19', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ELAN CHALOSSAIS', NULL);

-- PNM | Saison régulière | J20 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-25', '22:00:00', 'BOULAZAC BASKET DORDOGNE - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BOULAZAC BASKET DORDOGNE - 2', NULL);

-- RM2 | Saison régulière | J20 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-25', '22:00:00', 'BEAUNE-RILHAC-BONNAC BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BEAUNE-RILHAC-BONNAC BASKET', NULL);

-- DM3 | Phase 2 / Playoffs | J10 | Sénior 3 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-04-26', '15:00:00', 'BLEUETS ILLATS - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BLEUETS ILLATS - 2', NULL);

-- PNF | Saison régulière | J20 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-04-26', '17:00:00', 'UNION SPORTIVE BREDOISE BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'UNION SPORTIVE BREDOISE BASKET', NULL);

-- DM4 | Phase 2 / Playoffs | J10 | Sénior 4 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-04-26', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CASTELNAU MEDOC BC - 3', NULL);

-- RM2 | Saison régulière | J21 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-02', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'LIMOGES LANDOUGE LOISIRS BASKET', NULL);

-- PNM | Saison régulière | J21 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-02', '22:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ASPTT LIMOGES', NULL);

-- PNF | Saison régulière | J21 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-05-03', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ASPTT LIMOGES', NULL);

-- RM2 | Saison régulière | J22 | Sénior 2 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-09', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', NULL);

-- PNM | Saison régulière | J22 | Sénior 1 (Masculin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-09', '22:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ENTENTE PESSAC BASKET CLUB', NULL);

-- PNF | Saison régulière | J22 | SF2 (Féminin)
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-05-10', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', NULL);

COMMIT;