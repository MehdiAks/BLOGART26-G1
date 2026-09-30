# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Site public du Bordeaux Étudiant Club (BEC), club de basket bordelais. Public large, sans profil dominant :
visiteurs de passage, licenciés et parents (prochains matchs, résultats, infos pratiques), supporters et anciens
(actualités, vie du club), futurs joueurs (découvrir le club et les équipes), partenaires (visibilité, contact).
Une petite équipe d'administrateurs et de modérateurs gère le contenu via le back-office.

## Product Purpose

Tenir à jour la vitrine du club : actualités, calendrier et résultats, équipes et joueurs, bénévoles, partenaires,
boutique. Réussite : un visiteur trouve le prochain match ou une info pratique en quelques secondes, et le club
paraît vivant et sérieux.

## Operating Context

Site PHP procédural + MySQL chez un hébergeur mutualisé (PHP 7.4 à 8.x, Apache). Bootstrap 5 via CDN.
Contenu saisi par des bénévoles dans le back-office (articles en BBCode, photos uploadées).
Beaucoup de consultation sur téléphone (bord de terrain, parents).

## Capabilities and Constraints

- Pages publiques : accueil, actualités, article (commentaires et likes pour membres), calendrier, équipes, fiche équipe,
  joueurs, bénévoles, partenaires, notre histoire, anciens et amis, boutique, compte, mentions légales, CGU, RGPD, 404.
- Back-office : tableau de bord et CRUD articles, membres, statuts, thématiques, mots-clés, commentaires, likes,
  équipes, joueurs, matchs, bénévoles, boutique.
- Inscription publique désactivée pour l'instant.
- Rôles : 1 administrateur, 2 modérateur, 3 membre.

## Brand Commitments

- Nom : Bordeaux Étudiant Club (BEC).
- Blason du club (src/images/logo/logo-bec/) : imposé.
- Couleurs du maillot : rouge bordeaux et jaune. Imposées. Le reste de l'identité est libre.
- Direction choisie par le propriétaire : le site de club standard (grammaire des sites de clubs pros :
  centre de match, actualités, équipes, partenaires), exécuté au meilleur niveau de finition possible.
  Pas d'excentricité de concept. Référence de finition : sites de clubs professionnels.

## Evidence on Hand

- Vraies photos de joueurs et de matchs (src/uploads/, src/images/background/), vidéo d'accueil (src/video/).
- Logos des partenaires (src/images/Logo partenaires/) et des clubs adverses (src/images/logo/logo-adversaire/).
- Aucun témoignage, chiffre de fréquentation ou palmarès fourni : ne rien inventer. Les statistiques affichées
  viennent uniquement de la base (matchs).

## Product Principles

- L'info pratique d'abord : prochain match, résultats, contact accessibles sans chercher.
- Le club se montre par ses vraies photos et ses vrais résultats, pas par du décor.
- Lisible sur téléphone en extérieur.
- Un bénévole doit pouvoir publier sans casser la mise en page.

## Accessibility & Inclusion

Pas d'exigence spécifique établie. Viser WCAG 2.1 AA (contraste, focus visible, navigation clavier, mouvement réduit).
