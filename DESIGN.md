# Direction visuelle BEC

## Verdict de finition

La phase 2 applique la direction « site de club standard, niveau club professionnel » : informations de match en premier, vraies photos, hiérarchie éditoriale nette, aplats bordeaux, chiffres jaunes et absence d'ombres décoratives.

## Système

- Source des tokens : `src/css/css-propre/tokens.css`.
- Titres : Big Shoulders Display 800, capitales serrées.
- Texte et interface : Epilogue variable.
- Conteneur : 1200 px maximum, gouttières de 16 px sur mobile et 24 px à partir de la tablette.
- Blocs et images : rayon de 12 px; champs et boutons : 6 px.
- Mouvement : zoom d'image à 1.03 sur les cartes-liens et fondu de 150 ms pour les menus. Le mode mouvement réduit neutralise les transitions.
- Accessibilité : lien d'évitement, focus jaune de 3 px, cibles de 44 px, contraste renforcé et navigation native avec `details`.

## Composants de référence

- En-tête blanc collant avec blason statique, navigation soulignée, Boutique jaune et Compte bordeaux.
- Centre de match pleine largeur bordeaux sous le hero.
- Actualités sans carte ombrée : image, filet, titre et date.
- Listes de calendrier et tableaux d'administration filetés.
- Footer bordeaux en quatre colonnes, sans iframe tierce.
- Bandeau de consentement fixe en bas, sans blocage de la page.

## Provenance des rasters livrés

Tous les rasters sont des fichiers déjà fournis dans le dépôt du projet BEC; aucun visuel externe ou généré n'a été ajouté.

| Usage | Fichier | Provenance |
|---|---|---|
| Hero accueil | `src/images/background/background-index-1.webp` | Bibliothèque média existante du projet |
| Présentation du club | `src/images/background/background-index-3.webp` | Bibliothèque média existante du projet |
| Logos partenaires | `src/images/Logo partenaires/*.png` | Logos partenaires existants fournis avec le projet |
| Images d'articles, équipes et joueurs | `src/uploads/` et valeurs de la base | Téléversements gérés par le back-office existant |
| Image de repli | `src/images/image-defaut.jpeg` | Ressource existante du projet |

Le blason principal utilise le SVG existant `src/images/logo/logo-bec/logo.svg` et n'est donc pas un raster.

## Revue

- Copie au-dessus de la ligne de flottaison conforme au contrat : nom du club, localisation, calendrier et contact.
- Palette verrouillée sur `#FAF8F5`, `#17120F`, `#6B0F24` et `#F2C230`.
- Vidéo de fond, halo de curseur, machine à écrire, révélations au scroll et surélévation des boutons supprimés.
- Pages publiques, légales, compte, boutique, authentification et back-office conservés à leurs URL.
- Revue navigateur non capturée dans cet environnement : l'ouverture d'un port local est interdite et l'accès à l'application MAMP n'a pas été autorisé. Les validations PHP et sécurité sont consignées dans le compte rendu de livraison.
