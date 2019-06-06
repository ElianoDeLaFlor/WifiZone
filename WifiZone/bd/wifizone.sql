-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 29 avr. 2019 à 09:12
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wifizone`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `IdClient` int(11) NOT NULL AUTO_INCREMENT,
  `LoginClient` varchar(50) NOT NULL,
  `MdpClient` varchar(1000) NOT NULL,
  `TelClient` varchar(25) NOT NULL,
  `ResetCode` varchar(20) NOT NULL,
  PRIMARY KEY (`IdClient`),
  UNIQUE KEY `LoginClient` (`LoginClient`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`IdClient`, `LoginClient`, `MdpClient`, `TelClient`, `ResetCode`) VALUES
(1, 'sylvain91', '$2y$10$PANKhF2Jabnx9dAWI1X2KeZ1Fdw4dfzHD2.Eu8eWQcknZa.peWvbO', '92415513', ''),
(2, 'login', 'qwerty', '', ''),
(5, 'loginh', 'qwerty', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `IdTicket` int(11) NOT NULL AUTO_INCREMENT,
  `CodeTicket` varchar(50) NOT NULL,
  `DateCreationTicket` datetime NOT NULL,
  `PayementNum` varchar(50) NOT NULL,
  `DateAchatTicket` datetime DEFAULT NULL,
  `FK_IdTypeTicket` int(11) NOT NULL,
  `FK_IdClient` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdTicket`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ticket`
--

INSERT INTO `ticket` (`IdTicket`, `CodeTicket`, `DateCreationTicket`, `PayementNum`, `DateAchatTicket`, `FK_IdTypeTicket`, `FK_IdClient`) VALUES
(1, '23HJFH4', '2019-03-01 00:00:00', '94834505', '2019-04-03 00:00:00', 1, 1),
(3, '74JHFH8', '2019-04-01 00:00:00', '98765645', '2019-04-07 14:50:20', 1, 2),
(4, 'KJDHJFD', '2019-04-01 00:00:00', '98765645', '2019-04-07 14:51:06', 1, 3),
(5, '65HGF4FD', '2019-04-01 00:00:00', '', NULL, 1, 0),
(6, 'RFDRTY87', '2019-04-01 00:00:00', '98765645', '2019-04-07 15:13:40', 2, 1),
(7, '908GFT', '2019-04-01 00:00:00', '', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `typeticket`
--

DROP TABLE IF EXISTS `typeticket`;
CREATE TABLE IF NOT EXISTS `typeticket` (
  `IdTypeTicket` int(11) NOT NULL AUTO_INCREMENT,
  `ReferenceTypeTicket` varchar(50) NOT NULL,
  `TimeTypeTicket` varchar(50) NOT NULL,
  `DownSpeedTypeTicket` varchar(50) NOT NULL,
  `MontantTypeTicket` int(11) NOT NULL,
  `ValiditeTypeTicket` varchar(50) NOT NULL,
  PRIMARY KEY (`IdTypeTicket`),
  UNIQUE KEY `ReferenceTypeTicket` (`ReferenceTypeTicket`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeticket`
--

INSERT INTO `typeticket` (`IdTypeTicket`, `ReferenceTypeTicket`, `TimeTypeTicket`, `DownSpeedTypeTicket`, `MontantTypeTicket`, `ValiditeTypeTicket`) VALUES
(1, 'STANDARD', '24H', '0.5Mbs', 300, '1 Jour'),
(2, 'START', '24H', '1Mbs', 500, '1 Jour'),
(3, 'PREMIUM', '24H', '3.5Mbs', 1000, '1 Jour');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
