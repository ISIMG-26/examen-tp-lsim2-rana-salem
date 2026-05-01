-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2026 at 10:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitzone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `client_nom` varchar(100) NOT NULL,
  `client_email` varchar(150) NOT NULL,
  `client_phone` varchar(30) NOT NULL,
  `machine_id` int(11) NOT NULL,
  `machine_nom` varchar(100) NOT NULL,
  `machine_prix` decimal(10,2) NOT NULL,
  `statut` enum('panier','acheté') DEFAULT 'panier',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `client_nom`, `client_email`, `client_phone`, `machine_id`, `machine_nom`, `machine_prix`, `statut`, `created_at`) VALUES
(1, 'rana', 'ranasalem1705@gmail.com', '29132052', 7, 'Curl Machine', 650.00, 'panier', '2026-05-01 19:29:02'),
(2, 'rana', 'ranasalem1705@gmail.com', '29132052', 7, 'Curl Machine', 650.00, 'acheté', '2026-05-01 19:29:20'),
(3, 'rana', 'ranasalem1705@gmail.com', '29132052', 7, 'Curl Machine', 650.00, 'panier', '2026-05-01 19:30:45'),
(4, 'rana', 'ranasalem1705@gmail.com', '29132052', 7, 'Curl Machine', 650.00, 'acheté', '2026-05-01 19:40:24'),
(5, 'rana', 'ranasalem1705@gmail.com', '29132052', 8, 'Tricep Pushdown', 700.00, 'acheté', '2026-05-01 19:40:28'),
(6, 'rana', 'ranasalem1705@gmail.com', '29132052', 6, 'Shoulder Press', 1100.00, 'acheté', '2026-05-01 19:40:32'),
(7, 'rana', 'ranasalem1705@gmail.com', '29132052', 1, 'Leg Press', 1200.00, 'acheté', '2026-05-01 19:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`id`, `nom`, `categorie`, `prix`, `image`, `description`) VALUES
(1, 'Leg Press', 'Jambes', 1200.00, 'image5.png', 'Machine pour les exercices de jambes'),
(2, 'Smith Machine', 'Poitrine', 2500.00, 'image6.png', 'Barre guidée pour exercices variés'),
(3, 'Olympic Bench', 'Poitrine', 800.00, 'image7.png', 'Banc pour développé couché'),
(4, 'Cable Machine', 'Dos', 1800.00, 'image5.png', 'Machine à câbles polyvalente'),
(5, 'Lat Pulldown', 'Dos', 950.00, 'image6.png', 'Tirage vertical pour le dos'),
(6, 'Shoulder Press', 'Épaules', 1100.00, 'image7.png', 'Presse épaules assise'),
(7, 'Curl Machine', 'Bras', 650.00, 'image5.png', 'Machine pour biceps'),
(8, 'Tricep Pushdown', 'Bras', 700.00, 'image6.png', 'Machine pour triceps');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `envoye_le` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `email`, `message`, `envoye_le`) VALUES
(1, 'Rana Salem', 'rana.salem@isimg.tn', 'buy', '2026-05-01 19:38:15'),
(2, 'Rana Salem', 'rana.salem@isimg.tn', 'nn', '2026-05-01 19:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machine_id` (`machine_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
