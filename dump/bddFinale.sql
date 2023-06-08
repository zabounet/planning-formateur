-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 08 juin 2023 à 11:37
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
  `couleur_autre` char(7) NOT NULL,
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

INSERT INTO `couleurs` (`couleur_id`, `couleur_centre`, `couleur_pae`, `couleur_certif`, `couleur_ran`, `couleur_vacance_demandees`, `couleur_vacance_validee`, `couleur_autre`, `couleur_ferie`, `couleur_weekend`, `couleur_interruption`, `couleur_MNSP`, `couleur_perfectionment`) VALUES
(1, '#0c39a1', '#ffb3b3', '#32266e', '#0bb116', '#d4ff00', '#b39500', '#9c69e8', '#0dd9b7', '#4f4f4f', '#5f69b4', '#d70404', '#22492a');

-- --------------------------------------------------------

--
-- Structure de la table `date_autre`
--

DROP TABLE IF EXISTS `date_autre`;
CREATE TABLE IF NOT EXISTS `date_autre` (
  `id_autre` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut_autre` date NOT NULL,
  `date_fin_autre` date NOT NULL,
  `lettre` char(2) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  PRIMARY KEY (`id_autre`),
  KEY `Autre_Formateur_FK` (`id_formateur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_teletravail`
--

INSERT INTO `date_teletravail` (`id_teletravail`, `jour_teletravail`, `date_demande_changement`, `date_prise_effet`, `validation`, `id_formateur`) VALUES
(1, 'lundi', '2023-06-08', '2023-06-08', 1, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_vacance`
--

INSERT INTO `date_vacance` (`id_vacance`, `date_debut_vacances`, `date_fin_vacances`, `validation`, `id_formateur`) VALUES
(1, '2023-06-01', '2023-06-08', 1, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `mail_formateur`, `mdp_formateur`, `type_contrat_formateur`, `date_debut_contrat`, `date_fin_contrat`, `permissions_utilisateur`, `numero_grn`, `id_ville`) VALUES
(1, 'Non', 'Attribue', '', '', '', NULL, NULL, 0, 164, 1),
(2, 'Brunet', 'Veronique', 'veronique.brunet@afpa.fr', '$argon2id$v=19$m=65536,t=4,p=2$Y21XQTRkbkxqTVJZMmVFdw$VLx/a/9JnWOt+a405SR/m5W7nHbYvmH056Jolv2VAWE', 'CDI', NULL, NULL, 1, 180, 2),
(3, 'akbari', 'ali', '110.akbari.98@gmail.com', '$argon2id$v=19$m=65536,t=4,p=2$cy5mVnc3eDVmVnd2aTVMLg$qP0HkyS2s0Je3+3VxviFvjOKolHotG70u/N3f7gKyEU', 'CDI', '2023-04-08', '0001-01-01', 0, 122, 1),
(4, 'akbariccc', 'alicc', '110.akccbari.98@gmail.com', '$argon2id$v=19$m=65536,t=4,p=2$VFdLaWg3d2tqLjlqOGlDNw$/9Yb8G9tnSGTn2YwbyvcJyLfmArF1mHx7Aov4eF1kZU', 'CDD', '2022-03-03', '2023-06-08', 0, 117, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `grn`
--

DROP TABLE IF EXISTS `grn`;
CREATE TABLE IF NOT EXISTS `grn` (
  `numero_grn` int(11) NOT NULL,
  `nom_grn` varchar(128) NOT NULL,
  PRIMARY KEY (`numero_grn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `grn`
--

INSERT INTO `grn` (`numero_grn`, `nom_grn`) VALUES
(101, 'Horticulture'),
(102, 'Maçonnerie'),
(106, 'Entretien batiment'),
(108, 'Equipement Genie climatique'),
(111, 'Amenagements finitions niveau V'),
(117, 'Reseaux electriques et de communication'),
(122, 'Travail du bois niveau V, IV'),
(124, 'Equipement Electrique'),
(128, 'Soudage et controle'),
(144, 'Maintenance industrielle'),
(159, 'Secretariat - Assistanat'),
(160, 'Compatibilite - Gestion'),
(161, 'Relations Clients a distance'),
(162, 'Fonction Commerciale'),
(163, 'Distribution'),
(164, 'Informatique et telecommunication'),
(165, 'Tourisme et loisirs'),
(166, 'Hotellerie et restauration'),
(173, 'Conduite Routiere'),
(177, 'Autres Services entreprises et collectivités'),
(178, 'Metiers de la mediation-insertion-formation'),
(179, 'Pre-professionnalisation'),
(180, 'Orientation et accompagnement en groupe');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `logs` (`id`, `user_email`, `activity_type`, `success`, `activity_time`) VALUES
(1, 'veronique@veronique.veronique', 'Connexion', 1, '2023-06-08 09:04:23'),
(2, '', 'Connexion', 1, '2023-06-08 09:11:20'),
(3, 'veronique.brunet@afpa.fr', 'Connexion', 1, '2023-06-08 09:12:54'),
(4, 'veronique.brunet@afpa.fr', 'INSERT Dans Formateur(\r\n', 1, '2023-06-08 09:13:31'),
(5, 'veronique.brunet@afpa.fr', 'INSERT Dans Formateur(\r\n', 1, '2023-06-08 09:14:37'),
(6, 'veronique.brunet@afpa.fr', 'INSERT Dans Date_autre', 1, '2023-06-08 10:02:06'),
(7, 'veronique.brunet@afpa.fr', 'INSERT Dans Date_autre', 1, '2023-06-08 10:02:23'),
(8, 'veronique.brunet@afpa.fr', 'DELETE Dans date_autre', 1, '2023-06-08 10:03:50'),
(9, 'veronique.brunet@afpa.fr', 'DELETE Dans date_autre', 1, '2023-06-08 10:03:56'),
(10, 'veronique.brunet@afpa.fr', 'DELETE Dans date_autre', 1, '2023-06-08 10:04:00'),
(11, 'veronique.brunet@afpa.fr', 'INSERT Dans Date_autre', 1, '2023-06-08 10:04:24'),
(12, 'veronique.brunet@afpa.fr', 'Connexion', 1, '2023-06-08 11:29:49'),
(13, 'veronique.brunet@afpa.fr', 'DELETE Dans date_autre', 1, '2023-06-08 11:30:39'),
(14, 'veronique.brunet@afpa.fr', 'INSERT Dans Date_teletravail', 1, '2023-06-08 11:30:54'),
(15, 'veronique.brunet@afpa.fr', 'INSERT Dans Notification', 1, '2023-06-08 11:30:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`id_notification`, `description_notification`, `date`, `date_notification`, `role`, `id_formateur`, `type`) VALUES
(1, ' La manager a saisi pour vouz le t&eacute;l&eacute;travail pour lundi &agrave; compter du 08-06-2023', 'lundi', '2023-06-08 11:30:54', 'admin', 3, 'Date_teletravail');

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
-- Contraintes pour la table `date_autre`
--
ALTER TABLE `date_autre`
  ADD CONSTRAINT `date_autre_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

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
  ADD CONSTRAINT `Date_MNSP_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `date_pae`
--
ALTER TABLE `date_pae`
  ADD CONSTRAINT `Date_pae_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `date_perfectionnement`
--
ALTER TABLE `date_perfectionnement`
  ADD CONSTRAINT `Date_perfectionnement_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

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

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
