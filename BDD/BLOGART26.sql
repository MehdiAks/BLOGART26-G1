-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 05 fév. 2026 à 08:58
-- Version du serveur : 8.0.44
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `BLOGART26`
--

-- --------------------------------------------------------

--
-- Structure de la table `AFFECTATION_PERSONNEL`
--

CREATE TABLE `AFFECTATION_PERSONNEL` (
  `numAffectation` int NOT NULL,
  `numPersonnel` int NOT NULL,
  `numBranche` int NOT NULL,
  `libPoste` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `AFFECTATION_PERSONNEL`
--

INSERT INTO `AFFECTATION_PERSONNEL` (`numAffectation`, `numPersonnel`, `numBranche`, `libPoste`) VALUES
(1, 1, 1, 'Président du club'),
(2, 2, 1, 'Présidente adjointe'),
(3, 3, 1, 'Trésorière'),
(4, 4, 1, 'Secrétaire du club'),
(5, 5, 3, 'Bénévole'),
(6, 6, 3, 'Bénévole'),
(7, 7, 3, 'Bénévole'),
(8, 8, 3, 'Bénévole'),
(9, 9, 4, 'Bénévole'),
(10, 10, 4, 'Bénévole'),
(11, 11, 4, 'Bénévole'),
(12, 12, 4, 'Bénévole'),
(13, 13, 2, 'Coach'),
(14, 14, 2, 'Coach'),
(15, 15, 2, 'Coach'),
(16, 16, 2, 'Coach'),
(17, 17, 2, 'Assistant coach'),
(18, 18, 2, 'Assistant coach'),
(19, 19, 2, 'Assistant coach'),
(20, 20, 2, 'Assistant coach');

-- --------------------------------------------------------

--
-- Structure de la table `ARTICLE`
--

CREATE TABLE `ARTICLE` (
  `numArt` int NOT NULL,
  `dtCreaArt` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtMajArt` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `libTitrArt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libChapoArt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `libAccrochArt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parag1Art` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `libSsTitr1Art` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parag2Art` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `libSsTitr2Art` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parag3Art` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `libConclArt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `urlPhotArt` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numThem` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ARTICLE`
--

INSERT INTO `ARTICLE` (`numArt`, `dtCreaArt`, `dtMajArt`, `libTitrArt`, `libChapoArt`, `libAccrochArt`, `parag1Art`, `libSsTitr1Art`, `parag2Art`, `libSsTitr2Art`, `parag3Art`, `libConclArt`, `urlPhotArt`, `numThem`) VALUES
(1, '2019-02-24 16:08:30', '2026-02-03 14:49:19', 'BEC Basket &amp; The Cock and Bull Pub : une histoire de fidélité et de convivialité', 'Depuis 20 ans, le Cock and Bull Pub est un lieu emblématique de rencontres, de débats animés et de célébrations sportives, étroitement lié à la vie du BEC Basket.', 'Plus qu’un simple partenaire, le Cock and Bull est devenu au fil des saisons un véritable repère pou', 'Depuis deux décennies, le pub Cock and Bull accueille victoires, troisièmes mi-temps et discussions passionnées. Les histoires s’y écrivent autant autour d’un verre que sur les terrains de basket.', 'Une association construite dans le temps', 'Le partenariat entre le Cock and Bull et le BEC ne repose pas sur une opportunité ponctuelle, mais sur une relation durable fondée sur la confiance, la fidélité et une vision commune du sport comme vecteur de lien social.', 'Un repère pour toute une communauté', 'Saison après saison, le pub est devenu un prolongement du vestiaire, un lieu où l’on refait les matchs et où les liens se renforcent, toujours dans le même esprit de convivialité.', 'Célébrer les 20 ans du Cock and Bull, c’est aussi mettre en lumière une collaboration sincère, faite de moments partagés, d’émotions collectives et d’une passion commune pour le sport et la vie locale.', 'imgArt1.jpg', 1),
(2, '2019-03-13 20:14:10', '2026-02-03 14:50:03', 'Tournoi de Noël intergénérationnel : un moment de partage au BEC Basket', 'Comme chaque fin d’année, le BEC Basket a réuni toutes les générations autour de son traditionnel tournoi de Noël.', 'Une journée placée sous le signe du jeu, du partage et de l’esprit de fête.', 'Petits et grands se sont retrouvés sur les terrains pour participer à des mini-matchs mêlant enfants, parents, licenciés, bénévoles et dirigeants, dans une ambiance chaleureuse et festive.', 'Le basket comme lien intergénérationnel', 'Ce tournoi a permis de renforcer la cohésion au sein du club, de créer de nouveaux souvenirs et de rappeler que le basket est avant tout un sport de respect et de rassemblement.', 'Une touche de magie pour conclure la journée', 'La surprise finale est venue de l’apparition du Père Noël, pour le plus grand plaisir des participants, entre photos, sourires et encouragements au bord du terrain.', 'Grâce à l’énergie des bénévoles et à la bonne humeur de tous, l’esprit de Noël et les valeurs du BEC étaient une nouvelle fois bien présents.', 'imgArt2.jpg', 4),
(3, '2019-11-09 10:34:20', '2026-02-03 14:53:17', 'Week-end décisif pour nos Séniors Filles 1', 'Un rendez-vous crucial attend nos Séniors Filles ce week-end en championnat NF3.', 'Un match à fort enjeu pour consolider le haut du classement.', 'Nos SF1 recevront les troisièmes du championnat de NF3 dans une rencontre déterminante pour la suite de la saison.', 'Un objectif clair : viser la première place', 'Cette confrontation pourrait permettre de conforter la deuxième place actuelle et de se rapprocher des leaders du classement.', 'Un soutien indispensable', 'Plus que jamais, le soutien du public sera essentiel pour pousser les joueuses vers la victoire.', 'Rendez-vous en tribunes pour lancer l’année de la meilleure des manières et porter nos SF1 vers un succès important.', 'imgArt3.jpg', 4),
(4, '2020-01-12 18:21:21', '2026-01-29 09:25:12', 'Nicolas Caraty : médiateur culturel plein de bon sens !', 'Le lundi 21 février, nous avons eu la chance de rencontrer Nicolas Caraty, un médiateur culturel non-voyant du musée d\'Aquitaine. Cette entrevue a vu le jour suite à des questionnements sur l’art et les sculptures, ainsi que leur accessibilité. Nous en avons appris plus sur son parcours professionnel, et comment il s’est retrouvé au musée d’Aquitaine. Et nous avons également échangé longuement au sujet de l’accès à la culture pour tout le monde, ce qui nous a mené à discuter de son projet sensationnel : le parcours sensoriel !', 'Nicolas Caraty, lui, son parcours sensoriel', 'Toucher des œuvres du musée d’Aquitaine, c’est possible ! Et ce en grande partie grâce à lui ! Nicolas Caraty a débuté sa carrière professionnelle en tant qu’accordeur de piano sur Paris. Assez vite, il s’est vite questionné sur l’accès à la culture pour les personnes en situation de handicap. Il va par la suite travailler 3 ans chez « Toucher pour connaître », association concevant des expositions adaptées et retranscrit les journaux écrits en cassettes audio. À la suite de cette expérience, il change totalement de secteur et s’oriente vers la vente par correspondance et le suivi client chez Les 3 Suisses. Il occupe ce poste pendant près de 8 ans avant de le quitter et se diriger vers le musée d’Aquitaine de Bordeaux. Recruté en 2007 en tant que stagiaire chargé de la médiation culturelle, il est un an plus tard titularisé par la mairie de Bordeaux et occupe encore ce poste aujourd’hui. Nicolas est un amoureux de l’art, sa déclinaison préférée est celle de la musique. Amateur de piano et de guitare depuis son jeune âge, il se tourne de plus en plus vers le synthétiseur. Et c’est sans compter son attrait pour le cinéma, la peinture, le théâtre, l’écriture, et bien évidemment la sculpture.', 'L’art et l’handicap', '« L’art permet d’exprimer les choses, mais parfois la difficulté c’est d’y avoir accès. ». Cette phrase entendue durant l’interview nous a particulièrement marqués. Il est vrai que nous avons tous les jours l’occasion de prêter attention à la culture, néanmoins certaines personnes en situation de handicap (notamment visuel ou auditif) peuvent parfois trouver difficile l’accès à cette dernière. Bien sûr, comme nous l’explique Nicolas, le handicap ne signifie pas forcément que la culture devient totalement inaccessible. Lui-même est un musicien avéré comme évoqué plus tôt. Il nous a d’ailleurs expliqué un fait intéressant sur la découverte des sculptures : « Quand vous êtes non-voyant, vous faites une exploration partielle de l\'œuvre avec vos mains qui sont capables d’explorer ces détails. Au fur et à mesure vous êtes aptes à reconstituer l\'œuvre dans l’espace, en allant donc du détail vers la globalité ». Ce qui, lorsqu’on y réfléchit bien, est une découverte totalement opposée à celle d’une personne voyante qui, elle, voit la sculpture d’abord dans sa globalité, puis vient ensuite chercher les détails en la touchant. Donc tout est en réalité une question de perspectives et de méthodes.', 'Le parcours sensoriel', 'C’est là qu’entre en jeu le fameux parcours sensoriel ! Il s’agit d’un chemin pédagogique installé dans le musée d\'Aquitaine. Comme son nom l\'indique, il permet de faire découvrir diverses œuvres en faisant appel au plus de sens possible pour les rendre accessibles. Plusieurs initiatives sont prises en compte pour se faire, telles que la production d’audio-descriptions associées à plusieurs tableaux (contant le contexte, l’histoire de ces derniers, illustrés par des effets sonores). Et il faut évoquer les nombreuses sculptures reproduites à l’identique avec des matières très similaires à celles d\'origine. Il est question de reproduction de masques africains en bois, de sculptures en pierre… Nicolas nous a montré une reproduction d’une statue de bronze représentant le Roi Louis XV, réalisée grâce à une modélisation 3D. Il a également pris le temps de nous faire toucher d’autres ouvrages, notamment une reproduction de la Vénus à la corne, ainsi que des pierres taillées de la préhistoire. Ce parcours sensoriel permet donc à la fois de conserver en bon état les vestiges du passé, tout en proposant une offre permanente de visite culturelle aux personnes en situation de handicap.', 'Le patrimoine culturel de Bordeaux devient plus accessible puisque de nombreux efforts sont faits pour soutenir cette cause. Mais selon Nicolas, il faut continuer sur ce chemin. À présent, l’objectif majeur est de diffuser l’information. À notre échelle, nous pouvons partager nos connaissances culturelles avec autrui. Il faut aussi réfléchir à un moyen d’adapter ces services pour les rendre accessibles au maximum. D’après Nicolas : « Si on fait vivre cette découverte non pas par des connaissances encyclopédiques mais plutôt par la notion de plaisir, les gens seront plus à l’aise. Il ne faut pas les mettre en situation d’échec, mais plutôt les guider, les amener à découvrir les œuvres par eux-mêmes, et alors là il sera plus aisé de les mener vers des connaissances plus théoriques ».', 'imgArt4.jpg', 2),
(5, '2022-03-04 12:28:00', '2026-01-29 09:25:16', 'La sculpture Sanna va-t-elle nous quitter ?', 'Depuis presque dix ans, la sculpture Sanna trône sur la place de la comédie. Visage emblématique et intriguant que l’on apprécie contempler. Aujourd’hui, il est possible qu’elle ne devienne plus qu’un souvenir… La ville de Bordeaux a toujours été investie dans la culture et l\'accès à l’art, c’est pourquoi le sujet de la sculpture Sanna fait polémique au sein de la ville.', 'Quelle histoire se cache derrière ce visage ?', 'La demoiselle de fonte a été érigée en 2013 par Jaume Plensa dans le cadre d’une exposition bordelaise, Sanna était accompagnée de sa « sœur » Paula, qui elle, était placée devant la cathédrale de Bordeaux. Jaume Plensa est un artiste Catalan qui a réalisé onze autres œuvres, exposées à travers la ville. Mais, celles-ci ont été retirées. Actuellement, c’est un particulier anonyme qui possède la sculpture Sanna, il laisse à la municipalité de Bordeaux un délai de 5 ans pour la conserver sur la place de la Comédie. Elle partirait à priori en 2027. Ce serait donc le départ d’une œuvre extravagante et surtout emblématique de la ville de Bordeaux.', 'Une demoiselle de fonte, d’âme et d’or', 'Sanna est une sculpture figurative monumentale faite entièrement de fonte, il s’agit du visage d’une jeune fille qui paraît particulièrement apaisée, comme si elle était endormie. Cette impression de plénitude est due aux yeux fermés de la jeune fille et à son expression imperturbable, comme si elle n’allait jamais les rouvrir. Sous certaines perspectives, Sanna peut adopter différents styles : de face son visage est parfaitement droit et bien proportionné mais de côté son visage semble difforme. Aussi, nous pouvons voir évoluer les couleurs de la demoiselle de fonte au fur et à mesure des années. En effet, la sculpture rouille et sa teinte varie en fonction du temps. Sanna se situe devant le grand théâtre sur la place de la Comédie, son style particulier qui marie la grossièreté du fer et la finesse des traits, se combine parfaitement avec l’opéra par ses formes imposantes et travaillées. Pour l’artiste, Jaume Plensa, le visage est « le miroir de l’âme ». Par conséquent, l\'œuvre permet aux bordelais d’acquérir un instant de paix de l’esprit en plein cœur de la ville.', 'L\'achat de la statue', 'En plus de son aspect artistique, la sculpture de Sanna génère évidemment aussi un certain engouement affectant son aspect économique. En effet, en 2014 après l’exposition de Jaume Plensa, Bordeaux fait une levée de fond pour racheter la sculpture. La ville a besoin de récolter 150 000 € auprès des habitants et prévoit ensuite de compléter cette récolte en sortant également un minimum de 150 000 € de sa poche. Effectivement, la valeur financière de l\'œuvre varie entre 300 000 € et 500 000 €. Malheureusement, les dons étant trop faibles, la récolte n\'aboutit pas à un résultat concluant. Seulement 44 000 € ont été récoltés ce qui n’a absolument pas été suffisant pour que la municipalité prenne en charge le reste de l’achat. Fort heureusement en 2015, un particulier anonyme achète la statue et signe un contrat avec la municipalité de Bordeaux pour la laisser 6 ans de plus sur la place de la Comédie. Plus récemment encore, le 8 février 2022, la ville de Bordeaux a annoncé officiellement qu’un autre accord avait été approuvé, permettant à la sculpture de rester sur la place et surtout dans nos cœurs jusqu’en 2027.', 'Finalement, cette sculpture reste encore parmi nous pendant un bon moment. Cette demoiselle de fonte au vécu poétique ayant rythmé la vie de beaucoup de bordelais continuera donc de le faire ces cinq prochaines années. Et cette affaire d’argent plutôt compliquée pour la mairie de Bordeaux lui a tout de même permis de conserver ce bien grâce à l’aide de ce fameux acheteur anonyme. Nous vous suggérons donc d’aller une fois encore apprécier sa présence avant son départ imminent ! Avec l’équipe de rédaction, nous nous demandions si vous aussi vous aviez des anecdotes croustillantes à raconter sur ce visage fait de métaux. Qu’est-ce qu’elle vous fait ressentir ? Êtes-vous heureux d’apprendre qu’elle reste à nos côtés encore longtemps vous aussi ? Nous avons hâte de lire vos réponses en commentaire !', 'imgArt5.jpg', 4),
(6, '2023-12-04 10:08:30', '2026-01-29 09:25:22', 'Comment le sang bleu a dominé le symbole de Bordeaux ?', 'Tout au long de son histoire Bordeaux a connu de nombreuses façon d’être représentée, ou comment ses armoiries ont été les images de son occupation anglaise, de sa domination royale et de la prospérité moderne qu’elle connaît au 21ème siècle.', 'Avez-vous déjà vu l’emblématique blason de Bordeaux ?', 'Ce symbole qui à plusieurs reprises, s’est vu transformer par la noblesse anglaise. Celui provenant du Moyen âge tardif sous la conquête française est le plus connu puisque c’est une représentation symbolique et figurée grâce auquelle on peut deviner l’histoire entremêlée de la ville. Trois couleurs dominent cet écusson : le jaune, le rouge et le bleu. Dessus on peut y reconnaître différentes formes dont des « meubles » qui représentent des éléments précis. Situé au sommet de l’écu bordelais, semblable à un ciel bleu nuit, étoilé de fleurs de lys, se trouve le Chef d’azur semé de France symbole des rois de France. Au-dessous, sur un fond rouge sang, un Léopard d’or et non un Lion, représentant la province de la Guyenne, survole une forteresse. Ce n’est pas une simple forteresse idéale mais l\'un des monuments phare de Bordeaux : la Grosse-Cloche, reproduite sous des traits stylisés. Elle est fortifiée de deux tours aujourd’hui disparus. Comme débordant à flot, la mer d’azur ondoyé de sable d’argent incarnant la Garonne se voit surmonté d’un croissant d’argent qui fait évidemment allusion à la forme semi-circulaire du port de la Lune.', 'Un blason malmené aux bleus visibles', 'Si la première représentation connue du blason français de Bordeaux se trouve dans l’ouvrage de Gabriel de Tareda nommé Tracté contre la peste de 1519. Ce ne fut pas la première version à voir le jour. La ville fut influencée par le sang bleu anglais, la monarchie provenant d’Angleterre, pendant 300 ans, cette situation impactant le reflet de Bordeaux : son Blason. Richard Cœur de Lion a façonné un écu à son image afin d\'asseoir sa domination, ainsi se fut trois Léopards d’or qui logeaient au sommet du blason. Ce n’est qu’en 1453 grâce à la reconquête française, que le blason pris sa forme définitive, celle qu’on connaît, arborant finalement le symbole des rois français à la place. Plus tard une dernière version apparu : deux antilopes enchaînées et à collier fleurdelisé, ainsi qu’une couronne murale représentant une muraille encadre le blason français. Ce sont des supports d’armoiries inusitées en France, au Moyen-Âge. Une devise y est aussi inscrite « Lilia sola regunt lunam unda castra leonem » retranscrit « les lys règnent seuls sur la lune, les ondes, la forteresse et le lion » faisant allusion à la domination du roi de France sur Bordeaux, après la période d’occupation anglaise.', 'Le bleu roi toujours au devant du tableau bordelais', 'Malgré la confuse histoire ce blason des plus symboliques, la grande ville qu’est Bordeaux ne peut se décider à l’utiliser pour se représenter en ces temps modernes. Pour résoudre cette affaire de grande envergure la mairie a choisi un logo neutre tout en gardant un symbole représentatif : le port de la lune. En effet le logo-type de la ville est constitué de trois croissants entrelacés qu’on appelle aussi le chiffre de Bordeaux, de couleur blanc nacré sur fond rouge bordeaux. Il n’est pas impossible qu’elles figurent sur certaines reliure de livre et sur la fontaine Saint-Projet de la rue Sainte-Catherine. Gravé dans la pierre, fondue dans le métal ou sur le verre des bouteilles « bordelaises » on retrouve ce symbole sur tous les produits provenant de la ville. Le trio lunaire est également surmonté du nom de la ville sur fond bleu roi. Cette couleur qui a su se faire une place dans l’histoire de Bordeaux, représente autant la royauté que le fleuve bordelais. Et aujourd’hui à l’époque où l’homme s’élève grâce aux nouvelles technologies qui nous permettent de nombreux exploits, on peut enfin poser un nom sur ce bleu qui nous a guidé tous ces siècles et lui rendre hommage : Le Bleu 072 C.', 'Si la ville de Bordeaux a sa charte graphique et son propre logo elle n’est pas la seule, on retrouve nombreux logo tout aussi caractéristique s’inspirant de l’histoire, comme les logos d’Aquitaine, de l’Union Bordeaux-Bègles ou des bleus de Bordeaux : les Girondins !', 'imgArt6.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `BRANCHE_PERSONNEL`
--

CREATE TABLE `BRANCHE_PERSONNEL` (
  `numBranche` int NOT NULL,
  `libBranche` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `BRANCHE_PERSONNEL`
--

INSERT INTO `BRANCHE_PERSONNEL` (`numBranche`, `libBranche`) VALUES
(1, 'Bureau de direction'),
(2, 'Commission technique'),
(3, 'Commission animation'),
(4, 'Commission communication');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `numCom` int NOT NULL,
  `dtCreaCom` datetime DEFAULT CURRENT_TIMESTAMP,
  `libCom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtModCom` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `attModOK` tinyint(1) DEFAULT '0',
  `notifComKOAff` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dtDelLogCom` datetime DEFAULT NULL,
  `delLogiq` tinyint(1) DEFAULT '0',
  `numArt` int NOT NULL,
  `numMemb` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `COMMENT`
--

INSERT INTO `COMMENT` (`numCom`, `dtCreaCom`, `libCom`, `dtModCom`, `attModOK`, `notifComKOAff`, `dtDelLogCom`, `delLogiq`, `numArt`, `numMemb`) VALUES
(10, '2026-01-30 15:08:14', 'bonjours ces un test', '2026-02-03 16:02:47', 1, '', NULL, 0, 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `COOKIE_CONSENT`
--

CREATE TABLE `COOKIE_CONSENT` (
  `numCon` int NOT NULL,
  `ipAdresse` varchar(45) NOT NULL,
  `choixConsent` enum('accepted','rejected') NOT NULL,
  `dateCon` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateExpiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `COOKIE_CONSENT`
--

INSERT INTO `COOKIE_CONSENT` (`numCon`, `ipAdresse`, `choixConsent`, `dateCon`, `dateExpiration`) VALUES
(1, '::1', 'accepted', '2026-02-04 15:07:16', '2026-02-05 14:07:16');

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPE`
--

CREATE TABLE `EQUIPE` (
  `numEquipe` int NOT NULL,
  `libEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `libEquipeComplet` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categorieEquipe` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sectionEquipe` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveauEquipe` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descriptionEquipe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photoEquipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photoStaffEquipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pointsMarquesDomicile` int NOT NULL DEFAULT '0',
  `pointsEncaissesDomicile` int NOT NULL DEFAULT '0',
  `pointsMarquesExterieur` int NOT NULL DEFAULT '0',
  `pointsEncaissesExterieur` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `EQUIPE`
--

INSERT INTO `EQUIPE` (`numEquipe`, `libEquipe`, `libEquipeComplet`, `categorieEquipe`, `sectionEquipe`, `niveauEquipe`, `descriptionEquipe`, `photoEquipe`, `photoStaffEquipe`, `pointsMarquesDomicile`, `pointsEncaissesDomicile`, `pointsMarquesExterieur`, `pointsEncaissesExterieur`) VALUES
(1, 'SG1', 'Seniors garçons - Pré-nationale', 'Sénior', 'Masculin', 'PNM', 'Équipe fanion masculine engagée en pré-nationale, portée par l’intensité et la rigueur collective.', 'photo-equipe-SG1.webp', 'photo-staff-equipe-SG1.webp', 0, 0, 0, 0),
(2, 'SG2', 'Seniors garçons - Régionale 2', 'Sénior', 'Masculin', 'RM2', 'Groupe solide et ambitieux en régionale 2, avec un encadrement tourné vers la progression.', 'photo-equipe-SG2.webp', 'photo-staff-equipe-SG2.webp', 0, 0, 0, 0),
(3, 'SG3', 'Seniors garçons - Départementale 3', 'Sénior', 'Masculin', 'DM3', 'Collectif en départementale 3 qui fait grandir les joueurs tout en développant le jeu d’équipe.', 'photo-equipe-SG3.webp', 'photo-staff-equipe-SG3.webp', 0, 0, 0, 0),
(4, 'SG4', 'Seniors garçons - Départementale 4', 'Sénior', 'Masculin', 'DM4', 'Équipe en départementale 4 dédiée au plaisir du jeu et à l’apprentissage compétitif.', 'photo-equipe-SG4.webp', 'photo-staff-equipe-SG4.webp', 0, 0, 0, 0),
(5, 'SF1', 'Seniors filles - National 3', 'Sénior', 'Féminin', 'NF3', 'Les Seniors filles en National 3 incarnent l’exigence et l’ambition du BEC au plus haut niveau.', 'photo-equipe-SF1.webp', 'photo-staff-equipe-SF1.webp', 0, 0, 0, 0),
(6, 'SF2', 'Seniors filles - Pré-nationale', 'Sénior', 'Féminin', 'PNF', 'Formation compétitive en pré-nationale, axée sur la cohésion et la montée en puissance.', 'photo-equipe-SF2.webp', 'photo-staff-equipe-SF2.webp', 0, 0, 0, 0),
(7, 'SF3', 'Seniors filles - Pré-régionale', 'Sénior', 'Féminin', 'PRF', 'Groupe en pré-régionale qui combine intensité et développement des jeunes talents.', 'photo-equipe-SF3.webp', 'photo-staff-equipe-SF3.webp', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPE_JOUEUR`
--

CREATE TABLE `EQUIPE_JOUEUR` (
  `numEquipe` int NOT NULL,
  `numJoueur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `EQUIPE_JOUEUR`
--

INSERT INTO `EQUIPE_JOUEUR` (`numEquipe`, `numJoueur`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(6, 26),
(6, 27),
(6, 28),
(6, 29),
(6, 30),
(7, 31),
(7, 32),
(7, 33),
(7, 34),
(7, 35),
(3, 37);

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPE_PERSONNEL`
--

CREATE TABLE `EQUIPE_PERSONNEL` (
  `numEquipe` int NOT NULL,
  `numPersonnel` int NOT NULL,
  `libRoleEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `EQUIPE_PERSONNEL`
--

INSERT INTO `EQUIPE_PERSONNEL` (`numEquipe`, `numPersonnel`, `libRoleEquipe`) VALUES
(1, 13, 'Coach'),
(5, 13, 'Coach'),
(2, 14, 'Coach'),
(6, 14, 'Coach'),
(3, 15, 'Coach'),
(7, 15, 'Coach'),
(4, 16, 'Coach'),
(1, 17, 'Assistant'),
(2, 18, 'Assistant'),
(5, 18, 'Assistant'),
(3, 19, 'Assistant'),
(6, 19, 'Assistant'),
(4, 20, 'Assistant'),
(7, 20, 'Assistant');

-- --------------------------------------------------------

--
-- Structure de la table `JOUEUR`
--

CREATE TABLE `JOUEUR` (
  `numJoueur` int NOT NULL,
  `prenomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlPhotoJoueur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posteJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numMaillot` int DEFAULT NULL,
  `anneeArrivee` year DEFAULT NULL,
  `clubsPrecedents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dateNaissance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `JOUEUR`
--

INSERT INTO `JOUEUR` (`numJoueur`, `prenomJoueur`, `nomJoueur`, `urlPhotoJoueur`, `posteJoueur`, `numMaillot`, `anneeArrivee`, `clubsPrecedents`, `dateNaissance`) VALUES
(1, 'Lucas', 'Morel', NULL, 'Poste 1 : meneur (point guard)', 4, '2022', NULL, '2001-03-12'),
(2, 'Enzo', 'Robert', NULL, 'Poste 2 : arrière (shooting guard)', 7, '2021', NULL, '2000-06-08'),
(3, 'Theo', 'Garnier', NULL, 'Poste 3 : ailier (small forward)', 11, '2020', NULL, '1999-09-21'),
(4, 'Hugo', 'Marchand', NULL, 'Poste 4 : ailier fort (power forward)', 14, '2023', NULL, '2002-01-17'),
(5, 'Maxime', 'Rousseau', NULL, 'Poste 5 : pivot (center)', 15, '2019', NULL, '1998-11-30'),
(6, 'Quentin', 'Faure', NULL, 'Poste 1 : meneur (point guard); Poste 2 : arrière (shooting guard)', 5, '2022', NULL, '2001-05-03'),
(7, 'Nathan', 'Perez', NULL, 'Poste 2 : arrière (shooting guard)', 8, '2021', NULL, '2000-12-14'),
(8, 'Adrien', 'Boyer', NULL, 'Poste 3 : ailier (small forward)', 12, '2020', NULL, '1999-04-19'),
(9, 'Julien', 'Lemaire', NULL, 'Poste 4 : ailier fort (power forward); Poste 5 : pivot (center)', 21, '2023', NULL, '2002-02-27'),
(10, 'Thomas', 'Renault', NULL, 'Poste 5 : pivot (center)', 22, '2018', NULL, '1997-07-07'),
(11, 'Matthieu', 'Kuevidjen', NULL, 'Poste 2 : arrière (shooting guard)', 5, '2025', NULL, '2003-03-10'),
(12, 'Jean guillaume', 'Bidart', NULL, 'Poste 1 : meneur (point guard)', 4, '2021', NULL, '1984-04-30'),
(13, 'Danny', 'Dramet', NULL, 'Poste 4 : ailier fort (power forward)', 11, '2023', NULL, '1993-10-01'),
(15, 'Robin', 'Collomb', NULL, 'Poste 3 : ailier (small forward)', 8, '2025', NULL, '2005-03-22'),
(16, 'Romain', 'Vidal', NULL, 'Poste 1 : meneur (point guard); Poste 2 : arrière (shooting guard)', 3, '2020', NULL, '1999-01-15'),
(17, 'Vincent', 'Guerin', NULL, 'Poste 2 : arrière (shooting guard)', 10, '2021', NULL, '2000-03-09'),
(18, 'Clement', 'Roy', NULL, 'Poste 3 : ailier (small forward)', 16, '2022', NULL, '2001-11-18'),
(19, 'Florent', 'Henry', NULL, 'Poste 4 : ailier fort (power forward); Poste 5 : pivot (center)', 20, '2023', NULL, '2002-09-04'),
(20, 'Fabien', 'Chevalier', NULL, 'Poste 5 : pivot (center)', 25, '2018', NULL, '1997-04-26'),
(21, 'Clara', 'Martin', NULL, 'Poste 1 : meneur (point guard)', 4, '2021', NULL, '2001-07-13'),
(22, 'Emma', 'Petit', NULL, 'Poste 2 : arrière (shooting guard)', 7, '2020', NULL, '2000-10-31'),
(23, 'Lea', 'Fournier', NULL, 'Poste 3 : ailier (small forward)', 11, '2019', NULL, '1999-02-06'),
(24, 'Manon', 'Dubois', NULL, 'Poste 4 : ailier fort (power forward)', 14, '2022', NULL, '2001-12-22'),
(25, 'Sarah', 'Leroy', NULL, 'Poste 4 : ailier fort (power forward); Poste 5 : pivot (center)', 15, '2023', NULL, '2002-03-28'),
(26, 'Julie', 'Bernard', NULL, 'Poste 1 : meneur (point guard); Poste 2 : arrière (shooting guard)', 5, '2021', NULL, '2000-05-16'),
(27, 'Chloé', 'Roux', NULL, 'Poste 2 : arrière (shooting guard)', 8, '2020', NULL, '1999-09-09'),
(28, 'Alice', 'Giraud', NULL, 'Poste 3 : ailier (small forward)', 12, '2019', NULL, '1998-11-25'),
(29, 'Camille', 'Lefevre', NULL, 'Poste 4 : ailier fort (power forward); Poste 5 : pivot (center)', 21, '2022', NULL, '2001-01-20'),
(30, 'Ines', 'Moreau', NULL, 'Poste 5 : pivot (center)', 22, '2023', NULL, '2002-06-30'),
(31, 'Lola', 'Garcia', NULL, 'Poste 1 : meneur (point guard)', 6, '2020', NULL, '1999-08-12'),
(32, 'Jade', 'Perrin', NULL, 'Poste 2 : arrière (shooting guard); Poste 3 : ailier (small forward)', 9, '2021', NULL, '2000-02-03'),
(33, 'Nina', 'Mathis', NULL, 'Poste 3 : ailier (small forward)', 13, '2022', NULL, '2001-05-24'),
(34, 'Eva', 'Rolland', NULL, 'Poste 4 : ailier fort (power forward)', 18, '2023', NULL, '2002-10-07'),
(35, 'Zoé', 'Muller', NULL, 'Poste 5 : pivot (center)', 24, '2019', NULL, '1998-04-15'),
(37, 'Mehdi', 'afankous', '1770171329_IMG_9876 (2).webp', 'Poste 5 : pivot (center)', 15, '2021', NULL, '2001-04-16');

-- --------------------------------------------------------

--
-- Structure de la table `LIKEART`
--

CREATE TABLE `LIKEART` (
  `numMemb` int NOT NULL,
  `numArt` int NOT NULL,
  `likeA` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `LIKEART`
--

INSERT INTO `LIKEART` (`numMemb`, `numArt`, `likeA`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 5, 1),
(2, 1, 0),
(2, 3, 1),
(3, 1, 1),
(3, 2, 1),
(3, 6, 1),
(5, 6, 1),
(6, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `MEMBRE`
--

CREATE TABLE `MEMBRE` (
  `numMemb` int NOT NULL,
  `prenomMemb` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomMemb` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudoMemb` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passMemb` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `eMailMemb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtCreaMemb` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtMajMemb` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `accordMemb` tinyint(1) DEFAULT '1',
  `cookieMemb` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numStat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `MEMBRE`
--

INSERT INTO `MEMBRE` (`numMemb`, `prenomMemb`, `nomMemb`, `pseudoMemb`, `passMemb`, `eMailMemb`, `dtCreaMemb`, `dtMajMemb`, `accordMemb`, `cookieMemb`, `numStat`) VALUES
(1, 'Freddie', 'Mercury', 'Admin99', '12345678', 'freddie.mercury@gmail.com', '2019-05-29 10:13:43', NULL, 1, NULL, 1),
(2, 'Phil', 'Collins', 'Phil09', '12345678', 'phil.collins@gmail.com', '2020-01-09 10:13:43', '2026-01-30 04:59:28', 1, NULL, 1),
(3, 'Julie', 'La Rousse', 'juju1989', '12345678', 'julie.larousse@gmail.com', '2020-03-15 14:33:23', '2026-01-30 04:59:31', 1, NULL, 1),
(4, 'David', 'Bowie', 'dav33B', '12345678', 'david.bowie@gmail.com', '2020-07-19 13:13:13', '2026-01-30 04:59:23', 1, NULL, 1),
(5, 'afanpeak', 'afanpeak', 'afanpeak', '$2y$10$VSUvJ23ruFHe8X6yvvgv4eynjeDZXKu8U3GiLQoakJs1k1MnRQhN.', 'mehdi@gmail.com', '2026-01-29 08:10:30', '2026-01-30 04:38:39', 1, NULL, 1),
(6, 'jesuisadmin', 'jesuisadmin', 'mehdiadmin', '$2y$10$hz7QcNyOgY4sRyY0G3CikuJpU64VX3G46tiM2IwLMFrODdSGylSda', 'mehdiadmin@gmail.com', '2026-01-30 04:01:17', '2026-01-30 05:05:09', 1, NULL, 1),
(7, 'mehdi', 'afankous', 'afankops', 'Afankops123', 'afankops@gmail.com', '2026-01-30 05:04:05', NULL, 1, NULL, 1),
(8, 'mehdi', 'afankous', 'afankops', 'Afankops123', 'afankops@gmail.com', '2026-01-30 05:04:14', NULL, 1, NULL, 1),
(9, 'mehdimehdi', 'mehdi', 'mehdimehdi', '$2y$10$CsfmE.hPl/LoZ7X4nY1q0O/XUl.f.WrIK3OmRopt02PY2AGooJUMu', 'mehdimehdi@mehdi.com', '2026-01-30 15:13:37', NULL, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `MOTCLE`
--

CREATE TABLE `MOTCLE` (
  `numMotCle` int NOT NULL,
  `libMotCle` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `MOTCLE`
--

INSERT INTO `MOTCLE` (`numMotCle`, `libMotCle`) VALUES
(1, 'Bordeaux'),
(2, 'Basket'),
(3, 'National'),
(4, 'Régional'),
(5, 'Départementale'),
(6, 'Derby'),
(7, 'Evenement');

-- --------------------------------------------------------

--
-- Structure de la table `MOTCLEARTICLE`
--

CREATE TABLE `MOTCLEARTICLE` (
  `numArt` int NOT NULL,
  `numMotCle` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `MOTCLEARTICLE`
--

INSERT INTO `MOTCLEARTICLE` (`numArt`, `numMotCle`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(3, 3),
(3, 6),
(4, 1),
(4, 6),
(5, 1),
(5, 6),
(6, 1),
(6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `PERSONNEL`
--

CREATE TABLE `PERSONNEL` (
  `numPersonnel` int NOT NULL,
  `prenomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlPhotoPersonnel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `PERSONNEL`
--

INSERT INTO `PERSONNEL` (`numPersonnel`, `prenomPersonnel`, `nomPersonnel`, `urlPhotoPersonnel`) VALUES
(1, 'Jean', 'Dupont', NULL),
(2, 'Marie', 'Martin', NULL),
(3, 'Claire', 'Petit', NULL),
(4, 'Sophie', 'Leroy', NULL),
(5, 'Luc', 'Bernard', NULL),
(6, 'Emma', 'Roux', NULL),
(7, 'Paul', 'Fournier', NULL),
(8, 'Nina', 'Giraud', NULL),
(9, 'Hugo', 'Lefevre', NULL),
(10, 'Laura', 'Moreau', NULL),
(11, 'Tom', 'Garcia', NULL),
(12, 'Julie', 'Dubois', NULL),
(13, 'Alain', 'Morel', NULL),
(14, 'Sophie', 'Lambert', NULL),
(15, 'Karim', 'Boucher', NULL),
(16, 'Amelie', 'Renaud', NULL),
(17, 'Lucas', 'Perrin', NULL),
(18, 'Ines', 'Mathieu', NULL),
(19, 'Thomas', 'Rolland', NULL),
(20, 'Eva', 'Guerin', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `STATUT`
--

CREATE TABLE `STATUT` (
  `numStat` int NOT NULL,
  `libStat` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtCreaStat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `STATUT`
--

INSERT INTO `STATUT` (`numStat`, `libStat`, `dtCreaStat`) VALUES
(1, 'Administrateur', '2023-02-19 15:15:59'),
(2, 'Modérateur', '2023-02-19 15:19:12'),
(3, 'Membre', '2023-02-20 08:43:24');

-- --------------------------------------------------------

--
-- Structure de la table `THEMATIQUE`
--

CREATE TABLE `THEMATIQUE` (
  `numThem` int NOT NULL,
  `libThem` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `THEMATIQUE`
--

INSERT INTO `THEMATIQUE` (`numThem`, `libThem`) VALUES
(1, 'L\'événement'),
(2, 'L\'acteur-clé'),
(3, 'Le mouvement émergeant'),
(4, 'L\'insolite / le clin d\'œil');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `AFFECTATION_PERSONNEL`
--
ALTER TABLE `AFFECTATION_PERSONNEL`
  ADD PRIMARY KEY (`numAffectation`),
  ADD UNIQUE KEY `uniq_personnel_branche_poste` (`numPersonnel`,`numBranche`,`libPoste`),
  ADD KEY `FK_AFFECTATION_PERSONNEL_PERSONNEL` (`numPersonnel`),
  ADD KEY `FK_AFFECTATION_PERSONNEL_BRANCHE` (`numBranche`);

--
-- Index pour la table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  ADD PRIMARY KEY (`numArt`),
  ADD KEY `ARTICLE_FK` (`numArt`),
  ADD KEY `FK_ASSOCIATION_1` (`numThem`);

--
-- Index pour la table `BRANCHE_PERSONNEL`
--
ALTER TABLE `BRANCHE_PERSONNEL`
  ADD PRIMARY KEY (`numBranche`);

--
-- Index pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD PRIMARY KEY (`numCom`),
  ADD KEY `COMMENT_FK` (`numCom`),
  ADD KEY `FK_ASSOCIATION_2` (`numArt`),
  ADD KEY `FK_ASSOCIATION_3` (`numMemb`);

--
-- Index pour la table `COOKIE_CONSENT`
--
ALTER TABLE `COOKIE_CONSENT`
  ADD PRIMARY KEY (`numCon`),
  ADD KEY `idx_ip` (`ipAdresse`),
  ADD KEY `idx_expiration` (`dateExpiration`);

--
-- Index pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  ADD PRIMARY KEY (`numEquipe`);

--
-- Index pour la table `EQUIPE_JOUEUR`
--
ALTER TABLE `EQUIPE_JOUEUR`
  ADD PRIMARY KEY (`numEquipe`,`numJoueur`),
  ADD KEY `FK_EQUIPE_JOUEUR_JOUEUR` (`numJoueur`);

--
-- Index pour la table `EQUIPE_PERSONNEL`
--
ALTER TABLE `EQUIPE_PERSONNEL`
  ADD PRIMARY KEY (`numEquipe`,`numPersonnel`,`libRoleEquipe`),
  ADD KEY `FK_EQUIPE_PERSONNEL_PERSONNEL` (`numPersonnel`);

--
-- Index pour la table `JOUEUR`
--
ALTER TABLE `JOUEUR`
  ADD PRIMARY KEY (`numJoueur`);

--
-- Index pour la table `LIKEART`
--
ALTER TABLE `LIKEART`
  ADD PRIMARY KEY (`numMemb`,`numArt`),
  ADD KEY `LIKEART_FK` (`numMemb`,`numArt`),
  ADD KEY `FK_LIKEART1` (`numArt`);

--
-- Index pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD PRIMARY KEY (`numMemb`),
  ADD KEY `MEMBRE_FK` (`numMemb`),
  ADD KEY `FK_ASSOCIATION_4` (`numStat`);

--
-- Index pour la table `MOTCLE`
--
ALTER TABLE `MOTCLE`
  ADD PRIMARY KEY (`numMotCle`),
  ADD KEY `MOTCLE_FK` (`numMotCle`);

--
-- Index pour la table `MOTCLEARTICLE`
--
ALTER TABLE `MOTCLEARTICLE`
  ADD PRIMARY KEY (`numArt`,`numMotCle`),
  ADD KEY `MOTCLEARTICLE_FK` (`numArt`),
  ADD KEY `MOTCLEARTICLE2_FK` (`numMotCle`);

--
-- Index pour la table `PERSONNEL`
--
ALTER TABLE `PERSONNEL`
  ADD PRIMARY KEY (`numPersonnel`);

--
-- Index pour la table `STATUT`
--
ALTER TABLE `STATUT`
  ADD PRIMARY KEY (`numStat`),
  ADD KEY `STATUT_FK` (`numStat`);

--
-- Index pour la table `THEMATIQUE`
--
ALTER TABLE `THEMATIQUE`
  ADD PRIMARY KEY (`numThem`),
  ADD KEY `THEMATIQUE_FK` (`numThem`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `AFFECTATION_PERSONNEL`
--
ALTER TABLE `AFFECTATION_PERSONNEL`
  MODIFY `numAffectation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  MODIFY `numArt` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `BRANCHE_PERSONNEL`
--
ALTER TABLE `BRANCHE_PERSONNEL`
  MODIFY `numBranche` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `numCom` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  MODIFY `numEquipe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `JOUEUR`
--
ALTER TABLE `JOUEUR`
  MODIFY `numJoueur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  MODIFY `numMemb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `PERSONNEL`
--
ALTER TABLE `PERSONNEL`
  MODIFY `numPersonnel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `THEMATIQUE`
--
ALTER TABLE `THEMATIQUE`
  MODIFY `numThem` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `AFFECTATION_PERSONNEL`
--
ALTER TABLE `AFFECTATION_PERSONNEL`
  ADD CONSTRAINT `fk_affectation_personnel_branche` FOREIGN KEY (`numBranche`) REFERENCES `BRANCHE_PERSONNEL` (`numBranche`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_affectation_personnel_personnel` FOREIGN KEY (`numPersonnel`) REFERENCES `PERSONNEL` (`numPersonnel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EQUIPE_JOUEUR`
--
ALTER TABLE `EQUIPE_JOUEUR`
  ADD CONSTRAINT `fk_equipe_joueur_equipe` FOREIGN KEY (`numEquipe`) REFERENCES `EQUIPE` (`numEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipe_joueur_joueur` FOREIGN KEY (`numJoueur`) REFERENCES `JOUEUR` (`numJoueur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EQUIPE_PERSONNEL`
--
ALTER TABLE `EQUIPE_PERSONNEL`
  ADD CONSTRAINT `fk_equipe_personnel_equipe` FOREIGN KEY (`numEquipe`) REFERENCES `EQUIPE` (`numEquipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipe_personnel_personnel` FOREIGN KEY (`numPersonnel`) REFERENCES `PERSONNEL` (`numPersonnel`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
