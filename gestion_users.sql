-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 08 avr. 2026 à 08:22
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_users`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categorie_id`, `nom`, `description`) VALUES
(1, 'Electromenager', 'pour les choses'),
(2, 'batiment', 'prodit des batiment');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produit_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `categorie_id` int NOT NULL,
  `prix_achat` decimal(10,0) NOT NULL,
  `prix_vente` decimal(10,0) NOT NULL,
  `quantite` decimal(10,0) NOT NULL,
  `statut` enum('en stock','faible','rupture') NOT NULL,
  PRIMARY KEY (`produit_id`),
  KEY `fk_produit` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`produit_id`, `nom`, `categorie_id`, `prix_achat`, `prix_vente`, `quantite`, `statut`) VALUES
(1, 'biscuit', 1, '200', '150', '21', 'en stock');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `utilisateur_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenoms` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('gestionnaire','administrateur') NOT NULL,
  PRIMARY KEY (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utilisateur_id`, `nom`, `prenoms`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'MEDEGNON', 'Hugues', 'valentinmedegnon@gmail.com', '$2y$10$6kHAFvtX2/9W9KKJHPSGcehbVPQ.kxgjdAAtoo7uK6sabuH.ZELYq', 'administrateur'),
(2, 'MEDEGNON', 'Hugues', 'medegnon@gmail.com', '$2y$10$mjdjL.S1JvyeY16M6nTy0.zGvEk7t78HsdwAOvPL03xYXcr3tfvtC', 'administrateur'),
(3, 'MEDEGNON', 'CORE', 'degnon@gmail.com', '$2y$10$P038CAlV6iIHnOcuVLKF1OSBWmOY.7BJiTO23GaD7/tFm27dBH.K2', 'gestionnaire');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

DROP TABLE IF EXISTS `ventes`;
CREATE TABLE IF NOT EXISTS `ventes` (
  `vente_id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `date_vente` date NOT NULL,
  `quantite` decimal(10,0) NOT NULL,
  `montant_total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`vente_id`),
  KEY `fk_vente` (`produit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`categorie_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `fk_vente` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`produit_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
