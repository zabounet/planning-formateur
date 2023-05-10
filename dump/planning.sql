-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 10 mai 2023 à 07:05
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

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
-- Structure de la table `couleurs`
--

DROP TABLE IF EXISTS `couleurs`;
CREATE TABLE IF NOT EXISTS `couleurs` (
  `couleur_id` int(11) NOT NULL AUTO_INCREMENT,
  `couleur_centre` char(7) NOT NULL,
  `couleur_pae` char(7) NOT NULL,
  `couleur_certif` char(7) NOT NULL,
  `couleur_ran` char(7) NOT NULL,
  `couleur_vacance_demandees` char(7) NOT NULL,
  `couleur_vacance_validee` char(7) NOT NULL,
  `couleur_tt` char(7) NOT NULL,
  `couleur_ferie` char(7) NOT NULL,
  `couleur_weekend` char(7) NOT NULL,
  `couleur_interruption` char(7) NOT NULL,
  `couleur_MNSP` char(7) NOT NULL,
  `couleur_itinerant` char(7) NOT NULL,
  PRIMARY KEY (`couleur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `couleurs`
--

INSERT INTO `couleurs` (`couleur_id`, `couleur_centre`, `couleur_pae`, `couleur_certif`, `couleur_ran`, `couleur_vacance_demandees`, `couleur_vacance_validee`, `couleur_tt`, `couleur_ferie`, `couleur_weekend`, `couleur_interruption`, `couleur_MNSP`, `couleur_itinerant`) VALUES
(1, '#a10c0c', '#000000', '#000000', '#000000', '#000000', '#6d5775', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000');

-- --------------------------------------------------------

--
-- Structure de la table `date_centre`
--

DROP TABLE IF EXISTS `date_centre`;
CREATE TABLE IF NOT EXISTS `date_centre` (
  `id_centre` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_centre` date DEFAULT NULL,
  `date_fin_centre` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_centre`),
  KEY `Date_centre_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_centre`
--

INSERT INTO `date_centre` (`id_centre`, `date_debut_centre`, `date_fin_centre`, `id_formation`) VALUES
(4, '2023-05-01', '2023-11-15', 1),
(5, '2024-03-15', '2024-07-25', 1),
(6, '2023-05-01', '2023-07-23', 2),
(7, '2023-06-01', '2023-06-30', 3);

-- --------------------------------------------------------

--
-- Structure de la table `date_certif`
--

DROP TABLE IF EXISTS `date_certif`;
CREATE TABLE IF NOT EXISTS `date_certif` (
  `id_certif` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_certif` date DEFAULT NULL,
  `date_fin_certif` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_certif`),
  KEY `Date_certif_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_certif`
--

INSERT INTO `date_certif` (`id_certif`, `date_debut_certif`, `date_fin_certif`, `id_formation`) VALUES
(2, '2024-08-06', '2024-08-10', 1),
(3, '2023-11-01', '2023-11-09', 2),
(4, '2023-07-01', '2023-07-07', 3);

-- --------------------------------------------------------

--
-- Structure de la table `date_intervention`
--

DROP TABLE IF EXISTS `date_intervention`;
CREATE TABLE IF NOT EXISTS `date_intervention` (
  `id_intervention` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_intervention` date DEFAULT NULL,
  `date_fin_intervention` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_intervention`),
  KEY `Date_intervention_FK` (`id_formateur`),
  KEY `Date_intervention_formation_FK` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `date_pae`
--

DROP TABLE IF EXISTS `date_pae`;
CREATE TABLE IF NOT EXISTS `date_pae` (
  `id_date_pae` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_pae` date DEFAULT NULL,
  `date_fin_pae` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_date_pae`),
  KEY `Date_pae_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_pae`
--

INSERT INTO `date_pae` (`id_date_pae`, `date_debut_pae`, `date_fin_pae`, `id_formation`) VALUES
(4, '2024-07-26', '2024-08-05', 1),
(5, '2023-11-16', '2024-03-14', 1),
(6, '2023-08-30', '2023-10-07', 2),
(7, '2023-05-10', '2023-06-11', 2),
(8, '2023-06-26', '2023-07-15', 2),
(9, '2023-05-01', '2023-05-31', 3);

-- --------------------------------------------------------

--
-- Structure de la table `date_ran`
--

DROP TABLE IF EXISTS `date_ran`;
CREATE TABLE IF NOT EXISTS `date_ran` (
  `id_ran` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_ran` date DEFAULT NULL,
  `date_fin_ran` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_ran`),
  KEY `Date_ran_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_ran`
--

INSERT INTO `date_ran` (`id_ran`, `date_debut_ran`, `date_fin_ran`, `id_formation`) VALUES
(2, '2023-04-26', '2023-04-30', 1),
(3, '2023-04-30', '2023-05-07', 2),
(4, '2023-04-26', '2023-05-07', 3);

-- --------------------------------------------------------

--
-- Structure de la table `date_teletravail`
--

DROP TABLE IF EXISTS `date_teletravail`;
CREATE TABLE IF NOT EXISTS `date_teletravail` (
  `id_teletravail` int(11) NOT NULL,
  `jour_teletravail` date NOT NULL,
  `date_demande_changement` date NOT NULL,
  `date_prise_effet` date DEFAULT NULL,
  `validation` tinyint(1) NOT NULL,
  `id_formateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_teletravail`),
  KEY `Date_teletravail_Formateur_FK` (`id_formateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `date_vacance`
--

DROP TABLE IF EXISTS `date_vacance`;
CREATE TABLE IF NOT EXISTS `date_vacance` (
  `id_vacance` int(11) NOT NULL,
  `date_debut_vacances` date NOT NULL,
  `date_fin_vacances` date NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `id_formateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vacance`),
  KEY `Date_vacance_Formateur_FK` (`id_formateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

DROP TABLE IF EXISTS `formateur`;
CREATE TABLE IF NOT EXISTS `formateur` (
  `id_formateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_formateur` varchar(64) NOT NULL,
  `prenom_formateur` varchar(64) NOT NULL,
  `mail_formateur` varchar(128) NOT NULL,
  `mdp_formateur` varchar(255) NOT NULL,
  `type_contrat_formateur` char(3) NOT NULL,
  `date_debut_contrat` date DEFAULT NULL,
  `date_fin_contrat` date DEFAULT NULL,
  `permissions_utilisateur` tinyint(4) NOT NULL,
  `numero_grn` int(11) NOT NULL,
  `id_ville` int(11) NOT NULL,
  PRIMARY KEY (`id_formateur`),
  KEY `Formateur_GRN_FK` (`numero_grn`),
  KEY `Formateur_Ville0_FK` (`id_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `mail_formateur`, `mdp_formateur`, `type_contrat_formateur`, `date_debut_contrat`, `date_fin_contrat`, `permissions_utilisateur`, `numero_grn`, `id_ville`) VALUES
(1, 'Non', 'Attribue', '', '', '', NULL, NULL, 0, 164, 1),
(2, 'Veronique', 'Veronique', 'veronique@veronique.veronique', 'b809c6ed348514322f08bf98957a55a95b3a5d8e', '', NULL, NULL, 1, 164, 2),
(3, 'Bezault', 'Sandy', 'bezo@sendi.afpa', '5673041ad99da73cfefa170a7081c0daed5d97b6', 'CDI', '2014-04-17', NULL, 1, 164, 1),
(4, 'akbari', 'ali', '110.akbari.98@gmail.com', '069b9046620079fcbc3b192b0de9d210769e3118', 'CDI', '2023-05-02', '0001-01-01', 0, 165, 1),
(5, 'bezo', 'sendi', 'bezo@sendi@affpa.fere', '5673041ad99da73cfefa170a7081c0daed5d97b6', 'cdd', '2014-04-17', '2023-04-27', 0, 164, 1);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id_formation` int(11) NOT NULL AUTO_INCREMENT,
  `nom_formation` varchar(128) NOT NULL,
  `acronyme_formation` varchar(24) NOT NULL,
  `description_formation` varchar(128) NOT NULL,
  `date_debut_formation` date NOT NULL,
  `date_fin_formation` date NOT NULL,
  `numero_grn` int(11) NOT NULL,
  `id_type_formation` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `id_ville` int(11) NOT NULL,
  PRIMARY KEY (`id_formation`),
  KEY `Formation_GRN_FK` (`numero_grn`),
  KEY `Formation_Type_Formation0_FK` (`id_type_formation`),
  KEY `Formation_Formateur1_FK` (`id_formateur`),
  KEY `Formation_Ville2_FK` (`id_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_formation`, `nom_formation`, `acronyme_formation`, `description_formation`, `date_debut_formation`, `date_fin_formation`, `numero_grn`, `id_type_formation`, `id_formateur`, `id_ville`) VALUES
(1, '164 CDA offre 1099 : 2023-04-30 - 2023-11-09 Tours', 'CDA', 'CDACDACDA', '2023-04-30', '2023-11-09', 164, 4, 3, 2),
(2, '164 GUC offre 1983 : 2023-04-26 - 2024-08-10 Tours', 'GUC', 'GUCGUCGUC', '2023-04-26', '2024-08-10', 164, 1, 4, 2),
(3, '166 B3 offre 1060 : 2023-04-30 - 2023-11-09 Tours', 'B3', 'B3B3B3B3', '2023-04-30', '2023-11-09', 166, 3, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `grn`
--

DROP TABLE IF EXISTS `grn`;
CREATE TABLE IF NOT EXISTS `grn` (
  `numero_grn` int(11) NOT NULL,
  `nom_grn` varchar(32) NOT NULL,
  PRIMARY KEY (`numero_grn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `grn`
--

INSERT INTO `grn` (`numero_grn`, `nom_grn`) VALUES
(164, 'Informatique'),
(165, 'Commerce'),
(166, 'Design');

-- --------------------------------------------------------

--
-- Structure de la table `interruption`
--

DROP TABLE IF EXISTS `interruption`;
CREATE TABLE IF NOT EXISTS `interruption` (
  `id_interruption` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_interruption` date DEFAULT NULL,
  `date_fin_interruption` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_interruption`),
  KEY `Date_interruption_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `interruption`
--

INSERT INTO `interruption` (`id_interruption`, `date_debut_interruption`, `date_fin_interruption`, `id_formation`) VALUES
(3, '2023-04-28', '2023-05-07', 2),
(4, '2023-05-31', '2023-06-11', 2),
(5, '2023-08-01', '2023-11-09', 3);

-- --------------------------------------------------------

--
-- Structure de la table `type_formation`
--

DROP TABLE IF EXISTS `type_formation`;
CREATE TABLE IF NOT EXISTS `type_formation` (
  `id_type_formation` int(11) NOT NULL AUTO_INCREMENT,
  `designation_type_formation` varchar(16) NOT NULL,
  PRIMARY KEY (`id_type_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_formation`
--

INSERT INTO `type_formation` (`id_type_formation`, `designation_type_formation`) VALUES
(1, 'Courte'),
(2, 'Longue'),
(3, 'Continue'),
(4, 'Alternance');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id_ville` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(128) NOT NULL,
  PRIMARY KEY (`id_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id_ville`, `nom_ville`) VALUES
(1, 'Blois'),
(2, 'Tours');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `date_centre`
--
ALTER TABLE `date_centre`
  ADD CONSTRAINT `Date_centre_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_certif`
--
ALTER TABLE `date_certif`
  ADD CONSTRAINT `Date_certif_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_intervention`
--
ALTER TABLE `date_intervention`
  ADD CONSTRAINT `Date_intervention_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `Date_intervention_formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_pae`
--
ALTER TABLE `date_pae`
  ADD CONSTRAINT `Date_pae_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_ran`
--
ALTER TABLE `date_ran`
  ADD CONSTRAINT `Date_ran_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_teletravail`
--
ALTER TABLE `date_teletravail`
  ADD CONSTRAINT `Date_teletravail_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `date_vacance`
--
ALTER TABLE `date_vacance`
  ADD CONSTRAINT `Date_vacance_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD CONSTRAINT `Formateur_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `grn` (`numero_grn`),
  ADD CONSTRAINT `Formateur_Ville0_FK` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `Formation_Formateur1_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `Formation_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `grn` (`numero_grn`),
  ADD CONSTRAINT `Formation_Type_Formation0_FK` FOREIGN KEY (`id_type_formation`) REFERENCES `type_formation` (`id_type_formation`),
  ADD CONSTRAINT `Formation_Ville2_FK` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `interruption`
--
ALTER TABLE `interruption`
  ADD CONSTRAINT `Date_interruption_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
