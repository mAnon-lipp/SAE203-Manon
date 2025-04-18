-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 17 avr. 2025 à 18:20
-- Version du serveur : 10.11.11-MariaDB-0+deb12u1
-- Version de PHP : 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lippler1`
--

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Comédie'),
(3, 'Drame'),
(4, 'Science-fiction'),
(5, 'Animation'),
(6, 'Thriller'),
(7, 'Horreur'),
(8, 'Aventure'),
(9, 'Fantaisie'),
(10, 'Documentaire'),
(11, 'Romance');

-- --------------------------------------------------------

--
-- Structure de la table `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','deleted') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Comments`
--

INSERT INTO `Comments` (`id`, `movie_id`, `profile_id`, `comment`, `created_at`, `status`) VALUES
(2, 17, 1, 'Un banger absolue', '2025-04-10 14:43:54', 'deleted'),
(3, 63, 1, 'J\'adore', '2025-04-10 18:18:51', 'approved'),
(4, 70, 3, 'Une pépite', '2025-04-14 09:50:05', 'approved'),
(5, 70, 4, 'Une pépite', '2025-04-14 09:50:32', 'deleted'),
(7, 17, 4, 'x', '2025-04-14 15:38:08', 'deleted'),
(8, 7, 2, 'Cool', '2025-04-15 10:32:14', 'approved'),
(9, 64, 3, 'J\'ai eu trop peur', '2025-04-15 10:43:09', 'approved'),
(10, 68, 3, 'gfds', '2025-04-15 13:35:56', 'deleted'),
(11, 67, 9, 'La scene du poeme m\'a fait pleurer', '2025-04-16 12:16:50', 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `Favorites`
--

CREATE TABLE `Favorites` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Favorites`
--

INSERT INTO `Favorites` (`id`, `profile_id`, `movie_id`) VALUES
(13, 3, 12),
(14, 4, 17),
(25, 11, 27),
(37, 2, 27),
(38, 3, 17);

-- --------------------------------------------------------

--
-- Structure de la table `Movie`
--

CREATE TABLE `Movie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `min_age` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `Movie`
--

INSERT INTO `Movie` (`id`, `name`, `year`, `length`, `description`, `director`, `id_category`, `image`, `trailer`, `min_age`, `is_featured`, `created_at`) VALUES
(7, 'Interstellar', 2014, 169, 'Un groupe d\'explorateurs voyage à travers un trou de ver pour sauver l\'humanité.', 'Christopher Nolan', 4, 'interstellar.jpg', 'https://www.youtube.com/embed/VaOijhK3CRU?si=76Ke4uw4LYjuLuQ6', 12, 0, '2025-04-01 16:26:41'),
(12, 'La Liste de Schindler', 1993, 195, 'Un industriel allemand sauve des milliers de Juifs pendant l\'Holocauste.', 'Steven Spielberg', 3, 'schindler.webp', 'https://www.youtube.com/embed/ONWtyxzl-GE?si=xC3ASGGPy5Ib-aPn', 16, 0, '2025-03-31 22:00:00'),
(17, 'Your Name', 2016, 107, 'Deux adolescents échangent leurs corps de manière mystérieuse.', 'Makoto Shinkai', 5, 'your_name.jpg', 'https://www.youtube.com/embed/AROOK45LXXg?si=aUQyGk2VMCb_ToUL', 10, 1, '2025-04-10 16:26:41'),
(27, 'Le Bon, la Brute et le Truand', 1966, 161, 'Trois hommes se lancent à la recherche d\'un trésor caché.', 'Sergio Leone', 8, 'bon_brute_truand.jpg', 'https://www.youtube.com/embed/WA1hCZFOPqs?si=TwNZAoM4oj4KpGja', 12, 0, '2025-04-10 16:26:41'),
(63, 'Harry Potter', 2004, 142, 'Sirius Black, un dangereux sorcier criminel, s\'échappe de la sombre prison d\'Azkaban avec un seul et unique but : se venger d\'Harry Potter, entré avec ses amis Ron et Hermione en troisième année à l\'école de sorcellerie de Poudlard, où ils auront aussi à faire avec les terrifiants Détraqueurs.', 'Alfonso Cuarón', 9, 'hp.jpg', 'https://www.youtube.com/embed/CLncEeVf4ks?si=L5G7ivfNWOsNIYyg', 10, 1, '2025-04-10 16:26:41'),
(64, 'Massacre à la tronçonneuse', 1974, 84, 'Alors qu\'au fin fond du Texas les habitants d\'un petit village isolé découvrent que leur cimetière a été profané, cinq jeunes amis traversent la région dans leur minibus. Sur la route, le groupe accueille à bord de leur véhicule un auto-stoppeur. Cependant, lorsque l\'individu, au comportement étrange, se fait menaçant, les amis décident de l\'expulser avant de continuer leur route.', '	Tobe Hooper', 7, 'massacre.jpg', 'https://www.youtube.com/embed/VeeTHUQDQ5w?si=RcWuhOoVhAkuWTAd', 18, 0, '2025-04-10 16:26:41'),
(65, 'Les dents de la mer', 1975, 124, 'À quelques jours du début de la saison estivale, les habitants de la petite station balnéaire d\'Amity sont en émoi face à la découverte, sur le littoral, du corps atrocement mutilé d\'une jeune vacancière. Pour Martin Brody, le chef de la police, il ne fait aucun doute que la jeune fille a été victime d\'un requin. Il décide alors d\'interdire l\'accès des plages mais se heurte à l\'hostilité du maire, uniquement intéressé par l\'afflux des touristes.', 'Steven Spielberg', 7, 'mer.jpg', 'https://www.youtube.com/embed/BlqvX50DSNo?si=5PDZTJ9fqFFWgHiw', 12, 0, '2025-04-10 16:26:41'),
(66, 'Twilight, chapitre I : Fascination', 2008, 122, 'Bella Swan, 17 ans, quitte l\'Arizona, État ensoleillé où elle vivait avec sa mère et son beau-père pour emménager chez son père Charlie à Forks, une petite ville pluvieuse et grise de l\'État de Washington. Au lycée, elle rencontre la mystérieuse famille Cullen et se sent tout de suite attirée par Edward (le plus jeune de la famille) extrêmement séduisant mais distant.  De plus en plus fascinée par lui et sa famille, Bella décide de mener l\'enquête et découvre qu\'Edward Cullen est un vampire capable de lire dans les pensées de tout le monde sauf elle.', 'Catherine Hardwicke', 11, 'twilight.webp', 'https://www.youtube.com/embed/QftDMpqQSVE?si=dnU-mGQIk_1ja7P-', 12, 0, '2025-04-11 09:37:03'),
(67, '10 things i hate about you', 1999, 97, 'Kat Stratford n\'attire pas beaucoup de garçons à cause de son caractère abrasif. Malheureusement pour sa soeur cadette, Bianca, elle n\'a pas le droit de sortir avec des garçons avant sa soeur aînée, Kat. C\'est alors que le prétendant de Bianca tente de trouver une solution. Il décide de payer un garçon pour séduire Kat.', 'Andrew Lazar', 11, 'ten.png', 'https://www.youtube.com/embed/uE7qjQlfoRs?si=y1itjJx4f2-Vb49K', 0, 0, '2025-04-11 16:30:39'),
(68, 'Legally blonde', 2001, 96, 'Elle Woods ne se contente pas d\'être une vraie blonde au sourire éclatant et au look d\'enfer. Malheureusement, les ambitions politiques de son fiancé s\'accommodent mal d\'une compagne blonde. C\'est ainsi qu\'un triste soir, Elle se voit larguée par l\'homme de sa vie. Malgré cette rupture soudaine et inattendue, celle-ci est bien décidée à prouver ses capacités et s\'inscrit en droit à Harvard pour faire la conquête de la plus prestigieuse université américaine.', 'Robert Luketic', 2, 'blonde.jpg', 'https://www.youtube.com/embed/vWOHwI_FgAo?si=5ThNtARRvZLdhw8B', 0, 0, '2025-04-11 16:33:04'),
(69, 'Call Me by Your Name', 2017, 132, 'Été 1983. Elio Perlman, 17 ans, passe ses vacances dans la villa du XVIIe siècle que possède sa famille en Italie, à jouer de la musique classique, à lire et à flirter avec son amie Marzia. Son père, éminent professeur, et sa mère, traductrice, lui ont donné une excellente éducation. Un jour, Oliver, un séduisant Américain qui prépare son doctorat, vient travailler auprès du père d\'Elio. Elio et Oliver vont bientôt découvrir l\'éveil du désir.', 'Luca Guadagnino', 3, 'cmbyn.webp', 'https://www.youtube.com/embed/-pkhSA1YF40?si=xa-7kqDjgsgAZzeJ', 16, 1, '2025-04-11 16:35:41'),
(70, 'Imitation Game', 2014, 114, 'Londres, 1940. L\'Angleterre est en guerre contre l\'Allemagne nazie, dont les forces occupent une grande partie de l\'Europe', 'Morten Tyldum', 3, 'imitation.jpg', 'https://www.youtube.com/embed/YmeEz6cQrwM?si=x00M7d3Ih_rwuvZW', 13, 1, '2025-04-11 16:38:17'),
(71, 'Forrest Gump', 1994, 140, 'Quelques décennies d\'histoire américaine, des années 1940 à la fin du XXème siècle, à travers le regard et l\'étrange odyssée d\'un homme simple et pur, Forrest Gump.', 'Robert Zemeckis', 3, 'forrest.webp', 'https://www.youtube.com/embed/bLvqoHBptjg?si=wV8OEp2PucdXfBoh', 0, 0, '2025-04-17 13:22:57');

-- --------------------------------------------------------

--
-- Structure de la table `Profil`
--

CREATE TABLE `Profil` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `min_age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Profil`
--

INSERT INTO `Profil` (`id`, `name`, `avatar`, `min_age`) VALUES
(1, 'Manon Lippler', '', 12),
(2, 'Owen Trelat', 'owen.jpg', 12),
(3, 'Nina Pinardel', 'nina.jpg', 0),
(4, 'lylian mercier--lorrain', '', 18),
(9, 'Hugo Vialatou', '', 2),
(11, 'Suzanne Kamara', 'mora.jpg', 0),
(12, 'Denis', 'denis.jpg', 5);

-- --------------------------------------------------------

--
-- Structure de la table `Ratings`
--

CREATE TABLE `Ratings` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Ratings`
--

INSERT INTO `Ratings` (`id`, `profile_id`, `movie_id`, `rating`) VALUES
(1, 3, 63, 1),
(4, 2, 17, 2),
(5, 3, 17, 4),
(8, 4, 70, 2),
(9, 2, 70, 3),
(10, 1, 70, 1),
(11, 9, 68, 1),
(12, 4, 27, 2),
(13, 9, 70, 10);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Index pour la table `Favorites`
--
ALTER TABLE `Favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Index pour la table `Movie`
--
ALTER TABLE `Movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `Profil`
--
ALTER TABLE `Profil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Ratings`
--
ALTER TABLE `Ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profile_id` (`profile_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `Favorites`
--
ALTER TABLE `Favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `Movie`
--
ALTER TABLE `Movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `Profil`
--
ALTER TABLE `Profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `Ratings`
--
ALTER TABLE `Ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `Movie` (`id`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `Profil` (`id`);

--
-- Contraintes pour la table `Favorites`
--
ALTER TABLE `Favorites`
  ADD CONSTRAINT `Favorites_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profil` (`id`),
  ADD CONSTRAINT `Favorites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `Movie` (`id`);

--
-- Contraintes pour la table `Movie`
--
ALTER TABLE `Movie`
  ADD CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `Category` (`id`);

--
-- Contraintes pour la table `Ratings`
--
ALTER TABLE `Ratings`
  ADD CONSTRAINT `Ratings_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profil` (`id`),
  ADD CONSTRAINT `Ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `Movie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
