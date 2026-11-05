-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 05 nov. 2026 à 15:15
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sg1`
--

-- --------------------------------------------------------

--
-- Structure de la table `quetes`
--

CREATE TABLE `quetes` (
  `Id_quete` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Etat` enum('Démarée','En cours','Finie') DEFAULT NULL,
  `exclamation` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `quetes`
--

INSERT INTO `quetes` (`Id_quete`, `Nom`, `Etat`, `exclamation`) VALUES
(1, '1ere Quête', 'Finie', 0),
(2, '2eme Quête', 'Finie', 1),
(3, '3eme Quête', 'Démarée', 0),
(4, '4eme Quête', 'Finie', 1),
(5, 'quete', 'Finie', 0),
(15, 'der', 'Finie', 1),
(16, 'cc', 'Finie', 1),
(17, 'fihgg', 'Finie', 1),
(18, 'ff', 'En cours', 0),
(19, 'exportatioooooooon', 'En cours', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `quetes`
--
ALTER TABLE `quetes`
  ADD PRIMARY KEY (`Id_quete`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `quetes`
--
ALTER TABLE `quetes`
  MODIFY `Id_quete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
