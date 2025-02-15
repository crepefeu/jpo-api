-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 15 mai 2024 à 17:15
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jpo_iut_meaux_mmi`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `displayName` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `displayName`, `login`, `password`) VALUES
(1, 'Esteban', 'esteban', '$2y$10$MbF0JXFXfJL/zbQCoZEt5.FJvks7HSeqzEbkUk5rl2gmKsq4HLWG2');

-- --------------------------------------------------------

--
-- Structure de la table `analyticsSnapshots`
--

CREATE TABLE `analyticsSnapshots` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `attendeesCount` int(11) NOT NULL,
  `numberOfNewAttendees` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `analyticsSnapshots`
--

INSERT INTO `analyticsSnapshots` (`id`, `date`, `attendeesCount`, `numberOfNewAttendees`) VALUES
(1, '2024-01-04 10:55:26', 0, 0),
(2, '2024-01-05 10:55:26', 1, 1),
(3, '2024-01-06 10:55:26', 3, 2),
(4, '2024-01-07 10:55:26', 4, 1),
(5, '2024-01-08 10:55:26', 5, 1),
(6, '2024-01-09 10:55:26', 5, 0),
(7, '2024-01-10 10:55:26', 9, 4);

-- --------------------------------------------------------

--
-- Structure de la table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(256) NOT NULL,
  `diplomaId` int(11) NOT NULL,
  `diplomaCategoryId` int(11) NOT NULL,
  `isIrlAttendee` tinyint(1) NOT NULL,
  `regionalCode` varchar(9) NOT NULL,
  `virtualTourSatisfaction` int(11) DEFAULT NULL,
  `websiteSatisfaction` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `attendees`
--

INSERT INTO `attendees` (`id`, `firstName`, `lastName`, `email`, `diplomaId`, `diplomaCategoryId`, `isIrlAttendee`, `regionalCode`, `virtualTourSatisfaction`, `websiteSatisfaction`) VALUES
(1, 'Esteban', 'Rodriguez', 'esteban.rodriguez@live.fr', 9, 2, 1, 'fr-idf-ss', 0, 0),
(2, 'Emy', 'Dupont', 'emyrng@gmail.com', 16, 2, 1, 'fr-idf-vm', 0, 0),
(3, 'Benoit', 'Gauvin', 'benoitgauvin@gmail.com', 9, 2, 0, 'fr-idf-se', 1, 0),
(4, 'Alexandre', 'Moreau', 'alexandre.moreau@gmail.com', 45, 21, 1, 'fr-idf-vm', 2, 2),
(5, 'Léo', 'Guttin', 'leo.guttin01@gmail.com', 17, 2, 1, 'fr-naq-cm', 0, 0),
(6, 'Marceau', 'Leroux', 'leroux.marceau2345@outlook.fr', 45, 21, 1, 'fr-ges-br', 0, 0),
(7, 'Matteo', 'Legrand', 'lgd.matteo@gmail.com', 45, 21, 0, 'fr-hdf-pc', 1, 1),
(8, 'Rayane', 'Masmoudi', 'msmd.rayane@gmail.com', 50, 21, 1, 'fr-idf-ss', NULL, NULL),
(9, 'Rayane', 'Abidar', 'rayaneabd@gmail.com', 18, 5, 1, 'fr-idf-vm', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `diplomaCategories`
--

CREATE TABLE `diplomaCategories` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `diplomaCategories`
--

INSERT INTO `diplomaCategories` (`id`, `categoryName`) VALUES
(2, 'Baccalauréat général'),
(5, 'Licence'),
(21, 'Baccalauréat technologique'),
(22, 'Certificat d\'aptitude professionnelle (CAP)');

-- --------------------------------------------------------

--
-- Structure de la table `diplomaTypes`
--

CREATE TABLE `diplomaTypes` (
  `diplomaId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `diplomaName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `diplomaTypes`
--

INSERT INTO `diplomaTypes` (`diplomaId`, `categoryId`, `diplomaName`) VALUES
(9, 2, 'Bac S (Scientifique)'),
(16, 2, 'Bac L (Littéraire)'),
(17, 2, 'Bac ES (Économique et Social)'),
(18, 5, 'Licence'),
(45, 21, 'STI2D'),
(47, 21, 'STMG'),
(48, 21, 'STD2A'),
(49, 21, 'STL'),
(50, 21, 'ST2S'),
(51, 21, 'STAV'),
(52, 21, 'S2TMD');

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

CREATE TABLE `regions` (
  `code` varchar(9) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `regions`
--

INSERT INTO `regions` (`code`, `name`) VALUES
('fr-ara-ah', 'Ardèche'),
('fr-ara-ai', 'Ain'),
('fr-ara-al', 'Allier'),
('fr-ara-cl', 'Cantal'),
('fr-ara-dm', 'Drôme'),
('fr-ara-hl', 'Haute-Loire'),
('fr-ara-hs', 'Haute-Savoie'),
('fr-ara-is', 'Isère'),
('fr-ara-lr', 'Loire'),
('fr-ara-pd', 'Puy-de-Dôme'),
('fr-ara-rh', 'Rhône'),
('fr-ara-sv', 'Savoie'),
('fr-bfc-co', 'Côte-d\'Or'),
('fr-bfc-db', 'Doubs'),
('fr-bfc-hn', 'Haute-Saône'),
('fr-bfc-ju', 'Jura'),
('fr-bfc-ni', 'Nièvre'),
('fr-bfc-sl', 'Saône-et-Loire'),
('fr-bfc-tb', 'Territoire de Belfort'),
('fr-bfc-yo', 'Yonne'),
('fr-bre-ca', 'Côtes-d\'Armor'),
('fr-bre-fi', 'Finistère'),
('fr-bre-iv', 'Ille-et-Vilaine'),
('fr-bre-mb', 'Morbian'),
('fr-cor-cs', 'Corse-du-Sud'),
('fr-cor-hc', 'Haute-Corse'),
('fr-cvl-ch', 'Cher'),
('fr-cvl-el', 'Eure-et-Loir'),
('fr-cvl-il', 'Indre-et-Loire'),
('fr-cvl-in', 'Indre'),
('fr-cvl-lc', 'Loir-et-Cher'),
('fr-cvl-lt', 'Loiret'),
('fr-ges-ab', 'Aube'),
('fr-ges-an', 'Ardennes'),
('fr-ges-br', 'Bas-Rhin'),
('fr-ges-hm', 'Haute-Marne'),
('fr-ges-hr', 'Haut-Rhin'),
('fr-ges-mm', 'Meurthe-et-Moselle'),
('fr-ges-mo', 'Moselle'),
('fr-ges-mr', 'Marne'),
('fr-ges-ms', 'Meuse'),
('fr-ges-vg', 'Vosges'),
('fr-gf-gf', 'Guyanne française'),
('fr-gua-gp', 'Guadeloupe'),
('fr-hdf-as', 'Aisne'),
('fr-hdf-no', 'Nord'),
('fr-hdf-oi', 'Oise'),
('fr-hdf-pc', 'Pas-de-Calais'),
('fr-hdf-so', 'Somme'),
('fr-idf-es', 'Essonne'),
('fr-idf-hd', 'Hauts-de-Seine'),
('fr-idf-se', 'Seine-et-Marne'),
('fr-idf-ss', 'Seine-Saint-Denis'),
('fr-idf-vm', 'Val-de-Marne'),
('fr-idf-vo', 'Val-d\'Oise'),
('fr-idf-vp', 'Paris'),
('fr-idf-yv', 'Yvelines'),
('fr-lre-re', 'La Réunion'),
('fr-may-yt', 'Mayotte'),
('fr-mq-mq', 'Martinique'),
('fr-naq-cm', 'Charente-Maritime'),
('fr-naq-cr', 'Creuse'),
('fr-naq-ct', 'Charente'),
('fr-naq-cz', 'Corrèze'),
('fr-naq-dd', 'Dordogne'),
('fr-naq-ds', 'Deux-Sèvres'),
('fr-naq-gi', 'Gironde'),
('fr-naq-hv', 'Haute-Vienne'),
('fr-naq-ld', 'Landes'),
('fr-naq-lg', 'Lot-et-Garonne'),
('fr-naq-pa', 'Pyrénées-Atlantiques'),
('fr-naq-vn', 'Vienne'),
('fr-nor-cv', 'Calvados'),
('fr-nor-eu', 'Eure'),
('fr-nor-mh', 'Manche'),
('fr-nor-or', 'Orne'),
('fr-nor-sm', 'Seine-Maritime'),
('fr-occ-ad', 'Aude'),
('fr-occ-ag', 'Ariège'),
('fr-occ-av', 'Aveyron'),
('fr-occ-ga', 'Gard'),
('fr-occ-ge', 'Gers'),
('fr-occ-he', 'Hérault'),
('fr-occ-hg', 'Haute-Garonne'),
('fr-occ-hp', 'Haute-Pyrénées'),
('fr-occ-lo', 'Lot'),
('fr-occ-lz', 'Lozère'),
('fr-occ-po', 'Pyrénées-Orientales'),
('fr-occ-ta', 'Tarn'),
('fr-occ-tg', 'Tarn-et-Garonne'),
('fr-pac-am', 'Alpes-Maritimes'),
('fr-pac-ap', 'Alpes-De-Haute-Provence'),
('fr-pac-bd', 'Bouches-Du-Rhônefr-occ-av'),
('fr-pac-ha', 'Hautes-Alpes'),
('fr-pac-vc', 'Vaucluse'),
('fr-pac-vr', 'Var'),
('fr-pdl-la', 'Loire-Atlantique'),
('fr-pdl-ml', 'Maine-et-Loire'),
('fr-pdl-my', 'Mayennes'),
('fr-pdl-st', 'Sarthe'),
('fr-pdl-vd', 'Vendée');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `adminId`, `token`, `date`) VALUES
(1, 1, 'f32ccd0b92a2bf60361f10ba2ca1b73b4ac8f393ebdac968973fc353c4c7b694', '2024-01-10 15:32:37'),
(2, 1, 'ff0f9843fee3b269c4234e49a082a9804ea777dba28175d6181ebd3e288efb54', '2024-01-11 10:51:57'),
(3, 1, '5759a7bbdaecf10b60eecea4cebaf768aaf029d402034a0c4488968810a65e0b', '2024-01-11 14:19:34'),
(4, 1, 'e25d7ccf9e4de617ca66aad5b3f83518085987f461692393398b0d96197bf845', '2024-01-11 14:39:54'),
(5, 1, '4db649e689e973b2bf14a5d445a068cefc90279e853f1e5e5d6bd5630dc2c25e', '2024-01-11 14:53:13'),
(6, 1, '1a4f32bc997169c15516e8cabbe362701082cb9abf67e66443b485150ff06abe', '2024-01-11 15:15:19'),
(7, 1, '9e8692968fe2e4900c65341bcbdb05160fd057ada91138284cd6b7143bcf8268', '2024-02-18 16:08:46');

-- --------------------------------------------------------

--
-- Structure de la table `userPreferences`
--

CREATE TABLE `userPreferences` (
  `adminId` int(11) NOT NULL,
  `defaultTheme` varchar(256) NOT NULL,
  `showPercentagesOnCharts` tinyint(1) NOT NULL,
  `showLegendOnCharts` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `userPreferences`
--

INSERT INTO `userPreferences` (`adminId`, `defaultTheme`, `showPercentagesOnCharts`, `showLegendOnCharts`) VALUES
(1, 'light', 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `analyticsSnapshots`
--
ALTER TABLE `analyticsSnapshots`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_DIPLOMA_ID` (`diplomaId`),
  ADD KEY `FK_DIPLOMA_CATEGORY_ID` (`diplomaCategoryId`),
  ADD KEY `FK_REGIONAL_CODE` (`regionalCode`);

