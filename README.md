# Blogart Template

## Setup
### Group 1
MMI - IUT Bordeaux Montaigne  
Group members: Mehdi Afankous, Romain Bezombes, Alvin Bonaventure-Sanchez, Juliette Rieunau, Phuong-My Nguyen  
Theme: Bordeaux through the Bordeaux Étudiant Club

## Architecture
- **api** - Contains all php calls for example "create.php" for statuts, articles
- **classes** - Contains all classes for example "members.php"
- **config** - Contains all the configuration files specific to the operation of the application, for example "security.php"
- **functions** - Contains all the functions of your code for example "data.php", "create.php"
- **views** - Contain all front
- **src** - Contain all sources files or external libs

## Files to complete
- **.env** - Foreach user exemple in .env.example
- **config/security.php** - Check user cookie
- **index.php** - Must be the homepage
- **views** - All your pages
- 

## Scripts
### Télécharger les logos FFBB
Le script `scripts/fetch_ffbb_logos.php` peut être lancé en local avec PHP CLI pour récupérer les logos des équipes FFBB. Par défaut, il utilise la liste intégrée et sauvegarde dans `src/images/ffbb-logos`.

Exemples :
```bash
php scripts/fetch_ffbb_logos.php
php scripts/fetch_ffbb_logos.php -o ./logos
php scripts/fetch_ffbb_logos.php -l equipes.txt
php scripts/fetch_ffbb_logos.php senior1=https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983
```
