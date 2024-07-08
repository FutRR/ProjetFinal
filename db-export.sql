-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour projet_final_maximefutterer
CREATE DATABASE IF NOT EXISTS `projet_final_maximefutterer` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projet_final_maximefutterer`;

-- Listage de la structure de table projet_final_maximefutterer. avis
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `note` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F91ABF0FB88E14F` (`utilisateur_id`),
  CONSTRAINT `FK_8F91ABF0FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.avis : ~4 rows (environ)
INSERT IGNORE INTO `avis` (`id`, `utilisateur_id`, `contenu`, `date_creation`, `note`) VALUES
	(1, 1, 'cool', '2024-07-05 14:20:48', 5),
	(2, 1, 'test', '2024-07-05 14:30:40', 2),
	(3, 2, 'exemple', '2024-07-05 14:33:41', 1),
	(4, 2, 'test 2', '2024-07-05 14:38:28', 5),
	(5, 2, 'test 3', '2024-07-05 14:41:31', 4);

-- Listage de la structure de table projet_final_maximefutterer. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.doctrine_migration_versions : ~1 rows (environ)
INSERT IGNORE INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20240708095255', '2024-07-08 11:53:13', 103),
	('DoctrineMigrations\\Version20240708095818', '2024-07-08 11:58:30', 95);

-- Listage de la structure de table projet_final_maximefutterer. etape
CREATE TABLE IF NOT EXISTS `etape` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_etape` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre` int NOT NULL,
  `niveau_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_285F75DDB3E9C81` (`niveau_id`),
  CONSTRAINT `FK_285F75DDB3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.etape : ~8 rows (environ)
INSERT IGNORE INTO `etape` (`id`, `nom_etape`, `pdf`, `video`, `description`, `ordre`, `niveau_id`) VALUES
	(1, 'Lecture test', 'pdf/Commandes-Symfony-6687b9c8a58dd.pdf', 'https://www.youtube.com/embed/n7lOJNYGYvw', 'lorem ipsum blabla', 1, 1),
	(2, 'Rythme', 'pdf/piano-facile.pdf', 'https://www.youtube.com/embed/n7RjlO-beJA', 'lorem ipsum blabla', 2, 1),
	(3, 'Connaissances théoriques', 'pdf/Commandes-Symfony-6687b9c8a58dd.pdf', 'https://www.youtube.com/embed/YaGiM2cPXmM', 'lorem ipsum blabla', 3, 1),
	(4, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 1),
	(5, 'Lecture', NULL, 'https://www.youtube.com/embed/QYEj7U5CKzI', 'lorem ipsum blabla', 1, 2),
	(6, 'Rythme', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 2, 2),
	(7, 'Connaissances théoriques', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 3, 2),
	(8, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 2);

-- Listage de la structure de table projet_final_maximefutterer. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table projet_final_maximefutterer. niveau
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.niveau : ~2 rows (environ)
INSERT IGNORE INTO `niveau` (`id`, `nom_niveau`) VALUES
	(1, 'Niveau 1'),
	(2, 'Niveau 2');

-- Listage de la structure de table projet_final_maximefutterer. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `etape_id` int NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DFB88E14F` (`utilisateur_id`),
  KEY `IDX_5A8A6C8D4A8CA2AD` (`etape_id`),
  KEY `IDX_5A8A6C8D727ACA70` (`parent_id`),
  CONSTRAINT `FK_5A8A6C8D4A8CA2AD` FOREIGN KEY (`etape_id`) REFERENCES `etape` (`id`),
  CONSTRAINT `FK_5A8A6C8D727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `post` (`id`),
  CONSTRAINT `FK_5A8A6C8DFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.post : ~5 rows (environ)
INSERT IGNORE INTO `post` (`id`, `utilisateur_id`, `etape_id`, `contenu`, `date_creation`, `parent_id`) VALUES
	(1, 1, 1, 'mon premier post :)', '2024-07-08 09:42:41', NULL),
	(5, 1, 1, 'reponse', '2024-07-08 14:45:52', 1),
	(6, 1, 1, 'test', '2024-07-08 16:52:42', 1),
	(7, 1, 1, 'test2', '2024-07-08 16:57:26', NULL),
	(8, 1, 1, 'reponse 2', '2024-07-08 16:57:38', 7);

-- Listage de la structure de table projet_final_maximefutterer. progression
CREATE TABLE IF NOT EXISTS `progression` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `etape_id` int NOT NULL,
  `done` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D5B25073FB88E14F` (`utilisateur_id`),
  KEY `IDX_D5B250734A8CA2AD` (`etape_id`),
  CONSTRAINT `FK_D5B250734A8CA2AD` FOREIGN KEY (`etape_id`) REFERENCES `etape` (`id`),
  CONSTRAINT `FK_D5B25073FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.progression : ~7 rows (environ)
INSERT IGNORE INTO `progression` (`id`, `utilisateur_id`, `etape_id`, `done`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 1),
	(3, 1, 3, 1),
	(4, 1, 4, 1),
	(5, 1, 5, 1),
	(6, 1, 6, 1),
	(7, 1, 7, 0);

-- Listage de la structure de table projet_final_maximefutterer. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.utilisateur : ~0 rows (environ)
INSERT IGNORE INTO `utilisateur` (`id`, `email`, `roles`, `password`, `username`, `register_date`) VALUES
	(1, 'futterermaxime@gmail.com', '[]', '$2y$13$2m0OgmrAHZyvSJ7e0A7m8e623cB4RmOhtQlROVH0DmBovNRjMqUiG', 'FutRR_', '2024-07-02 11:39:12'),
	(2, 'exemple@exemple.exemple', '[]', '$2y$13$.hS7yk5nrHkeBfPiiDDAVOXGDd4WCNAjC8saH.6dGR6KohqLhzJPu', 'exemple', '2024-07-05 14:33:10');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
