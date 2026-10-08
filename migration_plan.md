# Plan de migration (saves.sql -> BLOGART26.sql)

## Objectifs
- Importer les données depuis l’ancien schéma (`saves.sql`) vers le nouveau schéma (`BLOGART26.sql`) sans modifier les tables protégées côté nouveau schéma.
- Ignorer toute table liée aux logos.
- Migration idempotente via `INSERT IGNORE` (ou option `--strategy truncate`).

## Contraintes prises en compte
- Tables protégées (structure intouchable) : `THEMATIQUE`, `STATUT`, `MOTCLEARTICLE`, `MOTCLE`, `MEMBRE`, `LIKEART`, `COMMENT`.
- Aucune migration de tables comportant `logo`, `logos`, `image_logo`, `logotype`.
- MySQL 8.x, `FOREIGN_KEY_CHECKS` désactivé pendant l’insertion puis réactivé.

## Méthodologie détaillée
### 1) Chargement des dumps dans des bases temporaires
- `old_db`: import de `/mnt/data/saves.sql`.
- `new_db`: import de `/mnt/data/BLOGART26.sql`.

### 2) Extraction du schéma via `information_schema`
- Tables : `information_schema.tables`.
- Colonnes : `information_schema.columns` (nom, type, nullabilité, PK, auto_increment).
- FKs : `information_schema.key_column_usage`.

### 3) Mapping automatique
- **Tables** :
  - Si même nom → mapping direct.
  - Sinon → heuristique par similarité (nom + recouvrement de colonnes).
- **Colonnes** :
  - Si même nom → mapping direct.
  - Sinon → heuristique par similarité de noms (snake/camel, préfixes, suffixes, FR/EN).
- **Tables split/merge** :
  - Heuristique par recouvrement de colonnes ; si aucune correspondance suffisamment fiable → marqué comme `SKIPPED`.

### 4) Insertion (ordre et dépendances)
- L’ordre d’insertion respecte implicitement les dépendances grâce au chargement avec `FOREIGN_KEY_CHECKS=0`.
- Après insertion : `FOREIGN_KEY_CHECKS=1`.

### 5) Idempotence
- Par défaut : `INSERT IGNORE` (évite les doublons si relancé).
- Option alternative : `--strategy truncate` pour `TRUNCATE` + `INSERT`.

### 6) Garde-fous et contrôles
- Log par table : nb de lignes importées.
- Comparaison `COUNT(*)` old vs new pour toutes les tables mappées.
- Fichier `migration_generated.sql` généré (audit / rollback manuel possible).

## Limites connues / données non migrables
- Tables “logos” : non migrées par design.
- Tables supprimées sans correspondance : signalées comme `removed`.
- Colonnes supprimées ou non mappées : ignorées.
- Colonnes requises sans défaut ni correspondance : valeur `DEFAULT` uniquement si gérable ; sinon la table est signalée.

## Livrables
- `migrate.py` : script d’import, comparaison, mapping et migration.
- `migration_generated.sql` : requêtes d’insertion générées.
- Sortie console : tableau de mapping, logs d’import, contrôles de comptes.

## Exemple d’exécution
```bash
python3 migrate.py \
  --old-dump /mnt/data/saves.sql \
  --new-dump /mnt/data/BLOGART26.sql \
  --mysql-host 127.0.0.1 \
  --mysql-port 3306 \
  --mysql-user root \
  --mysql-password secret
```

Pour une migration destructive (truncate avant insert) :
```bash
python3 migrate.py --strategy truncate
```
