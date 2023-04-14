-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 06 avr. 2023 à 12:29
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `planning`
--

-- --------------------------------------------------------

--
-- Structure de la table `Couleurs`
--

CREATE TABLE `Couleurs` (
  `couleur_id` int(11) NOT NULL,
  `couleur_centre` char(7) NOT NULL,
  `couleur_pae` char(7) NOT NULL,
  `couleur_certif` char(7) NOT NULL,
  `couleur_ran` char(7) NOT NULL,
  `couleur_vacance` char(7) NOT NULL,
  `couleur_tt` char(7) NOT NULL,
  `couleur_ferie` char(7) NOT NULL,
  `couleur_weekend` char(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Date_certif`
--

CREATE TABLE `Date_certif` (
  `id_date_certif` int(3) NOT NULL,
  `date_debut_certif` date NOT NULL,
  `date_fin_certif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Date_formation`
--

CREATE TABLE `Date_formation` (
  `id_date_formation` int(3) NOT NULL,
  `date_debut_formation` date NOT NULL,
  `date_fin_formation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Date_pae`
--

CREATE TABLE `Date_pae` (
  `id_date_pae` int(3) NOT NULL,
  `date_debut_pae` date NOT NULL,
  `date_fin_pae` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Date_ran`
--

CREATE TABLE `Date_ran` (
  `id_date_ran` int(3) NOT NULL,
  `date_debut_ran` date NOT NULL,
  `date_fin_ran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Formateur`
--

CREATE TABLE `Formateur` (
  `id_formateur` int(3) NOT NULL,
  `nom_formateur` varchar(64) NOT NULL,
  `prenom_formateur` varchar(64) NOT NULL,
  `mail_formateur` varchar(128) NOT NULL,
  `mdp_formateur` varchar(255) NOT NULL,
  `type_contrat_formateur` char(3) NOT NULL,
  `date_debut_contrat` date NOT NULL,
  `date_fin_contrat` date DEFAULT NULL,
  `numero_grm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Formation`
--

CREATE TABLE `Formation` (
  `id_formation` int(11) NOT NULL,
  `acronyme_formation` varchar(10) NOT NULL,
  `description_formation` varchar(128) NOT NULL,
  `numero_grm` int(3) NOT NULL,
  `id_date_ran` int(3) NOT NULL,
  `id_type_formation` int(1) NOT NULL,
  `id_date_formation` int(3) NOT NULL,
  `id_date_certif` int(3) NOT NULL,
  `id_date_pae` int(3) NOT NULL,
  `id_date_interruption` int(1) NOT NULL,
  `id_formateur` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GRM`
--

CREATE TABLE `GRM` (
  `numero_grm` int(3) NOT NULL,
  `nom_grm` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Interruption`
--

CREATE TABLE `Interruption` (
  `id_date_interruption` int(1) NOT NULL,
  `date_debut_interruption` date NOT NULL,
  `date_fin_interruption` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Type_Formation`
--

CREATE TABLE `Type_Formation` (
  `id_type_formation` int(1) NOT NULL,
  `designation_type_formation` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Couleurs`
--
ALTER TABLE `Couleurs`
  ADD PRIMARY KEY (`couleur_id`);

--
-- Index pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  ADD PRIMARY KEY (`id_date_certif`);

--
-- Index pour la table `Date_formation`
--
ALTER TABLE `Date_formation`
  ADD PRIMARY KEY (`id_date_formation`);

--
-- Index pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  ADD PRIMARY KEY (`id_date_pae`);

--
-- Index pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  ADD PRIMARY KEY (`id_date_ran`);

--
-- Index pour la table `Formateur`
--
ALTER TABLE `Formateur`
  ADD PRIMARY KEY (`id_formateur`),
  ADD KEY `numero_grm` (`numero_grm`);

--
-- Index pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD PRIMARY KEY (`id_formation`),
  ADD KEY `id_date_ran` (`id_date_ran`),
  ADD KEY `id_date_formation` (`id_date_formation`),
  ADD KEY `id_date_certif` (`id_date_certif`),
  ADD KEY `id_date_interruption` (`id_date_interruption`),
  ADD KEY `id_type_formation` (`id_type_formation`),
  ADD KEY `id_formateur` (`id_formateur`),
  ADD KEY `id_date_pae` (`id_date_pae`),
  ADD KEY `numero_grm` (`numero_grm`);

--
-- Index pour la table `GRM`
--
ALTER TABLE `GRM`
  ADD PRIMARY KEY (`numero_grm`);

--
-- Index pour la table `Interruption`
--
ALTER TABLE `Interruption`
  ADD PRIMARY KEY (`id_date_interruption`);

--
-- Index pour la table `Type_Formation`
--
ALTER TABLE `Type_Formation`
  ADD PRIMARY KEY (`id_type_formation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Couleurs`
--
ALTER TABLE `Couleurs`
  MODIFY `couleur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  MODIFY `id_date_certif` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_formation`
--
ALTER TABLE `Date_formation`
  MODIFY `id_date_formation` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  MODIFY `id_date_pae` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  MODIFY `id_date_ran` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Formateur`
--
ALTER TABLE `Formateur`
  MODIFY `id_formateur` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Formation`
--
ALTER TABLE `Formation`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Interruption`
--
ALTER TABLE `Interruption`
  MODIFY `id_date_interruption` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Type_Formation`
--
ALTER TABLE `Type_Formation`
  MODIFY `id_type_formation` int(1) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Formateur`
--
ALTER TABLE `Formateur`
  ADD CONSTRAINT `formateur_ibfk_1` FOREIGN KEY (`numero_grm`) REFERENCES `GRM` (`numero_grm`);

--
-- Contraintes pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD CONSTRAINT `formation_ibfk_1` FOREIGN KEY (`id_date_ran`) REFERENCES `Date_ran` (`id_date_ran`),
  ADD CONSTRAINT `formation_ibfk_2` FOREIGN KEY (`id_date_formation`) REFERENCES `Date_formation` (`id_date_formation`),
  ADD CONSTRAINT `formation_ibfk_3` FOREIGN KEY (`id_date_certif`) REFERENCES `Date_certif` (`id_date_certif`),
  ADD CONSTRAINT `formation_ibfk_4` FOREIGN KEY (`id_date_interruption`) REFERENCES `Interruption` (`id_date_interruption`),
  ADD CONSTRAINT `formation_ibfk_5` FOREIGN KEY (`id_type_formation`) REFERENCES `Type_Formation` (`id_type_formation`),
  ADD CONSTRAINT `formation_ibfk_6` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`),
  ADD CONSTRAINT `formation_ibfk_7` FOREIGN KEY (`id_date_pae`) REFERENCES `Date_pae` (`id_date_pae`),
  ADD CONSTRAINT `formation_ibfk_8` FOREIGN KEY (`numero_grm`) REFERENCES `GRM` (`numero_grm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
