-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 19 jan. 2020 à 23:22
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `todolist`
--

-- --------------------------------------------------------

--
-- Structure de la table `blocnote`
--

DROP TABLE IF EXISTS `blocnote`;
CREATE TABLE IF NOT EXISTS `blocnote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `user` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `blocnote`
--

INSERT INTO `blocnote` (`id`, `titre`, `note`, `user`) VALUES
(1, 'eric', 'mes notes', 11),
(2, 'jean', 'mes notes', 11),
(3, 'pierre', 'mes notes', 11),
(4, 'dwwm', 'notes', 11),
(5, 'ricou12 -1', 'zdeazd', 12),
(6, 'ricou12 -2', 'rehehqhtqht', 12);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `mdp`) VALUES
(11, 'dwwm2019@gmail.com', '$2y$10$/8uN3NSWs2unw2rYQ5nHmO00W7v9e57orE6FgpPwNMPCkEsMbWIPK'),
(12, 'ricou2019@gmail.com', '$2y$10$WmdaOoEdbH91P7h0DwM2ku0B1X2u3IMTBf9lX6DSOX1k5Nye6EA7.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
