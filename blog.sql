-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 03 oct. 2024 à 13:17
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'PHP'),
(2, 'Symfony');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int UNSIGNED NOT NULL,
  `content` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `approved` tinyint NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `chapo` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `post_of_day` tinyint UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `image`, `content`, `post_of_day`, `created_at`, `update_at`, `user_id`, `category_id`) VALUES
(1, 'Introduction à PHP', 'Découverte des bases du langage PHP.', 'php_intro.jpg', 'PHP est un langage de programmation côté serveur populaire pour le développement web. Cet article explique les bases de PHP, notamment la syntaxe, les variables, et les structures de contrôle.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(2, 'Installation de PHP', 'Comment installer PHP sur votre machine.', 'php_install.jpg', 'Pour commencer à développer avec PHP, vous devez d\'abord l\'installer sur votre machine. Ce guide vous montre comment installer PHP sur Windows, macOS et Linux.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(3, 'Les variables en PHP', 'Comprendre et utiliser les variables en PHP.', 'php_variables.jpg', 'Les variables en PHP sont utilisées pour stocker des données. Cet article couvre les types de variables, la syntaxe, et les bonnes pratiques pour leur utilisation.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(4, 'Les boucles en PHP', 'Utilisation des boucles pour automatiser les tâches répétitives.', 'php_loops.jpg', 'Les boucles sont essentielles en PHP pour exécuter du code de manière répétitive. Découvrez les différentes boucles disponibles en PHP : for, while, et foreach.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(5, 'Fonctions en PHP', 'Définir et utiliser des fonctions en PHP.', 'php_functions.jpg', 'Les fonctions permettent de réutiliser du code. Apprenez comment définir des fonctions, leur passer des paramètres, et retourner des valeurs.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(6, 'Introduction à Symfony', 'Premiers pas avec le framework Symfony.', 'symfony_intro.jpg', 'Symfony est un framework PHP très populaire pour créer des applications web robustes. Cet article vous guide à travers les bases de Symfony.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(7, 'Installation de Symfony', 'Comment installer et configurer Symfony.', 'symfony_install.jpg', 'Apprenez à installer Symfony via Composer, à configurer votre environnement de développement, et à lancer votre première application.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(8, 'Les routes en Symfony', 'Gestion des routes dans Symfony.', 'symfony_routes.jpg', 'Les routes en Symfony permettent de lier les URLs aux contrôleurs. Ce guide explique comment définir et gérer les routes dans une application Symfony.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(9, 'Contrôleurs en Symfony', 'Création et utilisation des contrôleurs dans Symfony.', 'symfony_controllers.jpg', 'Les contrôleurs sont le cœur de toute application Symfony. Découvrez comment créer des contrôleurs et les connecter aux routes.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(10, 'Les templates Twig en Symfony', 'Utilisation de Twig pour gérer les vues dans Symfony.', 'symfony_twig.jpg', 'Twig est le moteur de templates utilisé par Symfony. Apprenez à utiliser Twig pour créer des vues dynamiques et réutilisables dans vos applications.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(11, 'Gérer les formulaires en Symfony', 'Créer et gérer des formulaires avec Symfony.', 'symfony_forms.jpg', 'Symfony facilite la gestion des formulaires avec son composant Form. Ce guide vous montre comment créer des formulaires, les valider, et traiter les données soumises.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(12, 'Doctrine et les bases de données en Symfony', 'Gérer les bases de données avec Doctrine.', 'symfony_doctrine.jpg', 'Doctrine est l\'ORM par défaut de Symfony pour interagir avec les bases de données. Apprenez à configurer Doctrine, créer des entités, et effectuer des requêtes.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(13, 'Création d\'un blog en PHP - Partie 1', 'Introduction et configuration du projet.', 'blog_php_1.jpg', 'Dans cette série d\'articles, nous allons créer un blog simple en PHP. Dans cette première partie, nous configurons notre environnement et définissons la structure de base.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(14, 'Création d\'un blog en PHP - Partie 2', 'Gestion des utilisateurs.', 'blog_php_2.jpg', 'Dans cette deuxième partie, nous mettons en place la gestion des utilisateurs : inscription, connexion, et gestion des rôles.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(15, 'Création d\'un blog en PHP - Partie 3', 'Création et gestion des articles.', 'blog_php_3.jpg', 'Nous continuons notre blog en PHP en ajoutant la fonctionnalité de création et de gestion des articles.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(16, 'Création d\'un blog en PHP - Partie 4', 'Gestion des catégories et des commentaires.', 'blog_php_4.jpg', 'Dans cette quatrième partie, nous ajoutons la gestion des catégories d\'articles et des commentaires pour nos utilisateurs.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(17, 'Création d\'un blog en PHP - Partie 5', 'Sécurisation de l\'application.', 'blog_php_5.jpg', 'La sécurité est essentielle dans toute application. Nous abordons ici les mesures de sécurité comme la protection contre les attaques XSS, CSRF, et SQL Injection.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(18, 'Création d\'un blog en PHP - Partie 6', 'Optimisation et déploiement.', 'blog_php_6.jpg', 'Enfin, nous optimisons notre blog pour de meilleures performances et le déployons sur un serveur de production.', NULL, '2024-08-30 09:04:10', NULL, 1, 1),
(19, 'Les bundles en Symfony', 'Utilisation des bundles dans Symfony.', 'symfony_bundles.jpg', 'Les bundles sont des composants réutilisables dans Symfony. Apprenez à intégrer et créer des bundles pour modulariser votre application.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(20, 'Gestion des utilisateurs en Symfony', 'Créer un système de gestion des utilisateurs avec Symfony.', 'symfony_users.jpg', 'Ce guide vous montre comment mettre en place un système de gestion des utilisateurs, y compris l\'inscription, la connexion, et la gestion des rôles.', NULL, '2024-08-30 09:04:10', NULL, 2, 2),
(21, 'Déploiement d\'une application Symfony', 'Guide complet pour déployer une application Symfony.', 'symfony_deployment.jpg', 'Découvrez les bonnes pratiques pour déployer votre application Symfony sur un serveur de production.', NULL, '2024-08-30 09:04:10', NULL, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `role` int NOT NULL,
  `is_valid` tinyint NOT NULL,
  `banned` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `role`, `is_valid`, `banned`) VALUES
(1, 'Jean', 'Dupont', 'jean.dupont@example.com', 'hashedpassword123', '0123456789', 1, 1, 0),
(2, 'Marie', 'Durand', 'marie.durand@example.com', 'hashedpassword456', '0987654321', 2, 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_user1_idx` (`user_id`),
  ADD KEY `fk_comment_post1_idx` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Post_user1_idx` (`user_id`),
  ADD KEY `fk_post_category1_idx` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `fk_Post_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
