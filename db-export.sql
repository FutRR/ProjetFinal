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

-- Listage de la structure de table projet_final_maximefutterer. etape
CREATE TABLE IF NOT EXISTS `etape` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_etape` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre` int NOT NULL,
  `niveau_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.etape : ~2 rows (environ)
INSERT IGNORE INTO `etape` (`id`, `nom_etape`, `pdf`, `video`, `description`, `ordre`, `niveau_id`) VALUES
	(1, 'Lecture', NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lacus lorem, molestie sit amet rutrum ut, porta nec ante. Suspendisse iaculis ullamcorper quam, nec iaculis tellus tincidunt convallis. Suspendisse et luctus enim, sed accumsan velit. Suspendisse non purus nec nisl lobortis fermentum nec sit amet nunc. Nullam faucibus convallis purus, at posuere sapien sollicitudin sit amet. Nam sed augue et diam facilisis laoreet. Aenean lorem augue, elementum et ligula vel, ultrices pellentesque mauris.', 1, 1),
	(2, 'Rythmique', NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lacus lorem, molestie sit amet rutrum ut, porta nec ante. Suspendisse iaculis ullamcorper quam, nec iaculis tellus tincidunt convallis. Suspendisse et luctus enim, sed accumsan velit. Suspendisse non purus nec nisl lobortis fermentum nec sit amet nunc. Nullam faucibus convallis purus, at posuere sapien sollicitudin sit amet. Nam sed augue et diam facilisis laoreet. Aenean lorem augue, elementum et ligula vel, ultrices pellentesque mauris.', 2, 1);

-- Listage de la structure de table projet_final_maximefutterer. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `nom_niveau` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.niveau : ~0 rows (environ)
INSERT IGNORE INTO `niveau` (`id`, `nom_niveau`, `description`) VALUES
	(1, 'Niveau 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lacus lorem, molestie sit amet rutrum ut, porta nec ante. Suspendisse iaculis ullamcorper quam, nec iaculis tellus tincidunt convallis. Suspendisse et luctus enim, sed accumsan velit. Suspendisse non purus nec nisl lobortis fermentum nec sit amet nunc. Nullam faucibus convallis purus, at posuere sapien sollicitudin sit amet. Nam sed augue et diam facilisis laoreet. Aenean lorem augue, elementum et ligula vel, ultrices pellentesque mauris.');

-- Listage de la structure de table projet_final_maximefutterer. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.utilisateur : ~1 rows (environ)
INSERT IGNORE INTO `utilisateur` (`id`, `email`, `roles`, `password`) VALUES
	(1, 'futterermaxime@gmail.com', '[]', '$2y$13$2m0OgmrAHZyvSJ7e0A7m8e623cB4RmOhtQlROVH0DmBovNRjMqUiG');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
