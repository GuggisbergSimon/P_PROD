-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 20 Janvier 2021 à 08:20
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
CREATE DATABASE IF NOT EXISTS `bd_etmeal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bd_etmeal`;

-- --------------------------------------------------------

--
-- Structure de la table `t_meal`
--

CREATE TABLE `t_meal` (
  `idMeal` int(11) NOT NULL,
  `meaName` varchar(50) NOT NULL,
  `meaPicturePath` varchar(50) NOT NULL,
  `meaIsCurrentMeal` tinyint(1) DEFAULT '0'
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
  `fkUser` int(11) NOT NULL
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
  `useRole` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useUsername`, `useEmail`, `useFirstName`, `useLastName`, `usePassword`, `useRole`) VALUES
(1, 'admin', 'cafeteriatestaba@outlook.com', 'Admin', 'Cuisine', '$2y$10$8iiaZ7yR5g.mC9wg.2JdB..C0w/rwX.Nid6.e4igHSp/EvQ6tPWna', 100);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_meal`
--
ALTER TABLE `t_meal`
  ADD PRIMARY KEY (`idMeal`);

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
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_meal`
--
ALTER TABLE `t_meal`
  MODIFY `idMeal` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  ADD CONSTRAINT `t_reservation_ibfk_1` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_reservation_ibfk_2` FOREIGN KEY (`fkMeal`) REFERENCES `t_meal` (`idMeal`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
