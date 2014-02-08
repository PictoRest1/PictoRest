-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 06 Février 2014 à 15:22
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `pictorest`
--
CREATE DATABASE IF NOT EXISTS `pictorest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pictorest`;

-- --------------------------------------------------------

--
-- Structure de la table `abonne`
--

CREATE TABLE IF NOT EXISTS `Abonne` (
  `idAbonne` int(11) NOT NULL AUTO_INCREMENT,
  `idUtil` int(11) NOT NULL,
  `idAlbum` int(11) NOT NULL,
  PRIMARY KEY (`idAbonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `abonne`
--

INSERT INTO `abonne` (`idAbonne`, `idUtil`, `idAlbum`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE IF NOT EXISTS `Album` (
  `idAlbum` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `idUtil` int(11) NOT NULL,
  PRIMARY KEY (`idAlbum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `album`
--

INSERT INTO `album` (`idAlbum`, `libelle`, `date`, `idUtil`) VALUES
(1, 'AlbumTest', '2014-02-05', 1),
(2, 'Lolol', '2014-02-06', 2);

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE IF NOT EXISTS `Photo` (
  `idPhoto` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `description` text,
  `date` date NOT NULL,
  `idAlbum` int(11) NOT NULL,
  PRIMARY KEY (`idPhoto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `photo`
--

INSERT INTO `photo` (`idPhoto`, `libelle`, `description`, `date`, `idAlbum`) VALUES
(1, 'photo test', 'photo de merde', '2014-02-06', 1),
(2, 'autre photo', 'connard', '2014-02-06', 1),
(3, 'trio', 'lalala', '2014-02-06', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `idUtil` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(200) NOT NULL,
  PRIMARY KEY (`idUtil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtil`, `pseudo`, `email`, `mdp`) VALUES
(1, 'JeanGuy', 'lol@lol.fr', 'blabla'),
(2, 'Bernard', 'zkzf@flzf.fr', 'trolol');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
