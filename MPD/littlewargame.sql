-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 26 fév. 2018 à 10:02
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `littlewargame`
--

-- --------------------------------------------------------

--
-- Structure de la table `area`
--

CREATE TABLE `area` (
  `id` mediumint(3) UNSIGNED NOT NULL,
  `x` smallint(2) NOT NULL,
  `y` smallint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `area`
--

INSERT INTO `area` (`id`, `x`, `y`) VALUES
(1, 0, 0),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `area_ressource`
--

CREATE TABLE `area_ressource` (
  `id` int(4) UNSIGNED NOT NULL,
  `ressource_id` tinyint(1) UNSIGNED NOT NULL,
  `area_id` mediumint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `area_ressource`
--

INSERT INTO `area_ressource` (`id`, `ressource_id`, `area_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(4, 4, 2),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `building`
--

CREATE TABLE `building` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `inventory_id` mediumint(3) UNSIGNED NOT NULL,
  `temple_level` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `building`
--

INSERT INTO `building` (`id`, `inventory_id`, `temple_level`) VALUES
(1, 4, 0),
(2, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `inventory`
--

CREATE TABLE `inventory` (
  `id` mediumint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `inventory`
--

INSERT INTO `inventory` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12);

-- --------------------------------------------------------

--
-- Structure de la table `inventory_ressource`
--

CREATE TABLE `inventory_ressource` (
  `inventory_id` mediumint(3) UNSIGNED NOT NULL,
  `ressource_id` tinyint(1) UNSIGNED NOT NULL,
  `amount` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `inventory_ressource`
--

INSERT INTO `inventory_ressource` (`inventory_id`, `ressource_id`, `amount`) VALUES
(1, 3, 80),
(2, 2, 10),
(2, 4, 4),
(3, 2, 10);

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `id` smallint(2) UNSIGNED NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `login`, `password`) VALUES
(1, 'LittleWarGame', '$2y$10$lng0nC8ZjhMHUinBZGBH1O1HhkrYZJo4aEyXqqlUwjkILxUIrfT9m');

-- --------------------------------------------------------

--
-- Structure de la table `ressource`
--

CREATE TABLE `ressource` (
  `id` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ressource`
--

INSERT INTO `ressource` (`id`) VALUES
(1),
(2),
(3),
(4);

-- --------------------------------------------------------

--
-- Structure de la table `temple`
--

CREATE TABLE `temple` (
  `id` mediumint(3) UNSIGNED NOT NULL,
  `village_id` mediumint(3) UNSIGNED NOT NULL,
  `inventory_id` mediumint(3) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `level` tinyint(1) UNSIGNED NOT NULL,
  `worker` smallint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `temple`
--

INSERT INTO `temple` (`id`, `village_id`, `inventory_id`, `name`, `level`, `worker`) VALUES
(1, 1, 3, 'Temple d\'Arès', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `temple_cost_level`
--

CREATE TABLE `temple_cost_level` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `inventory_id` mediumint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `temple_cost_level`
--

INSERT INTO `temple_cost_level` (`id`, `inventory_id`) VALUES
(1, 6),
(2, 7),
(3, 8),
(4, 9),
(5, 10);

-- --------------------------------------------------------

--
-- Structure de la table `temple_running_level`
--

CREATE TABLE `temple_running_level` (
  `temple_id` mediumint(3) UNSIGNED NOT NULL,
  `level_id` tinyint(1) UNSIGNED NOT NULL,
  `inventory_id` mediumint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `temple_running_level`
--

INSERT INTO `temple_running_level` (`temple_id`, `level_id`, `inventory_id`) VALUES
(1, 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `village`
--

CREATE TABLE `village` (
  `id` mediumint(3) UNSIGNED NOT NULL,
  `area_id` mediumint(3) UNSIGNED NOT NULL,
  `member_id` smallint(2) UNSIGNED NOT NULL,
  `inventory_id` mediumint(3) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `population` smallint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `village`
--

INSERT INTO `village` (`id`, `area_id`, `member_id`, `inventory_id`, `name`, `population`) VALUES
(1, 1, 1, 1, 'Sparte', 100),
(2, 2, 1, 2, 'Athènes', 50);

-- --------------------------------------------------------

--
-- Structure de la table `village_building`
--

CREATE TABLE `village_building` (
  `village_id` mediumint(3) UNSIGNED NOT NULL,
  `building_id` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `village_farmer`
--

CREATE TABLE `village_farmer` (
  `village_id` mediumint(3) UNSIGNED NOT NULL,
  `area_ressource_id` int(4) UNSIGNED NOT NULL,
  `worker` smallint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `village_farmer`
--

INSERT INTO `village_farmer` (`village_id`, `area_ressource_id`, `worker`) VALUES
(1, 1, 0),
(1, 5, 40),
(2, 2, 5),
(2, 4, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `area_ressource`
--
ALTER TABLE `area_ressource`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_area_ressources_ressource1_idx` (`ressource_id`),
  ADD KEY `fk_area_ressources_area1_idx` (`area_id`);

--
-- Index pour la table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_building_inventory1_idx` (`inventory_id`);

--
-- Index pour la table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `inventory_ressource`
--
ALTER TABLE `inventory_ressource`
  ADD UNIQUE KEY `inventory_id` (`inventory_id`,`ressource_id`),
  ADD KEY `fk_inventory_ressource_inventory1_idx` (`inventory_id`),
  ADD KEY `fk_member_ressource_ressource` (`ressource_id`);

--
-- Index pour la table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`login`);

--
-- Index pour la table `ressource`
--
ALTER TABLE `ressource`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `temple`
--
ALTER TABLE `temple`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_temple_inventory1_idx` (`inventory_id`),
  ADD KEY `fk_temple_village1_idx` (`village_id`);

--
-- Index pour la table `temple_cost_level`
--
ALTER TABLE `temple_cost_level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_temple_cost_level_inventory1_idx` (`inventory_id`);

--
-- Index pour la table `temple_running_level`
--
ALTER TABLE `temple_running_level`
  ADD KEY `fk_temple_level_temple1_idx` (`temple_id`),
  ADD KEY `fk_temple_level_inventory1_idx` (`inventory_id`),
  ADD KEY `fk_temple_running_level_temple_cost_level1_idx` (`level_id`);

--
-- Index pour la table `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_village_member1_idx` (`member_id`),
  ADD KEY `fk_village_inventory1_idx` (`inventory_id`),
  ADD KEY `fk_village_area1_idx` (`area_id`);

--
-- Index pour la table `village_building`
--
ALTER TABLE `village_building`
  ADD KEY `fk_village_building_village1_idx` (`village_id`),
  ADD KEY `fk_village_building_building1_idx` (`building_id`);

--
-- Index pour la table `village_farmer`
--
ALTER TABLE `village_farmer`
  ADD UNIQUE KEY `village_id` (`village_id`,`area_ressource_id`),
  ADD KEY `fk_village_farmer_village1_idx` (`village_id`),
  ADD KEY `fk_village_farmer_area_ressources1_idx` (`area_ressource_id`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `area`
--
ALTER TABLE `area`
  MODIFY `id` mediumint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `area_ressource`
--
ALTER TABLE `area_ressource`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` mediumint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `id` smallint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ressource`
--
ALTER TABLE `ressource`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `temple`
--
ALTER TABLE `temple`
  MODIFY `id` mediumint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `temple_cost_level`
--
ALTER TABLE `temple_cost_level`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `village`
--
ALTER TABLE `village`
  MODIFY `id` mediumint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `area_ressource`
--
ALTER TABLE `area_ressource`
  ADD CONSTRAINT `fk_area_ressources_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_area_ressources_ressource1` FOREIGN KEY (`ressource_id`) REFERENCES `ressource` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `fk_building_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `inventory_ressource`
--
ALTER TABLE `inventory_ressource`
  ADD CONSTRAINT `fk_inventory_ressource_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_member_ressource_ressource` FOREIGN KEY (`ressource_id`) REFERENCES `ressource` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `temple`
--
ALTER TABLE `temple`
  ADD CONSTRAINT `fk_temple_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_temple_village1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `temple_cost_level`
--
ALTER TABLE `temple_cost_level`
  ADD CONSTRAINT `fk_temple_cost_level_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `temple_running_level`
--
ALTER TABLE `temple_running_level`
  ADD CONSTRAINT `fk_temple_level_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_temple_level_temple1` FOREIGN KEY (`temple_id`) REFERENCES `temple` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_temple_running_level_temple_cost_level1` FOREIGN KEY (`level_id`) REFERENCES `temple_cost_level` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `village`
--
ALTER TABLE `village`
  ADD CONSTRAINT `fk_village_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_village_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_village_member1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `village_building`
--
ALTER TABLE `village_building`
  ADD CONSTRAINT `fk_village_building_building1` FOREIGN KEY (`building_id`) REFERENCES `building` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_village_building_village1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `village_farmer`
--
ALTER TABLE `village_farmer`
  ADD CONSTRAINT `fk_village_farmer_area_ressources1` FOREIGN KEY (`area_ressource_id`) REFERENCES `area_ressource` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_village_farmer_village1` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
