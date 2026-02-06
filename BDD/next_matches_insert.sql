-- Inserts des prochains matchs (saison 2025-2026)
-- Mapping demandé:
-- NF3/PRF -> SF3 (numEquipe 7, numCompetition 7)
-- PNF -> SF2 (numEquipe 6, numCompetition 6)
-- PNM/RM2 -> SG2 (numEquipe 2, numCompetition 2)
-- DM3 -> SG3 (numEquipe 3, numCompetition 3)
-- DM4 -> SG4 (numEquipe 9, numCompetition 4)

START TRANSACTION;

-- RM2 (SG2) - J14
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-07', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'UNION SAINT BRUNO BORDEAUX', NULL);

-- PNM (SG2) - J14
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-07', '21:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CASTELNAU MEDOC BC', NULL);

-- PRF (SF3) - J14
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-07', '21:30:00', 'LE TAILLAN BASKET - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'LE TAILLAN BASKET - 2', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J4
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-02-08', '14:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'STE EULALIE BASKET BALL', NULL);

-- PNF (SF2) - J14
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-02-08', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AMICALE LOISIRS CASTILLONNES BASKET', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J4
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-02-08', '16:00:00', 'AGJA CAUDERAN - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'AGJA CAUDERAN - 2', NULL);

-- NF3 (SF3) - J14
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-08', '16:30:00', 'ENTENTE PESSAC BASKET CLUB - 1');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'ENTENTE PESSAC BASKET CLUB - 1', NULL);

-- NF3 (SF3) - J15
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-02-22', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AS ST DELPHIN - 2', NULL);

-- PNM (SG2) - J15
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-28', '21:00:00', 'CEP POITIERS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CEP POITIERS', NULL);

-- RM2 (SG2) - J15
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-02-28', '21:00:00', 'AIXE BC VAL DE VIENNE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'AIXE BC VAL DE VIENNE', NULL);

-- PNF (SF2) - J15
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-01', '16:00:00', 'LIMOGES ABC EN LIMOUSIN - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'LIMOGES ABC EN LIMOUSIN - 2', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J5
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-01', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'BLEUETS ILLATS - 2', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J5
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-01', '16:00:00', 'CASTELNAU MEDOC BC - 3');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CASTELNAU MEDOC BC - 3', NULL);

-- NF3 (SF3) - J16
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-01', '16:30:00', 'HAGETMAU MOMUY CASTAIGNOS BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'HAGETMAU MOMUY CASTAIGNOS BASKET', NULL);

-- RM2 (SG2) - J16
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-07', '19:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AS ST DELPHIN', NULL);

-- PNM (SG2) - J16
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-07', '21:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'JSA BORDEAUX BASKET - 2', NULL);

-- PNF (SF2) - J16
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-08', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'POUZIOUX VOUNEUIL/BIARD BC', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J6
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-08', '16:00:00', 'STADE BORDELAIS');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'STADE BORDELAIS', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J6
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-08', '16:00:00', 'COUTRAS GUITRES BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'COUTRAS GUITRES BASKET', NULL);

-- NF3 (SF3) - J17
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-08', '16:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'IE - AUCH BASKET CLUB - 1', NULL);

-- PNF (SF2) - J17
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-21', '19:00:00', 'CA BRIVE CORREZE SECTION BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CA BRIVE CORREZE SECTION BASKET', NULL);

-- RM2 (SG2) - J17
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-21', '21:00:00', 'CA BRIVE CORREZE SECTION BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CA BRIVE CORREZE SECTION BASKET', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J7
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-21', '21:30:00', 'BOULIAC BASKET CLUB - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BOULIAC BASKET CLUB - 2', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J7
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-22', '16:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CA CARBON BLANC OMNISPORT', NULL);

-- NF3 (SF3) - J18
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-22', '16:30:00', 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', NULL);

-- PNM (SG2) - J18
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-28', '21:00:00', 'COGNAC BASKET AVENIR');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'COGNAC BASKET AVENIR', NULL);

