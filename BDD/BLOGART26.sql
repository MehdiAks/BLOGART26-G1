-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 02 fév. 2026 à 09:10
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
-- Base de données : `u437341779_BLOGART26`
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
(1, '2019-02-24 16:08:30', '2026-01-29 09:24:52', 'La surprenante reconversion de la base sous-marine', 'Un bâtiment unique chargé d\'histoire qui a survécu à l\'emprise des Allemands en 1943, et qui est aujourd\'hui l\'un des symboles d\'art de notre ville bordelaise. Comment ce bloc de béton armé a-t-il pu surpasser son obscure origine ?', 'La grande immergée du port de la Lune n’a pas toujours été celle que l’on connaît aujourd’hui', 'La grande immergée du port de la Lune, éclairée de son immense néon bleu « something strange happened here » n’a pas toujours été celle que l’on connaît aujourd’hui. Oui, notre base sous-marine est notre héritage nazi. En 1943, le bloc de béton, que nous connaissons tous, voit le jour après 22 mois de travaux forcés par des prisonniers. Une légende urbaine raconte que plus d’une centaine de ces travailleurs se seraient noyés d\'épuisement et même que certain auraient été coulés dans le béton. 235 mètres de long, 160 mètres de large, 19 mètres de hauteur, et une superficie de plus de 41 000 m2, cette base aux quatre sœurs se situant le long des côtes forment à la perfection le « Mur de l’Atlantique » érigé par les nazis fous. Le bâtiment de guerre a été pensé pour vivre des siècles, composé de 11 bassins, il peut accueillir quinze grands sous-marins. Tout ceci surplombé d\'une tour bunker abritant des magasins et des ateliers. L\'ensemble est couvert d\'un toit en béton armé de plus de 5 mètres d\'épaisseur, renforcé en 1943 par un dispositif de pare-bombes, capable de provoquer l\'explosion d\'une bombe avant d\'atteindre le toit. Un bijou nazi de 600 000 m3 de béton prêt pour résister.', 'Quel avenir pour cet amas de béton ?', 'Après la destruction et le sabotage du matériel nazis par les Alliés en août 1944, il a fallu se demander que deviendrait ce bâtiment. Raser l’édifice bétonné est la première idée à avoir vu le jour. Elle fut rapidement abandonnée, dû à son coup et sa logistique trop complexe. Mais petit-à-petit, elle va renaître dans les esprits après avoir servi de décor pour le film « Le Coup de Grâce » en 1964. Plus tard sous l’impulsion du batteur Jean-François Buisson, un studio d’enregistrement est aménagé pour son groupe dans l\'alvéole 9. Le bunker commence à attirer et interpeler les artistes qui y voient un lieu charismatique. En septembre 1998, l\'association Art AttAcks réalise la première exposition d’art contemporain « Sous le béton la plage » mêlant arts visuels et architecture. Tout ceci annonce subtilement la vocation artistique du lieu. Quelques mois plus tard, la première grande rénovation du vieux bâtiment a lieu pour permettre le renouveau de la base sous-marine. Lors de l’été 1999, la montagne de métal s’ouvre enfin au public leur proposant des expositions permanentes ou temporaires. Depuis la base a accueilli de nombreuses exhibitions artistiques et plus de 110 000 visiteurs.', 'Peau neuve, colorée et numérique pour la base bordelaise.', 'Aujourd\'hui la base sous-marine occupe une place incontournable dans le paysage culturel bordelais. Mais en 2020 elle se refait une beauté ! Passée de l\'ombre à la lumière voilà le nouvel objectif du monument. Culturespaces cherche à attirer tous les regards bordelais vers le bâtiment bétonné. Son projet ? Faire de la base sous-marine bordelaise le plus grand centre d\'art numérique au monde. Plusieurs défis ont dû être relevés en raison de l\'historique de la base, ancien bâtiment bombardé et de la présence de l\'eau avec une profondeur de 16 m (création de nouvelles passerelles, ajout d\'un bâtiment annexe future billetterie). Mais tout est fait pour transformer cet amas de béton en « Bassin des Lumières ». Après une nouvelle rénovation la grande immergée devient innovante et atypique grâce à une nouvelle expérience visuelle et sonore avec la projection de la première exposition depuis la rénovation en l\'honneur des tableaux de Gustave Klimt qui épouseront les formes de l\'édifice et se refléteront sur les courbes de l\'eau. Près de 70 ans plus tard, la base sous-marine s\'est métamorphosée en symbole d\'art comme si elle voulait prendre une revanche sur l\'origine de sa construction.', 'Pour le mot de la fin : Bruno Monnier, président de Culturespace, affirme que ses équipes et lui ont travaillé d’arrache-pied pour imaginer et concevoir la nouvelle base sous marine. Il confie à AquitaineOnline que « C’est une installation unique au monde qui s’intègre aux dimensions gigantesques du lieu ». Chez Gavé Bleu, nous trouvons le projet fantastique ! Et nous espérons que comme nous, vous serez au rendez-vous pour (re)découvrir ce monument bordelais qui revit !', 'imgArt1.jpg', 1),
(2, '2019-03-13 20:14:10', '2026-01-29 09:25:00', 'Le CHU de bordeaux se met-il au bleu ?', 'Le bleu, une couleur si commune, qui provoque tranquillité, sécurité et confiance. Toutes ces raisons pourraient déjà expliquer ce que Gavé bleu a remarqué… Mais regardons plus loin ! Pourquoi le CHU, lieu d’urgence, d’anxiété, parfois lier aux défunts, se pare d’une couleur si complémentaire, le bleu ?', 'Le CHU de Bordeaux, lieu au service de tous, tient un rôle important dans la vie des Bordelais !', 'Tout d’abord, un logo, que vous avez vu et revu, mais auquel vous n\'avez jamais, vraiment prêté attention. Ce logo est le même depuis 20 ans, exprimant les valeurs de l’hôpital, l’accueil, l’ouverture et l’échange. Il véhicule une image forte et symbolique. De plus, sa couleur est bleue ciel, tel les casques bleus de l’ONU, évoque donc la paix, l’assurance, la bienveillance et l’expertise. On peut remarquer que, c’est aussi la couleur phare de grands groupes, et d’entreprises pharmaceutiques, tel que La Roche-Posay, Bayer, Vichy ou encore Nivea. Pourquoi un tel intérêt ? Vous ne le savez peut-être pas, mais à une époque, on parlait de « Sang Bleu », ce qui correspondait aux personnes de la noblesse ou de sang royal, donc historiquement le bleu évoque aussi, le prestige ! Pour finir, le bleu est aussi une des 3 couleurs primaires, donc essentiel pour pouvoir construire les autres couleurs. Ce qui fait écho avec le fait que l\'hôpital est en lieu nécessaire et primordial à la société !', 'Savez-vous pourquoi les blouses des chirurgiens sont-elles bleues ?', 'Voici une question que vous ne vous êtes peut-être jamais posée. Pourquoi les différents hôpitaux, ont-ils choisi, pour leurs opérations la couleur bleue, ou même vert clair ? La couleur actuelle des blouses des chirurgiens, n\'a pas été choisie au hasard. Avant, les blouses étaient blanches, symbole de propreté. Mais le blanc s’est révélé être source d’illusion d’optique. Comme nous le savons, les chirurgiens passent souvent de très longues heures, concentrés sur des organes ou du sang humain… Le cerveau est donc concentré sur ces tons rouges, si le chirurgien fixe soudainement sa blouse, ou la blouse de ses collègues, il verra des tâches noires, ce phénomène peut le déconcentrer pendant quelques minutes. Ce qui n’arrive pas si les blouses et les murs sont verts ou bleus, car ces couleurs sont des couleurs complémentaires aux teintes rouges ! Ce sont donc, les couleurs qui gênent le moins les professionnels de santé. De plus, elles permettent de rendre les yeux plus sensibles aux différentes couleurs de l\'anatomie humaine et les aident à être plus attentifs aux éventuelles erreurs durant l\'opération. Bluffant non ?', 'Connaissez vous les fées du CHU de Bordeaux ?', 'Les Fées Bleues sont une association créée par le personnel soignant du CHU, qui a pour but d’apporter de la couleur et du confort, dans le monde aseptisé du soin des prématurés ou bien pour les enfants en réanimation. Ces bénévoles sont des aides-soignantes ou infirmières qui y consacrent leurs temps libre. Ces fées bleues, créent ainsi, des parures colorées pour les incubateurs, confectionnent des jeux pour occuper les enfants, ou crée des tuniques colorées pour remplacer les tuniques de soins… Le CHU soutient l\'initiative de son personnel soignant, et a même accueilli récemment un nouveau pensionnaire au service pédiatrique. Il s’appelle Nao, il est bleu et blanc, et il mesure 58 cm ! Sa mission est d’aider les enfants qui ne peuvent pas sortir de l\'hôpital à cause de leur déficience immunitaire. Ce robot joue, danse et parle… Il a été programmé à destination des personnes autistes, handicapées, ou âgées. Grâce à son intelligence artificielle, le robot rompt l\'isolement, et recrée du lien avec l\'extérieur. Ce beau cadeau fait aux enfants du CHU de Bordeaux, a été offert par le Lion Club Bordeaux Graves, un cadeaux d’une valeur de 12 000 € !', 'Et voilà vous savez maintenant tout sur le CHU de Bordeaux ! Quoi que… Savez-vous qu’il participe à l\'opération de sensibilisation Mars Bleu ? Notre hôpital se met donc au bleu pour améliorer son quotidien et pour le plus grand plaisir de Gavé Bleu !', 'imgArt2.jpg', 4),
(3, '2019-11-09 10:34:20', '2026-01-29 09:25:04', 'Le Lion bleu de Bordeaux, star des réseaux sociaux', 'Surplombant la place Stalingrad, anciennement place du Pont, et faisant fièrement face au pont de Pierre, le Lion bleu de Xavier Veilhan fait depuis 2005 l’objet de toutes les convoitises.', 'En France, toute construction d’un bâtiment public a pour but d’accueillir du monde', 'En France, depuis 1951 et l’arrêté des « 1% artistique », toute construction d’un bâtiment public ayant pour but d’accueillir du monde doit prévoir 1% de son budget total pour financer des œuvres d’art aux abords du bâtiment. En construisant les lignes de tramway, la ville de Bordeaux et sa métropole ont donc mis en place le programme « L’art dans la ville ». Supervisé par le directeur du Centre Georges-Pompidou, cette initiative a pu débloquer plusieurs millions d’euros depuis 2000 pour la réalisation d’une quinzaine d’œuvres. Parmi ces œuvres, nous pouvons noter « La maison aux personnages » place Amélie Raba Léon, les affiches « Aux bord’eaux » présentes dans toutes les stations ou bien le fameux Lion bleu bordelais. Mise en place et vissée sur les pavés de la rive droite le 30 juin 2005, cette sculpture en plastique mesure 6 mètres de haut. Elle va de pair avec la mise en service de la première ligne de tramway dans Bordeaux, la ligne A, qui traverse le pont de Pierre et la place Stalingrad. En décalage total par rapport au style architectural très XVIIIème de la ville, cette œuvre a d’abord été massivement rejetée par les habitants du quartier, mais ils l’ont désormais adoptée.', 'Un symbole de la rive droite', 'On n’imagine pas la place Stalingrad sans cet imposant félin coloré. Ce lion bleu est devenu l\'emblème de cette place et, pour les habitants de la rive gauche, c’est le symbole de « l’autre rive », c’est la première chose que l’on voit en traversant la Garonne depuis le quartier de Saint-Michel. Ce lion bleu, on s’y abrite, on s’y donne rendez-vous, on s’en sert de repère et les écoliers y prennent souvent leur premier cours d’art contemporain. Ce lion bleu n’est pour certain qu’un gros point azur pixelisé à l’horizon, mais pour d’autres c’est un symbole, un mirage, comme un gros jouet qu\'on ne perd jamais. Et ce gros jouet, des centaines d’internautes se le sont attribué et en parlent sur Instagram via le #lionbleu. Ils postent régulièrement des photos de lui, toujours dans la même posture, veillant sur la ville de Bordeaux. D’objet d’art à star du net, il n’y a qu’un pas. Et ce pas, le Lion de Veilhan l’a franchi comme il franchirait la Garonne pour rejoindre le centre-ville bordelais. En plus de son esthétique remarquable, son créateur n’a pas omis de lui donner un sens propre en prenant en compte l’environnement qui entoure cette statue bestiale.', 'Un tremplin pour Xavier Veilhan', 'L\'artiste plasticien à l’origine du Lion bleu, diplômé de l\'EnsAD-Paris (École Nationale Supérieure des Arts Décoratifs) et officier de l’Ordre des Arts et des Lettres, n’a pas choisi une figure animalière pour rien. La place Stalingrad est un hommage à la victoire de l’armée soviétique durant la Seconde Guerre Mondiale. Xavier Veilhan souhaitait donc offrir à ce lieu une œuvre monumentale qui renforce son identité. À l’instar du Lion de Belfort de Bartholdi, il a donc choisi cet animal pour ses valeurs de force tranquille, se battant pour la justice avec puissance mais intelligence. Il déclarait, avant sa construction, vouloir quelque chose de totémique, à la fois dominant et protecteur. Il ne reste plus qu’à espérer qu’il seconde Bordeaux et ses habitants dans leur quotidien futur. Le sculpteur du Lion a vu sa côte mondiale grimper suite à la réalisation de cette œuvre. Il a, depuis, pu exposer un Carrosse violet à Versailles en 2009, un Skateur bleu en Corée du Sud en 2014, ou encore Romy, une femme jaune, devant la gare de Lille en 2019.', 'Espérons que cet élan de créativité se poursuive et que, par la suite, Xavier Veilhan réutilise cette couleur qui nous est si chère, le bleu.', 'imgArt3.jpg', 4),
(4, '2020-01-12 18:21:21', '2026-01-29 09:25:12', 'Nicolas Caraty : médiateur culturel plein de bon sens !', 'Le lundi 21 février, nous avons eu la chance de rencontrer Nicolas Caraty, un médiateur culturel non-voyant du musée d\'Aquitaine. Cette entrevue a vu le jour suite à des questionnements sur l’art et les sculptures, ainsi que leur accessibilité. Nous en avons appris plus sur son parcours professionnel, et comment il s’est retrouvé au musée d’Aquitaine. Et nous avons également échangé longuement au sujet de l’accès à la culture pour tout le monde, ce qui nous a mené à discuter de son projet sensationnel : le parcours sensoriel !', 'Nicolas Caraty, lui, son parcours sensoriel', 'Toucher des œuvres du musée d’Aquitaine, c’est possible ! Et ce en grande partie grâce à lui ! Nicolas Caraty a débuté sa carrière professionnelle en tant qu’accordeur de piano sur Paris. Assez vite, il s’est vite questionné sur l’accès à la culture pour les personnes en situation de handicap. Il va par la suite travailler 3 ans chez « Toucher pour connaître », association concevant des expositions adaptées et retranscrit les journaux écrits en cassettes audio. À la suite de cette expérience, il change totalement de secteur et s’oriente vers la vente par correspondance et le suivi client chez Les 3 Suisses. Il occupe ce poste pendant près de 8 ans avant de le quitter et se diriger vers le musée d’Aquitaine de Bordeaux. Recruté en 2007 en tant que stagiaire chargé de la médiation culturelle, il est un an plus tard titularisé par la mairie de Bordeaux et occupe encore ce poste aujourd’hui. Nicolas est un amoureux de l’art, sa déclinaison préférée est celle de la musique. Amateur de piano et de guitare depuis son jeune âge, il se tourne de plus en plus vers le synthétiseur. Et c’est sans compter son attrait pour le cinéma, la peinture, le théâtre, l’écriture, et bien évidemment la sculpture.', 'L’art et l’handicap', '« L’art permet d’exprimer les choses, mais parfois la difficulté c’est d’y avoir accès. ». Cette phrase entendue durant l’interview nous a particulièrement marqués. Il est vrai que nous avons tous les jours l’occasion de prêter attention à la culture, néanmoins certaines personnes en situation de handicap (notamment visuel ou auditif) peuvent parfois trouver difficile l’accès à cette dernière. Bien sûr, comme nous l’explique Nicolas, le handicap ne signifie pas forcément que la culture devient totalement inaccessible. Lui-même est un musicien avéré comme évoqué plus tôt. Il nous a d’ailleurs expliqué un fait intéressant sur la découverte des sculptures : « Quand vous êtes non-voyant, vous faites une exploration partielle de l\'œuvre avec vos mains qui sont capables d’explorer ces détails. Au fur et à mesure vous êtes aptes à reconstituer l\'œuvre dans l’espace, en allant donc du détail vers la globalité ». Ce qui, lorsqu’on y réfléchit bien, est une découverte totalement opposée à celle d’une personne voyante qui, elle, voit la sculpture d’abord dans sa globalité, puis vient ensuite chercher les détails en la touchant. Donc tout est en réalité une question de perspectives et de méthodes.', 'Le parcours sensoriel', 'C’est là qu’entre en jeu le fameux parcours sensoriel ! Il s’agit d’un chemin pédagogique installé dans le musée d\'Aquitaine. Comme son nom l\'indique, il permet de faire découvrir diverses œuvres en faisant appel au plus de sens possible pour les rendre accessibles. Plusieurs initiatives sont prises en compte pour se faire, telles que la production d’audio-descriptions associées à plusieurs tableaux (contant le contexte, l’histoire de ces derniers, illustrés par des effets sonores). Et il faut évoquer les nombreuses sculptures reproduites à l’identique avec des matières très similaires à celles d\'origine. Il est question de reproduction de masques africains en bois, de sculptures en pierre… Nicolas nous a montré une reproduction d’une statue de bronze représentant le Roi Louis XV, réalisée grâce à une modélisation 3D. Il a également pris le temps de nous faire toucher d’autres ouvrages, notamment une reproduction de la Vénus à la corne, ainsi que des pierres taillées de la préhistoire. Ce parcours sensoriel permet donc à la fois de conserver en bon état les vestiges du passé, tout en proposant une offre permanente de visite culturelle aux personnes en situation de handicap.', 'Le patrimoine culturel de Bordeaux devient plus accessible puisque de nombreux efforts sont faits pour soutenir cette cause. Mais selon Nicolas, il faut continuer sur ce chemin. À présent, l’objectif majeur est de diffuser l’information. À notre échelle, nous pouvons partager nos connaissances culturelles avec autrui. Il faut aussi réfléchir à un moyen d’adapter ces services pour les rendre accessibles au maximum. D’après Nicolas : « Si on fait vivre cette découverte non pas par des connaissances encyclopédiques mais plutôt par la notion de plaisir, les gens seront plus à l’aise. Il ne faut pas les mettre en situation d’échec, mais plutôt les guider, les amener à découvrir les œuvres par eux-mêmes, et alors là il sera plus aisé de les mener vers des connaissances plus théoriques ».', 'imgArt4.jpg', 2),
(5, '2022-03-04 12:28:00', '2026-01-29 09:25:16', 'La sculpture Sanna va-t-elle nous quitter ?', 'Depuis presque dix ans, la sculpture Sanna trône sur la place de la comédie. Visage emblématique et intriguant que l’on apprécie contempler. Aujourd’hui, il est possible qu’elle ne devienne plus qu’un souvenir… La ville de Bordeaux a toujours été investie dans la culture et l\'accès à l’art, c’est pourquoi le sujet de la sculpture Sanna fait polémique au sein de la ville.', 'Quelle histoire se cache derrière ce visage ?', 'La demoiselle de fonte a été érigée en 2013 par Jaume Plensa dans le cadre d’une exposition bordelaise, Sanna était accompagnée de sa « sœur » Paula, qui elle, était placée devant la cathédrale de Bordeaux. Jaume Plensa est un artiste Catalan qui a réalisé onze autres œuvres, exposées à travers la ville. Mais, celles-ci ont été retirées. Actuellement, c’est un particulier anonyme qui possède la sculpture Sanna, il laisse à la municipalité de Bordeaux un délai de 5 ans pour la conserver sur la place de la Comédie. Elle partirait à priori en 2027. Ce serait donc le départ d’une œuvre extravagante et surtout emblématique de la ville de Bordeaux.', 'Une demoiselle de fonte, d’âme et d’or', 'Sanna est une sculpture figurative monumentale faite entièrement de fonte, il s’agit du visage d’une jeune fille qui paraît particulièrement apaisée, comme si elle était endormie. Cette impression de plénitude est due aux yeux fermés de la jeune fille et à son expression imperturbable, comme si elle n’allait jamais les rouvrir. Sous certaines perspectives, Sanna peut adopter différents styles : de face son visage est parfaitement droit et bien proportionné mais de côté son visage semble difforme. Aussi, nous pouvons voir évoluer les couleurs de la demoiselle de fonte au fur et à mesure des années. En effet, la sculpture rouille et sa teinte varie en fonction du temps. Sanna se situe devant le grand théâtre sur la place de la Comédie, son style particulier qui marie la grossièreté du fer et la finesse des traits, se combine parfaitement avec l’opéra par ses formes imposantes et travaillées. Pour l’artiste, Jaume Plensa, le visage est « le miroir de l’âme ». Par conséquent, l\'œuvre permet aux bordelais d’acquérir un instant de paix de l’esprit en plein cœur de la ville.', 'L\'achat de la statue', 'En plus de son aspect artistique, la sculpture de Sanna génère évidemment aussi un certain engouement affectant son aspect économique. En effet, en 2014 après l’exposition de Jaume Plensa, Bordeaux fait une levée de fond pour racheter la sculpture. La ville a besoin de récolter 150 000 € auprès des habitants et prévoit ensuite de compléter cette récolte en sortant également un minimum de 150 000 € de sa poche. Effectivement, la valeur financière de l\'œuvre varie entre 300 000 € et 500 000 €. Malheureusement, les dons étant trop faibles, la récolte n\'aboutit pas à un résultat concluant. Seulement 44 000 € ont été récoltés ce qui n’a absolument pas été suffisant pour que la municipalité prenne en charge le reste de l’achat. Fort heureusement en 2015, un particulier anonyme achète la statue et signe un contrat avec la municipalité de Bordeaux pour la laisser 6 ans de plus sur la place de la Comédie. Plus récemment encore, le 8 février 2022, la ville de Bordeaux a annoncé officiellement qu’un autre accord avait été approuvé, permettant à la sculpture de rester sur la place et surtout dans nos cœurs jusqu’en 2027.', 'Finalement, cette sculpture reste encore parmi nous pendant un bon moment. Cette demoiselle de fonte au vécu poétique ayant rythmé la vie de beaucoup de bordelais continuera donc de le faire ces cinq prochaines années. Et cette affaire d’argent plutôt compliquée pour la mairie de Bordeaux lui a tout de même permis de conserver ce bien grâce à l’aide de ce fameux acheteur anonyme. Nous vous suggérons donc d’aller une fois encore apprécier sa présence avant son départ imminent ! Avec l’équipe de rédaction, nous nous demandions si vous aussi vous aviez des anecdotes croustillantes à raconter sur ce visage fait de métaux. Qu’est-ce qu’elle vous fait ressentir ? Êtes-vous heureux d’apprendre qu’elle reste à nos côtés encore longtemps vous aussi ? Nous avons hâte de lire vos réponses en commentaire !', 'imgArt5.jpg', 4),
(6, '2023-12-04 10:08:30', '2026-01-29 09:25:22', 'Comment le sang bleu a dominé le symbole de Bordeaux ?', 'Tout au long de son histoire Bordeaux a connu de nombreuses façon d’être représentée, ou comment ses armoiries ont été les images de son occupation anglaise, de sa domination royale et de la prospérité moderne qu’elle connaît au 21ème siècle.', 'Avez-vous déjà vu l’emblématique blason de Bordeaux ?', 'Ce symbole qui à plusieurs reprises, s’est vu transformer par la noblesse anglaise. Celui provenant du Moyen âge tardif sous la conquête française est le plus connu puisque c’est une représentation symbolique et figurée grâce auquelle on peut deviner l’histoire entremêlée de la ville. Trois couleurs dominent cet écusson : le jaune, le rouge et le bleu. Dessus on peut y reconnaître différentes formes dont des « meubles » qui représentent des éléments précis. Situé au sommet de l’écu bordelais, semblable à un ciel bleu nuit, étoilé de fleurs de lys, se trouve le Chef d’azur semé de France symbole des rois de France. Au-dessous, sur un fond rouge sang, un Léopard d’or et non un Lion, représentant la province de la Guyenne, survole une forteresse. Ce n’est pas une simple forteresse idéale mais l\'un des monuments phare de Bordeaux : la Grosse-Cloche, reproduite sous des traits stylisés. Elle est fortifiée de deux tours aujourd’hui disparus. Comme débordant à flot, la mer d’azur ondoyé de sable d’argent incarnant la Garonne se voit surmonté d’un croissant d’argent qui fait évidemment allusion à la forme semi-circulaire du port de la Lune.', 'Un blason malmené aux bleus visibles', 'Si la première représentation connue du blason français de Bordeaux se trouve dans l’ouvrage de Gabriel de Tareda nommé Tracté contre la peste de 1519. Ce ne fut pas la première version à voir le jour. La ville fut influencée par le sang bleu anglais, la monarchie provenant d’Angleterre, pendant 300 ans, cette situation impactant le reflet de Bordeaux : son Blason. Richard Cœur de Lion a façonné un écu à son image afin d\'asseoir sa domination, ainsi se fut trois Léopards d’or qui logeaient au sommet du blason. Ce n’est qu’en 1453 grâce à la reconquête française, que le blason pris sa forme définitive, celle qu’on connaît, arborant finalement le symbole des rois français à la place. Plus tard une dernière version apparu : deux antilopes enchaînées et à collier fleurdelisé, ainsi qu’une couronne murale représentant une muraille encadre le blason français. Ce sont des supports d’armoiries inusitées en France, au Moyen-Âge. Une devise y est aussi inscrite « Lilia sola regunt lunam unda castra leonem » retranscrit « les lys règnent seuls sur la lune, les ondes, la forteresse et le lion » faisant allusion à la domination du roi de France sur Bordeaux, après la période d’occupation anglaise.', 'Le bleu roi toujours au devant du tableau bordelais', 'Malgré la confuse histoire ce blason des plus symboliques, la grande ville qu’est Bordeaux ne peut se décider à l’utiliser pour se représenter en ces temps modernes. Pour résoudre cette affaire de grande envergure la mairie a choisi un logo neutre tout en gardant un symbole représentatif : le port de la lune. En effet le logo-type de la ville est constitué de trois croissants entrelacés qu’on appelle aussi le chiffre de Bordeaux, de couleur blanc nacré sur fond rouge bordeaux. Il n’est pas impossible qu’elles figurent sur certaines reliure de livre et sur la fontaine Saint-Projet de la rue Sainte-Catherine. Gravé dans la pierre, fondue dans le métal ou sur le verre des bouteilles « bordelaises » on retrouve ce symbole sur tous les produits provenant de la ville. Le trio lunaire est également surmonté du nom de la ville sur fond bleu roi. Cette couleur qui a su se faire une place dans l’histoire de Bordeaux, représente autant la royauté que le fleuve bordelais. Et aujourd’hui à l’époque où l’homme s’élève grâce aux nouvelles technologies qui nous permettent de nombreux exploits, on peut enfin poser un nom sur ce bleu qui nous a guidé tous ces siècles et lui rendre hommage : Le Bleu 072 C.', 'Si la ville de Bordeaux a sa charte graphique et son propre logo elle n’est pas la seule, on retrouve nombreux logo tout aussi caractéristique s’inspirant de l’histoire, comme les logos d’Aquitaine, de l’Union Bordeaux-Bègles ou des bleus de Bordeaux : les Girondins !', 'imgArt6.jpg', 3);

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
(10, '2026-01-30 15:08:14', 'bonjours ces un test', NULL, 0, NULL, NULL, 0, 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `MATCH_CLUB`
--

CREATE TABLE `MATCH_CLUB` (
  `numMatch` int NOT NULL,
  `sourceId` varchar(120) COLLATE utf8mb3_unicode_ci NOT NULL,
  `competition` varchar(120) COLLATE utf8mb3_unicode_ci NOT NULL,
  `matchDate` date NOT NULL,
  `matchTime` time DEFAULT NULL,
  `teamHome` varchar(120) COLLATE utf8mb3_unicode_ci NOT NULL,
  `teamAway` varchar(120) COLLATE utf8mb3_unicode_ci NOT NULL,
  `location` varchar(160) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` varchar(40) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `scoreHome` int DEFAULT NULL,
  `scoreAway` int DEFAULT NULL,
  `sourceUrl` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtCreaMatch` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtMajMatch` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `MATCH_CLUB`
--

INSERT INTO `MATCH_CLUB` (`numMatch`, `sourceId`, `competition`, `matchDate`, `matchTime`, `teamHome`, `teamAway`, `location`, `status`, `scoreHome`, `scoreAway`, `sourceUrl`, `dtCreaMatch`, `dtMajMatch`) VALUES
(1, 'ffbb-2026-02-08-bec-1', 'Championnat Pré-Nationale', '2026-02-08', '20:30:00', 'BEC Basket', 'Bordeaux Basket Club', 'Salle Saint-Genès, Bordeaux', 'À venir', NULL, NULL, 'https://www.ffbb.com/competitions/ffbb-2026-02-08-bec-1', '2026-02-01 09:00:00', NULL),
(2, 'ffbb-2026-02-15-bec-2', 'Championnat Pré-Nationale', '2026-02-15', '18:00:00', 'Stade Bordelais', 'BEC Basket', 'Gymnase Nelson-Paillou, Bordeaux', 'À venir', NULL, NULL, 'https://www.ffbb.com/competitions/ffbb-2026-02-15-bec-2', '2026-02-01 09:00:00', NULL),
(3, 'ffbb-2026-02-22-bec-3', 'Coupe de la Gironde', '2026-02-22', '16:30:00', 'BEC Basket', 'AS Mérignac', 'Salle Saint-Genès, Bordeaux', 'À venir', NULL, NULL, 'https://www.ffbb.com/competitions/ffbb-2026-02-22-bec-3', '2026-02-01 09:00:00', NULL),
(4, 'ffbb-2026-03-01-bec-4', 'Championnat Pré-Nationale', '2026-03-01', '19:00:00', 'US Talence', 'BEC Basket', 'Complexe Sportif Henri-Deschamps, Talence', 'À venir', NULL, NULL, 'https://www.ffbb.com/competitions/ffbb-2026-03-01-bec-4', '2026-02-01 09:00:00', NULL);

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
(1, '::1', 'accepted', '2026-01-30 16:00:08', '2026-01-31 15:00:08');

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
(5, 6, 1);

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
(5, 6),
(6, 1),
(6, 6);

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
-- AUTO_INCREMENT pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `numCom` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `MATCH_CLUB`
--
ALTER TABLE `MATCH_CLUB`
  MODIFY `numMatch` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `COOKIE_CONSENT`
--
ALTER TABLE `COOKIE_CONSENT`
  MODIFY `numCon` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  MODIFY `numMemb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `MOTCLE`
--
ALTER TABLE `MOTCLE`
  MODIFY `numMotCle` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `STATUT`
--
ALTER TABLE `STATUT`
  MODIFY `numStat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Contraintes pour la table `LIKEART`
--
ALTER TABLE `LIKEART`
  ADD CONSTRAINT `FK_LIKEART1` FOREIGN KEY (`numArt`) REFERENCES `ARTICLE` (`numArt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_LIKEART2` FOREIGN KEY (`numMemb`) REFERENCES `MEMBRE` (`numMemb`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
