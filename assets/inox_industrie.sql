-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 23 sep. 2025 à 23:21
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
-- Base de données : `inox_industrie`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'salma', 'salma@gmail.com', 'salma'),
(7, 'salma', 'SALMAdahmane@gmail.com', '$2y$10$MCcDrTfOpspyAI6oOfbck.kKvPJ7LzJoPGsMMSOob5VDVsL7uDpuy'),
(8, 'Mariam', 'Mariam@gmail.com', '$2y$10$IvGKM69xRtiqbOq11Ldulu0ComjD7DFXCHDTq42K1Y6mZRh92xNnu');

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `produits` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','valide') DEFAULT 'en_attente',
  `date_demande` datetime DEFAULT current_timestamp(),
  `date_validation` datetime DEFAULT NULL,
  `preuve` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

CREATE TABLE `paniers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) DEFAULT 1,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `prix_promo` decimal(10,2) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `date_debut_discount` date DEFAULT NULL,
  `date_fin_discount` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `image`, `prix`, `stock`, `categorie`, `prix_promo`, `discount_percent`, `date_debut_discount`, `date_fin_discount`) VALUES
(16, 'Profilé aluminium extrudé', 'Barre en alu pour structures métalliques\r\nLongueur 3000 × Ø 30', 'images.jpeg', '500', 40, 'Construction', 0.00, 0, '0000-00-00', '0000-00-00'),
(17, 'Plaque alu pour carrosserie', 'Plaque légère utilisée en transport auto\r\n2500 × 1250 × 1.5', 'images__1_.jpeg', '550', 220, 'Transport', 0.00, 0, '0000-00-00', '0000-00-00'),
(18, 'Bobine aluminium conductrice', 'Bobine alu pour câbles électriques\r\nLargeur 1000 × Ép. 0.8', '61XIA8WJ0ZL._AC_UF1000_1000_QL80_.jpg', '1200', 600, 'Énergie & Chimie', 0.00, 0, '0000-00-00', '0000-00-00'),
(19, 'Plaque aluminium anodisée', 'Plaque résistante à la corrosion\r\n1500 × 1000 × 4', 'anodized-aluminum-sheet67ba2.webp', '650', 20, 'Énergie & Chimie', 0.00, 0, '0000-00-00', '0000-00-00'),
(20, 'Plaque alu ménagère', 'Tôle légère pour ustensiles et objets\r\n1000 × 500 × 1', 'tole-alu-brut-3003-h22-diamant.webp', '400', 30, 'Domestique', 0.00, 0, '0000-00-00', '0000-00-00'),
(21, 'Plaque alu médicale', 'Aluminium stérile pour instruments médicaux\r\n1200 × 600 × 2.5', 'Opa-Alu-PVC-Medical-Tablet-Blister-Alu-Alu-Cold-Forming-Foil.avif', '700', 10, 'Médical', 0.00, 0, '0000-00-00', '0000-00-00'),
(22, 'Tige aluminium médicale', 'Matière première pour implants & équipements\r\nLongueur 2000 × Ø 20', 'images__2_.jpeg', '800', 23, 'Médical', 0.00, 0, '0000-00-00', '0000-00-00'),
(23, 'Plaque alu épaisse', 'Plaque résistante pour étagères\r\n1000 × 500 × 3', 't__l__chargement.jpeg', '250', 18, 'Construction', 0.00, 0, '0000-00-00', '0000-00-00'),
(24, 'Tube alu rond', 'Tube léger pour structures simples\r\nLongueur 1500 × Ø 25', 't__l__chargement__1_.jpeg', '150', 9, 'Construction', 0.00, 0, '0000-00-00', '0000-00-00'),
(25, 'Cornière alu en L', 'Profilé alu en L pour renforts maison\r\nLongueur 2000 × 30×30', '0012672_corniere-aluminium-2020200-chrome_550.jpeg', '180', 33, 'Domestique', 0.00, 0, '0000-00-00', '0000-00-00'),
(26, 'Tôle alu emboutie', 'Plaque alu antidérapante (sols, rampes)\r\n1000 × 500 × 2.5', 'toles_embouties.jpg', '280', 22, 'Construction', 0.00, 0, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(3, 'salma', 'salmadahmane970@gmail.com', '$2y$10$V20S25DClAiI6KWlxPtq2ubPSIRPJoFxMCmQEpkYETBPAlI/8Gkp6'),
(6, 'sara', 'sara@gmail.com', '$2y$10$QcOwPKokKxxYrQtbR8POheQfVU2Rogy2LZMO.8JxnNjXGnbBRu/ka');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paniers`
--
ALTER TABLE `paniers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `paniers`
--
ALTER TABLE `paniers`
  ADD CONSTRAINT `paniers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paniers_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
