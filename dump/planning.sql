-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 25 mai 2023 à 12:24
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

DROP TABLE IF EXISTS `Couleurs`;
CREATE TABLE IF NOT EXISTS `Couleurs` (
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

INSERT INTO `Couleurs` (`couleur_id`, `couleur_centre`, `couleur_pae`, `couleur_certif`, `couleur_ran`, `couleur_vacance_demandees`, `couleur_vacance_validee`, `couleur_tt`, `couleur_ferie`, `couleur_weekend`, `couleur_interruption`, `couleur_MNSP`, `couleur_perfectionment`) VALUES
(1, '#0c39a1', '#ffb3b3', '#32266e', '#0bb116', '#d4ff00', '#ffd500', '#9c69e8', '#0dd9b7', '#4f4f4f', '#5f69b4', '#d70404', '#d800f5');

-- --------------------------------------------------------

--
-- Structure de la table `date_centre`
--

DROP TABLE IF EXISTS `Date_centre`;
CREATE TABLE IF NOT EXISTS `Date_centre` (
  `id_centre` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_centre` date DEFAULT NULL,
  `date_fin_centre` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_centre`),
  KEY `Date_centre_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_centre`
--

INSERT INTO `Date_centre` (`id_centre`, `date_debut_centre`, `date_fin_centre`, `id_formation`) VALUES
(7, '2023-06-01', '2023-06-30', 3),
(11, '2023-05-01', '2023-07-23', 2),
(12, '2024-01-10', '2025-03-05', 4),
(13, '2023-06-17', '2023-07-13', 4),
(14, '0001-01-01', '0001-01-01', 4),
(15, '2023-06-16', '2023-08-06', 4),
(16, '2024-12-07', '2024-09-08', 4),
(54, '2023-05-01', '2023-11-15', 1),
(55, '2024-03-15', '2024-07-25', 1),
(56, '2024-06-10', '2024-06-20', 5);

-- --------------------------------------------------------

--
-- Structure de la table `date_certif`
--

DROP TABLE IF EXISTS `Date_certif`;
CREATE TABLE IF NOT EXISTS `Date_certif` (
  `id_certif` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_certif` date DEFAULT NULL,
  `date_fin_certif` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_certif`),
  KEY `Date_certif_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_certif`
--

INSERT INTO `Date_certif` (`id_certif`, `date_debut_certif`, `date_fin_certif`, `id_formation`) VALUES
(4, '2023-07-01', '2023-07-07', 3),
(7, '2023-11-01', '2023-11-09', 2),
(26, '2024-08-06', '2024-08-10', 1);

-- --------------------------------------------------------

--
-- Structure de la table `date_intervention`
--

DROP TABLE IF EXISTS `Date_intervention`;
CREATE TABLE IF NOT EXISTS `Date_intervention` (
  `id_intervention` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_intervention` date DEFAULT NULL,
  `date_fin_intervention` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_intervention`),
  KEY `Date_intervention_FK` (`id_formateur`),
  KEY `Date_intervention_formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_intervention`
--

INSERT INTO `Date_intervention` (`id_intervention`, `date_debut_intervention`, `date_fin_intervention`, `id_formateur`, `id_formation`) VALUES
(3, '2023-08-25', '2023-09-01', 4, 2),
(4, '2023-09-11', '2024-01-11', 4, 3),
(7, '2023-05-11', '2023-05-26', 5, 3),
(10, '2023-06-21', '2023-06-23', 4, 4),
(11, '2023-05-01', '2023-05-10', 6, 1),
(12, '2023-05-08', '2023-05-20', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `date_mnsp`
--

DROP TABLE IF EXISTS `Date_MNSP`;
CREATE TABLE IF NOT EXISTS `Date_MNSP` (
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

INSERT INTO `Date_MNSP` (`id_MNSP`, `date_debut_MNSP`, `date_fin_MNSP`, `id_formateur`) VALUES
(1, '2023-05-01', '2023-05-10', 3);

-- --------------------------------------------------------

--
-- Structure de la table `date_pae`
--

DROP TABLE IF EXISTS `Date_pae`;
CREATE TABLE IF NOT EXISTS `Date_pae` (
  `id_date_pae` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_pae` date DEFAULT NULL,
  `date_fin_pae` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_date_pae`),
  KEY `Date_pae_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_pae`
--

INSERT INTO `Date_pae` (`id_date_pae`, `date_debut_pae`, `date_fin_pae`, `id_formation`) VALUES
(9, '2023-05-01', '2023-05-31', 3),
(15, '2023-08-30', '2023-10-07', 2),
(16, '2023-05-10', '2023-06-11', 2),
(17, '2023-06-26', '2023-07-15', 2),
(55, '2024-07-26', '2024-08-05', 1),
(56, '2023-11-16', '2024-03-14', 1);

-- --------------------------------------------------------

--
-- Structure de la table `date_perfectionnement`
--

DROP TABLE IF EXISTS `Date_perfectionnement`;
CREATE TABLE IF NOT EXISTS `Date_perfectionnement` (
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

INSERT INTO `Date_perfectionnement` (`id_perfectionnement`, `date_debut_perfectionnement`, `date_fin_perfectionnement`, `id_formateur`) VALUES
(1, '2023-05-11', '2023-05-13', 3);

-- --------------------------------------------------------

--
-- Structure de la table `date_ran`
--

DROP TABLE IF EXISTS `Date_ran`;
CREATE TABLE IF NOT EXISTS `Date_ran` (
  `id_ran` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_ran` date DEFAULT NULL,
  `date_fin_ran` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_ran`),
  KEY `Date_ran_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_ran`
--

INSERT INTO `Date_ran` (`id_ran`, `date_debut_ran`, `date_fin_ran`, `id_formation`) VALUES
(4, '2023-04-26', '2023-05-07', 3),
(7, '2023-04-30', '2023-05-07', 2),
(26, '2023-04-26', '2023-04-30', 1);

-- --------------------------------------------------------

--
-- Structure de la table `date_teletravail`
--

DROP TABLE IF EXISTS `Date_teletravail`;
CREATE TABLE IF NOT EXISTS `Date_teletravail` (
  `id_teletravail` int(11) NOT NULL AUTO_INCREMENT,
  `jour_teletravail` VARCHAR(64) NOT NULL,
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

DROP TABLE IF EXISTS `Date_vacance`;
CREATE TABLE IF NOT EXISTS `Date_vacance` (
  `id_vacance` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_vacances` date NOT NULL,
  `date_fin_vacances` date NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `id_formateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vacance`),
  KEY `Date_vacance_Formateur_FK` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_vacance`
--

INSERT INTO `Date_vacance` (`id_vacance`, `date_debut_vacances`, `date_fin_vacances`, `validation`, `id_formateur`) VALUES
(1, '2023-05-12', '2023-05-19', 0, 4),
(2, '2023-06-01', '2023-06-15', 1, 4),
(3, '2023-07-06', '2023-07-13', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

DROP TABLE IF EXISTS `Formateur`;
CREATE TABLE IF NOT EXISTS `Formateur` (
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

INSERT INTO `Formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `mail_formateur`, `mdp_formateur`, `type_contrat_formateur`, `date_debut_contrat`, `date_fin_contrat`, `permissions_utilisateur`, `numero_grn`, `id_ville`) VALUES
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

DROP TABLE IF EXISTS `Formation`;
CREATE TABLE IF NOT EXISTS `Formation` (
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

INSERT INTO `Formation` (`id_formation`, `nom_formation`, `acronyme_formation`, `description_formation`, `candidats_formation`, `date_debut_formation`, `date_fin_formation`, `numero_grn`, `id_type_formation`, `id_formateur`, `id_ville`) VALUES
(1, '164 CDA offre 1099  : 30-04-2023 - 09-11-2023 Tours', 'CDA', '        CDACDACDA', '15 / 10', '2023-04-30', '2023-11-09', 164, 4, 7, 2),
(2, '164 GUC offre 1983  : 2023-04-26 - 2024-08-10 Tours', 'GUC', ' GUCGUCGUC', '', '2023-04-26', '2024-08-10', 164, 1, 5, 2),
(3, '166 B3 offre 1060 : 2023-04-30 - 2023-11-09 Tours', 'B3', 'B3B3B3B3', '', '2023-04-30', '2023-11-09', 166, 3, 1, 2),
(4, '164 1 1 : 0001-01-01 - 0001-01-01 Blois', '1', '1', '', '0001-01-01', '0001-01-01', 164, 1, 1, 1),
(5, '164 RDC offre 0394  : 28-05-2023 - 06-09-2023 Blois', 'RDC', ' Rez De Chaussée', '13 / 9', '2023-05-28', '2023-09-06', 164, 1, 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `grn`
--

DROP TABLE IF EXISTS `GRN`;
CREATE TABLE IF NOT EXISTS `GRN` (
  `numero_grn` int(11) NOT NULL,
  `nom_grn` varchar(32) NOT NULL,
  PRIMARY KEY (`numero_grn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `grn`
--

INSERT INTO `GRN` (`numero_grn`, `nom_grn`) VALUES
(164, 'Informatique'),
(165, 'Commerce'),
(166, 'Design');

-- --------------------------------------------------------

--
-- Structure de la table `interruption`
--

DROP TABLE IF EXISTS `Interruption`;
CREATE TABLE IF NOT EXISTS `Interruption` (
  `id_interruption` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_interruption` date DEFAULT NULL,
  `date_fin_interruption` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL,
  PRIMARY KEY (`id_interruption`),
  KEY `Date_interruption_Formation_FK` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `interruption`
--

INSERT INTO `Interruption` (`id_interruption`, `date_debut_interruption`, `date_fin_interruption`, `id_formation`) VALUES
(5, '2023-08-01', '2023-11-09', 3),
(8, '2023-04-28', '2023-05-07', 2),
(9, '2023-05-31', '2023-06-11', 2),
(10, '2023-08-09', '2023-08-14', 4),
(12, '2024-07-07', '2024-07-07', 5);

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

DROP TABLE IF EXISTS `Logs`;
CREATE TABLE IF NOT EXISTS `Logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(128) DEFAULT NULL,
  `activity_type` varchar(50) DEFAULT NULL,
  `success` tinyint(4) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `Logs` (`id`, `user_email`, `activity_type`, `success`, `activity_time`) VALUES
(1, 'veronique@veronique.veronique', 'UPDATE Dans couleurs', 1, '2023-05-25 12:21:13'),
(2, 'veronique@veronique.veronique', 'UPDATE Dans couleurs', 1, '2023-05-25 12:23:05');

-- --------------------------------------------------------

--
-- Structure de la table `type_formation`
--

DROP TABLE IF EXISTS `Type_formation`;
CREATE TABLE IF NOT EXISTS `Type_formation` (
  `id_type_formation` int(11) NOT NULL AUTO_INCREMENT,
  `designation_type_formation` varchar(16) NOT NULL,
  PRIMARY KEY (`id_type_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_formation`
--

INSERT INTO `Type_formation` (`id_type_formation`, `designation_type_formation`) VALUES
(1, 'Courte'),
(2, 'Longue'),
(3, 'Continue'),
(4, 'Alternance');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `V`;
CREATE TABLE IF NOT EXISTS `Ville` (
  `id_ville` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(128) NOT NULL,
  PRIMARY KEY (`id_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `Ville` (`id_ville`, `nom_ville`) VALUES
(1, 'Blois'),
(2, 'Tours');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `date_centre`
--
ALTER TABLE `Date_centre`
  ADD CONSTRAINT `Date_centre_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_certif`
--
ALTER TABLE `Date_certif`
  ADD CONSTRAINT `Date_certif_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_intervention`
--
ALTER TABLE `Date_intervention`
  ADD CONSTRAINT `Date_intervention_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `Date_intervention_formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_mnsp`
--
ALTER TABLE `Date_mnsp`
  ADD CONSTRAINT `date_mnsp_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `date_pae`
--
ALTER TABLE `Date_pae`
  ADD CONSTRAINT `Date_pae_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `date_perfectionnement`
--
ALTER TABLE `Date_perfectionnement`
  ADD CONSTRAINT `date_perfectionnement_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `date_ran`
--
ALTER TABLE `Date_ran`
  ADD CONSTRAINT `Date_ran_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `date_teletravail`
--
ALTER TABLE `Date_teletravail`
  ADD CONSTRAINT `Date_teletravail_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `date_vacance`
--
ALTER TABLE `Date_vacance`
  ADD CONSTRAINT `Date_vacance_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `formateur`
--
ALTER TABLE `Formateur`
  ADD CONSTRAINT `Formateur_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `GRN` (`numero_grn`),
  ADD CONSTRAINT `Formateur_Ville0_FK` FOREIGN KEY (`id_ville`) REFERENCES `Ville` (`id_ville`);

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `Formation`
  ADD CONSTRAINT `Formation_Formateur1_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`),
  ADD CONSTRAINT `Formation_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `GRN` (`numero_grn`),
  ADD CONSTRAINT `Formation_Type_Formation0_FK` FOREIGN KEY (`id_type_formation`) REFERENCES `Type_formation` (`id_type_formation`),
  ADD CONSTRAINT `Formation_Ville2_FK` FOREIGN KEY (`id_ville`) REFERENCES `Ville` (`id_ville`);

--
-- Contraintes pour la table `interruption`
--
ALTER TABLE `Interruption`
  ADD CONSTRAINT `Date_interruption_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
