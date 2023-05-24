-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 24 mai 2023 à 10:32
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
  `couleur_vacance_demandees` char(7) NOT NULL,
  `couleur_vacance_validee` char(7) NOT NULL,
  `couleur_tt` char(7) NOT NULL,
  `couleur_ferie` char(7) NOT NULL,
  `couleur_weekend` char(7) NOT NULL,
  `couleur_interruption` char(7) NOT NULL,
  `couleur_MNSP` char(7) NOT NULL,
  `couleur_itinerant` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Couleurs`
--

INSERT INTO `Couleurs` (`couleur_id`, `couleur_centre`, `couleur_pae`, `couleur_certif`, `couleur_ran`, `couleur_vacance_demandees`, `couleur_vacance_validee`, `couleur_tt`, `couleur_ferie`, `couleur_weekend`, `couleur_interruption`, `couleur_MNSP`, `couleur_itinerant`) VALUES
(1, '#a10c0c', '#000000', '#000000', '#000000', '#000000', '#6d5775', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000');

-- --------------------------------------------------------

--
-- Structure de la table `Date_centre`
--

CREATE TABLE `Date_centre` (
  `id_centre` int(11) NOT NULL,
  `date_debut_centre` date DEFAULT NULL,
  `date_fin_centre` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Date_centre`
--

INSERT INTO `Date_centre` (`id_centre`, `date_debut_centre`, `date_fin_centre`, `id_formation`) VALUES
(7, '2023-06-01', '2023-06-30', 3),
(8, '2023-05-01', '2023-11-15', 1),
(9, '2024-03-15', '2024-07-25', 1),
(11, '2023-05-01', '2023-07-23', 2),
(12, '2024-01-10', '2025-03-05', 4),
(13, '2023-06-17', '2023-07-13', 4),
(14, '0001-01-01', '0001-01-01', 4),
(15, '2023-06-16', '2023-08-06', 4),
(16, '2024-12-07', '2024-09-08', 4),
(17, '2024-06-10', '2024-06-20', 5);

-- --------------------------------------------------------

--
-- Structure de la table `Date_certif`
--

