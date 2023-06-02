-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 02 juin 2023 à 07:00
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
  `couleur_perfectionment` char(7) NOT NULL,
  PRIMARY KEY (`couleur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `couleurs`
--

INSERT INTO `couleurs` (`couleur_id`, `couleur_centre`, `couleur_pae`, `couleur_certif`, `couleur_ran`, `couleur_vacance_demandees`, `couleur_vacance_validee`, `couleur_tt`, `couleur_ferie`, `couleur_weekend`, `couleur_interruption`, `couleur_MNSP`, `couleur_perfectionment`) VALUES
(1, '#0c39a1', '#ffb3b3', '#32266e', '#0bb116', '#d4ff00', '#ffd500', '#9c69e8', '#0dd9b7', '#4f4f4f', '#5f69b4', '#d70404', '#d800f5');

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_centre`
--

INSERT INTO `date_centre` (`id_centre`, `date_debut_centre`, `date_fin_centre`, `id_formation`) VALUES
(7, '2023-06-01', '2023-06-30', 3),
(12, '2024-01-10', '2025-03-05', 4),
(13, '2023-06-17', '2023-07-13', 4),
(14, '0001-01-01', '0001-01-01', 4),
(15, '2023-06-16', '2023-08-06', 4),
(16, '2024-12-07', '2024-09-08', 4),
(54, '2023-05-01', '2023-11-15', 1),
(55, '2024-03-15', '2024-07-25', 1),
(56, '2024-06-10', '2024-06-20', 5),
(57, '2023-05-01', '2023-07-23', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_certif`
--

INSERT INTO `date_certif` (`id_certif`, `date_debut_certif`, `date_fin_certif`, `id_formation`) VALUES
(4, '2023-07-01', '2023-07-07', 3),
(26, '2024-08-06', '2024-08-10', 1),
(27, '2023-11-01', '2023-11-09', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_intervention`
--

INSERT INTO `date_intervention` (`id_intervention`, `date_debut_intervention`, `date_fin_intervention`, `id_formateur`, `id_formation`) VALUES
(4, '2023-09-11', '2024-01-11', 4, 3),
(7, '2023-05-11', '2023-05-26', 5, 3),
(10, '2023-06-21', '2023-06-23', 4, 4),
(11, '2023-05-01', '2023-05-10', 6, 1),
(12, '2023-05-08', '2023-05-20', 3, 1),
(13, '2023-06-21', '2023-06-23', 4, 2),
(14, '2023-08-25', '2023-09-01', 4, 2),
(15, '2023-09-11', '2024-01-11', 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `date_mnsp`
--

DROP TABLE IF EXISTS `date_mnsp`;
CREATE TABLE IF NOT EXISTS `date_mnsp` (
  `id_MNSP` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_MNSP` date DEFAULT NULL,
  `date_fin_MNSP` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  PRIMARY KEY (`id_MNSP`),
  KEY `id_formateur` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_mnsp`
--

INSERT INTO `date_mnsp` (`id_MNSP`, `date_debut_MNSP`, `date_fin_MNSP`, `id_formateur`) VALUES
(1, '2023-05-01', '2023-05-10', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_pae`
--

INSERT INTO `date_pae` (`id_date_pae`, `date_debut_pae`, `date_fin_pae`, `id_formation`) VALUES
(9, '2023-05-01', '2023-05-31', 3),
(55, '2024-07-26', '2024-08-05', 1),
(56, '2023-11-16', '2024-03-14', 1),
(57, '2023-08-30', '2023-10-07', 2),
(58, '2023-05-10', '2023-06-11', 2),
(59, '2023-06-26', '2023-07-15', 2);

-- --------------------------------------------------------

--
-- Structure de la table `date_perfectionnement`
--

DROP TABLE IF EXISTS `date_perfectionnement`;
CREATE TABLE IF NOT EXISTS `date_perfectionnement` (
  `id_perfectionnement` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_perfectionnement` date DEFAULT NULL,
  `date_fin_perfectionnement` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  PRIMARY KEY (`id_perfectionnement`),
  KEY `id_formateur` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_perfectionnement`
--

INSERT INTO `date_perfectionnement` (`id_perfectionnement`, `date_debut_perfectionnement`, `date_fin_perfectionnement`, `id_formateur`) VALUES
(1, '2023-05-11', '2023-05-13', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_ran`
--

INSERT INTO `date_ran` (`id_ran`, `date_debut_ran`, `date_fin_ran`, `id_formation`) VALUES
(4, '2023-04-26', '2023-05-07', 3),
(26, '2023-04-26', '2023-04-30', 1),
(27, '2023-04-30', '2023-05-07', 2);

-- --------------------------------------------------------

--
-- Structure de la table `date_teletravail`
--

DROP TABLE IF EXISTS `date_teletravail`;
CREATE TABLE IF NOT EXISTS `date_teletravail` (
  `id_teletravail` int(11) NOT NULL AUTO_INCREMENT,
  `jour_teletravail` varchar(64) NOT NULL,
  `date_demande_changement` date NOT NULL,
  `date_prise_effet` date DEFAULT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `id_formateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_teletravail`),
  KEY `Date_teletravail_Formateur_FK` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_teletravail`
--

INSERT INTO `date_teletravail` (`id_teletravail`, `jour_teletravail`, `date_demande_changement`, `date_prise_effet`, `validation`, `id_formateur`) VALUES
(22, 'mardi,jeudi', '2023-06-01', '2023-06-01', 1, 4),
(23, 'vendredi', '2023-06-01', '2023-05-31', 1, 4),
(24, 'mardi', '2023-06-01', '2023-06-13', NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `date_vacance`
--

DROP TABLE IF EXISTS `date_vacance`;
CREATE TABLE IF NOT EXISTS `date_vacance` (
  `id_vacance` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_vacances` date NOT NULL,
  `date_fin_vacances` date NOT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `id_formateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vacance`),
  KEY `Date_vacance_Formateur_FK` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_vacance`
--

INSERT INTO `date_vacance` (`id_vacance`, `date_debut_vacances`, `date_fin_vacances`, `validation`, `id_formateur`) VALUES
(1, '2023-05-12', '2023-05-19', NULL, 4),
(2, '2023-06-01', '2023-06-15', NULL, 4),
(3, '2023-07-06', '2023-07-13', 1, 4),
(4, '2023-06-07', '2023-09-13', 0, 4);

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
  `type_contrat_formateur` varchar(10) NOT NULL,
  `date_debut_contrat` date DEFAULT NULL,
  `date_fin_contrat` date DEFAULT NULL,
  `permissions_utilisateur` tinyint(4) NOT NULL,
  `numero_grn` int(11) NOT NULL,
  `id_ville` int(11) NOT NULL,
  PRIMARY KEY (`id_formateur`),
  KEY `Formateur_GRN_FK` (`numero_grn`),
  KEY `Formateur_Ville0_FK` (`id_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `mail_formateur`, `mdp_formateur`, `type_contrat_formateur`, `date_debut_contrat`, `date_fin_contrat`, `permissions_utilisateur`, `numero_grn`, `id_ville`) VALUES
(1, 'Non', 'Attribue', '', '', '', NULL, NULL, 0, 164, 1),
(2, 'Veronique', 'Veronique', 'veronique@veronique.veronique', '$argon2id$v=19$m=65536,t=4,p=2$N2M3VWl3TEJOMDU5TmhocQ$cC3Y9GMdi52uOX7F/4ckLo9gil7MxnIor+UU3fudVHs', 'AUTRE', NULL, NULL, 1, 164, 1),
(3, 'Bezault', 'Sandy', 'bezo@sendi.afpa', '$argon2id$v=19$m=65536,t=4,p=2$a1NuMWdhQTFnZEhLMkdBbw$FW6Z35tEyozZ4oOQ8r1WIaHcLhJsUhog5hTZ+sC7Qq4', 'CDI', '2014-04-17', '0001-01-01', 0, 164, 1),
(4, 'akbari', 'ali', '110.akbari.98@gmail.com', '$argon2id$v=19$m=65536,t=4,p=2$LzBxZmI4bDdHLzJuNVJEQw$3fjk+b06PEas2BHkfJYJBZ7Kd2jCYwM0zY7kLEPa1TA', 'CDI', '2023-05-02', '0001-01-01', 0, 165, 1),
(5, 'bezo', 'sendi', 'bezo@sendi@affpa.fere', '$argon2id$v=19$m=65536,t=4,p=2$SlprOWFhZldBVHFMbkNsRA$sGKVDFBKPhG28zimfZhFdxLx1AM9XTRt7IpxdjwE3Wo', 'CDD', '2014-04-17', '2023-04-27', 0, 164, 1),
(6, 'Rabot', 'Nicolas', 'nicolas@nicolas.nicolas', '$argon2id$v=19$m=65536,t=4,p=2$TllKcU8yNmxXZnFyd0c0Ug$jS6FF3v4ZvHEAe6EiC0JbbvvzHWgXO/mYDQAxtCZ36k', 'INTERIM', '2023-12-10', '2024-02-10', 0, 166, 2),
(7, 'Rabot', 'Nicolas', 'nicolas@nicolas.nicolas', '$argon2id$v=19$m=65536,t=4,p=2$YU5MVElCZFZ6QVJvYzQzQQ$iJRpfq/kcm4L+oESviWEIoPcRhv7N5H4k51rzSWOYOk', 'INTERIM', '2023-12-10', '2024-02-10', 0, 166, 2);

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
  `candidats_formation` varchar(10) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_formation`, `nom_formation`, `acronyme_formation`, `description_formation`, `candidats_formation`, `date_debut_formation`, `date_fin_formation`, `numero_grn`, `id_type_formation`, `id_formateur`, `id_ville`) VALUES
(1, '164 CDA offre 1099  : 30-04-2023 - 09-11-2023 Tours', 'CDA', '        CDACDACDA', '15 / 10', '2023-04-30', '2023-11-09', 164, 4, 7, 2),
(2, '164 GUC offre 1983  : 26-04-2023 - 10-08-2024 Tours', 'GUC', 'GUCGUCGUC', '', '2023-04-26', '2024-08-10', 164, 1, 7, 2),
(3, '166 B3 offre 1060 : 2023-04-30 - 2023-11-09 Tours', 'B3', 'B3B3B3B3', '', '2023-04-30', '2023-11-09', 166, 3, 1, 2),
(4, '164 1 1 : 0001-01-01 - 0001-01-01 Blois', '1', '1', '', '0001-01-01', '0001-01-01', 164, 1, 1, 1),
(5, '164 RDC offre 0394  : 28-05-2023 - 06-09-2023 Blois', 'RDC', ' Rez De Chaussée', '13 / 9', '2023-05-28', '2023-09-06', 164, 1, 7, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `interruption`
--

INSERT INTO `interruption` (`id_interruption`, `date_debut_interruption`, `date_fin_interruption`, `id_formation`) VALUES
(5, '2023-08-01', '2023-11-09', 3),
(10, '2023-08-09', '2023-08-14', 4),
(12, '2024-07-07', '2024-07-07', 5),
(13, '2023-04-28', '2023-05-07', 2),
(14, '2023-05-31', '2023-06-11', 2);

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(128) DEFAULT NULL,
  `activity_type` varchar(50) DEFAULT NULL,
  `success` tinyint(4) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1043 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `description_notification` varchar(512) DEFAULT NULL,
  `date` varchar(64) NOT NULL,
  `date_notification` datetime DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  `type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_notification`),
  KEY `Notification_Formateur_FK` (`id_formateur`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

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
-- Contraintes pour la table `date_mnsp`
--
ALTER TABLE `date_mnsp`
  ADD CONSTRAINT `date_mnsp_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `date_pae`
--
ALTER TABLE `date_pae`
  ADD CONSTRAINT `Date_pae_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_perfectionnement`
--
ALTER TABLE `date_perfectionnement`
  ADD CONSTRAINT `date_perfectionnement_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

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
