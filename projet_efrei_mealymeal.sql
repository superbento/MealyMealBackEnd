-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 07 Avril 2019 à 14:57
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_efrei_mealymeal`
--

-- --------------------------------------------------------

--
-- Structure de la table `aliment`
--

CREATE TABLE `aliment` (
  `id_aliment` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `calories_per_100g` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `average_ration` int(11) NOT NULL,
  `HighCalories` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `aliment`
--

INSERT INTO `aliment` (`id_aliment`, `name`, `calories_per_100g`, `category`, `average_ration`, `HighCalories`) VALUES
(1, 'chicken_leg', 160, 'Meat', 250, 0),
(2, 'chicken_breast', 121, 'Meat', 100, 0),
(3, 'turkey_breast', 121, 'Meat', 100, 0),
(4, 'turkey_leg', 208, 'Meat', 100, 0),
(5, 'guineafowl_leg', 108, 'Meat', 150, 0),
(6, 'pork', 242, 'Meat', 100, 1),
(7, 'mutton', 294, 'Meat', 100, 1),
(8, 'beef_chopped', 332, 'Meat', 100, 0),
(9, 'beef_rib', 471, 'Meat', 100, 1),
(10, 'beef_steak', 271, 'Meat', 100, 1),
(11, 'beef_tenderloin', 324, 'Meat', 100, 0),
(12, 'beef_oxtongue', 224, 'Meat', 100, 0),
(13, 'Thon', 117, 'Fish', 100, 0),
(14, 'Sole', 73, 'Fish', 100, 0),
(15, 'Maquereau', 240, 'Fish', 100, 0),
(16, 'Rice', 130, 'SideDish', 100, 0),
(17, 'Pasta', 130, 'SideDish', 100, 0),
(18, 'Potato', 85, 'SideDish', 100, 0),
(19, 'Corn', 100, 'Vegetable', 100, 0),
(20, 'Pea', 71, 'Vegetable', 100, 0),
(21, 'eggplant', 25, 'Vegetable', 100, 0),
(22, 'Pepper_red', 31, 'Vegetable', 100, 0),
(23, 'Pepper_yellow', 27, 'Vegetable', 100, 0),
(24, 'Pepper_green', 20, 'Vegetable', 100, 0),
(25, 'greenbean', 31, 'Vegetable', 100, 0),
(26, 'apple', 52, 'Fruit', 100, 0),
(27, 'banana', 89, 'Fruit', 100, 0),
(28, 'orange', 45, 'Fruit', 100, 0),
(29, 'peach', 40, 'Fruit', 100, 0),
(30, 'eggs', 155, 'breakfast', 60, 0),
(31, 'cereal', 391, 'breakfast', 100, 0),
(32, 'bread', 265, 'breakfast', 100, 0),
(33, 'peanuts', 567, 'snack', 100, 1),
(34, 'almond', 634, 'snack', 100, 1),
(35, 'cashewnut', 631, 'snack', 100, 1),
(36, 'quinoa', 120, 'SideDish', 100, 0),
(37, 'chocolate bun', 280, 'breakfast', 70, 0),
(38, 'croissant', 406, 'breakfast', 100, 0),
(39, 'Avocado', 165, 'Vegetable', 100, 1),
(40, 'Sardine', 160, 'Fish', 100, 1),
(41, 'lamb', 193, 'Meat', 100, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `aliment`
--
ALTER TABLE `aliment`
  ADD PRIMARY KEY (`id_aliment`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `aliment`
--
ALTER TABLE `aliment`
  MODIFY `id_aliment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
