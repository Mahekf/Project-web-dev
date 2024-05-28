-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 14 mai 2024 à 17:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `image`, `quantity`) VALUES
(1, 1, 'Then she was gone', '10', '1715699428ThrillerB1.jpg', 1),
(2, 1, 'At first light', '35', '1715699489ThrillerB7.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `price` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `img`, `price`, `name`) VALUES
(1, '1715699369img2.jpg', 25, 'harry potter'),
(2, '1715699428ThrillerB1.jpg', 10, 'Then she was gone'),
(3, '1715699489ThrillerB7.jpg', 35, 'At first light'),
(4, '1715699546ThrillerB5.jpg', 10, 'That night');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `type_compte` enum('acheteur','vendeur','administrateur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Age`, `Password`, `type_compte`) VALUES
(1, 'zahra', 'zahraghanem57@gmail.com', 15, '$2y$10$tE683b9FUaS3voXenpAmluYlOu4qXnrV1b79oaiUq78jm.hwJNOZK', 'acheteur'),
(2, 'zahra', 'admin@gmail.com', 30, '$2y$10$hvD6UDEeAw04CFLmcM7.xe2ad8OVrWbQ03MvnqI3d/pj1lPQoTHPi', 'administrateur'),
(3, 'zahra', 'vendeur@gmail.com', 28, '$2y$10$xQzVsSit/XZ0hejn1rWMmedQsycw.DwFmpSbq62ZMvMOgrN30ymaa', 'vendeur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