CREATE TABLE `Date_certif` (
  `id_certif` int(11) NOT NULL,
  `date_debut_certif` date DEFAULT NULL,
  `date_fin_certif` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Date_certif`
--

INSERT INTO `Date_certif` (`id_certif`, `date_debut_certif`, `date_fin_certif`, `id_formation`) VALUES
(4, '2023-07-01', '2023-07-07', 3),
(5, '2024-08-06', '2024-08-10', 1),
(7, '2023-11-01', '2023-11-09', 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Date_intervention`
--

INSERT INTO `Date_intervention` (`id_intervention`, `date_debut_intervention`, `date_fin_intervention`, `id_formateur`, `id_formation`) VALUES
(1, '2023-05-11', '2023-08-24', 4, 1),
(3, '2023-08-25', '2023-09-01', 4, 2),
(4, '2023-09-11', '2024-01-11', 4, 3),
(5, '2023-05-01', '2023-08-17', 3, 2),
(6, '2023-08-24', '2024-02-17', 3, 1),
(7, '2023-05-11', '2023-05-26', 5, 3),
(8, '2024-01-09', '2024-01-15', 3, 4),
(9, '2024-05-10', '2024-05-12', 3, 4),
(10, '2023-06-21', '2023-06-23', 4, 4),
(11, '2023-06-09', '2023-06-19', 3, 4),
(12, '2024-05-29', '2024-09-08', 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Date_pae`
--

CREATE TABLE `Date_pae` (
  `id_date_pae` int(11) NOT NULL,
  `date_debut_pae` date DEFAULT NULL,
  `date_fin_pae` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Date_pae`
--

INSERT INTO `Date_pae` (`id_date_pae`, `date_debut_pae`, `date_fin_pae`, `id_formation`) VALUES
(9, '2023-05-01', '2023-05-31', 3),
(10, '2024-07-26', '2024-08-05', 1),
(11, '2023-11-16', '2024-03-14', 1),
(15, '2023-08-30', '2023-10-07', 2),
(16, '2023-05-10', '2023-06-11', 2),
(17, '2023-06-26', '2023-07-15', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Date_ran`
--

CREATE TABLE `Date_ran` (
  `id_ran` int(11) NOT NULL,
  `date_debut_ran` date DEFAULT NULL,
  `date_fin_ran` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Date_ran`
--

INSERT INTO `Date_ran` (`id_ran`, `date_debut_ran`, `date_fin_ran`, `id_formation`) VALUES
(4, '2023-04-26', '2023-05-07', 3),
(5, '2023-04-26', '2023-04-30', 1),
(7, '2023-04-30', '2023-05-07', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Date_teletravail`
--

CREATE TABLE `Date_teletravail` (
  `id_teletravail` int(11) NOT NULL,
  `jour_teletravail` date NOT NULL,
  `date_demande_changement` date NOT NULL,
  `date_prise_effet` date DEFAULT NULL,
  `validation` tinyint(1) NOT NULL,
  `id_formateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Date_vacance`
--

CREATE TABLE `Date_vacance` (
  `id_vacance` int(11) NOT NULL,
  `date_debut_vacances` date NOT NULL,
  `date_fin_vacances` date NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `id_formateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Date_vacance`
--

INSERT INTO `Date_vacance` (`id_vacance`, `date_debut_vacances`, `date_fin_vacances`, `validation`, `id_formateur`) VALUES
(1, '2023-05-12', '2023-05-19', 0, 4),
(2, '2023-06-01', '2023-06-15', 1, 4),
(3, '2023-07-06', '2023-07-13', 1, 4);

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
  `type_contrat_formateur` char(3) NOT NULL,
  `date_debut_contrat` date DEFAULT NULL,
  `date_fin_contrat` date DEFAULT NULL,
  `permissions_utilisateur` tinyint(4) NOT NULL,
  `numero_grn` int(11) NOT NULL,
  `id_ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Formateur`
--

INSERT INTO `Formateur` (`id_formateur`, `nom_formateur`, `prenom_formateur`, `mail_formateur`, `mdp_formateur`, `type_contrat_formateur`, `date_debut_contrat`, `date_fin_contrat`, `permissions_utilisateur`, `numero_grn`, `id_ville`) VALUES
(1, 'Non', 'Attribue', '', '', '', NULL, NULL, 0, 164, 1),
(2, 'Veronique', 'Veronique', 'veronique@veronique.veronique', '$argon2id$v=19$m=65536,t=4,p=2$N2M3VWl3TEJOMDU5TmhocQ$cC3Y9GMdi52uOX7F/4ckLo9gil7MxnIor+UU3fudVHs', 'AUTRE', NULL, NULL, 1, 164, 1),
(3, 'Bezault', 'Sandy', 'bezo@sendi.afpa', '$argon2id$v=19$m=65536,t=4,p=2$a1NuMWdhQTFnZEhLMkdBbw$FW6Z35tEyozZ4oOQ8r1WIaHcLhJsUhog5hTZ+sC7Qq4', 'CDI', '2014-04-17', '0001-01-01', 0, 164, 1),
(4, 'akbari', 'ali', '110.akbari.98@gmail.com', '$argon2id$v=19$m=65536,t=4,p=2$LzBxZmI4bDdHLzJuNVJEQw$3fjk+b06PEas2BHkfJYJBZ7Kd2jCYwM0zY7kLEPa1TA', 'CDI', '2023-05-02', '0001-01-01', 0, 165, 1),
(5, 'bezo', 'sendi', 'bezo@sendi@affpa.fere', '$argon2id$v=19$m=65536,t=4,p=2$SlprOWFhZldBVHFMbkNsRA$sGKVDFBKPhG28zimfZhFdxLx1AM9XTRt7IpxdjwE3Wo', 'CDD', '2014-04-17', '2023-04-27', 0, 164, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Formation`
--

INSERT INTO `Formation` (`id_formation`, `nom_formation`, `acronyme_formation`, `description_formation`, `candidats_formation`, `date_debut_formation`, `date_fin_formation`, `numero_grn`, `id_type_formation`, `id_formateur`, `id_ville`) VALUES
(1, '164 CDA offre 1099  : 2023-04-30 - 2023-11-09 Tours', 'CDA', ' CDACDACDA', '', '2023-04-30', '2023-11-09', 164, 4, 3, 2),
(2, '164 GUC offre 1983  : 2023-04-26 - 2024-08-10 Tours', 'GUC', ' GUCGUCGUC', '', '2023-04-26', '2024-08-10', 164, 1, 5, 2),
(3, '166 B3 offre 1060 : 2023-04-30 - 2023-11-09 Tours', 'B3', 'B3B3B3B3', '', '2023-04-30', '2023-11-09', 166, 3, 1, 2),
(4, '164 1 1 : 0001-01-01 - 0001-01-01 Blois', '1', '1', '', '0001-01-01', '0001-01-01', 164, 1, 1, 1),
(5, '164 RDC offre 0394 : 2023-05-28 - 2023-09-06 Blois', 'RDC', 'Rez De Chaussée', '13 / 9', '2023-05-28', '2023-09-06', 164, 1, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `GRN`
--

CREATE TABLE `GRN` (
  `numero_grn` int(11) NOT NULL,
  `nom_grn` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `GRN`
--

INSERT INTO `GRN` (`numero_grn`, `nom_grn`) VALUES
(164, 'Informatique'),
(165, 'Commerce'),
(166, 'Design');

-- --------------------------------------------------------

--
-- Structure de la table `Interruption`
--

CREATE TABLE `Interruption` (
  `id_interruption` int(11) NOT NULL,
  `date_debut_interruption` date DEFAULT NULL,
  `date_fin_interruption` date DEFAULT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Interruption`
--

INSERT INTO `Interruption` (`id_interruption`, `date_debut_interruption`, `date_fin_interruption`, `id_formation`) VALUES
(5, '2023-08-01', '2023-11-09', 3),
(8, '2023-04-28', '2023-05-07', 2),
(9, '2023-05-31', '2023-06-11', 2),
(10, '2023-08-09', '2023-08-14', 4),
(11, '2024-07-07', '2024-07-07', 5);

-- --------------------------------------------------------

--
-- Structure de la table `Type_formation`
--

CREATE TABLE `Type_formation` (
  `id_type_formation` int(11) NOT NULL,
  `designation_type_formation` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Index pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  ADD PRIMARY KEY (`id_date_pae`),
  ADD KEY `Date_pae_Formation_FK` (`id_formation`);

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
  MODIFY `couleur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Date_centre`
--
ALTER TABLE `Date_centre`
  MODIFY `id_centre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  MODIFY `id_certif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `Date_intervention`
--
ALTER TABLE `Date_intervention`
  MODIFY `id_intervention` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  MODIFY `id_date_pae` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  MODIFY `id_ran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `Date_teletravail`
--
ALTER TABLE `Date_teletravail`
  MODIFY `id_teletravail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Date_vacance`
--
ALTER TABLE `Date_vacance`
  MODIFY `id_vacance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Formateur`
--
ALTER TABLE `Formateur`
  MODIFY `id_formateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Formation`
--
ALTER TABLE `Formation`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Interruption`
--
ALTER TABLE `Interruption`
  MODIFY `id_interruption` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Contraintes pour la table `Date_centre`
--
ALTER TABLE `Date_centre`
  ADD CONSTRAINT `Date_centre_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `Date_certif`
--
ALTER TABLE `Date_certif`
  ADD CONSTRAINT `Date_certif_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `Date_intervention`
--
ALTER TABLE `Date_intervention`
  ADD CONSTRAINT `Date_intervention_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `Date_intervention_formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `Date_pae`
--
ALTER TABLE `Date_pae`
  ADD CONSTRAINT `Date_pae_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `Date_ran`
--
ALTER TABLE `Date_ran`
  ADD CONSTRAINT `Date_ran_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `Date_teletravail`
--
ALTER TABLE `Date_teletravail`
  ADD CONSTRAINT `Date_teletravail_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `Date_vacance`
--
ALTER TABLE `Date_vacance`
  ADD CONSTRAINT `Date_vacance_Formateur_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`);

--
-- Contraintes pour la table `Formateur`
--
ALTER TABLE `Formateur`
  ADD CONSTRAINT `Formateur_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `grn` (`numero_grn`),
  ADD CONSTRAINT `Formateur_Ville0_FK` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD CONSTRAINT `Formation_Formateur1_FK` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `Formation_GRN_FK` FOREIGN KEY (`numero_grn`) REFERENCES `grn` (`numero_grn`),
  ADD CONSTRAINT `Formation_Type_Formation0_FK` FOREIGN KEY (`id_type_formation`) REFERENCES `type_formation` (`id_type_formation`),
  ADD CONSTRAINT `Formation_Ville2_FK` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `Interruption`
--
ALTER TABLE `Interruption`
  ADD CONSTRAINT `Date_interruption_Formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
