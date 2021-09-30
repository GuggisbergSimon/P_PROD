-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 12 Mars 2021 à 08:03
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bd_etmeal`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_meal`
--

CREATE TABLE `t_meal` (
  `idMeal` int(11) NOT NULL,
  `meaName` varchar(50) DEFAULT NULL,
  `meaPicturePath` varchar(50) DEFAULT NULL,
  `meaIsCurrentMeal` tinyint(1) DEFAULT '0',
  `meaStartDate` date NOT NULL DEFAULT '2021-03-11',
  `meaDeadline` date NOT NULL DEFAULT '2021-03-11',
  `meaDisplay` int(11) NOT NULL DEFAULT '1',
  `meaCreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_reservation`
--

CREATE TABLE `t_reservation` (
  `idReservation` int(11) NOT NULL,
  `resDate` date NOT NULL,
  `resHour` tinyint(1) NOT NULL,
  `fkMeal` int(11) NOT NULL,
  `resTable` tinyint(1) NOT NULL,
  `fkUser` int(11) NOT NULL,
  `resCreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `useUsername` varchar(64) NOT NULL,
  `useEmail` varchar(128) NOT NULL,
  `useFirstName` varchar(64) NOT NULL,
  `useLastName` varchar(64) NOT NULL,
  `usePassword` varchar(200) NOT NULL,
  `useRole` tinyint(1) NOT NULL,
  `useVerif` tinyint(1) NOT NULL DEFAULT '0',
  `useCreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_verification`
--

CREATE TABLE `t_verification` (
  `idVerification` int(11) NOT NULL,
  `verhash` text NOT NULL,
  `verDeadline` datetime(6) NOT NULL,
  `fkUser` int(11) NOT NULL,
  `verCreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_meal`
--
ALTER TABLE `t_meal`
  ADD PRIMARY KEY (`idMeal`),
  ADD UNIQUE KEY `meaName` (`meaName`);

--
-- Index pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `fkUser` (`fkUser`),
  ADD KEY `fkMeal` (`fkMeal`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `useEmail` (`useEmail`),
  ADD UNIQUE KEY `useUsername` (`useUsername`);

--
-- Index pour la table `t_verification`
--
ALTER TABLE `t_verification`
  ADD PRIMARY KEY (`idVerification`),
  ADD KEY `fkUser` (`fkUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_meal`
--
ALTER TABLE `t_meal`
  MODIFY `idMeal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT pour la table `t_verification`
--
ALTER TABLE `t_verification`
  MODIFY `idVerification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  ADD CONSTRAINT `t_reservation_ibfk_1` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_reservation_ibfk_2` FOREIGN KEY (`fkMeal`) REFERENCES `t_meal` (`idMeal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `t_verification`
--
ALTER TABLE `t_verification`
  ADD CONSTRAINT `t_verification_ibfk_1` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
