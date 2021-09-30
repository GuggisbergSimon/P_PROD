-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 23 sep. 2021 à 10:53
-- Version du serveur :  8.0.21
-- Version de PHP :  7.3.19-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bd_etmeal`
--

--
-- Déchargement des données de la table `t_meal`
--

INSERT INTO `t_meal` (`idMeal`, `meaName`, `meaPicturePath`, `meaIsCurrentMeal`, `meaStartDate`, `meaDeadline`, `meaDisplay`, `meaCreationDate`) VALUES
(1, 'Escalope de quorn végé', '', 1, '2021-03-11', '2024-02-03', 1, '2021-03-18 12:20:56'),
(2, 'Burger végétarien', '', 1, '2021-03-11', '2024-10-08', 1, '2021-03-18 12:20:56'),
(6, 'Tomate Mozzarella di bufala, salade ', NULL, 0, '2021-05-28', '2021-06-11', 0, '2021-03-22 11:13:56'),
(7, 'Rouleaux de printemps, grande salade ', NULL, 1, '2021-05-31', '2021-09-10', 1, '2021-03-25 13:44:50'),
(8, 'zyx', NULL, 0, '2021-06-16', '2021-06-25', 0, '2021-06-16 06:44:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