-- RM2 (SG2) - J18
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-03-28', '21:00:00', 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', NULL);

-- PNF (SF2) - J18
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-03-29', '17:00:00', 'CA BEGLES');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'CA BEGLES', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J8
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-03-29', '17:00:00', 'ENTENTE PESSAC BASKET CLUB - 3');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'ENTENTE PESSAC BASKET CLUB - 3', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J8
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-03-29', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CA BEGLES - 3', NULL);

-- NF3 (SF3) - J19
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-03-29', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'B. COMMINGES SALIES DU SALAT - 1', NULL);

-- RM2 (SG2) - J19
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-04', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ES ST FRONT DE PRADOUX', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J9
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-04-04', '21:00:00', 'STE EULALIE BASKET BALL');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'STE EULALIE BASKET BALL', NULL);

-- PNM (SG2) - J19
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-04', '22:15:00', 'US CENON RIVE DROITE');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'US CENON RIVE DROITE', NULL);

-- PNF (SF2) - J19
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-04-05', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CHAURAY BASKET CLUB - 2', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J9
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-04-05', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'AGJA CAUDERAN - 2', NULL);

-- NF3 (SF3) - J20
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-04-05', '17:30:00', 'LE TAILLAN BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'LE TAILLAN BASKET', NULL);

-- NF3 (SF3) - J21
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-04-12', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'FEYTIAT BASKET 87', NULL);

-- NF3 (SF3) - J22
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 7, NULL, NULL, '2026-04-19', '17:30:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 7, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ELAN CHALOSSAIS', NULL);

-- PNM (SG2) - J20
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-25', '22:00:00', 'BOULAZAC BASKET DORDOGNE - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BOULAZAC BASKET DORDOGNE - 2', NULL);

-- RM2 (SG2) - J20
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-04-25', '22:00:00', 'BEAUNE-RILHAC-BONNAC BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BEAUNE-RILHAC-BONNAC BASKET', NULL);

-- DM3 (SG3) - Phase 2 / Playoffs J10
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 3, NULL, NULL, '2026-04-26', '15:00:00', 'BLEUETS ILLATS - 2');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 3, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'BLEUETS ILLATS - 2', NULL);

-- PNF (SF2) - J20
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-04-26', '17:00:00', 'UNION SPORTIVE BREDOISE BASKET');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'exterieur', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'domicile', NULL, 'UNION SPORTIVE BREDOISE BASKET', NULL);

-- DM4 (SG4) - Phase 2 / Playoffs J10
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 4, NULL, NULL, '2026-04-26', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 9, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'CASTELNAU MEDOC BC - 3', NULL);

-- RM2 (SG2) - J21
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-02', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'LIMOGES LANDOUGE LOISIRS BASKET', NULL);

-- PNM (SG2) - J21
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-02', '22:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ASPTT LIMOGES', NULL);

-- PNF (SF2) - J21
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-05-03', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ASPTT LIMOGES', NULL);

-- RM2 (SG2) - J22
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-09', '20:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', NULL);

-- PNM (SG2) - J22
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 2, NULL, NULL, '2026-05-09', '22:15:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 2, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'ENTENTE PESSAC BASKET CLUB', NULL);

-- PNF (SF2) - J22
INSERT INTO `MATCH` (numSaison, numCompetition, numPhase, numJournee, dateMatch, heureMatch, lieuMatch)
VALUES (1, 6, NULL, NULL, '2026-05-10', '17:00:00', 'BORDEAUX ETUDIANTS CLUB');
SET @match_id = LAST_INSERT_ID();
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, 6, 'domicile', NULL, NULL, NULL);
INSERT INTO MATCH_PARTICIPANT (numMatch, numEquipe, cote, score, nomEquipeAdverse, numeroEquipeAdverse)
VALUES (@match_id, NULL, 'exterieur', NULL, 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', NULL);

COMMIT;