--
-- Index pour la table `diplomaCategories`
--
ALTER TABLE `diplomaCategories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `diplomaTypes`
--
ALTER TABLE `diplomaTypes`
  ADD PRIMARY KEY (`diplomaId`),
  ADD KEY `FK_DIPLOMA_CATEGORY` (`categoryId`);

--
-- Index pour la table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ADMIN_ID` (`adminId`);

--
-- Index pour la table `userPreferences`
--
ALTER TABLE `userPreferences`
  ADD PRIMARY KEY (`adminId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `analyticsSnapshots`
--
ALTER TABLE `analyticsSnapshots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `diplomaCategories`
--
ALTER TABLE `diplomaCategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `diplomaTypes`
--
ALTER TABLE `diplomaTypes`
  MODIFY `diplomaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `FK_DIPLOMA_CATEGORY_ID` FOREIGN KEY (`diplomaCategoryId`) REFERENCES `diplomaCategories` (`id`),
  ADD CONSTRAINT `FK_DIPLOMA_ID` FOREIGN KEY (`diplomaId`) REFERENCES `diplomaTypes` (`diplomaId`),
  ADD CONSTRAINT `FK_REGIONAL_CODE` FOREIGN KEY (`regionalCode`) REFERENCES `regions` (`code`);

--
-- Contraintes pour la table `diplomaTypes`
--
ALTER TABLE `diplomaTypes`
  ADD CONSTRAINT `FK_DIPLOMA_CATEGORY` FOREIGN KEY (`categoryId`) REFERENCES `diplomaCategories` (`id`);

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `FK_ADMIN_ID` FOREIGN KEY (`adminId`) REFERENCES `admins` (`id`);

--
-- Contraintes pour la table `userPreferences`
--
ALTER TABLE `userPreferences`
  ADD CONSTRAINT `FK_USER_PREFERENCES_ADMINID` FOREIGN KEY (`adminId`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
