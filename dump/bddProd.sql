-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 08 juin 2023 à 16:13
-- Version du serveur : 10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 8.1.17

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
  `couleur_vacance_demandees` char(7) NOT NULL,
  `couleur_vacance_validee` char(7) NOT NULL,
  `couleur_autre` char(7) NOT NULL,
  `couleur_ferie` char(7) NOT NULL,
  `couleur_weekend` char(7) NOT NULL,
  `couleur_interruption` char(7) NOT NULL,
  `couleur_MNSP` char(7) NOT NULL,
  `couleur_perfectionment` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Couleurs`
--

INSERT INTO `Couleurs` (`couleur_id`, `couleur_centre`, `couleur_pae`, `couleur_certif`, `couleur_ran`, `couleur_vacance_demandees`, `couleur_vacance_validee`, `couleur_autre`, `couleur_ferie`, `couleur_weekend`, `couleur_interruption`, `couleur_MNSP`, `couleur_perfectionment`) VALUES
(1, '#0c39a1', '#ffb3b3', '#32266e', '#0bb116', '#d4ff00', '#b39500', '#9c69e8', '#0dd9b7', '#4f4f4f', '#5f69b4', '#d70404', '#22492a');

-- --------------------------------------------------------

--
-- Structure de la table `Date_autre`
--

CREATE TABLE `Date_autre` (
  `id_autre` int(11) NOT NULL,
  `date_debut_autre` date NOT NULL,
  `date_fin_autre` date NOT NULL,
  `lettre` char(2) NOT NULL,
  `id_formateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_centre`
--

CREATE TABLE `Date_centre` (
  `id_centre` int(11) NOT NULL,
  `date_debut_centre` date DEFAULT NULL,
  `date_fin_centre` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_certif`
--

