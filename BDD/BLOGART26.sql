-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 03 fév. 2026 à 11:50
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
  `libTitrArt` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `libChapoArt` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `libAccrochArt` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parag1Art` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `libSsTitr1Art` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parag2Art` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `libSsTitr2Art` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parag3Art` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `libConclArt` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `urlPhotArt` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
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
-- Structure de la table `bec_matches`
--

CREATE TABLE `bec_matches` (
  `id` int UNSIGNED NOT NULL,
  `Section` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Equipe` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Competition` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phase` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Journee` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Heure` time NOT NULL,
  `Domicile_Exterieur` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Equipe_domicile` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Equipe_exterieure` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Adversaire` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Score_BEC` int DEFAULT NULL,
  `Score_Adversaire` int DEFAULT NULL,
  `Score_domicile` int DEFAULT NULL,
  `Score_exterieur` int DEFAULT NULL,
  `MatchNo` int NOT NULL,
  `Source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bec_matches`
--

INSERT INTO `bec_matches` (`id`, `Section`, `Equipe`, `Competition`, `Phase`, `Journee`, `Date`, `Heure`, `Domicile_Exterieur`, `Equipe_domicile`, `Equipe_exterieure`, `Adversaire`, `Score_BEC`, `Score_Adversaire`, `Score_domicile`, `Score_exterieur`, `MatchNo`, `Source`) VALUES
(1, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J1', '2025-09-20', '22:00:00', 'Extérieur', 'US CHARTRONS BORDEAUX', 'BORDEAUX ETUDIANTS CLUB', 'US CHARTRONS BORDEAUX', 43, 81, 81, 43, 6, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(2, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J1', '2025-09-20', '22:00:00', 'Extérieur', 'BORDEAUX BASTIDE BASKET', 'BORDEAUX ETUDIANTS CLUB', 'BORDEAUX BASTIDE BASKET', 67, 60, 60, 67, 811, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(3, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J1', '2025-09-20', '22:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'SA GAZINET CESTAS', 'SA GAZINET CESTAS', 64, 50, 64, 50, 8004, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(4, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J1', '2025-09-21', '15:00:00', 'Extérieur', 'ENTENTE SPORTIVE BLANQUEFORT - 2', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE SPORTIVE BLANQUEFORT - 2', 102, 48, 48, 102, 9004, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(5, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J1', '2025-09-21', '17:00:00', 'Extérieur', 'BRESSUIRE LE REVEIL', 'BORDEAUX ETUDIANTS CLUB', 'BRESSUIRE LE REVEIL', NULL, NULL, NULL, NULL, 405, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(6, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J1', '2025-09-21', '17:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ABB CORNEBARRIEU', 'ABB CORNEBARRIEU', 75, 40, 75, 40, 18, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(7, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J2', '2025-09-27', '20:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'UNION SPORTIVE TULLE CORREZE', 'UNION SPORTIVE TULLE CORREZE', 69, 88, 69, 88, 834, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(8, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J2', '2025-09-27', '22:00:00', 'Extérieur', 'US CHARTRONS BORDEAUX', 'BORDEAUX ETUDIANTS CLUB', 'US CHARTRONS BORDEAUX', 79, 33, 33, 79, 8014, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(9, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J2', '2025-09-27', '22:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AYTRE BASKET BALL', 'AYTRE BASKET BALL', 68, 52, 68, 52, 17, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(10, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J2', '2025-09-28', '15:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'STADE BORDELAIS', 'STADE BORDELAIS', 61, 60, 61, 60, 9014, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(11, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J2', '2025-09-28', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AYTRE BASKET BALL', 'AYTRE BASKET BALL', 52, 57, 52, 57, 416, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(12, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J2', '2025-09-28', '17:30:00', 'Extérieur', 'COTEAUX DU LUY BASKET', 'BORDEAUX ETUDIANTS CLUB', 'COTEAUX DU LUY BASKET', 72, 76, 76, 72, 66, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(13, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J3', '2025-10-04', '22:00:00', 'Extérieur', 'CASTELNAU MEDOC BC', 'BORDEAUX ETUDIANTS CLUB', 'CASTELNAU MEDOC BC', 90, 105, 105, 90, 28, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(14, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J3', '2025-10-04', '22:00:00', 'Extérieur', 'UNION SAINT BRUNO BORDEAUX', 'BORDEAUX ETUDIANTS CLUB', 'UNION SAINT BRUNO BORDEAUX', 52, 70, 70, 52, 857, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(15, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J3', '2025-10-04', '22:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'US TALENCE', 'US TALENCE', 45, 52, 45, 52, 8020, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(16, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J3', '2025-10-05', '17:00:00', 'Extérieur', 'AMICALE LOISIRS CASTILLONNES BASKET', 'BORDEAUX ETUDIANTS CLUB', 'AMICALE LOISIRS CASTILLONNES BASKET', 52, 47, 47, 52, 427, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(17, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J3', '2025-10-05', '17:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE PESSAC BASKET CLUB - 1', 'ENTENTE PESSAC BASKET CLUB - 1', 82, 62, 82, 62, 114, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(18, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J3', '2025-10-05', '19:00:00', 'Extérieur', 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3', 'BORDEAUX ETUDIANTS CLUB', 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3', 72, 49, 49, 72, 9022, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(19, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J3', '2025-10-05', '19:00:00', 'Extérieur', 'B.IZON - 2', 'BORDEAUX ETUDIANTS CLUB', 'B.IZON - 2', 34, 41, 41, 34, 28, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(20, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J4', '2025-10-11', '20:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AIXE BC VAL DE VIENNE', 'AIXE BC VAL DE VIENNE', 73, 64, 73, 64, 880, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(21, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J4', '2025-10-11', '22:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CEP POITIERS', 'CEP POITIERS', 57, 67, 57, 67, 39, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(22, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J4', '2025-10-11', '23:00:00', 'Extérieur', 'STE EULALIE BASKET BALL', 'BORDEAUX ETUDIANTS CLUB', 'STE EULALIE BASKET BALL', 57, 60, 60, 57, 8028, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(23, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J4', '2025-10-12', '15:00:00', 'Extérieur', 'BC ST AVIT ST NAZAIRE', 'BORDEAUX ETUDIANTS CLUB', 'BC ST AVIT ST NAZAIRE', 63, 57, 57, 63, 42, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(24, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J4', '2025-10-12', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'LIMOGES ABC EN LIMOUSIN - 2', 'LIMOGES ABC EN LIMOUSIN - 2', 49, 53, 49, 53, 438, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(25, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J4', '2025-10-12', '17:30:00', 'Extérieur', 'AS ST DELPHIN - 2', 'BORDEAUX ETUDIANTS CLUB', 'AS ST DELPHIN - 2', 74, 73, 73, 74, 162, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(26, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J1', '2025-10-19', '15:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'COUTRAS GUITRES BASKET', 'COUTRAS GUITRES BASKET', 46, 49, 46, 49, 4, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(27, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J4', '2025-10-19', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BASKET CLUB MARCHEPRIME', 'BASKET CLUB MARCHEPRIME', 83, 64, 83, 64, 9030, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(28, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J5', '2025-10-26', '16:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'HAGETMAU MOMUY CASTAIGNOS BASKET', 'HAGETMAU MOMUY CASTAIGNOS BASKET', 69, 53, 69, 53, 210, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(29, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J5', '2025-11-01', '21:00:00', 'Extérieur', 'JSA BORDEAUX BASKET - 2', 'BORDEAUX ETUDIANTS CLUB', 'JSA BORDEAUX BASKET - 2', 72, 57, 57, 72, 50, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(30, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J5', '2025-11-01', '21:00:00', 'Extérieur', 'AS ST DELPHIN', 'BORDEAUX ETUDIANTS CLUB', 'AS ST DELPHIN', 62, 75, 75, 62, 903, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(31, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J5', '2025-11-01', '21:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC SMB - SAM - SA MERIGNACAIS', 'IE - CTC SMB - SAM - SA MERIGNACAIS', 54, 42, 54, 42, 8036, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(32, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J5', '2025-11-02', '15:00:00', 'Extérieur', 'AS MARTIGNAS - 2', 'BORDEAUX ETUDIANTS CLUB', 'AS MARTIGNAS - 2', 53, 31, 31, 53, 9039, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(33, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J5', '2025-11-02', '16:00:00', 'Extérieur', 'POUZIOUX VOUNEUIL/BIARD BC', 'BORDEAUX ETUDIANTS CLUB', 'POUZIOUX VOUNEUIL/BIARD BC', 46, 76, 76, 46, 449, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(34, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J5', '2025-11-02', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'STE EULALIE BASKET BALL', 'STE EULALIE BASKET BALL', 38, 58, 38, 58, 52, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(35, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J6', '2025-11-02', '16:30:00', 'Extérieur', 'IE - AUCH BASKET CLUB - 1', 'BORDEAUX ETUDIANTS CLUB', 'IE - AUCH BASKET CLUB - 1', 75, 42, 42, 75, 258, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(36, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J6', '2025-11-08', '19:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE SPORTIVE BLANQUEFORT - 2', 'ENTENTE SPORTIVE BLANQUEFORT - 2', 111, 42, 111, 42, 9049, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(37, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J6', '2025-11-08', '21:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CA BRIVE CORREZE SECTION BASKET', 'CA BRIVE CORREZE SECTION BASKET', 79, 65, 79, 65, 926, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(38, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J6', '2025-11-08', '22:00:00', 'Extérieur', 'UNION SPORTIVE BREDOISE BASKET - 2', 'BORDEAUX ETUDIANTS CLUB', 'UNION SPORTIVE BREDOISE BASKET - 2', 48, 58, 58, 48, 8044, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(39, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J6', '2025-11-09', '14:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CA BRIVE CORREZE SECTION BASKET', 'CA BRIVE CORREZE SECTION BASKET', 54, 45, 54, 45, 460, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(40, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J6', '2025-11-09', '16:00:00', 'Extérieur', 'COUTRAS GUITRES BASKET', 'BORDEAUX ETUDIANTS CLUB', 'COUTRAS GUITRES BASKET', 34, 48, 48, 34, 64, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(41, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J7', '2025-11-09', '16:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', 95, 43, 95, 43, 301, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(42, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J7', '2025-11-15', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'LE TAILLAN BASKET - 2', 'LE TAILLAN BASKET - 2', 49, 52, 49, 52, 8052, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(43, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J7', '2025-11-15', '19:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', 81, 55, 81, 55, 953, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(44, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J7', '2025-11-15', '21:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'COGNAC BASKET AVENIR', 'COGNAC BASKET AVENIR', 74, 66, 74, 66, 76, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(45, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J7', '2025-11-16', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CA BEGLES', 'CA BEGLES', 42, 58, 42, 58, 475, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(46, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J7', '2025-11-16', '16:00:00', 'Extérieur', 'STADE BORDELAIS', 'BORDEAUX ETUDIANTS CLUB', 'STADE BORDELAIS', 58, 66, 66, 58, 9059, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(47, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J8', '2025-11-16', '16:30:00', 'Extérieur', 'B. COMMINGES SALIES DU SALAT - 1', 'BORDEAUX ETUDIANTS CLUB', 'B. COMMINGES SALIES DU SALAT - 1', 89, 84, 84, 89, 351, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(48, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J8', '2025-11-27', '22:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'US CENON RIVE DROITE', 'US CENON RIVE DROITE', 77, 69, 77, 69, 90, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(49, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J8', '2025-11-29', '21:00:00', 'Extérieur', 'ES ST FRONT DE PRADOUX', 'BORDEAUX ETUDIANTS CLUB', 'ES ST FRONT DE PRADOUX', 74, 61, 61, 74, 979, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(50, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J8', '2025-11-29', '21:30:00', 'Extérieur', 'SA GAZINET CESTAS', 'BORDEAUX ETUDIANTS CLUB', 'SA GAZINET CESTAS', 54, 41, 41, 54, 8060, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(51, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J8', '2025-11-30', '14:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3', 'EN - CTC MEDOC ESTUAIRE - LUDON BASKET CLUB - 3', 75, 60, 75, 60, 9067, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(52, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J8', '2025-11-30', '16:00:00', 'Extérieur', 'CHAURAY BASKET CLUB - 2', 'BORDEAUX ETUDIANTS CLUB', 'CHAURAY BASKET CLUB - 2', 52, 42, 42, 52, 489, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(53, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J8', '2025-11-30', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'B.IZON - 2', 'B.IZON - 2', 51, 28, 51, 28, 88, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(54, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J9', '2025-11-30', '16:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'LE TAILLAN BASKET', 'LE TAILLAN BASKET', 86, 40, 86, 40, 399, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(55, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J9', '2025-12-06', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'US CHARTRONS BORDEAUX', 'US CHARTRONS BORDEAUX', 65, 46, 65, 46, 8070, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(56, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J9', '2025-12-06', '19:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BEAUNE-RILHAC-BONNAC BASKET', 'BEAUNE-RILHAC-BONNAC BASKET', 63, 70, 63, 70, 1003, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(57, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J9', '2025-12-06', '21:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BOULAZAC BASKET DORDOGNE - 2', 'BOULAZAC BASKET DORDOGNE - 2', 71, 57, 71, 57, 102, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(58, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J10', '2025-12-07', '14:00:00', 'Extérieur', 'FEYTIAT BASKET 87', 'BORDEAUX ETUDIANTS CLUB', 'FEYTIAT BASKET 87', 82, 53, 53, 82, 446, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(59, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J9', '2025-12-07', '14:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BC ST AVIT ST NAZAIRE', 'BC ST AVIT ST NAZAIRE', 59, 56, 59, 56, 102, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(60, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J9', '2025-12-07', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'UNION SPORTIVE BREDOISE BASKET', 'UNION SPORTIVE BREDOISE BASKET', 43, 49, 43, 49, 501, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(61, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J9', '2025-12-07', '16:00:00', 'Extérieur', 'BASKET CLUB MARCHEPRIME', 'BORDEAUX ETUDIANTS CLUB', 'BASKET CLUB MARCHEPRIME', 69, 64, 64, 69, 9075, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(62, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J10', '2025-12-13', '20:00:00', 'Extérieur', 'US TALENCE', 'BORDEAUX ETUDIANTS CLUB', 'US TALENCE', 66, 71, 71, 66, 8076, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(63, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Saison régulière', 'J10', '2025-12-13', '20:00:00', 'Extérieur', 'STE EULALIE BASKET BALL', 'BORDEAUX ETUDIANTS CLUB', 'STE EULALIE BASKET BALL', 48, 60, 60, 48, 112, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005179778'),
(64, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J10', '2025-12-13', '21:00:00', 'Extérieur', 'ASPTT LIMOGES', 'BORDEAUX ETUDIANTS CLUB', 'ASPTT LIMOGES', 85, 68, 68, 85, 113, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(65, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J10', '2025-12-13', '21:30:00', 'Extérieur', 'LIMOGES LANDOUGE LOISIRS BASKET', 'BORDEAUX ETUDIANTS CLUB', 'LIMOGES LANDOUGE LOISIRS BASKET', 68, 83, 83, 68, 1026, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(66, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J10', '2025-12-14', '16:00:00', 'Extérieur', 'ASPTT LIMOGES', 'BORDEAUX ETUDIANTS CLUB', 'ASPTT LIMOGES', 58, 79, 79, 58, 512, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(67, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Saison régulière', 'J10', '2025-12-14', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AS MARTIGNAS - 2', 'AS MARTIGNAS - 2', 68, 54, 68, 54, 9084, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145647'),
(68, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J11', '2026-01-10', '21:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'STE EULALIE BASKET BALL', 'STE EULALIE BASKET BALL', 46, 39, 46, 39, 8084, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(69, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J11', '2026-01-10', '22:00:00', 'Extérieur', 'ENTENTE PESSAC BASKET CLUB', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE PESSAC BASKET CLUB', 60, 70, 70, 60, 126, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(70, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J11', '2026-01-10', '22:00:00', 'Extérieur', 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', 62, 84, 84, 62, 1051, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(71, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J1', '2026-01-11', '14:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'STADE BORDELAIS', 'STADE BORDELAIS', 77, 71, 77, 71, 9000, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(72, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J11', '2026-01-11', '16:00:00', 'Extérieur', 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', 54, 49, 49, 54, 525, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(73, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J1', '2026-01-11', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'COUTRAS GUITRES BASKET', 'COUTRAS GUITRES BASKET', 36, 51, 36, 51, 3, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(74, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J11', '2026-01-11', '16:30:00', 'Extérieur', 'ELAN CHALOSSAIS', 'BORDEAUX ETUDIANTS CLUB', 'ELAN CHALOSSAIS', 66, 70, 70, 66, 495, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(75, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J12', '2026-01-17', '19:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BORDEAUX BASTIDE BASKET', 'BORDEAUX BASTIDE BASKET', 65, 62, 65, 62, 1075, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(76, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J12', '2026-01-17', '21:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'US CHARTRONS BORDEAUX', 'US CHARTRONS BORDEAUX', 72, 85, 72, 85, 138, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(77, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J12', '2026-01-17', '21:30:00', 'Extérieur', 'IE - CTC SMB - SAM - SA MERIGNACAIS', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC SMB - SAM - SA MERIGNACAIS', 49, 51, 51, 49, 8092, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(78, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J2', '2026-01-18', '14:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BOULIAC BASKET CLUB - 2', 'BOULIAC BASKET CLUB - 2', 50, 81, 50, 81, 9010, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(79, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J12', '2026-01-18', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BRESSUIRE LE REVEIL', 'BRESSUIRE LE REVEIL', 67, 46, 67, 46, 537, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(80, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J2', '2026-01-18', '16:00:00', 'Extérieur', 'CA CARBON BLANC OMNISPORT', 'BORDEAUX ETUDIANTS CLUB', 'CA CARBON BLANC OMNISPORT', 42, 82, 82, 42, 15, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(81, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J12', '2026-01-18', '16:30:00', 'Extérieur', 'ABB CORNEBARRIEU', 'BORDEAUX ETUDIANTS CLUB', 'ABB CORNEBARRIEU', 85, 65, 65, 85, 546, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(82, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J13', '2026-01-31', '21:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'UNION SPORTIVE BREDOISE BASKET - 2', 'UNION SPORTIVE BREDOISE BASKET - 2', 58, 54, 58, 54, 8100, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(83, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J13', '2026-01-31', '21:00:00', 'Extérieur', 'UNION SPORTIVE TULLE CORREZE', 'BORDEAUX ETUDIANTS CLUB', 'UNION SPORTIVE TULLE CORREZE', 68, 77, 77, 68, 1098, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(84, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J13', '2026-01-31', '22:00:00', 'Extérieur', 'AYTRE BASKET BALL', 'BORDEAUX ETUDIANTS CLUB', 'AYTRE BASKET BALL', 56, 68, 68, 56, 149, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(85, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J3', '2026-02-01', '14:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE PESSAC BASKET CLUB - 3', 'ENTENTE PESSAC BASKET CLUB - 3', 72, 63, 72, 63, 9020, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(86, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J13', '2026-02-01', '16:00:00', 'Extérieur', 'AYTRE BASKET BALL', 'BORDEAUX ETUDIANTS CLUB', 'AYTRE BASKET BALL', 54, 67, 67, 54, 548, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(87, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J3', '2026-02-01', '16:00:00', 'Extérieur', 'CA BEGLES - 3', 'BORDEAUX ETUDIANTS CLUB', 'CA BEGLES - 3', 36, 67, 67, 36, 27, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(88, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J13', '2026-02-01', '16:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'COTEAUX DU LUY BASKET', 'COTEAUX DU LUY BASKET', 57, 59, 57, 59, 594, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(89, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J14', '2026-02-07', '19:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'UNION SAINT BRUNO BORDEAUX', 'UNION SAINT BRUNO BORDEAUX', NULL, NULL, NULL, NULL, 1121, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(90, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J14', '2026-02-07', '21:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CASTELNAU MEDOC BC', 'CASTELNAU MEDOC BC', NULL, NULL, NULL, NULL, 160, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(91, 'Féminin', 'SF3 (Féminin)', 'PRF', 'Saison régulière', 'J14', '2026-02-07', '21:30:00', 'Extérieur', 'LE TAILLAN BASKET - 2', 'BORDEAUX ETUDIANTS CLUB', 'LE TAILLAN BASKET - 2', NULL, NULL, NULL, NULL, 8108, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005145370'),
(92, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J4', '2026-02-08', '14:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'STE EULALIE BASKET BALL', 'STE EULALIE BASKET BALL', NULL, NULL, NULL, NULL, 39, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(93, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J14', '2026-02-08', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AMICALE LOISIRS CASTILLONNES BASKET', 'AMICALE LOISIRS CASTILLONNES BASKET', NULL, NULL, NULL, NULL, 559, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(94, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J4', '2026-02-08', '16:00:00', 'Extérieur', 'AGJA CAUDERAN - 2', 'BORDEAUX ETUDIANTS CLUB', 'AGJA CAUDERAN - 2', NULL, NULL, NULL, NULL, 9027, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(95, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J14', '2026-02-08', '16:30:00', 'Extérieur', 'ENTENTE PESSAC BASKET CLUB - 1', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE PESSAC BASKET CLUB - 1', NULL, NULL, NULL, NULL, 642, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(96, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J15', '2026-02-22', '16:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AS ST DELPHIN - 2', 'AS ST DELPHIN - 2', NULL, NULL, NULL, NULL, 690, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(97, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J15', '2026-02-28', '21:00:00', 'Extérieur', 'CEP POITIERS', 'BORDEAUX ETUDIANTS CLUB', 'CEP POITIERS', NULL, NULL, NULL, NULL, 171, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(98, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J15', '2026-02-28', '21:00:00', 'Extérieur', 'AIXE BC VAL DE VIENNE', 'BORDEAUX ETUDIANTS CLUB', 'AIXE BC VAL DE VIENNE', NULL, NULL, NULL, NULL, 1144, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(99, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J15', '2026-03-01', '16:00:00', 'Extérieur', 'LIMOGES ABC EN LIMOUSIN - 2', 'BORDEAUX ETUDIANTS CLUB', 'LIMOGES ABC EN LIMOUSIN - 2', NULL, NULL, NULL, NULL, 570, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(100, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J5', '2026-03-01', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'BLEUETS ILLATS - 2', 'BLEUETS ILLATS - 2', NULL, NULL, NULL, NULL, 9037, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(101, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J5', '2026-03-01', '16:00:00', 'Extérieur', 'CASTELNAU MEDOC BC - 3', 'BORDEAUX ETUDIANTS CLUB', 'CASTELNAU MEDOC BC - 3', NULL, NULL, NULL, NULL, 51, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(102, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J16', '2026-03-01', '16:30:00', 'Extérieur', 'HAGETMAU MOMUY CASTAIGNOS BASKET', 'BORDEAUX ETUDIANTS CLUB', 'HAGETMAU MOMUY CASTAIGNOS BASKET', NULL, NULL, NULL, NULL, 738, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(103, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J16', '2026-03-07', '19:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AS ST DELPHIN', 'AS ST DELPHIN', NULL, NULL, NULL, NULL, 1167, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(104, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J16', '2026-03-07', '21:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'JSA BORDEAUX BASKET - 2', 'JSA BORDEAUX BASKET - 2', NULL, NULL, NULL, NULL, 182, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(105, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J16', '2026-03-08', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'POUZIOUX VOUNEUIL/BIARD BC', 'POUZIOUX VOUNEUIL/BIARD BC', NULL, NULL, NULL, NULL, 581, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(106, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J6', '2026-03-08', '16:00:00', 'Extérieur', 'STADE BORDELAIS', 'BORDEAUX ETUDIANTS CLUB', 'STADE BORDELAIS', NULL, NULL, NULL, NULL, 9045, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(107, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J6', '2026-03-08', '16:00:00', 'Extérieur', 'COUTRAS GUITRES BASKET', 'BORDEAUX ETUDIANTS CLUB', 'COUTRAS GUITRES BASKET', NULL, NULL, NULL, NULL, 63, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(108, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J17', '2026-03-08', '16:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'IE - AUCH BASKET CLUB - 1', 'IE - AUCH BASKET CLUB - 1', NULL, NULL, NULL, NULL, 786, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(109, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J17', '2026-03-21', '19:00:00', 'Extérieur', 'CA BRIVE CORREZE SECTION BASKET', 'BORDEAUX ETUDIANTS CLUB', 'CA BRIVE CORREZE SECTION BASKET', NULL, NULL, NULL, NULL, 592, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(110, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J17', '2026-03-21', '21:00:00', 'Extérieur', 'CA BRIVE CORREZE SECTION BASKET', 'BORDEAUX ETUDIANTS CLUB', 'CA BRIVE CORREZE SECTION BASKET', NULL, NULL, NULL, NULL, 1190, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(111, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J7', '2026-03-21', '21:30:00', 'Extérieur', 'BOULIAC BASKET CLUB - 2', 'BORDEAUX ETUDIANTS CLUB', 'BOULIAC BASKET CLUB - 2', NULL, NULL, NULL, NULL, 9055, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(112, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J7', '2026-03-22', '16:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CA CARBON BLANC OMNISPORT', 'CA CARBON BLANC OMNISPORT', NULL, NULL, NULL, NULL, 75, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(113, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J18', '2026-03-22', '16:30:00', 'Extérieur', 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC GRAND DAX BASKET - ADOUR DAX LANDES BASKET', NULL, NULL, NULL, NULL, 829, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(114, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J18', '2026-03-28', '21:00:00', 'Extérieur', 'COGNAC BASKET AVENIR', 'BORDEAUX ETUDIANTS CLUB', 'COGNAC BASKET AVENIR', NULL, NULL, NULL, NULL, 208, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(115, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J18', '2026-03-28', '21:00:00', 'Extérieur', 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC DORDOGNE SUD BASKET - US BERGERAC BASKET', NULL, NULL, NULL, NULL, 1217, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(116, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J18', '2026-03-29', '17:00:00', 'Extérieur', 'CA BEGLES', 'BORDEAUX ETUDIANTS CLUB', 'CA BEGLES', NULL, NULL, NULL, NULL, 607, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(117, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J8', '2026-03-29', '17:00:00', 'Extérieur', 'ENTENTE PESSAC BASKET CLUB - 3', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE PESSAC BASKET CLUB - 3', NULL, NULL, NULL, NULL, 9065, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(118, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J8', '2026-03-29', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CA BEGLES - 3', 'CA BEGLES - 3', NULL, NULL, NULL, NULL, 87, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(119, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J19', '2026-03-29', '17:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'B. COMMINGES SALIES DU SALAT - 1', 'B. COMMINGES SALIES DU SALAT - 1', NULL, NULL, NULL, NULL, 879, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(120, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J19', '2026-04-04', '20:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ES ST FRONT DE PRADOUX', 'ES ST FRONT DE PRADOUX', NULL, NULL, NULL, NULL, 1243, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(121, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J9', '2026-04-04', '21:00:00', 'Extérieur', 'STE EULALIE BASKET BALL', 'BORDEAUX ETUDIANTS CLUB', 'STE EULALIE BASKET BALL', NULL, NULL, NULL, NULL, 99, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(122, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J19', '2026-04-04', '22:15:00', 'Extérieur', 'US CENON RIVE DROITE', 'BORDEAUX ETUDIANTS CLUB', 'US CENON RIVE DROITE', NULL, NULL, NULL, NULL, 222, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(123, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J19', '2026-04-05', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CHAURAY BASKET CLUB - 2', 'CHAURAY BASKET CLUB - 2', NULL, NULL, NULL, NULL, 621, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(124, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J9', '2026-04-05', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'AGJA CAUDERAN - 2', 'AGJA CAUDERAN - 2', NULL, NULL, NULL, NULL, 9072, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(125, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J20', '2026-04-05', '17:30:00', 'Extérieur', 'LE TAILLAN BASKET', 'BORDEAUX ETUDIANTS CLUB', 'LE TAILLAN BASKET', NULL, NULL, NULL, NULL, 927, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(126, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J21', '2026-04-12', '17:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'FEYTIAT BASKET 87', 'FEYTIAT BASKET 87', NULL, NULL, NULL, NULL, 974, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(127, 'Féminin', 'SF1 (Féminin)', 'NF3', 'Saison régulière', 'J22', '2026-04-19', '17:30:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ELAN CHALOSSAIS', 'ELAN CHALOSSAIS', NULL, NULL, NULL, NULL, 1023, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139512'),
(128, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J20', '2026-04-25', '22:00:00', 'Extérieur', 'BOULAZAC BASKET DORDOGNE - 2', 'BORDEAUX ETUDIANTS CLUB', 'BOULAZAC BASKET DORDOGNE - 2', NULL, NULL, NULL, NULL, 234, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(129, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J20', '2026-04-25', '22:00:00', 'Extérieur', 'BEAUNE-RILHAC-BONNAC BASKET', 'BORDEAUX ETUDIANTS CLUB', 'BEAUNE-RILHAC-BONNAC BASKET', NULL, NULL, NULL, NULL, 1267, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(130, 'Masculin', 'Sénior 3 (Masculin)', 'DM3', 'Phase 2 / Playoffs', 'J10', '2026-04-26', '15:00:00', 'Extérieur', 'BLEUETS ILLATS - 2', 'BORDEAUX ETUDIANTS CLUB', 'BLEUETS ILLATS - 2', NULL, NULL, NULL, NULL, 9082, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248420'),
(131, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J20', '2026-04-26', '17:00:00', 'Extérieur', 'UNION SPORTIVE BREDOISE BASKET', 'BORDEAUX ETUDIANTS CLUB', 'UNION SPORTIVE BREDOISE BASKET', NULL, NULL, NULL, NULL, 633, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(132, 'Masculin', 'Sénior 4 (Masculin)', 'DM4', 'Phase 2 / Playoffs', 'J10', '2026-04-26', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'CASTELNAU MEDOC BC - 3', 'CASTELNAU MEDOC BC - 3', NULL, NULL, NULL, NULL, 111, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005248439'),
(133, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J21', '2026-05-02', '20:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'LIMOGES LANDOUGE LOISIRS BASKET', 'LIMOGES LANDOUGE LOISIRS BASKET', NULL, NULL, NULL, NULL, 1290, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(134, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J21', '2026-05-02', '22:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ASPTT LIMOGES', 'ASPTT LIMOGES', NULL, NULL, NULL, NULL, 245, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(135, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J21', '2026-05-03', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ASPTT LIMOGES', 'ASPTT LIMOGES', NULL, NULL, NULL, NULL, 644, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159'),
(136, 'Masculin', 'Sénior 2 (Masculin)', 'RM2', 'Saison régulière', 'J22', '2026-05-09', '20:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', 'IE - CTC MEDOC ESTUAIRE - AS PIAN MEDOC BASKET', NULL, NULL, NULL, NULL, 1315, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005138117'),
(137, 'Masculin', 'Sénior 1 (Masculin)', 'PNM', 'Saison régulière', 'J22', '2026-05-09', '22:15:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'ENTENTE PESSAC BASKET CLUB', 'ENTENTE PESSAC BASKET CLUB', NULL, NULL, NULL, NULL, 258, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005137983'),
(138, 'Féminin', 'SF2 (Féminin)', 'PNF', 'Saison régulière', 'J22', '2026-05-10', '17:00:00', 'Domicile', 'BORDEAUX ETUDIANTS CLUB', 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', 'IE - CTC UBVP - VILLENEUVE BASKET CLUB', NULL, NULL, NULL, NULL, 657, 'https://competitions.ffbb.com/ligues/naq/comites/0033/clubs/naq0033024/equipes/200000005139159');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `numCom` int NOT NULL,
  `dtCreaCom` datetime DEFAULT CURRENT_TIMESTAMP,
  `libCom` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtModCom` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `attModOK` tinyint(1) DEFAULT '0',
  `notifComKOAff` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
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
  `prenomMemb` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nomMemb` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `pseudoMemb` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `passMemb` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `eMailMemb` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtCreaMemb` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtMajMemb` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `accordMemb` tinyint(1) DEFAULT '1',
  `cookieMemb` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
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
  `numMotCle` int NOT NULL AUTO_INCREMENT,
  `libMotCle` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
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
  `numStat` int NOT NULL AUTO_INCREMENT,
  `libStat` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
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
  `libThem` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
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
-- Index pour la table `bec_matches`
--
ALTER TABLE `bec_matches`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `bec_matches`
--
ALTER TABLE `bec_matches`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `numCom` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `STATUT`
--
ALTER TABLE `STATUT`
  MODIFY `numStat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
