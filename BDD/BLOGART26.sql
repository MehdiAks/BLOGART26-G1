-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 06 fév. 2026 à 08:54
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
-- Structure de la table `ARTICLE`
--

CREATE TABLE `ARTICLE` (
  `numArt` int NOT NULL,
  `dtCreaArt` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtMajArt` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `libTitrArt` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `libChapoArt` text COLLATE utf8mb3_unicode_ci,
  `libAccrochArt` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parag1Art` text COLLATE utf8mb3_unicode_ci,
  `libSsTitr1Art` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parag2Art` text COLLATE utf8mb3_unicode_ci,
  `libSsTitr2Art` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parag3Art` text COLLATE utf8mb3_unicode_ci,
  `libConclArt` text COLLATE utf8mb3_unicode_ci,
  `urlPhotArt` varchar(70) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `numThem` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `ARTICLE`
--

INSERT INTO `ARTICLE` (`numArt`, `dtCreaArt`, `dtMajArt`, `libTitrArt`, `libChapoArt`, `libAccrochArt`, `parag1Art`, `libSsTitr1Art`, `parag2Art`, `libSsTitr2Art`, `parag3Art`, `libConclArt`, `urlPhotArt`, `numThem`) VALUES
(1, '2019-02-24 16:08:30', NULL, 'La surprenante reconversion de la base sous-marine', 'Un bâtiment unique chargé d\'histoire qui a survécu à l\'emprise des Allemands en 1943, et qui est aujourd\'hui l\'un des symboles d\'art de notre ville bordelaise. Comment ce bloc de béton armé a-t-il pu surpasser son obscure origine ?', 'La grande immergée du port de la Lune n’a pas toujours été celle que l’on connaît aujourd’hui', 'La grande immergée du port de la Lune, éclairée de son immense néon bleu « something strange happened here » n’a pas toujours été celle que l’on connaît aujourd’hui. Oui, notre base sous-marine est notre héritage nazi. En 1943, le bloc de béton, que nous connaissons tous, voit le jour après 22 mois de travaux forcés par des prisonniers. Une légende urbaine raconte que plus d’une centaine de ces travailleurs se seraient noyés d\'épuisement et même que certain auraient été coulés dans le béton. 235 mètres de long, 160 mètres de large, 19 mètres de hauteur, et une superficie de plus de 41 000 m2, cette base aux quatre sœurs se situant le long des côtes forment à la perfection le « Mur de l’Atlantique » érigé par les nazis fous. Le bâtiment de guerre a été pensé pour vivre des siècles, composé de 11 bassins, il peut accueillir quinze grands sous-marins. Tout ceci surplombé d\'une tour bunker abritant des magasins et des ateliers. L\'ensemble est couvert d\'un toit en béton armé de plus de 5 mètres d\'épaisseur, renforcé en 1943 par un dispositif de pare-bombes, capable de provoquer l\'explosion d\'une bombe avant d\'atteindre le toit. Un bijou nazi de 600 000 m3 de béton prêt pour résister.', 'Quel avenir pour cet amas de béton ?', 'Après la destruction et le sabotage du matériel nazis par les Alliés en août 1944, il a fallu se demander que deviendrait ce bâtiment. Raser l’édifice bétonné est la première idée à avoir vu le jour. Elle fut rapidement abandonnée, dû à son coup et sa logistique trop complexe. Mais petit-à-petit, elle va renaître dans les esprits après avoir servi de décor pour le film « Le Coup de Grâce » en 1964. Plus tard sous l’impulsion du batteur Jean-François Buisson, un studio d’enregistrement est aménagé pour son groupe dans l\'alvéole 9. Le bunker commence à attirer et interpeler les artistes qui y voient un lieu charismatique. En septembre 1998, l\'association Art AttAcks réalise la première exposition d’art contemporain « Sous le béton la plage » mêlant arts visuels et architecture. Tout ceci annonce subtilement la vocation artistique du lieu. Quelques mois plus tard, la première grande rénovation du vieux bâtiment a lieu pour permettre le renouveau de la base sous-marine. Lors de l’été 1999, la montagne de métal s’ouvre enfin au public leur proposant des expositions permanentes ou temporaires. Depuis la base a accueilli de nombreuses exhibitions artistiques et plus de 110 000 visiteurs.', 'Peau neuve, colorée et numérique pour la base bordelaise.', 'Aujourd\'hui la base sous-marine occupe une place incontournable dans le paysage culturel bordelais. Mais en 2020 elle se refait une beauté ! Passée de l\'ombre à la lumière voilà le nouvel objectif du monument. Culturespaces cherche à attirer tous les regards bordelais vers le bâtiment bétonné. Son projet ? Faire de la base sous-marine bordelaise le plus grand centre d\'art numérique au monde. Plusieurs défis ont dû être relevés en raison de l\'historique de la base, ancien bâtiment bombardé et de la présence de l\'eau avec une profondeur de 16 m (création de nouvelles passerelles, ajout d\'un bâtiment annexe future billetterie). Mais tout est fait pour transformer cet amas de béton en « Bassin des Lumières ». Après une nouvelle rénovation la grande immergée devient innovante et atypique grâce à une nouvelle expérience visuelle et sonore avec la projection de la première exposition depuis la rénovation en l\'honneur des tableaux de Gustave Klimt qui épouseront les formes de l\'édifice et se refléteront sur les courbes de l\'eau. Près de 70 ans plus tard, la base sous-marine s\'est métamorphosée en symbole d\'art comme si elle voulait prendre une revanche sur l\'origine de sa construction.', 'Pour le mot de la fin : Bruno Monnier, président de Culturespace, affirme que ses équipes et lui ont travaillé d’arrache-pied pour imaginer et concevoir la nouvelle base sous marine. Il confie à AquitaineOnline que « C’est une installation unique au monde qui s’intègre aux dimensions gigantesques du lieu ». Chez Gavé Bleu, nous trouvons le projet fantastique ! Et nous espérons que comme nous, vous serez au rendez-vous pour (re)découvrir ce monument bordelais qui revit !', 'imgArt19.jpeg', 1),
(2, '2019-03-13 20:14:10', '2024-01-12 11:08:24', 'Le CHU de bordeaux se met-il au bleu ?', 'Le bleu, une couleur si commune, qui provoque tranquillité, sécurité et confiance. Toutes ces raisons pourraient déjà expliquer ce que Gavé bleu a remarqué… Mais regardons plus loin ! Pourquoi le CHU, lieu d’urgence, d’anxiété, parfois lier aux défunts, se pare d’une couleur si complémentaire, le bleu ?', 'Le CHU de Bordeaux, lieu au service de tous, tient un rôle important dans la vie des Bordelais !', 'Tout d’abord, un logo, que vous avez vu et revu, mais auquel vous n\'avez jamais, vraiment prêté attention. Ce logo est le même depuis 20 ans, exprimant les valeurs de l’hôpital, l’accueil, l’ouverture et l’échange. Il véhicule une image forte et symbolique. De plus, sa couleur est bleue ciel, tel les casques bleus de l’ONU, évoque donc la paix, l’assurance, la bienveillance et l’expertise. On peut remarquer que, c’est aussi la couleur phare de grands groupes, et d’entreprises pharmaceutiques, tel que La Roche-Posay, Bayer, Vichy ou encore Nivea. Pourquoi un tel intérêt ? Vous ne le savez peut-être pas, mais à une époque, on parlait de « Sang Bleu », ce qui correspondait aux personnes de la noblesse ou de sang royal, donc historiquement le bleu évoque aussi, le prestige ! Pour finir, le bleu est aussi une des 3 couleurs primaires, donc essentiel pour pouvoir construire les autres couleurs. Ce qui fait écho avec le fait que l\'hôpital est en lieu nécessaire et primordial à la société !', 'Savez-vous pourquoi les blouses des chirurgiens sont-elles bleues ?', 'Voici une question que vous ne vous êtes peut-être jamais posée. Pourquoi les différents hôpitaux, ont-ils choisi, pour leurs opérations la couleur bleue, ou même vert clair ? La couleur actuelle des blouses des chirurgiens, n\'a pas été choisie au hasard. Avant, les blouses étaient blanches, symbole de propreté. Mais le blanc s’est révélé être source d’illusion d’optique. Comme nous le savons, les chirurgiens passent souvent de très longues heures, concentrés sur des organes ou du sang humain… Le cerveau est donc concentré sur ces tons rouges, si le chirurgien fixe soudainement sa blouse, ou la blouse de ses collègues, il verra des tâches noires, ce phénomène peut le déconcentrer pendant quelques minutes. Ce qui n’arrive pas si les blouses et les murs sont verts ou bleus, car ces couleurs sont des couleurs complémentaires aux teintes rouges ! Ce sont donc, les couleurs qui gênent le moins les professionnels de santé. De plus, elles permettent de rendre les yeux plus sensibles aux différentes couleurs de l\'anatomie humaine et les aident à être plus attentifs aux éventuelles erreurs durant l\'opération. Bluffant non ?', 'Connaissez vous les fées du CHU de Bordeaux ?', 'Les Fées Bleues sont une association créée par le personnel soignant du CHU, qui a pour but d’apporter de la couleur et du confort, dans le monde aseptisé du soin des prématurés ou bien pour les enfants en réanimation. Ces bénévoles sont des aides-soignantes ou infirmières qui y consacrent leurs temps libre. Ces fées bleues, créent ainsi, des parures colorées pour les incubateurs, confectionnent des jeux pour occuper les enfants, ou crée des tuniques colorées pour remplacer les tuniques de soins… Le CHU soutient l\'initiative de son personnel soignant, et a même accueilli récemment un nouveau pensionnaire au service pédiatrique. Il s’appelle Nao, il est bleu et blanc, et il mesure 58 cm ! Sa mission est d’aider les enfants qui ne peuvent pas sortir de l\'hôpital à cause de leur déficience immunitaire. Ce robot joue, danse et parle… Il a été programmé à destination des personnes autistes, handicapées, ou âgées. Grâce à son intelligence artificielle, le robot rompt l\'isolement, et recrée du lien avec l\'extérieur. Ce beau cadeau fait aux enfants du CHU de Bordeaux, a été offert par le Lion Club Bordeaux Graves, un cadeaux d’une valeur de 12 000 € !', 'Et voilà vous savez maintenant tout sur le CHU de Bordeaux ! Quoi que… Savez-vous qu’il participe à l\'opération de sensibilisation Mars Bleu ? Notre hôpital se met donc au bleu pour améliorer son quotidien et pour le plus grand plaisir de Gavé Bleu !', 'imgArt18.jpeg', 4),
(3, '2019-11-09 10:34:20', NULL, 'Le Lion bleu de Bordeaux, star des réseaux sociaux', 'Surplombant la place Stalingrad, anciennement place du Pont, et faisant fièrement face au pont de Pierre, le Lion bleu de Xavier Veilhan fait depuis 2005 l’objet de toutes les convoitises.', 'En France, toute construction d’un bâtiment public a pour but d’accueillir du monde', 'En France, depuis 1951 et l’arrêté des « 1% artistique », toute construction d’un bâtiment public ayant pour but d’accueillir du monde doit prévoir 1% de son budget total pour financer des œuvres d’art aux abords du bâtiment. En construisant les lignes de tramway, la ville de Bordeaux et sa métropole ont donc mis en place le programme « L’art dans la ville ». Supervisé par le directeur du Centre Georges-Pompidou, cette initiative a pu débloquer plusieurs millions d’euros depuis 2000 pour la réalisation d’une quinzaine d’œuvres. Parmi ces œuvres, nous pouvons noter « La maison aux personnages » place Amélie Raba Léon, les affiches « Aux bord’eaux » présentes dans toutes les stations ou bien le fameux Lion bleu bordelais. Mise en place et vissée sur les pavés de la rive droite le 30 juin 2005, cette sculpture en plastique mesure 6 mètres de haut. Elle va de pair avec la mise en service de la première ligne de tramway dans Bordeaux, la ligne A, qui traverse le pont de Pierre et la place Stalingrad. En décalage total par rapport au style architectural très XVIIIème de la ville, cette œuvre a d’abord été massivement rejetée par les habitants du quartier, mais ils l’ont désormais adoptée.', 'Un symbole de la rive droite', 'On n’imagine pas la place Stalingrad sans cet imposant félin coloré. Ce lion bleu est devenu l\'emblème de cette place et, pour les habitants de la rive gauche, c’est le symbole de « l’autre rive », c’est la première chose que l’on voit en traversant la Garonne depuis le quartier de Saint-Michel. Ce lion bleu, on s’y abrite, on s’y donne rendez-vous, on s’en sert de repère et les écoliers y prennent souvent leur premier cours d’art contemporain. Ce lion bleu n’est pour certain qu’un gros point azur pixelisé à l’horizon, mais pour d’autres c’est un symbole, un mirage, comme un gros jouet qu\'on ne perd jamais. Et ce gros jouet, des centaines d’internautes se le sont attribué et en parlent sur Instagram via le #lionbleu. Ils postent régulièrement des photos de lui, toujours dans la même posture, veillant sur la ville de Bordeaux. D’objet d’art à star du net, il n’y a qu’un pas. Et ce pas, le Lion de Veilhan l’a franchi comme il franchirait la Garonne pour rejoindre le centre-ville bordelais. En plus de son esthétique remarquable, son créateur n’a pas omis de lui donner un sens propre en prenant en compte l’environnement qui entoure cette statue bestiale.', 'Un tremplin pour Xavier Veilhan', 'L\'artiste plasticien à l’origine du Lion bleu, diplômé de l\'EnsAD-Paris (École Nationale Supérieure des Arts Décoratifs) et officier de l’Ordre des Arts et des Lettres, n’a pas choisi une figure animalière pour rien. La place Stalingrad est un hommage à la victoire de l’armée soviétique durant la Seconde Guerre Mondiale. Xavier Veilhan souhaitait donc offrir à ce lieu une œuvre monumentale qui renforce son identité. À l’instar du Lion de Belfort de Bartholdi, il a donc choisi cet animal pour ses valeurs de force tranquille, se battant pour la justice avec puissance mais intelligence. Il déclarait, avant sa construction, vouloir quelque chose de totémique, à la fois dominant et protecteur. Il ne reste plus qu’à espérer qu’il seconde Bordeaux et ses habitants dans leur quotidien futur. Le sculpteur du Lion a vu sa côte mondiale grimper suite à la réalisation de cette œuvre. Il a, depuis, pu exposer un Carrosse violet à Versailles en 2009, un Skateur bleu en Corée du Sud en 2014, ou encore Romy, une femme jaune, devant la gare de Lille en 2019.', 'Espérons que cet élan de créativité se poursuive et que, par la suite, Xavier Veilhan réutilise cette couleur qui nous est si chère, le bleu.', 'imgArt23.jpg', 4),
(4, '2020-01-12 18:21:21', NULL, 'Nicolas Caraty : médiateur culturel plein de bon sens !', 'Le lundi 21 février, nous avons eu la chance de rencontrer Nicolas Caraty, un médiateur culturel non-voyant du musée d\'Aquitaine. Cette entrevue a vu le jour suite à des questionnements sur l’art et les sculptures, ainsi que leur accessibilité. Nous en avons appris plus sur son parcours professionnel, et comment il s’est retrouvé au musée d’Aquitaine. Et nous avons également échangé longuement au sujet de l’accès à la culture pour tout le monde, ce qui nous a mené à discuter de son projet sensationnel : le parcours sensoriel !', 'Nicolas Caraty, lui, son parcours sensoriel', 'Toucher des œuvres du musée d’Aquitaine, c’est possible ! Et ce en grande partie grâce à lui ! Nicolas Caraty a débuté sa carrière professionnelle en tant qu’accordeur de piano sur Paris. Assez vite, il s’est vite questionné sur l’accès à la culture pour les personnes en situation de handicap. Il va par la suite travailler 3 ans chez « Toucher pour connaître », association concevant des expositions adaptées et retranscrit les journaux écrits en cassettes audio. À la suite de cette expérience, il change totalement de secteur et s’oriente vers la vente par correspondance et le suivi client chez Les 3 Suisses. Il occupe ce poste pendant près de 8 ans avant de le quitter et se diriger vers le musée d’Aquitaine de Bordeaux. Recruté en 2007 en tant que stagiaire chargé de la médiation culturelle, il est un an plus tard titularisé par la mairie de Bordeaux et occupe encore ce poste aujourd’hui. Nicolas est un amoureux de l’art, sa déclinaison préférée est celle de la musique. Amateur de piano et de guitare depuis son jeune âge, il se tourne de plus en plus vers le synthétiseur. Et c’est sans compter son attrait pour le cinéma, la peinture, le théâtre, l’écriture, et bien évidemment la sculpture.', 'L’art et l’handicap', '« L’art permet d’exprimer les choses, mais parfois la difficulté c’est d’y avoir accès. ». Cette phrase entendue durant l’interview nous a particulièrement marqués. Il est vrai que nous avons tous les jours l’occasion de prêter attention à la culture, néanmoins certaines personnes en situation de handicap (notamment visuel ou auditif) peuvent parfois trouver difficile l’accès à cette dernière. Bien sûr, comme nous l’explique Nicolas, le handicap ne signifie pas forcément que la culture devient totalement inaccessible. Lui-même est un musicien avéré comme évoqué plus tôt. Il nous a d’ailleurs expliqué un fait intéressant sur la découverte des sculptures : « Quand vous êtes non-voyant, vous faites une exploration partielle de l\'œuvre avec vos mains qui sont capables d’explorer ces détails. Au fur et à mesure vous êtes aptes à reconstituer l\'œuvre dans l’espace, en allant donc du détail vers la globalité ». Ce qui, lorsqu’on y réfléchit bien, est une découverte totalement opposée à celle d’une personne voyante qui, elle, voit la sculpture d’abord dans sa globalité, puis vient ensuite chercher les détails en la touchant. Donc tout est en réalité une question de perspectives et de méthodes.', 'Le parcours sensoriel', 'C’est là qu’entre en jeu le fameux parcours sensoriel ! Il s’agit d’un chemin pédagogique installé dans le musée d\'Aquitaine. Comme son nom l\'indique, il permet de faire découvrir diverses œuvres en faisant appel au plus de sens possible pour les rendre accessibles. Plusieurs initiatives sont prises en compte pour se faire, telles que la production d’audio-descriptions associées à plusieurs tableaux (contant le contexte, l’histoire de ces derniers, illustrés par des effets sonores). Et il faut évoquer les nombreuses sculptures reproduites à l’identique avec des matières très similaires à celles d\'origine. Il est question de reproduction de masques africains en bois, de sculptures en pierre… Nicolas nous a montré une reproduction d’une statue de bronze représentant le Roi Louis XV, réalisée grâce à une modélisation 3D. Il a également pris le temps de nous faire toucher d’autres ouvrages, notamment une reproduction de la Vénus à la corne, ainsi que des pierres taillées de la préhistoire. Ce parcours sensoriel permet donc à la fois de conserver en bon état les vestiges du passé, tout en proposant une offre permanente de visite culturelle aux personnes en situation de handicap.', 'Le patrimoine culturel de Bordeaux devient plus accessible puisque de nombreux efforts sont faits pour soutenir cette cause. Mais selon Nicolas, il faut continuer sur ce chemin. À présent, l’objectif majeur est de diffuser l’information. À notre échelle, nous pouvons partager nos connaissances culturelles avec autrui. Il faut aussi réfléchir à un moyen d’adapter ces services pour les rendre accessibles au maximum. D’après Nicolas : « Si on fait vivre cette découverte non pas par des connaissances encyclopédiques mais plutôt par la notion de plaisir, les gens seront plus à l’aise. Il ne faut pas les mettre en situation d’échec, mais plutôt les guider, les amener à découvrir les œuvres par eux-mêmes, et alors là il sera plus aisé de les mener vers des connaissances plus théoriques ».', 'imgArt24.jpeg', 2),
(5, '2022-03-04 12:28:00', NULL, 'La sculpture Sanna va-t-elle nous quitter ?', 'Depuis presque dix ans, la sculpture Sanna trône sur la place de la comédie. Visage emblématique et intriguant que l’on apprécie contempler. Aujourd’hui, il est possible qu’elle ne devienne plus qu’un souvenir… La ville de Bordeaux a toujours été investie dans la culture et l\'accès à l’art, c’est pourquoi le sujet de la sculpture Sanna fait polémique au sein de la ville.', 'Quelle histoire se cache derrière ce visage ?', 'La demoiselle de fonte a été érigée en 2013 par Jaume Plensa dans le cadre d’une exposition bordelaise, Sanna était accompagnée de sa « sœur » Paula, qui elle, était placée devant la cathédrale de Bordeaux. Jaume Plensa est un artiste Catalan qui a réalisé onze autres œuvres, exposées à travers la ville. Mais, celles-ci ont été retirées. Actuellement, c’est un particulier anonyme qui possède la sculpture Sanna, il laisse à la municipalité de Bordeaux un délai de 5 ans pour la conserver sur la place de la Comédie. Elle partirait à priori en 2027. Ce serait donc le départ d’une œuvre extravagante et surtout emblématique de la ville de Bordeaux.', 'Une demoiselle de fonte, d’âme et d’or', 'Sanna est une sculpture figurative monumentale faite entièrement de fonte, il s’agit du visage d’une jeune fille qui paraît particulièrement apaisée, comme si elle était endormie. Cette impression de plénitude est due aux yeux fermés de la jeune fille et à son expression imperturbable, comme si elle n’allait jamais les rouvrir. Sous certaines perspectives, Sanna peut adopter différents styles : de face son visage est parfaitement droit et bien proportionné mais de côté son visage semble difforme. Aussi, nous pouvons voir évoluer les couleurs de la demoiselle de fonte au fur et à mesure des années. En effet, la sculpture rouille et sa teinte varie en fonction du temps. Sanna se situe devant le grand théâtre sur la place de la Comédie, son style particulier qui marie la grossièreté du fer et la finesse des traits, se combine parfaitement avec l’opéra par ses formes imposantes et travaillées. Pour l’artiste, Jaume Plensa, le visage est « le miroir de l’âme ». Par conséquent, l\'œuvre permet aux bordelais d’acquérir un instant de paix de l’esprit en plein cœur de la ville.', 'L\'achat de la statue', 'En plus de son aspect artistique, la sculpture de Sanna génère évidemment aussi un certain engouement affectant son aspect économique. En effet, en 2014 après l’exposition de Jaume Plensa, Bordeaux fait une levée de fond pour racheter la sculpture. La ville a besoin de récolter 150 000 € auprès des habitants et prévoit ensuite de compléter cette récolte en sortant également un minimum de 150 000 € de sa poche. Effectivement, la valeur financière de l\'œuvre varie entre 300 000 € et 500 000 €. Malheureusement, les dons étant trop faibles, la récolte n\'aboutit pas à un résultat concluant. Seulement 44 000 € ont été récoltés ce qui n’a absolument pas été suffisant pour que la municipalité prenne en charge le reste de l’achat. Fort heureusement en 2015, un particulier anonyme achète la statue et signe un contrat avec la municipalité de Bordeaux pour la laisser 6 ans de plus sur la place de la Comédie. Plus récemment encore, le 8 février 2022, la ville de Bordeaux a annoncé officiellement qu’un autre accord avait été approuvé, permettant à la sculpture de rester sur la place et surtout dans nos cœurs jusqu’en 2027.', 'Finalement, cette sculpture reste encore parmi nous pendant un bon moment. Cette demoiselle de fonte au vécu poétique ayant rythmé la vie de beaucoup de bordelais continuera donc de le faire ces cinq prochaines années. Et cette affaire d’argent plutôt compliquée pour la mairie de Bordeaux lui a tout de même permis de conserver ce bien grâce à l’aide de ce fameux acheteur anonyme. Nous vous suggérons donc d’aller une fois encore apprécier sa présence avant son départ imminent ! Avec l’équipe de rédaction, nous nous demandions si vous aussi vous aviez des anecdotes croustillantes à raconter sur ce visage fait de métaux. Qu’est-ce qu’elle vous fait ressentir ? Êtes-vous heureux d’apprendre qu’elle reste à nos côtés encore longtemps vous aussi ? Nous avons hâte de lire vos réponses en commentaire !', 'imgArt25.jpeg', 4);

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

CREATE TABLE `boutique` (
  `numArtBoutique` int UNSIGNED NOT NULL,
  `libArtBoutique` varchar(255) NOT NULL,
  `descArtBoutique` text,
  `couleursArtBoutique` json NOT NULL,
  `taillesArtBoutique` json NOT NULL,
  `prixAdulteArtBoutique` decimal(10,2) NOT NULL,
  `prixEnfantArtBoutique` decimal(10,2) DEFAULT NULL,
  `urlPhotoArtBoutique` json NOT NULL,
  `categorieArtBoutique` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `boutique`
--

INSERT INTO `boutique` (`numArtBoutique`, `libArtBoutique`, `descArtBoutique`, `couleursArtBoutique`, `taillesArtBoutique`, `prixAdulteArtBoutique`, `prixEnfantArtBoutique`, `urlPhotoArtBoutique`, `categorieArtBoutique`, `created_at`, `updated_at`) VALUES
(1, 'T-shirt', 'T-shirt officiel du BEC.', '[\"Rouge\", \"Noir\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 15.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(2, 'Short molleton', 'Short confortable en molleton.', '[\"Noir\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 20.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(3, 'Chaussettes', 'Chaussettes de sport BEC.', '[\"Rouge\", \"Blanc\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 10.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(4, 'Polo', 'Polo club pour les supporters.', '[\"Rouge\", \"Blanc\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 25.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(5, 'Short coton fin', 'Short léger en coton fin.', '[\"Noir\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 15.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(6, 'Casquette', 'Casquette officielle du BEC.', '[\"Blanc\", \"Bleu\"]', '[\"Taille unique\"]', 15.00, NULL, '[]', 'Accessoire', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(7, 'Pull', 'Pull chaud pour l\'entraînement ou le quotidien.', '[\"Rouge\", \"Noir\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 35.00, 32.00, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(8, 'Short entraînement', 'Short respirant pour les séances.', '[\"Rouge\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 15.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(9, 'Serviette 100 x 140 cm', 'Serviette idéale pour l\'entraînement.', '[\"Rouge\", \"Blanc\"]', '[\"100 x 140 cm\"]', 20.00, NULL, '[]', 'Accessoire', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(10, 'Doudoune sans manche', 'Doudoune légère sans manche.', '[\"Noir\", \"Bleu\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 36.00, 34.00, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(11, 'Doudoune manche longue', 'Doudoune chaude à manches longues.', '[\"Noir\", \"Bleu\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 42.00, 40.00, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(12, 'Jogging', 'Jogging BEC confortable.', '[\"Blanc\", \"Noir\"]', '[\"XS\", \"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 30.00, NULL, '[]', 'Vêtement', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(13, 'Sac à dos', 'Sac à dos pratique pour les matchs.', '[\"Noir\"]', '[\"Taille unique\"]', 25.00, NULL, '[]', 'Accessoire', '2026-02-06 04:11:45', '2026-02-06 04:11:45'),
(14, 'Gourde', 'Gourde réutilisable pour l\'entraînement.', '[\"Blanc\", \"Rouge\"]', '[\"Taille unique\"]', 6.00, NULL, '[]', 'Accessoire', '2026-02-06 04:11:45', '2026-02-06 04:11:45');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `numCom` int NOT NULL,
  `dtCreaCom` datetime DEFAULT CURRENT_TIMESTAMP,
  `libCom` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtModCom` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `attModOK` tinyint(1) DEFAULT '0',
  `notifComKOAff` text COLLATE utf8mb3_unicode_ci,
  `dtDelLogCom` datetime DEFAULT NULL,
  `delLogiq` tinyint(1) DEFAULT '0',
  `numArt` int NOT NULL,
  `numMemb` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `COMMENT`
--

INSERT INTO `COMMENT` (`numCom`, `dtCreaCom`, `libCom`, `dtModCom`, `attModOK`, `notifComKOAff`, `dtDelLogCom`, `delLogiq`, `numArt`, `numMemb`) VALUES
(1, '2020-11-09 10:13:43', 'Trop cool comme article', NULL, 0, NULL, NULL, 0, 1, 1),
(2, '2023-11-02 13:18:42', 'Trop pourri', '2023-11-03 18:43:19', 0, 'Message trop provocateur', '2023-11-04 08:23:19', 1, 1, 2),
(3, '2020-11-04 16:21:12', 'Trop cool comme article', '2021-01-12 13:36:48', 1, NULL, NULL, 0, 4, 3),
(4, '2020-11-05 03:15:38', 'Trop cool comme article', NULL, 0, NULL, NULL, 0, 1, 1),
(5, '2020-11-06 21:16:36', 'Trop cool comme article', '2023-01-12 09:03:48', 1, NULL, NULL, 0, 1, 2),
(6, '2020-11-06 11:20:31', 'Trop cool comme article', NULL, 0, NULL, NULL, 0, 1, 3),
(7, '2020-11-08 08:41:12', 'Trop cool comme article', NULL, 0, NULL, NULL, 0, 1, 3),
(8, '2020-11-18 08:41:12', 'De la daube cet article', '2024-01-09 21:03:48', 0, 'Trop insultant', '2024-01-12 09:03:48', 1, 1, 3),
(9, '2022-10-09 12:07:09', 'Un super article', '2024-01-09 21:03:48', 0, '', NULL, 0, 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPE`
--

CREATE TABLE `EQUIPE` (
  `numEquipe` int NOT NULL,
  `codeEquipe` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `club` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bordeaux étudiant club',
  `categorie` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionEquipe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photoDLequipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photoStaff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `EQUIPE`
--

INSERT INTO `EQUIPE` (`numEquipe`, `codeEquipe`, `nomEquipe`, `club`, `categorie`, `section`, `niveau`, `descriptionEquipe`, `photoDLequipe`, `photoStaff`) VALUES
(2, 'SEN1', 'Seniors 1', 'Bordeaux étudiant club', 'Senior', 'Masculin', 'Régional 1', 'Équipe fanion senior 1', NULL, NULL),
(3, 'SEN2', 'Seniors 2', 'Bordeaux étudiant club', 'Senior', 'Masculin', 'Régional 2', 'Équipe senior 2', NULL, NULL),
(4, 'SEN3', 'Seniors 3', 'Bordeaux étudiant club', 'Senior', 'Masculin', 'Départemental 1', 'Équipe senior 3', NULL, NULL),
(5, 'SEN4', 'Seniors 4', 'Bordeaux étudiant club', 'Senior', 'Masculin', 'Départemental 2', 'Équipe senior 4', NULL, NULL),
(6, 'SEN5', 'Seniors 5', 'Bordeaux étudiant club', 'Senior', 'Féminin', 'Régional 1', 'Équipe senior féminine 1', NULL, NULL),
(7, 'SEN6', 'Seniors 6', 'Bordeaux étudiant club', 'Senior', 'Féminin', 'Régional 2', 'Équipe senior féminine 2', NULL, NULL),
(8, 'SEN7', 'Seniors 7', 'Bordeaux étudiant club', 'Senior', 'Féminin', 'Départemental 1', 'Équipe senior féminine 3', NULL, NULL),
(1, 'SG3', 'Séniors garçons 3', 'Bordeaux étudiant club', 'Senior', 'Masculine', 'Départementale 3', 'adasda', 'photos-equipes/SG3-photo-equipe.jpg', 'photos-equipes/SG3-photo-staff.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `JOUEUR`
--

CREATE TABLE `JOUEUR` (
  `numJoueur` int NOT NULL,
  `surnomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomJoueur` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlPhotoJoueur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `codeEquipe` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posteJoueur` tinyint UNSIGNED NOT NULL,
  `numeroMaillot` int DEFAULT NULL,
  `dateRecrutement` date DEFAULT NULL,
  `clubsPrecedents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `JOUEUR`
--

INSERT INTO `JOUEUR` (`numJoueur`, `surnomJoueur`, `prenomJoueur`, `nomJoueur`, `urlPhotoJoueur`, `dateNaissance`, `codeEquipe`, `posteJoueur`, `numeroMaillot`, `dateRecrutement`, `clubsPrecedents`) VALUES
(1, 'Mehdikops', 'Mehdi', 'Afankous', NULL, '1291-03-18', 'SG3', 1, 1, '2025-09-01', NULL),
(2, 'SEN1-J01', 'Alex', 'Durand', NULL, '1997-03-12', 'SEN1', 1, 1, '2022-07-01', NULL),
(3, 'SEN1-J02', 'Hugo', 'Martin', NULL, '1996-05-20', 'SEN1', 2, 2, '2021-07-01', NULL),
(4, 'SEN1-J03', 'Lucas', 'Petit', NULL, '1998-01-04', 'SEN1', 3, 3, '2020-07-01', NULL),
(5, 'SEN1-J04', 'Nolan', 'Bernard', NULL, '1995-09-10', 'SEN1', 4, 4, '2019-07-01', NULL),
(6, 'SEN1-J05', 'Maxime', 'Robert', NULL, '1994-11-16', 'SEN1', 5, 5, '2020-08-15', NULL),
(7, 'SEN1-J06', 'Theo', 'Richard', NULL, '1997-02-21', 'SEN1', 6, 6, '2023-07-01', NULL),
(8, 'SEN1-J07', 'Enzo', 'Dubois', NULL, '1996-06-18', 'SEN1', 7, 7, '2022-07-01', NULL),
(9, 'SEN1-J08', 'Paul', 'Moreau', NULL, '1999-08-30', 'SEN1', 8, 8, '2021-08-01', NULL),
(10, 'SEN1-J09', 'Louis', 'Fournier', NULL, '1993-12-02', 'SEN1', 9, 9, '2020-07-01', NULL),
(11, 'SEN1-J10', 'Jules', 'Girard', NULL, '1998-04-15', 'SEN1', 10, 10, '2019-07-01', NULL),
(12, 'SEN2-J01', 'Antoine', 'Leroy', NULL, '1996-02-14', 'SEN2', 1, 1, '2022-07-01', NULL),
(13, 'SEN2-J02', 'Thomas', 'Roux', NULL, '1995-07-19', 'SEN2', 2, 2, '2021-07-01', NULL),
(14, 'SEN2-J03', 'Adrien', 'David', NULL, '1997-09-25', 'SEN2', 3, 3, '2020-07-01', NULL),
(15, 'SEN2-J04', 'Bastien', 'Bertrand', NULL, '1994-01-07', 'SEN2', 4, 4, '2019-07-01', NULL),
(16, 'SEN2-J05', 'Florian', 'Morel', NULL, '1996-11-03', 'SEN2', 5, 5, '2020-08-15', NULL),
(17, 'SEN2-J06', 'Quentin', 'Simon', NULL, '1998-05-11', 'SEN2', 6, 6, '2023-07-01', NULL),
(18, 'SEN2-J07', 'Romain', 'Laurent', NULL, '1997-03-22', 'SEN2', 7, 7, '2022-07-01', NULL),
(19, 'SEN2-J08', 'Nathan', 'Lefevre', NULL, '1999-12-08', 'SEN2', 8, 8, '2021-08-01', NULL),
(20, 'SEN2-J09', 'Kylian', 'Michel', NULL, '1993-06-29', 'SEN2', 9, 9, '2020-07-01', NULL),
(21, 'SEN2-J10', 'Loic', 'Garcia', NULL, '1998-10-17', 'SEN2', 10, 10, '2019-07-01', NULL),
(22, 'SEN3-J01', 'Mathis', 'Perrin', NULL, '1996-03-09', 'SEN3', 1, 1, '2022-07-01', NULL),
(23, 'SEN3-J02', 'Yann', 'Robin', NULL, '1995-05-28', 'SEN3', 2, 2, '2021-07-01', NULL),
(24, 'SEN3-J03', 'Evan', 'Clement', NULL, '1997-01-19', 'SEN3', 3, 3, '2020-07-01', NULL),
(25, 'SEN3-J04', 'Sacha', 'Morin', NULL, '1994-08-13', 'SEN3', 4, 4, '2019-07-01', NULL),
(26, 'SEN3-J05', 'Dylan', 'Roche', NULL, '1996-12-05', 'SEN3', 5, 5, '2020-08-15', NULL),
(27, 'SEN3-J06', 'Noe', 'Schmitt', NULL, '1998-04-27', 'SEN3', 6, 6, '2023-07-01', NULL),
(28, 'SEN3-J07', 'Eliot', 'Henry', NULL, '1997-02-16', 'SEN3', 7, 7, '2022-07-01', NULL),
(29, 'SEN3-J08', 'Malo', 'Boyer', NULL, '1999-09-01', 'SEN3', 8, 8, '2021-08-01', NULL),
(30, 'SEN3-J09', 'Gabriel', 'Giraud', NULL, '1993-07-23', 'SEN3', 9, 9, '2020-07-01', NULL),
(31, 'SEN3-J10', 'Leo', 'Chevalier', NULL, '1998-10-30', 'SEN3', 10, 10, '2019-07-01', NULL),
(32, 'SEN4-J01', 'Hugo', 'Masson', NULL, '1996-02-11', 'SEN4', 1, 1, '2022-07-01', NULL),
(33, 'SEN4-J02', 'Tom', 'Garnier', NULL, '1995-06-14', 'SEN4', 2, 2, '2021-07-01', NULL),
(34, 'SEN4-J03', 'Noah', 'Riviere', NULL, '1997-01-26', 'SEN4', 3, 3, '2020-07-01', NULL),
(35, 'SEN4-J04', 'Axel', 'Barbier', NULL, '1994-09-06', 'SEN4', 4, 4, '2019-07-01', NULL),
(36, 'SEN4-J05', 'Liam', 'Marchand', NULL, '1996-11-21', 'SEN4', 5, 5, '2020-08-15', NULL),
(37, 'SEN4-J06', 'Nils', 'Charpentier', NULL, '1998-05-09', 'SEN4', 6, 6, '2023-07-01', NULL),
(38, 'SEN4-J07', 'Ethan', 'Rolland', NULL, '1997-03-18', 'SEN4', 7, 7, '2022-07-01', NULL),
(39, 'SEN4-J08', 'Aaron', 'Aubert', NULL, '1999-12-12', 'SEN4', 8, 8, '2021-08-01', NULL),
(40, 'SEN4-J09', 'Kevin', 'Guillot', NULL, '1993-06-03', 'SEN4', 9, 9, '2020-07-01', NULL),
(41, 'SEN4-J10', 'Simon', 'Bouvier', NULL, '1998-10-25', 'SEN4', 10, 10, '2019-07-01', NULL),
(42, 'SEN5-J01', 'Emma', 'Dupont', NULL, '1998-03-07', 'SEN5', 1, 1, '2022-07-01', NULL),
(43, 'SEN5-J02', 'Lea', 'Lemaire', NULL, '1997-05-18', 'SEN5', 2, 2, '2021-07-01', NULL),
(44, 'SEN5-J03', 'Chloe', 'Lopez', NULL, '1999-02-12', 'SEN5', 3, 3, '2020-07-01', NULL),
(45, 'SEN5-J04', 'Manon', 'Fontaine', NULL, '1996-09-03', 'SEN5', 4, 4, '2019-07-01', NULL),
(46, 'SEN5-J05', 'Ines', 'Lambert', NULL, '1998-11-30', 'SEN5', 5, 5, '2020-08-15', NULL),
(47, 'SEN5-J06', 'Sarah', 'Muller', NULL, '1997-04-19', 'SEN5', 6, 6, '2023-07-01', NULL),
(48, 'SEN5-J07', 'Louna', 'Perez', NULL, '1999-06-22', 'SEN5', 7, 7, '2022-07-01', NULL),
(49, 'SEN5-J08', 'Camille', 'Colin', NULL, '1998-12-10', 'SEN5', 8, 8, '2021-08-01', NULL),
(50, 'SEN5-J09', 'Julie', 'Arnaud', NULL, '1996-07-29', 'SEN5', 9, 9, '2020-07-01', NULL),
(51, 'SEN5-J10', 'Alyssa', 'Renaud', NULL, '1999-10-26', 'SEN5', 10, 10, '2019-07-01', NULL),
(52, 'SEN6-J01', 'Laura', 'Roy', NULL, '1998-02-05', 'SEN6', 1, 1, '2022-07-01', NULL),
(53, 'SEN6-J02', 'Clara', 'Gomez', NULL, '1997-05-27', 'SEN6', 2, 2, '2021-07-01', NULL),
(54, 'SEN6-J03', 'Lucie', 'Allard', NULL, '1999-01-21', 'SEN6', 3, 3, '2020-07-01', NULL),
(55, 'SEN6-J04', 'Elena', 'Gaudin', NULL, '1996-08-11', 'SEN6', 4, 4, '2019-07-01', NULL),
(56, 'SEN6-J05', 'Nina', 'Baron', NULL, '1998-12-19', 'SEN6', 5, 5, '2020-08-15', NULL),
(57, 'SEN6-J06', 'Maeva', 'Hernandez', NULL, '1997-04-23', 'SEN6', 6, 6, '2023-07-01', NULL),
(58, 'SEN6-J07', 'Romane', 'Navarro', NULL, '1999-06-09', 'SEN6', 7, 7, '2022-07-01', NULL),
(59, 'SEN6-J08', 'Elise', 'Vidal', NULL, '1998-12-02', 'SEN6', 8, 8, '2021-08-01', NULL),
(60, 'SEN6-J09', 'Pauline', 'Brun', NULL, '1996-07-16', 'SEN6', 9, 9, '2020-07-01', NULL),
(61, 'SEN6-J10', 'Lina', 'Moulin', NULL, '1999-10-20', 'SEN6', 10, 10, '2019-07-01', NULL),
(62, 'SEN7-J01', 'Marie', 'Picard', NULL, '1998-02-01', 'SEN7', 1, 1, '2022-07-01', NULL),
(63, 'SEN7-J02', 'Anais', 'Roy', NULL, '1997-05-15', 'SEN7', 2, 2, '2021-07-01', NULL),
(64, 'SEN7-J03', 'Jade', 'Roger', NULL, '1999-01-13', 'SEN7', 3, 3, '2020-07-01', NULL),
(65, 'SEN7-J04', 'Lola', 'Berger', NULL, '1996-08-21', 'SEN7', 4, 4, '2019-07-01', NULL),
(66, 'SEN7-J05', 'Zoe', 'Lemoine', NULL, '1998-12-09', 'SEN7', 5, 5, '2020-08-15', NULL),
(67, 'SEN7-J06', 'Mila', 'Rousseau', NULL, '1997-04-30', 'SEN7', 6, 6, '2023-07-01', NULL),
(68, 'SEN7-J07', 'Alix', 'Faure', NULL, '1999-06-07', 'SEN7', 7, 7, '2022-07-01', NULL),
(69, 'SEN7-J08', 'Agathe', 'Morel', NULL, '1998-12-28', 'SEN7', 8, 8, '2021-08-01', NULL),
(70, 'SEN7-J09', 'Maya', 'Poirier', NULL, '1996-07-13', 'SEN7', 9, 9, '2020-07-01', NULL),
(71, 'SEN7-J10', 'Elsa', 'Leroux', NULL, '1999-10-18', 'SEN7', 10, 10, '2019-07-01', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `LIKEART`
--

CREATE TABLE `LIKEART` (
  `numMemb` int NOT NULL,
  `numArt` int NOT NULL,
  `likeA` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
(3, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `MATCH`
--

CREATE TABLE `MATCH` (
  `numMatch` int NOT NULL,
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
  `source` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `MATCH`
--

INSERT INTO `MATCH` (`numMatch`, `codeEquipe`, `clubAdversaire`, `numEquipeAdverse`, `saison`, `phase`, `journee`, `dateMatch`, `heureMatch`, `lieuMatch`, `scoreBec`, `scoreAdversaire`, `source`) VALUES
(1, 'SG3', 'Union st bruno', NULL, '2025 - 2026', 'Saison réguliere', 'J3', '2026-02-07', '12:30:00', 'Domicile', 50, 32, NULL),
(2, 'SG3', 'Union st bruno', NULL, '2025-2026', 'Saison régulière', 'J3', '2026-02-21', '09:53:00', 'Domicile', 12, 2, NULL),
(3, 'SG3', 'Union st bruno', NULL, '2025-2026', 'Saison régulière', 'J3', '2026-02-28', '09:53:00', 'Extérieur', 12, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `MEMBRE`
--

CREATE TABLE `MEMBRE` (
  `numMemb` int NOT NULL,
  `prenomMemb` varchar(70) COLLATE utf8mb3_unicode_ci NOT NULL,
  `nomMemb` varchar(70) COLLATE utf8mb3_unicode_ci NOT NULL,
  `pseudoMemb` varchar(70) COLLATE utf8mb3_unicode_ci NOT NULL,
  `passMemb` varchar(70) COLLATE utf8mb3_unicode_ci NOT NULL,
  `eMailMemb` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtCreaMemb` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtMajMemb` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `accordMemb` tinyint(1) DEFAULT '1',
  `cookieMemb` varchar(70) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `numStat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `MEMBRE`
--

INSERT INTO `MEMBRE` (`numMemb`, `prenomMemb`, `nomMemb`, `pseudoMemb`, `passMemb`, `eMailMemb`, `dtCreaMemb`, `dtMajMemb`, `accordMemb`, `cookieMemb`, `numStat`) VALUES
(1, 'Freddie', 'Mercury', 'Admin99', '12345678', 'freddie.mercury@gmail.com', '2019-05-29 10:13:43', NULL, 1, NULL, 1),
(2, 'Phil', 'Collins', 'Phil09', '12345678', 'phil.collins@gmail.com', '2020-01-09 10:13:43', NULL, 1, NULL, 2),
(3, 'Julie', 'La Rousse', 'juju1989', '12345678', 'julie.larousse@gmail.com', '2020-03-15 14:33:23', '2024-01-12 14:36:48', 1, NULL, 3),
(4, 'David', 'Bowie', 'dav33B', '12345678', 'david.bowie@gmail.com', '2020-07-19 13:13:13', NULL, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `MOTCLE`
--

CREATE TABLE `MOTCLE` (
  `numMotCle` int NOT NULL,
  `libMotCle` varchar(60) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `MOTCLE`
--

INSERT INTO `MOTCLE` (`numMotCle`, `libMotCle`) VALUES
(1, 'Bordeaux'),
(2, 'CHU'),
(3, 'chirurgiens'),
(4, 'Hôpital'),
(5, 'soignants'),
(6, 'bleu'),
(7, 'Mars Bleu');

-- --------------------------------------------------------

--
-- Structure de la table `MOTCLEARTICLE`
--

CREATE TABLE `MOTCLEARTICLE` (
  `numArt` int NOT NULL,
  `numMotCle` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `MOTCLEARTICLE`
--

INSERT INTO `MOTCLEARTICLE` (`numArt`, `numMotCle`) VALUES
(1, 1),
(1, 6),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(3, 1),
(3, 6),
(4, 1),
(4, 6),
(5, 1),
(5, 6);

-- --------------------------------------------------------

--
-- Structure de la table `PERSONNEL`
--

CREATE TABLE `PERSONNEL` (
  `numPersonnel` int NOT NULL,
  `surnomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomPersonnel` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlPhotoPersonnel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailPersonnel` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephonePersonnel` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estStaffEquipe` tinyint(1) NOT NULL DEFAULT '0',
  `numEquipeStaff` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roleStaffEquipe` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estDirection` tinyint(1) NOT NULL DEFAULT '0',
  `posteDirection` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estCommissionTechnique` tinyint(1) NOT NULL DEFAULT '0',
  `posteCommissionTechnique` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estCommissionAnimation` tinyint(1) NOT NULL DEFAULT '0',
  `posteCommissionAnimation` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estCommissionCommunication` tinyint(1) NOT NULL DEFAULT '0',
  `posteCommissionCommunication` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `PERSONNEL`
--

INSERT INTO `PERSONNEL` (`numPersonnel`, `surnomPersonnel`, `prenomPersonnel`, `nomPersonnel`, `urlPhotoPersonnel`, `emailPersonnel`, `telephonePersonnel`, `estStaffEquipe`, `numEquipeStaff`, `roleStaffEquipe`, `estDirection`, `posteDirection`, `estCommissionTechnique`, `posteCommissionTechnique`, `estCommissionAnimation`, `posteCommissionAnimation`, `estCommissionCommunication`, `posteCommissionCommunication`) VALUES
(26, 'ANIM-BEN1', 'Sandra', 'Collet', NULL, 'animation1@bec.fr', '0610000011', 0, NULL, NULL, 0, NULL, 0, NULL, 1, 'Membre commission animation', 0, NULL),
(27, 'ANIM-BEN2', 'Guillaume', 'Pages', NULL, 'animation2@bec.fr', '0610000012', 0, NULL, NULL, 0, NULL, 0, NULL, 1, 'Membre commission animation', 0, NULL),
(28, 'ANIM-BEN3', 'Alexia', 'Fabre', NULL, 'animation3@bec.fr', '0610000013', 0, NULL, NULL, 0, NULL, 0, NULL, 1, 'Membre commission animation', 0, NULL),
(29, 'ANIM-BEN4', 'Vincent', 'Archer', NULL, 'animation4@bec.fr', '0610000014', 0, NULL, NULL, 0, NULL, 0, NULL, 1, 'Membre commission animation', 0, NULL),
(30, 'ANIM-BEN5', 'Marine', 'Gallet', NULL, 'animation5@bec.fr', '0610000015', 0, NULL, NULL, 0, NULL, 0, NULL, 1, 'Membre commission animation', 0, NULL),
(3, 'ASST-SEN1', 'Marc', 'Assistant', NULL, 'assistant.sen1@bec.fr', '0600000002', 1, 'SEN1', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, 'ASST-SEN2', 'Romain', 'Assistant', NULL, 'assistant.sen2@bec.fr', '0600000004', 1, 'SEN2', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, 'ASST-SEN3', 'Florian', 'Assistant', NULL, 'assistant.sen3@bec.fr', '0600000006', 1, 'SEN3', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, 'ASST-SEN4', 'Quentin', 'Assistant', NULL, 'assistant.sen4@bec.fr', '0600000008', 1, 'SEN4', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(11, 'ASST-SEN5', 'Julie', 'Assistant', NULL, 'assistant.sen5@bec.fr', '0600000010', 1, 'SEN5', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(13, 'ASST-SEN6', 'Emma', 'Assistant', NULL, 'assistant.sen6@bec.fr', '0600000012', 1, 'SEN6', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(15, 'ASST-SEN7', 'Chloe', 'Assistant', NULL, 'assistant.sen7@bec.fr', '0600000014', 1, 'SEN7', 'Assistant coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, 'COACH-SEN1', 'Pierre', 'Coach', NULL, 'coach.sen1@bec.fr', '0600000001', 1, 'SEN1', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, 'COACH-SEN2', 'Julien', 'Coach', NULL, 'coach.sen2@bec.fr', '0600000003', 1, 'SEN2', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, 'COACH-SEN3', 'Nicolas', 'Coach', NULL, 'coach.sen3@bec.fr', '0600000005', 1, 'SEN3', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, 'COACH-SEN4', 'Baptiste', 'Coach', NULL, 'coach.sen4@bec.fr', '0600000007', 1, 'SEN4', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, 'COACH-SEN5', 'Sophie', 'Coach', NULL, 'coach.sen5@bec.fr', '0600000009', 1, 'SEN5', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(12, 'COACH-SEN6', 'Claire', 'Coach', NULL, 'coach.sen6@bec.fr', '0600000011', 1, 'SEN6', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(14, 'COACH-SEN7', 'Laura', 'Coach', NULL, 'coach.sen7@bec.fr', '0600000013', 1, 'SEN7', 'Coach', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(31, 'COM-BEN1', 'Caroline', 'Vallin', NULL, 'com1@bec.fr', '0610000016', 0, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, 1, 'Membre commission communication'),
(32, 'COM-BEN2', 'Anthony', 'Blanc', NULL, 'com2@bec.fr', '0610000017', 0, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, 1, 'Membre commission communication'),
(33, 'COM-BEN3', 'Laura', 'Vigne', NULL, 'com3@bec.fr', '0610000018', 0, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, 1, 'Membre commission communication'),
(34, 'COM-BEN4', 'Jeremy', 'Tessier', NULL, 'com4@bec.fr', '0610000019', 0, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, 1, 'Membre commission communication'),
(35, 'COM-BEN5', 'Pauline', 'Serre', NULL, 'com5@bec.fr', '0610000020', 0, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, 1, 'Membre commission communication'),
(16, 'DIR-BEN1', 'Nathalie', 'Perrier', NULL, 'direction1@bec.fr', '0610000001', 0, NULL, NULL, 1, 'Membre direction', 0, NULL, 0, NULL, 0, NULL),
(17, 'DIR-BEN2', 'Olivier', 'Lemoine', NULL, 'direction2@bec.fr', '0610000002', 0, NULL, NULL, 1, 'Membre direction', 0, NULL, 0, NULL, 0, NULL),
(18, 'DIR-BEN3', 'Sonia', 'Marin', NULL, 'direction3@bec.fr', '0610000003', 0, NULL, NULL, 1, 'Membre direction', 0, NULL, 0, NULL, 0, NULL),
(19, 'DIR-BEN4', 'Eric', 'Legrand', NULL, 'direction4@bec.fr', '0610000004', 0, NULL, NULL, 1, 'Membre direction', 0, NULL, 0, NULL, 0, NULL),
(20, 'DIR-BEN5', 'Isabelle', 'Noel', NULL, 'direction5@bec.fr', '0610000005', 0, NULL, NULL, 1, 'Membre direction', 0, NULL, 0, NULL, 0, NULL),
(1, 'mehdiafankous', 'mehdi', 'afankous', '/src/uploads/photos-benevoles/af.mehdi.jpg', NULL, NULL, 1, 'SG3', 'coach', 1, 'président', 1, 'responsable technique', 1, 'annimateur', 1, 'community manager'),
(21, 'TECH-BEN1', 'Damien', 'Perrot', NULL, 'tech1@bec.fr', '0610000006', 0, NULL, NULL, 0, NULL, 1, 'Membre commission technique', 0, NULL, 0, NULL),
(22, 'TECH-BEN2', 'Laurent', 'Benoit', NULL, 'tech2@bec.fr', '0610000007', 0, NULL, NULL, 0, NULL, 1, 'Membre commission technique', 0, NULL, 0, NULL),
(23, 'TECH-BEN3', 'Celine', 'Guerin', NULL, 'tech3@bec.fr', '0610000008', 0, NULL, NULL, 0, NULL, 1, 'Membre commission technique', 0, NULL, 0, NULL),
(24, 'TECH-BEN4', 'Pascal', 'Leger', NULL, 'tech4@bec.fr', '0610000009', 0, NULL, NULL, 0, NULL, 1, 'Membre commission technique', 0, NULL, 0, NULL),
(25, 'TECH-BEN5', 'Marion', 'Jacquet', NULL, 'tech5@bec.fr', '0610000010', 0, NULL, NULL, 0, NULL, 1, 'Membre commission technique', 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `STATUT`
--

CREATE TABLE `STATUT` (
  `numStat` int NOT NULL,
  `libStat` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtCreaStat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `libThem` varchar(60) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
-- Index pour la table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  ADD PRIMARY KEY (`numArt`),
  ADD KEY `ARTICLE_FK` (`numArt`),
  ADD KEY `FK_ASSOCIATION_1` (`numThem`);

--
-- Index pour la table `boutique`
--
ALTER TABLE `boutique`
  ADD PRIMARY KEY (`numArtBoutique`);

--
-- Index pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD PRIMARY KEY (`numCom`),
  ADD KEY `COMMENT_FK` (`numCom`),
  ADD KEY `FK_ASSOCIATION_2` (`numArt`),
  ADD KEY `FK_ASSOCIATION_3` (`numMemb`);

--
-- Index pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  ADD PRIMARY KEY (`codeEquipe`),
  ADD UNIQUE KEY `uniq_equipe_num` (`numEquipe`);

--
-- Index pour la table `JOUEUR`
--
ALTER TABLE `JOUEUR`
  ADD PRIMARY KEY (`surnomJoueur`),
  ADD UNIQUE KEY `uniq_joueur_num` (`numJoueur`),
  ADD KEY `idx_joueur_equipe` (`codeEquipe`);

--
-- Index pour la table `LIKEART`
--
ALTER TABLE `LIKEART`
  ADD PRIMARY KEY (`numMemb`,`numArt`),
  ADD KEY `LIKEART_FK` (`numMemb`,`numArt`),
  ADD KEY `FK_LIKEART1` (`numArt`);

--
-- Index pour la table `MATCH`
--
ALTER TABLE `MATCH`
  ADD PRIMARY KEY (`numMatch`),
  ADD KEY `idx_match_equipe` (`codeEquipe`);

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
  ADD PRIMARY KEY (`surnomPersonnel`),
  ADD UNIQUE KEY `uniq_personnel_num` (`numPersonnel`),
  ADD KEY `idx_personnel_equipe` (`numEquipeStaff`);

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
-- AUTO_INCREMENT pour la table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  MODIFY `numArt` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `boutique`
--
ALTER TABLE `boutique`
  MODIFY `numArtBoutique` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `numCom` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  MODIFY `numEquipe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `JOUEUR`
--
ALTER TABLE `JOUEUR`
  MODIFY `numJoueur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `MATCH`
--
ALTER TABLE `MATCH`
  MODIFY `numMatch` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  MODIFY `numMemb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `MOTCLE`
--
ALTER TABLE `MOTCLE`
  MODIFY `numMotCle` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `PERSONNEL`
--
ALTER TABLE `PERSONNEL`
  MODIFY `numPersonnel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `STATUT`
--
ALTER TABLE `STATUT`
  MODIFY `numStat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `THEMATIQUE`
--
ALTER TABLE `THEMATIQUE`
  MODIFY `numThem` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  ADD CONSTRAINT `FK_ASSOCIATION_1` FOREIGN KEY (`numThem`) REFERENCES `THEMATIQUE` (`numThem`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD CONSTRAINT `FK_ASSOCIATION_2` FOREIGN KEY (`numArt`) REFERENCES `ARTICLE` (`numArt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_ASSOCIATION_3` FOREIGN KEY (`numMemb`) REFERENCES `MEMBRE` (`numMemb`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `JOUEUR`
--
ALTER TABLE `JOUEUR`
  ADD CONSTRAINT `fk_joueur_equipe` FOREIGN KEY (`codeEquipe`) REFERENCES `EQUIPE` (`codeEquipe`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `LIKEART`
--
ALTER TABLE `LIKEART`
  ADD CONSTRAINT `FK_LIKEART1` FOREIGN KEY (`numArt`) REFERENCES `ARTICLE` (`numArt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_LIKEART2` FOREIGN KEY (`numMemb`) REFERENCES `MEMBRE` (`numMemb`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `MATCH`
--
ALTER TABLE `MATCH`
  ADD CONSTRAINT `fk_match_equipe` FOREIGN KEY (`codeEquipe`) REFERENCES `EQUIPE` (`codeEquipe`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD CONSTRAINT `FK_ASSOCIATION_4` FOREIGN KEY (`numStat`) REFERENCES `STATUT` (`numStat`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `MOTCLEARTICLE`
--
ALTER TABLE `MOTCLEARTICLE`
  ADD CONSTRAINT `FK_MotCleArt1` FOREIGN KEY (`numMotCle`) REFERENCES `MOTCLE` (`numMotCle`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_MotCleArt2` FOREIGN KEY (`numArt`) REFERENCES `ARTICLE` (`numArt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `PERSONNEL`
--
ALTER TABLE `PERSONNEL`
  ADD CONSTRAINT `fk_personnel_equipe` FOREIGN KEY (`numEquipeStaff`) REFERENCES `EQUIPE` (`codeEquipe`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