CREATE TABLE `Date_certif` (
  `id_certif` int(11) NOT NULL,
  `date_debut_certif` date DEFAULT NULL,
  `date_fin_certif` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_intervention`
--

CREATE TABLE `Date_intervention` (
  `id_intervention` int(11) NOT NULL,
  `date_debut_intervention` date DEFAULT NULL,
  `date_fin_intervention` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_MNSP`
--

CREATE TABLE `Date_MNSP` (
  `id_MNSP` int(11) NOT NULL,
  `date_debut_MNSP` date DEFAULT NULL,
  `date_fin_MNSP` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_pae`
--

CREATE TABLE `Date_pae` (
  `id_date_pae` int(11) NOT NULL,
  `date_debut_pae` date DEFAULT NULL,
  `date_fin_pae` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_perfectionnement`
--

CREATE TABLE `Date_perfectionnement` (
  `id_perfectionnement` int(11) NOT NULL,
  `date_debut_perfectionnement` date DEFAULT NULL,
  `date_fin_perfectionnement` date DEFAULT NULL,
  `id_formateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_ran`
--

CREATE TABLE `Date_ran` (
  `id_ran` int(11) NOT NULL,
  `date_debut_ran` date DEFAULT NULL,
  `date_fin_ran` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_teletravail`
--

CREATE TABLE `Date_teletravail` (
  `id_teletravail` int(11) NOT NULL,
  `jour_teletravail` varchar(64) NOT NULL,
  `date_demande_changement` date NOT NULL,
  `date_prise_effet` date DEFAULT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `id_formateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Date_vacance`
--

CREATE TABLE `Date_vacance` (
  `id_vacance` int(11) NOT NULL,
  `date_debut_vacances` date NOT NULL,
  `date_fin_vacances` date NOT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `id_formateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Formateur`
--

CREATE TABLE `Formateur` (
  `id_formateur` int(11) NOT NULL,
  `nom_formateur` varchar(64) NOT NULL,
  `prenom_formateur` varchar(64) NOT NULL,
  `mail_formateur` varchar(128) NOT NULL,
  `mdp_formateur` varchar(255) NOT NULL,
  `type_contrat_formateur` varchar(10) NOT NULL,
  `date_debut_contrat` date DEFAULT NULL,
  `date_fin_contrat` date DEFAULT NULL,
  `permissions_utilisateur` tinyint(4) NOT NULL,
  `numero_grn` int(11) NOT NULL,
  `id_ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Formateur`
--

INSERT INTO `Formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `mail_formateur`, `mdp_formateur`, `type_contrat_formateur`, `date_debut_contrat`, `date_fin_contrat`, `permissions_utilisateur`, `numero_grn`, `id_ville`) VALUES
(1, 'Non', 'Attribue', '', '', '', NULL, NULL, 0, 164, 1),
(2, 'Brunet', 'Veronique', 'veronique.brunet@afpa.fr', '$argon2id$v=19$m=65536,t=4,p=2$Y21XQTRkbkxqTVJZMmVFdw$VLx/a/9JnWOt+a405SR/m5W7nHbYvmH056Jolv2VAWE', 'CDI', NULL, NULL, 1, 180, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Formation`
--

CREATE TABLE `Formation` (
  `id_formation` int(11) NOT NULL,
  `nom_formation` varchar(128) NOT NULL,
  `acronyme_formation` varchar(24) NOT NULL,
  `description_formation` varchar(128) NOT NULL,
  `candidats_formation` varchar(10) NOT NULL,
  `date_debut_formation` date NOT NULL,
  `date_fin_formation` date NOT NULL,
  `numero_grn` int(11) NOT NULL,
  `id_type_formation` int(11) NOT NULL,
  `id_formateur` int(11) NOT NULL,
  `id_ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GRN`
--

CREATE TABLE `GRN` (
  `numero_grn` int(11) NOT NULL,
  `nom_grn` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `GRN`
--

INSERT INTO `GRN` (`numero_grn`, `nom_grn`) VALUES
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
-- Structure de la table `Interruption`
--

CREATE TABLE `Interruption` (
  `id_interruption` int(11) NOT NULL,
  `date_debut_interruption` date DEFAULT NULL,
  `date_fin_interruption` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Logs`
--

CREATE TABLE `Logs` (
  `id` int(11) NOT NULL,
  `user_email` varchar(128) DEFAULT NULL,
  `activity_type` varchar(50) DEFAULT NULL,
  `success` tinyint(4) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Notification`
--

CREATE TABLE `Notification` (
  `id_notification` int(11) NOT NULL,
  `description_notification` varchar(512) DEFAULT NULL,
  `date` varchar(64) NOT NULL,
  `date_notification` datetime DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  `type` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Type_formation`
--

CREATE TABLE `Type_formation` (
  `id_type_formation` int(11) NOT NULL,
  `designation_type_formation` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Type_formation`
--

INSERT INTO `Type_formation` (`id_type_formation`, `designation_type_formation`) VALUES
(1, 'Courte'),
(2, 'Longue'),
(3, 'Continue'),
(4, 'Alternance');

-- --------------------------------------------------------

--
-- Structure de la table `Ville`
--

CREATE TABLE `Ville` (
  `id_ville` int(11) NOT NULL,
  `nom_ville` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Ville`
--

INSERT INTO `Ville` (`id_ville`, `nom_ville`) VALUES
(1, 'Blois'),
(2, 'Tours');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Couleurs`
--
ALTER TABLE `Couleurs`
  ADD PRIMARY KEY (`couleur_id`);

--
-- Index pour la table `Date_autre`
--
ALTER TABLE `Date_autre`
  ADD PRIMARY KEY (`id_autre`),
  ADD KEY `Autre_Formateur_FK` (`id_formateur`);

--
-- Index pour la table `Date_centre`
--
ALTER TABLE `Date_centre`
  ADD PRIMARY KEY (`id_centre`),
  ADD KEY `Date_centre_Formation_FK` (`id_formation`);

--
-- Index pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  ADD PRIMARY KEY (`id_certif`),
  ADD KEY `Date_certif_Formation_FK` (`id_formation`);

--
-- Index pour la table `Date_intervention`
--
ALTER TABLE `Date_intervention`
  ADD PRIMARY KEY (`id_intervention`),
  ADD KEY `Date_intervention_FK` (`id_formateur`),
  ADD KEY `Date_intervention_formation_FK` (`id_formation`);

--
-- Index pour la table `Date_MNSP`
--
ALTER TABLE `Date_MNSP`
  ADD PRIMARY KEY (`id_MNSP`),
  ADD KEY `id_formateur` (`id_formateur`);

--
-- Index pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  ADD PRIMARY KEY (`id_date_pae`),
  ADD KEY `Date_pae_Formation_FK` (`id_formation`);

--
-- Index pour la table `Date_perfectionnement`
--
ALTER TABLE `Date_perfectionnement`
  ADD PRIMARY KEY (`id_perfectionnement`),
  ADD KEY `id_formateur` (`id_formateur`);

--
-- Index pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  ADD PRIMARY KEY (`id_ran`),
  ADD KEY `Date_ran_Formation_FK` (`id_formation`);

--
-- Index pour la table `Date_teletravail`
--
ALTER TABLE `Date_teletravail`
  ADD PRIMARY KEY (`id_teletravail`),
  ADD KEY `Date_teletravail_Formateur_FK` (`id_formateur`);

--
-- Index pour la table `Date_vacance`
--
ALTER TABLE `Date_vacance`
  ADD PRIMARY KEY (`id_vacance`),
  ADD KEY `Date_vacance_Formateur_FK` (`id_formateur`);

--
-- Index pour la table `Formateur`
--
ALTER TABLE `Formateur`
  ADD PRIMARY KEY (`id_formateur`),
  ADD KEY `Formateur_GRN_FK` (`numero_grn`),
  ADD KEY `Formateur_Ville0_FK` (`id_ville`);

--
-- Index pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD PRIMARY KEY (`id_formation`),
  ADD KEY `Formation_GRN_FK` (`numero_grn`),
  ADD KEY `Formation_Type_Formation0_FK` (`id_type_formation`),
  ADD KEY `Formation_Formateur1_FK` (`id_formateur`),
  ADD KEY `Formation_Ville2_FK` (`id_ville`);

--
-- Index pour la table `GRN`
--
ALTER TABLE `GRN`
  ADD PRIMARY KEY (`numero_grn`);

--
-- Index pour la table `Interruption`
--
ALTER TABLE `Interruption`
  ADD PRIMARY KEY (`id_interruption`),
  ADD KEY `Date_interruption_Formation_FK` (`id_formation`);

--
-- Index pour la table `Logs`
--
ALTER TABLE `Logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Notification`
--
ALTER TABLE `Notification`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `Notification_Formateur_FK` (`id_formateur`);

--
-- Index pour la table `Type_formation`
--
ALTER TABLE `Type_formation`
  ADD PRIMARY KEY (`id_type_formation`);

--
-- Index pour la table `Ville`
--
ALTER TABLE `Ville`
  ADD PRIMARY KEY (`id_ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Couleurs`
--
ALTER TABLE `Couleurs`
  MODIFY `couleur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_autre`
--
ALTER TABLE `Date_autre`
  MODIFY `id_autre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_centre`
--
ALTER TABLE `Date_centre`
  MODIFY `id_centre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  MODIFY `id_certif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_intervention`
--
ALTER TABLE `Date_intervention`
  MODIFY `id_intervention` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_MNSP`
--
ALTER TABLE `Date_MNSP`
  MODIFY `id_MNSP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  MODIFY `id_date_pae` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_perfectionnement`
--
ALTER TABLE `Date_perfectionnement`
  MODIFY `id_perfectionnement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  MODIFY `id_ran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_teletravail`
--
ALTER TABLE `Date_teletravail`
  MODIFY `id_teletravail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_vacance`
--
ALTER TABLE `Date_vacance`
  MODIFY `id_vacance` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Formateur`
--
ALTER TABLE `Formateur`
  MODIFY `id_formateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT pour la table `Formation`
--
ALTER TABLE `Formation`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Interruption`
--
ALTER TABLE `Interruption`
  MODIFY `id_interruption` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Logs`
--
ALTER TABLE `Logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Notification`
--
ALTER TABLE `Notification`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Type_formation`
--
ALTER TABLE `Type_formation`
  MODIFY `id_type_formation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Ville`
--
ALTER TABLE `Ville`
  MODIFY `id_ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Date_autre`
--
ALTER TABLE `Date_autre`
  ADD CONSTRAINT `Date_autre_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `Date_centre`
--
ALTER TABLE `Date_centre`
  ADD CONSTRAINT `Date_centre_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  ADD CONSTRAINT `Date_certif_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `Date_intervention`
--
ALTER TABLE `Date_intervention`
  ADD CONSTRAINT `Date_intervention_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`),
  ADD CONSTRAINT `Date_intervention_formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `Date_MNSP`
--
ALTER TABLE `Date_MNSP`
  ADD CONSTRAINT `Date_MNSP_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  ADD CONSTRAINT `Date_pae_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `Date_perfectionnement`
--
ALTER TABLE `Date_perfectionnement`
  ADD CONSTRAINT `Date_perfectionnement_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  ADD CONSTRAINT `Date_ran_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `Date_teletravail`
--
ALTER TABLE `Date_teletravail`
  ADD CONSTRAINT `Date_teletravail_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `Date_vacance`
--
ALTER TABLE `Date_vacance`
  ADD CONSTRAINT `Date_vacance_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);

--
-- Contraintes pour la table `Formateur`
--
ALTER TABLE `Formateur`
  ADD CONSTRAINT `Formateur_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `GRN` (`numero_grn`),
  ADD CONSTRAINT `Formateur_Ville0_FK` FOREIGN KEY (`id_ville`) REFERENCES `Ville` (`id_ville`);

--
-- Contraintes pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD CONSTRAINT `Formation_Formateur1_FK` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`),
  ADD CONSTRAINT `Formation_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `GRN` (`numero_grn`),
  ADD CONSTRAINT `Formation_Type_Formation0_FK` FOREIGN KEY (`id_type_formation`) REFERENCES `Type_formation` (`id_type_formation`),
  ADD CONSTRAINT `Formation_Ville2_FK` FOREIGN KEY (`id_ville`) REFERENCES `Ville` (`id_ville`);

--
-- Contraintes pour la table `Interruption`
--
ALTER TABLE `Interruption`
  ADD CONSTRAINT `Date_interruption_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `Formation` (`id_formation`);

--
-- Contraintes pour la table `Notification`
--
ALTER TABLE `Notification`
  ADD CONSTRAINT `Notification_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `Formateur` (`id_formateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
