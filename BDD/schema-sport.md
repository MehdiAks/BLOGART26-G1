# Schéma relationnel sportif (proposition normalisée 3NF)

> **Objectif** : supprimer les répétitions (équipes/sections/compétitions/roles), historiser les changements (saisons, affectations) et éliminer les champs texte redondants dans les transactions (matchs).

## Référentiels

### CLUB
- **PK** : `numClub`
- **Champs** : `nomClub`, `villeClub`, `estClubMaison`
- **Rôle** : référentiel des clubs (BEC + adversaires). Permet d’éviter les noms d’adversaires en clair dans `MATCH`.

### CATEGORIE_EQUIPE
- **PK** : `numCategorie`
- **Champs** : `libCategorie`
- **Rôle** : référentiel des catégories (Sénior, U18, etc.).

### SECTION_EQUIPE
- **PK** : `numSection`
- **Champs** : `libSection`
- **Rôle** : référentiel des sections (Masculin, Féminin, Mixte, etc.).

### NIVEAU_EQUIPE
- **PK** : `numNiveau`
- **Champs** : `libNiveau`
- **Rôle** : référentiel des niveaux (N3, PNM, RM2...).

### POSTE
- **PK** : `numPoste`
- **Champs** : `libPoste`
- **Rôle** : référentiel des postes.

### ROLE_PERSONNEL
- **PK** : `numRolePersonnel`
- **Champs** : `libRolePersonnel`
- **Rôle** : référentiel des rôles (Coach, Assistant, Kiné...).

### SAISON
- **PK** : `numSaison`
- **Champs** : `libSaison`, `dateDebut`, `dateFin`, `estCourante`
- **Rôle** : référentiel des saisons pour historiser équipes, joueurs et matchs.

## Équipes

### EQUIPE
- **PK** : `numEquipe`
- **FK** : `numClub → CLUB`, `numCategorie → CATEGORIE_EQUIPE`, `numSection → SECTION_EQUIPE`, `numNiveau → NIVEAU_EQUIPE`
- **Champs** : `codeEquipe`, `libEquipe`, `libEquipeComplet`, `descriptionEquipe`
- **Rôle** : informations d’équipe stockées une seule fois.

## Joueurs

### JOUEUR
- **PK** : `numJoueur`
- **Champs** : `prenomJoueur`, `nomJoueur`, `urlPhotoJoueur`, `dateNaissance`
- **Rôle** : identité du joueur (pas de numéro de maillot ni de poste ici).

### JOUEUR_AFFECTATION
- **PK** : `numAffectation`
- **FK** : `numJoueur → JOUEUR`, `numEquipe → EQUIPE`, `numSaison → SAISON`, `numPoste → POSTE`
- **Champs** : `numMaillot`, `dateDebut`, `dateFin`
- **Rôle** : historise les changements d’équipe, de poste et de numéro par saison.

### JOUEUR_CLUB
- **PK** : `numJoueurClub`
- **FK** : `numJoueur → JOUEUR`, `numClub → CLUB`
- **Champs** : `dateDebut`, `dateFin`, `notes`
- **Rôle** : parcours dans les clubs précédents sans texte libre dupliqué.

## Personnel / bénévoles

### PERSONNEL
- **PK** : `numPersonnel`
- **Champs** : `prenomPersonnel`, `nomPersonnel`, `urlPhotoPersonnel`, `emailPersonnel`, `telephonePersonnel`
- **Rôle** : identité du personnel/bénévoles.

### AFFECTATION_PERSONNEL_EQUIPE
- **PK** : `numAffectation`
- **FK** : `numPersonnel → PERSONNEL`, `numEquipe → EQUIPE`, `numSaison → SAISON`, `numRolePersonnel → ROLE_PERSONNEL`
- **Champs** : `dateDebut`, `dateFin`
- **Rôle** : affectations par équipe et par saison, sans rôle texte libre.

## Compétitions / matchs

### COMPETITION
- **PK** : `numCompetition`
- **FK** : `numSaison → SAISON`
- **Champs** : `libCompetition`
- **Rôle** : référentiel des compétitions par saison.

### PHASE_COMPETITION
- **PK** : `numPhase`
- **FK** : `numCompetition → COMPETITION`
- **Champs** : `libPhase`, `ordrePhase`
- **Rôle** : phases de compétition (saison régulière, playoffs...).

### JOURNEE
- **PK** : `numJournee`
- **FK** : `numPhase → PHASE_COMPETITION`
- **Champs** : `libJournee`, `numeroJournee`
- **Rôle** : journées rattachées à une phase.

### MATCH
- **PK** : `numMatch`
- **FK** : `numSaison → SAISON`, `numCompetition → COMPETITION`, `numPhase → PHASE_COMPETITION`, `numJournee → JOURNEE`
- **Champs** : `dateMatch`, `heureMatch`, `lieuMatch`
- **Rôle** : entité transactionnelle minimale (aucun nom d’équipe/adversaire, pas de score dupliqué).

### MATCH_PARTICIPANT
- **PK** : `numMatchParticipant`
- **FK** : `numMatch → MATCH`, `numEquipe → EQUIPE`
- **Champs** : `cote` (domicile/exterieur), `score`
- **Rôle** : table de liaison domicile/extérieur avec score unique par participant.

## Notes de migration (optionnel)

- **Équipes** : créer `CLUB` puis `EQUIPE` avec `numClub` pointant vers le club BEC et les clubs adverses existants.
- **Joueurs** : migrer `JOUEUR` vers la nouvelle table (sans `numMaillot`, `posteJoueur`), puis créer une ligne `JOUEUR_AFFECTATION` par saison/équipe actuelle.
- **Matchs** : migrer `bec_matches` vers `MATCH` + `MATCH_PARTICIPANT` (2 lignes par match), en remplaçant `Equipe`/`Adversaire` par des références `EQUIPE`/`CLUB`.
