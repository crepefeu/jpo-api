-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 23 fév. 2025 à 10:58
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
  `displayName` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `id` varchar(36) NOT NULL DEFAULT (UUID())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`displayName`, `login`, `password`, `id`) VALUES
('Esteban', 'esteban', '$2y$10$MbF0JXFXfJL/zbQCoZEt5.FJvks7HSeqzEbkUk5rl2gmKsq4HLWG2', 'b8a7022e-ebb0-11ef-b826-4677500d9c58');

-- --------------------------------------------------------

--
-- Structure de la table `analyticsSnapshots`
--

CREATE TABLE `analyticsSnapshots` (
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `attendeesCount` int(11) NOT NULL,
  `numberOfNewAttendees` int(11) NOT NULL,
  `id` varchar(36) NOT NULL DEFAULT (UUID())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `analyticsSnapshots`
--

INSERT INTO `analyticsSnapshots` (`date`, `attendeesCount`, `numberOfNewAttendees`, `id`) VALUES
('2024-01-04 10:55:26', 0, 0, 'b8a89846-ebb0-11ef-b826-4677500d9c58'),
('2024-01-05 10:55:26', 1, 1, 'b8a8990e-ebb0-11ef-b826-4677500d9c58'),
('2024-01-06 10:55:26', 3, 2, 'b8a89940-ebb0-11ef-b826-4677500d9c58'),
('2024-01-07 10:55:26', 4, 1, 'b8a89968-ebb0-11ef-b826-4677500d9c58'),
('2024-01-08 10:55:26', 5, 1, 'b8a89986-ebb0-11ef-b826-4677500d9c58'),
('2024-01-09 10:55:26', 5, 0, 'b8a899ae-ebb0-11ef-b826-4677500d9c58'),
('2024-01-10 10:55:26', 9, 4, 'b8a899d6-ebb0-11ef-b826-4677500d9c58');

-- --------------------------------------------------------

--
-- Structure de la table `attendees`
--

CREATE TABLE `attendees` (
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(256) NOT NULL,
  `isIrlAttendee` tinyint(1) NOT NULL,
  `regionalCode` varchar(9) NOT NULL,
  `virtualTourSatisfaction` int(11) DEFAULT NULL,
  `websiteSatisfaction` int(11) DEFAULT NULL,
  `id` varchar(36) NOT NULL DEFAULT (UUID()),
  `diplomaId` varchar(36) NOT NULL,
  `diplomaCategoryId` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `attendees`
--

INSERT INTO `attendees` (`firstName`, `lastName`, `email`, `isIrlAttendee`, `regionalCode`, `virtualTourSatisfaction`, `websiteSatisfaction`, `id`, `diplomaId`, `diplomaCategoryId`) VALUES
('Esteban', 'Rodriguez', 'esteban.rodriguez@live.fr', 1, 'fr-idf-ss', 0, 0, 'b8a9f560-ebb0-11ef-b826-4677500d9c58', 'b8a9827e-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Emy', 'Dupont', 'emyrng@gmail.com', 1, 'fr-idf-vm', 0, 0, 'b8a9f9c0-ebb0-11ef-b826-4677500d9c58', 'b8a98378-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Benoit', 'Gauvin', 'benoitgauvin@gmail.com', 0, 'fr-idf-se', 1, 0, 'b8a9f9f2-ebb0-11ef-b826-4677500d9c58', 'b8a9827e-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Alexandre', 'Moreau', 'alexandre.moreau@gmail.com', 1, 'fr-idf-vm', 2, 2, 'b8a9fa1a-ebb0-11ef-b826-4677500d9c58', 'b8a983fa-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('Léo', 'Guttin', 'leo.guttin01@gmail.com', 1, 'fr-naq-cm', 0, 0, 'b8a9fa4c-ebb0-11ef-b826-4677500d9c58', 'b8a983b4-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Marceau', 'Leroux', 'leroux.marceau2345@outlook.fr', 1, 'fr-ges-br', 0, 0, 'b8a9fa74-ebb0-11ef-b826-4677500d9c58', 'b8a983fa-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('Matteo', 'Legrand', 'lgd.matteo@gmail.com', 0, 'fr-hdf-pc', 1, 1, 'b8a9fa9c-ebb0-11ef-b826-4677500d9c58', 'b8a983fa-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('Rayane', 'Masmoudi', 'msmd.rayane@gmail.com', 1, 'fr-idf-ss', NULL, NULL, 'b8a9fac4-ebb0-11ef-b826-4677500d9c58', 'b8a98490-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('Rayane', 'Abidar', 'rayaneabd@gmail.com', 1, 'fr-idf-vm', NULL, NULL, 'b8a9faec-ebb0-11ef-b826-4677500d9c58', 'b8a983dc-ebb0-11ef-b826-4677500d9c58', 'b8a90dc6-ebb0-11ef-b826-4677500d9c58');

-- --------------------------------------------------------

--
-- Structure de la table `diplomaCategories`
--

CREATE TABLE `diplomaCategories` (
  `categoryName` varchar(256) NOT NULL,
  `id` varchar(36) NOT NULL DEFAULT (UUID())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `diplomaCategories`
--

INSERT INTO `diplomaCategories` (`categoryName`, `id`) VALUES
('Baccalauréat général', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Licence', 'b8a90dc6-ebb0-11ef-b826-4677500d9c58'),
('Baccalauréat technologique', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('Certificat d\'aptitude professionnelle (CAP)', 'b8a90e20-ebb0-11ef-b826-4677500d9c58');

-- --------------------------------------------------------

--
-- Structure de la table `diplomaTypes`
--

CREATE TABLE `diplomaTypes` (
  `diplomaName` varchar(256) NOT NULL,
  `id` varchar(36) NOT NULL DEFAULT (UUID()),
  `categoryId` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `diplomaTypes`
--

INSERT INTO `diplomaTypes` (`diplomaName`, `id`, `categoryId`) VALUES
('Bac S (Scientifique)', 'b8a9827e-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Bac L (Littéraire)', 'b8a98378-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Bac ES (Économique et Social)', 'b8a983b4-ebb0-11ef-b826-4677500d9c58', 'b8a90d3a-ebb0-11ef-b826-4677500d9c58'),
('Licence', 'b8a983dc-ebb0-11ef-b826-4677500d9c58', 'b8a90dc6-ebb0-11ef-b826-4677500d9c58'),
('STI2D', 'b8a983fa-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('STMG', 'b8a98422-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('STD2A', 'b8a9844a-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('STL', 'b8a98468-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('ST2S', 'b8a98490-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('STAV', 'b8a984ae-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58'),
('S2TMD', 'b8a984d6-ebb0-11ef-b826-4677500d9c58', 'b8a90df8-ebb0-11ef-b826-4677500d9c58');

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
  `token` varchar(64) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `id` varchar(36) NOT NULL DEFAULT (UUID()),
  `adminId` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`token`, `date`, `id`, `adminId`) VALUES
('424ec64e-d95d-4d3b-9c11-5e944d2f292c', '2025-02-16 15:27:05', '186017ac-ec72-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('948f2010-2b76-4fcc-9d9c-f5f8b77e8666', '2025-02-16 15:20:16', '24ec6e4a-ec71-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('c11d1b46-fdd3-4b86-8ada-411aeefa7358', '2025-02-16 15:35:26', '437c3a0a-ec73-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('3c4cb4d7-3f29-4e1a-90c4-1d75ab22bb3f', '2025-02-16 14:23:56', '467bdf4e-ec69-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('eb1ccca9-7ea9-426a-99d0-40bc9032aa1f', '2025-02-16 14:32:56', '882c6804-ec6a-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('7549e54a-ad73-47eb-bdf8-e13dfdb8e7d3', '2025-02-19 19:44:35', '907df62e-eef1-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('1e3b474a-eb94-4c0c-a9b3-238a6f37b85a', '2025-02-16 14:33:24', '9883de9e-ec6a-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('e78fd992-cd8f-491e-a4aa-aaa7c6a33a23', '2025-02-19 19:37:53', 'a1641078-eef0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('8ca28a8c-7a97-42cc-8413-ebcd4e97c53c', '2025-02-16 14:27:07', 'b7e6bece-ec69-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('f32ccd0b92a2bf60361f10ba2ca1b73b4ac8f393ebdac968973fc353c4c7b694', '2024-01-10 15:32:37', 'b8a81fba-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('ff0f9843fee3b269c4234e49a082a9804ea777dba28175d6181ebd3e288efb54', '2024-01-11 10:51:57', 'b8a8203c-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('5759a7bbdaecf10b60eecea4cebaf768aaf029d402034a0c4488968810a65e0b', '2024-01-11 14:19:34', 'b8a8206e-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('e25d7ccf9e4de617ca66aad5b3f83518085987f461692393398b0d96197bf845', '2024-01-11 14:39:54', 'b8a82096-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('4db649e689e973b2bf14a5d445a068cefc90279e853f1e5e5d6bd5630dc2c25e', '2024-01-11 14:53:13', 'b8a820be-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('1a4f32bc997169c15516e8cabbe362701082cb9abf67e66443b485150ff06abe', '2024-01-11 15:15:19', 'b8a820e6-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('9e8692968fe2e4900c65341bcbdb05160fd057ada91138284cd6b7143bcf8268', '2024-02-18 16:08:46', 'b8a82104-ebb0-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('06ef16b0-64b8-49a2-a767-65d5fe3b2cd0', '2025-02-22 00:02:20', 'e740ace2-f0a7-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('a028d285-02e2-4159-b130-58abb1654c18', '2025-02-16 14:28:36', 'ed3928b4-ec69-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58'),
('f4b837ad-2f19-45fd-95c1-05194e329b88', '2025-02-16 15:18:46', 'ef774668-ec70-11ef-b826-4677500d9c58', 'b8a7022e-ebb0-11ef-b826-4677500d9c58');

-- --------------------------------------------------------

--
-- Structure de la table `userPreferences`
--

CREATE TABLE `userPreferences` (
  `defaultTheme` varchar(256) NOT NULL,
  `showPercentagesOnCharts` tinyint(1) NOT NULL,
  `showLegendOnCharts` tinyint(1) NOT NULL,
  `adminId` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `userPreferences`
--

INSERT INTO `userPreferences` (`defaultTheme`, `showPercentagesOnCharts`, `showLegendOnCharts`, `adminId`) VALUES
('dark', 1, 1, 'b8a7022e-ebb0-11ef-b826-4677500d9c58');

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
  ADD KEY `FK_REGIONAL_CODE` (`regionalCode`),
  ADD KEY `FK_DIPLOMA_ID` (`diplomaId`),
  ADD KEY `FK_DIPLOMA_CATEGORY_ID` (`diplomaCategoryId`);

--
-- Index pour la table `diplomaCategories`
--
ALTER TABLE `diplomaCategories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `diplomaTypes`
--
ALTER TABLE `diplomaTypes`
  ADD PRIMARY KEY (`id`),
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
  ADD KEY `FK_USER_PREFERENCES_ADMINID` (`adminId`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `FK_DIPLOMA_CATEGORY_ID` FOREIGN KEY (`diplomaCategoryId`) REFERENCES `diplomaCategories` (`id`),
  ADD CONSTRAINT `FK_DIPLOMA_ID` FOREIGN KEY (`diplomaId`) REFERENCES `diplomaTypes` (`id`),
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
