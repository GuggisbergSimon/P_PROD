-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 27 Novembre 2020 à 10:04
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdwebprojet`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_book`
--

CREATE TABLE `t_book` (
  `idBook` int(11) NOT NULL,
  `booCover` varchar(50) NOT NULL,
  `booTitle` varchar(50) NOT NULL,
  `booChapter` int(11) NOT NULL,
  `booExtract` varchar(50) NOT NULL,
  `booAbstract` text NOT NULL,
  `booAuthor` varchar(50) NOT NULL,
  `booEditor` varchar(50) NOT NULL,
  `booYear` year(4) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_book`
--

INSERT INTO `t_book` (`idBook`, `booCover`, `booTitle`, `booChapter`, `booExtract`, `booAbstract`, `booAuthor`, `booEditor`, `booYear`, `idUser`, `idCategory`) VALUES
(1, 'Lataque.jpg', 'Shingeki no Kyojin', 130, 'Pas d\'extrait', 'Il y a 107 ans, les Titans ont presque exterminé la race humaine.\r\nCes Titans mesurent principalement une dizaine de mètres et ils se nourrissent d\'humains.\r\nLes humains ayant survécus à cette extermination ont construit une cité fortifiée avec des murs d\'enceinte de 50 mètres de haut pour pouvoir se protéger des Titans.\r\n\r\nPendant 100 ans les humains ont connu la paix.\r\nEren est un jeune garçon qui rêve de sortir de la ville pour explorer le monde extérieur.\r\nIl mène une vie paisible avec ses parents et sa sœur Mikasa dans le district de Shiganshina.\r\n\r\nMais un jour de l\'année 845, un Titan de plus de 60 mètres de haut apparaît. Il démolit une partie du mur du district de Shiganshina et provoque une invasion de Titans.\r\n\r\nEren verra sa mère se faire dévorer sous ses yeux sans rien pouvoir faire. Il décidera après ces événements traumatisants de s\'engager dans les forces militaires de la ville avec pour but d\'exterminer tous les Titans qui existent.', 'Hajime Isayama', 'Kōdansha', 2009, 1, 2),
(2, 'soloLeveling.jpg', 'Solo leveling', 121, 'Pas d\'extrait', 'Depuis l\'apparition d\'un portail reliant notre monde à un monde rempli de monstres et de créatures de toutes sortes, certaines personnes ont acquis des pouvoirs et la capacité de les chasser : on les appelle les « Chasseurs ». Chaque chasseur voit son potentiel magique classé de E (le plus bas) à S (le plus haut). Le protagoniste de l\'histoire, Sung Jin-Woo, est un chasseur sud-coréen de rang E à peine plus fort qu\'un humain normal. Il est surnommé par ses compères « le chasseur plus faible ». Un jour, lui et son groupe se retrouvent piégés dans un donjon extrêmement dangereux alors qu\'il avait été préalablement détecté en tant que donjon de rang D. Seuls quelques-uns d\'entre eux survivent et parviennent à s\'échapper. Gravement blessé, Sung Jin-Woo reste à l\'arrière et permet aux autres chasseurs de s\'enfuir. Alors qu\'il est sur le point d\'être achevé, Sung Jin-Woo se réveille dans un hôpital où on lui dit que lorsque que les renforts l\'ont retrouvé dans le donjon, il n\'y avait plus aucun monstre aux alentours. Il découvre alors qu\'il possède une capacité qui le transforme en un « Joueur » et qu\'il peut désormais voir une interface lui montrant des quêtes, un inventaire, une boutique qu\'il est le seul à voir... Il découvre également qu\'il peut progresser dans les rangs, ce qui est normalement impossible pour un chasseur. ', 'Chu-Gong', 'Kakao', 2018, 1, 8),
(3, 'NoGameNoLife.jpg', 'No game no life', 11, 'Pas d\'extrait', 'Sora et Shiro sont deux frère et sœur hikikomori. L\'hikikomori désigne une pathologie psycho-sociale caractérisant les personnes (souvent des adolescents) qui vivent coupées du monde en restant cloîtrées chez elles, refusant toute communication. Dans le cas des deux protagonistes, leur condition vient de leur vision du monde réel, qui se résume à un jeu guère intéressant.\r\n\r\nEnsemble, ils forment un duo de joueurs invaincus, véritable légende urbaine. Un jour, un garçon se qualifiant de "Dieu" les transporte dans un monde fantastique, où il a interdit toute forme de violence entre les 16 races différentes y vivant. À la place, toute décision ou conflit est réglé par le jeu. Les deux adolescents y sont convoqués car ils pourraient bien être les sauveurs de l\'humanité, la race Imanity qui, classée dernière parmi les 16 races, se retrouve confinée dans leur seule et unique cité restante. Durant leur quête pour sauver l\'Imanity, ils rencontrent Stephanie Dola : reconnue comme la petite fille de l\'ancien roi considéré comme fou, Jibril : une Flügel qui est l\'une des races les plus puissantes et Kurami Zell : une ancienne ennemie devenue une alliée.', ' Yū Kamiya', 'Media Factory', 2013, 1, 5),
(4, 'chi.jpg', ' Chi\'s Sweet Home', 218, 'Pas d\'extrait', 'Un chaton femelle gris et blanc tigré de noir déambule loin de sa mère et du restant de la portée alors qu\'il se promenait dehors avec sa famille. Perdu, le chaton cherche à retrouver sa famille mais à la place il rencontre un jeune garçon, Yohei, et sa mère. Ils emmènent le chaton chez eux, mais les animaux ne sont pas autorisés dans leur immeuble, ils essayent alors de lui trouver un nouveau foyer. Mais cela se révèle être une tâche difficile, et la famille décide finalement de garder le chaton, en le baptisant « Chi ». Finalement, ils trouvent un autre immeuble, où les chats sont autorisés. Un jour, Yohei aperçoit une affiche de recherche à l\'effigie de Chi. Alors, la famille hésite à rendre Chi...\r\n\r\nChaque épisode de ces livres sont différents, mais suivent malgré tout les aventures amusantes d\'un chaton innocent et naïf. ', ' Konami Kanata', 'Kōdansha', 2004, 1, 5),
(5, 'nana.jpg', 'Nana', 84, 'Pas d\'extrait', 'Dans le Japon contemporain, deux jeunes femmes se rencontrent dans le train les conduisant à Tōkyō. L\'une va rejoindre son petit ami tandis que l\'autre veut devenir chanteuse professionnelle. Inconsciemment, cette dernière est également à la poursuite de son petit ami parti faire carrière dans la musique deux ans plus tôt. Leur destination n\'est pas leur seul point commun car elles ont le même âge (20 ans), mais aussi le même prénom : Nana. Elles se séparent finalement à la descente du train. Plus tard, elles se retrouvent par hasard, alors qu\'elles cherchaient toutes les deux un appartement. Trouvant avantageux de partager les frais de loyer, elles décident de vivre en colocation dans l\'appartement 707 (c\'est une autre coïncidence car leur prénom, Nana, représente le chiffre 7 en japonais). Aussi différentes d\'apparence que de caractère, Nana Ōsaki et Nana Komatsu vont se lier d\'une profonde et fusionnelle amitié, se complétant et se soutenant mutuellement à travers les différentes épreuves qu\'elles seront amenées à traverser. ', ' Ai Yazawa', 'Shūeisha', 0000, 1, 3),
(6, 'godofhigh.jpg', 'The God of High School', 481, 'Pas d\'extrait', 'Le manhwa raconte les aventures du protagoniste Jin Mo-Ri, un artiste martial de 17 ans à Séoul5. Au début de l\'histoire, il est invité à un tournoi d\'arts martiaux appelé « The God Of High School » (ou « Dieu du lycée » en français). L\'événement, parrainé par une corporation louche, réunit des participants de toute la Corée du Sud pour les phases régionales, puis nationales afin de choisir trois représentants pour le tournoi mondial. En récompense, le gagnant voit le vœu de son choix réalisé.\r\n\r\nCela intrigue Mo-Ri, et au fur de sa progression dans les préliminaires, il rencontrera de nombreux autres concurrents, chacun avec son propre style et ses motivations. Parmi lesquels deux prodiges des arts martiaux : L\'expert en karaté full-contact Han Dae-Wi et la bretteuse Yu Mi-Ra. Ces deux combattants se lieront d\'amitié avec Mo-Ri après l\'avoir affronté, et les trois personnages seront sélectionnés ensemble en tant que représentants de la Corée du Sud pour les phases mondiales. Au fur et à mesure que les préliminaires se terminent et que les équipes se forment, le voile se lève sur la nature de la mystérieuse organisation et des sombres intentions de ses membres. ', 'Park Yong-Je', 'Naver', 2011, 1, 8),
(7, '20201123142043Koala.jpg', 'dsafdaw', 9, '20201123142043X-129-ALL01-E04_Principe-Adressage.p', 'dawdwad', 'fawfawf', 'fwafafawfaw', 1903, 1, 2),
(8, '20201123142446Penguins.jpg', 'Pookie', 3, '20201123142446E-182-KBA01-E05-Hardening-Ref-Window', 'e<f<fe<effegsggsgsegse', 'fesfes', 'fesfse', 0000, 1, 2),
(18, '20201123144017Jellyfish.jpg', 'wdadwad', 3, '20201123144017S-ALL01-DéroulementModule.pdf', 'dwdwadawdaw', 'dwadwaadw', 'dadwdwaadw', 1902, 1, 2),
(21, '20201123144457Lighthouse.jpg', 'wdwadwa', 1, '20201123144457E-126-ALL01-E03_ModeEmploi.pdf', 'dwaDwad', 'dwadaw', 'dwadwa', 1902, 1, 5),
(22, '20201127110232Desert.jpg', 'Capture', 6, '20201127110232E-129-ALL01-E09-Topologies réseau-mo', 'Moi  PLS', 'Moi', 'MoiCom', 1901, 2, 6);

-- --------------------------------------------------------

--
-- Structure de la table `t_category`
--

CREATE TABLE `t_category` (
  `idCategory` int(11) NOT NULL,
  `catName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_category`
--

INSERT INTO `t_category` (`idCategory`, `catName`) VALUES
(2, 'Shõnen'),
(3, 'Shõjo'),
(4, 'Kodomo'),
(5, 'Seinen'),
(6, 'Josei'),
(8, 'Manhwa');

-- --------------------------------------------------------

--
-- Structure de la table `t_evaluate`
--

CREATE TABLE `t_evaluate` (
  `idUser` int(11) NOT NULL,
  `idBook` int(11) NOT NULL,
  `evaGrade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `usePseudo` varchar(50) NOT NULL,
  `useDate` date NOT NULL,
  `usePassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `usePseudo`, `useDate`, `usePassword`) VALUES
(1, 'Chiwou', '2020-09-11', 'mdppassecurisédutout'),
(2, 'pooky', '2020-11-27', '123456789');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_book`
--
ALTER TABLE `t_book`
  ADD PRIMARY KEY (`idBook`),
  ADD UNIQUE KEY `ID_t_livre_IND` (`idBook`),
  ADD KEY `FKt_appartenir_IND` (`idCategory`),
  ADD KEY `FKt_proposer_IND` (`idUser`);

--
-- Index pour la table `t_category`
--
ALTER TABLE `t_category`
  ADD PRIMARY KEY (`idCategory`),
  ADD UNIQUE KEY `ID_t_categorie_IND` (`idCategory`);

--
-- Index pour la table `t_evaluate`
--
ALTER TABLE `t_evaluate`
  ADD PRIMARY KEY (`idUser`,`idBook`),
  ADD UNIQUE KEY `ID_t_evaluer_IND` (`idUser`,`idBook`),
  ADD KEY `FKt_e_t_l_IND` (`idBook`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `ID_t_utilisateur_IND` (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_book`
--
ALTER TABLE `t_book`
  MODIFY `idBook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `t_category`
--
ALTER TABLE `t_category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_book`
--
ALTER TABLE `t_book`
  ADD CONSTRAINT `FKt_appartenir_FK` FOREIGN KEY (`idCategory`) REFERENCES `t_category` (`idCategory`),
  ADD CONSTRAINT `FKt_proposer_FK` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

--
-- Contraintes pour la table `t_evaluate`
--
ALTER TABLE `t_evaluate`
  ADD CONSTRAINT `FKt_e_t_l_FK` FOREIGN KEY (`idBook`) REFERENCES `t_book` (`idBook`),
  ADD CONSTRAINT `FKt_e_t_u` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
