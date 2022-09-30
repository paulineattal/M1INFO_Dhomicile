-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 07 mai 2021 à 17:25
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------


drop table if exists `hebergement`;
drop table if exists `inscription`;
drop table if exists `reservationheb`;

--
-- Structure de la table `hebergement`
--

CREATE TABLE `hebergement` (
  `idHebergement` int(3) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `type` enum('Hotel','Auberge_jeunesse','Airbnb') NOT NULL,
  `adresse` varchar(30) NOT NULL,
  `prix` int(6) NOT NULL,
  `etoile` int(1) NOT NULL,
  `idGerant` int(3) NOT NULL,
  `disponibilite` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `hebergement`
--

INSERT INTO `hebergement` (`idHebergement`, `nom`, `type`, `adresse`, `prix`, `etoile`, `idGerant`, `disponibilite`) VALUES
(1, 'Au petit pré', 'Auberge_jeunesse', '10 rue du pré', 80, 4, 2, 1),
(3, 'L\'impérial', 'Hotel', '40 rue des citrons dorés', 620, 5, 2, 1),
(4, 'Ma maison', 'Airbnb', '52 B rue Jean Bornicat', 45, 5, 2, 1),
(5, 'Le Collington', 'Hotel', '48 rue République ', 120, 3, 2, 1),
(6, 'My new house', 'Airbnb', 'Newuser\'s Avenue', 72, 3, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `idInscrit` int(11) DEFAULT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  `role` varchar(30) DEFAULT NULL,
  `pseudo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`idInscrit`, `nom`, `prenom`, `mdp`, `role`, `pseudo`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin'),
(2, 'proprio', 'proprio', 'proprio', 'Proprietaire', 'proprio'),
(3, 'client', 'client', 'client', 'Client','client');

-- --------------------------------------------------------

--
-- Structure de la table `reservationheb`
--

CREATE TABLE `reservationheb` (
  `idReservation` int(30) NOT NULL,
  `idClient` int(30) NOT NULL,
  `idProprietaire` int(30) NOT NULL,
  `idHebergement` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservationheb`
--

INSERT INTO `reservationheb` (`idReservation`, `idClient`, `idProprietaire`, `idHebergement`) VALUES
(1, 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `hebergement`
--
ALTER TABLE `hebergement`
  ADD PRIMARY KEY (`idHebergement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `hebergement`
--
ALTER TABLE `hebergement`
  MODIFY `idHebergement` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
