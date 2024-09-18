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
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  `date_creation` datetime NOT NULL,
  `note` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F91ABF0FB88E14F` (`utilisateur_id`),
  CONSTRAINT `FK_8F91ABF0FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.avis : ~16 rows (environ)
REPLACE INTO `avis` (`id`, `utilisateur_id`, `contenu`, `date_creation`, `note`) VALUES
	(1, 1, 'cool', '2024-07-05 14:20:48', 5),
	(2, 1, 'test', '2024-07-05 14:30:40', 2),
	(3, 2, 'exemple', '2024-07-05 14:33:41', 1),
	(4, 2, 'test 2', '2024-07-05 14:38:28', 5),
	(5, 2, 'test 3', '2024-07-05 14:41:31', 4),
	(6, 1, 'super', '2024-07-05 15:51:44', 5),
	(7, 2, 'cool', '2024-07-09 13:43:19', 5),
	(8, 1, '<p><strong>super</strong></p>', '2024-07-10 07:56:05', 5),
	(9, 1, '<p>test</p>', '2024-07-10 07:58:27', 1),
	(10, 1, '<p>Tr&egrave;s bon site, j\'ai appris le piano tr&egrave;s efficacement!</p>', '2024-07-11 09:50:03', 5),
	(11, 1, '<p>test</p>', '2024-07-11 09:51:05', 1),
	(12, 1, '<p>4 etoiles</p>', '2024-07-11 10:52:30', 4),
	(13, 1, '<p>testt</p>', '2024-07-11 10:54:40', 2),
	(14, 1, '<p>retest</p>', '2024-07-11 10:56:20', 3),
	(15, 1, '<p>yes</p>', '2024-07-11 10:58:32', 5),
	(17, 1, 'bof bof', '2024-07-29 14:32:14', 3);

-- Listage de la structure de table projet_final_maximefutterer. etape
CREATE TABLE IF NOT EXISTS `etape` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_etape` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre` int NOT NULL,
  `niveau_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_285F75DDB3E9C81` (`niveau_id`),
  CONSTRAINT `FK_285F75DDB3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.etape : ~12 rows (environ)
REPLACE INTO `etape` (`id`, `nom_etape`, `pdf`, `video`, `description`, `ordre`, `niveau_id`) VALUES
	(1, 'Lecture', 'pdf/au-clair-de-la-lune-66eae4d79bf15.pdf', 'https://www.youtube.com/embed/9UjAosN2CWc', 'lorem ipsum blabla', 1, 1),
	(2, 'Rythme', 'pdf/piano-facile.pdf', 'https://www.youtube.com/embed/9UjAosN2CWc-beJA', 'lorem ipsum blabla', 2, 1),
	(3, 'Théorie', 'pdf/Commandes-Symfony-6687b9c8a58dd.pdf', 'https://www.youtube.com/embed/YaGiM2cPXmM', 'lorem ipsum blabla', 3, 1),
	(4, 'Morceau', 'pdf/piano-facile.pdf', 'https://www.youtube.com/embed/HjG5RxDIg-beJA', 'lorem ipsum blabla', 4, 1),
	(5, 'Lecture', NULL, 'https://www.youtube.com/embed/QYEj7U5CKzI', 'lorem ipsum blabla', 1, 2),
	(6, 'Rythme', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 2, 2),
	(7, 'Théorie', 'pdf/piano-facile.pdf', 'https://www.youtube.com/embed/', 'lorem ipsum blabla', 3, 2),
	(8, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 2),
	(9, 'Lecture', 'pdf/au-clair-de-la-lune-66eae4d79bf15.pdf', 'https://www.youtube.com/embed/5WZkSaTBRCQ', 'lorem ipsum blabla', 1, 3),
	(10, 'Rythme', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 2, 3),
	(11, 'Théorie', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 3, 3),
	(12, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 3),
	(29, 'Lecture', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 1, 15),
	(30, 'Rythme', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 2, 15),
	(31, 'Théorie', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 3, 15),
	(32, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 15),
	(33, 'Lecture', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 1, 16),
	(34, 'Rythme', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 2, 16),
	(35, 'Théorie', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 3, 16),
	(36, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 16),
	(37, 'Lecture', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 1, 17),
	(38, 'Rythme', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 2, 17),
	(39, 'Théorie', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 3, 17),
	(40, 'Morceau', 'pdf/piano-facile.pdf', NULL, 'lorem ipsum blabla', 4, 17);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.messenger_messages : ~1 rows (environ)
REPLACE INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
	(1, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":5:{i:0;s:30:\\"reset_password/email.html.twig\\";i:1;N;i:2;a:1:{s:10:\\"resetToken\\";O:58:\\"SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\":4:{s:65:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0token\\";s:40:\\"HslUAHcarKuLXuaVi8JbUQ5JnhoOReaqSit2DrvN\\";s:69:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0expiresAt\\";O:17:\\"DateTimeImmutable\\":3:{s:4:\\"date\\";s:26:\\"2024-07-12 07:59:54.966431\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:3:\\"UTC\\";}s:71:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0generatedAt\\";i:1720767594;s:73:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0transInterval\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:22:\\"admin@maesterclass.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:21:\\"Maesterclass Mail Bot\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:24:\\"futterermaxime@gmail.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:27:\\"Your password reset request\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}i:4;N;}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2024-07-12 06:59:55', '2024-07-12 06:59:55', NULL);

-- Listage de la structure de table projet_final_maximefutterer. niveau
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.niveau : ~6 rows (environ)
REPLACE INTO `niveau` (`id`, `nom_niveau`, `prix`) VALUES
	(1, 'Niveau 1', NULL),
	(2, 'Niveau 2', NULL),
	(3, 'Niveau 3', NULL),
	(15, 'Niveau 4', NULL),
	(16, 'Niveau 5', NULL),
	(17, 'Niveau 6', NULL);

-- Listage de la structure de table projet_final_maximefutterer. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `etape_id` int NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  `date_creation` datetime NOT NULL,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DFB88E14F` (`utilisateur_id`),
  KEY `IDX_5A8A6C8D4A8CA2AD` (`etape_id`),
  KEY `IDX_5A8A6C8D727ACA70` (`parent_id`),
  CONSTRAINT `FK_5A8A6C8D4A8CA2AD` FOREIGN KEY (`etape_id`) REFERENCES `etape` (`id`),
  CONSTRAINT `FK_5A8A6C8D727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `post` (`id`),
  CONSTRAINT `FK_5A8A6C8DFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.post : ~14 rows (environ)
REPLACE INTO `post` (`id`, `utilisateur_id`, `etape_id`, `contenu`, `date_creation`, `parent_id`) VALUES
	(1, 1, 1, 'mon premier post :)', '2024-07-08 09:42:41', NULL),
	(9, 2, 1, 'encore un test', '2024-07-09 08:15:19', NULL),
	(11, 2, 1, 'et voila', '2024-07-09 12:02:32', 9),
	(12, 2, 1, 'et voila', '2024-07-09 12:02:35', 9),
	(20, NULL, 1, 'test', '2024-08-01 20:45:48', NULL),
	(21, 1, 6, 'Très bien! J\'ai pu apprendre ce morceau en quelques heures seulement!', '2024-08-29 12:07:47', NULL),
	(22, 11, 3, 'Test', '2024-09-06 08:49:54', NULL),
	(23, NULL, 3, 'test 1', '2024-09-06 09:13:57', NULL),
	(24, NULL, 3, 'test 2', '2024-09-06 09:14:05', NULL),
	(26, 11, 3, 'reponse', '2024-09-16 13:49:34', 23),
	(27, 11, 3, 'test', '2024-09-16 13:49:55', 22),
	(28, 11, 1, 'test home page', '2024-09-18 15:21:29', 12),
	(29, NULL, 1, 'test home page 2', '2024-09-18 15:22:32', 28),
	(30, 1, 1, 'test homepage 3', '2024-09-18 16:21:23', 1),
	(31, 13, 39, 'Test 99', '2024-09-18 20:32:13', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.progression : ~18 rows (environ)
REPLACE INTO `progression` (`id`, `utilisateur_id`, `etape_id`, `done`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 1),
	(3, 1, 3, 1),
	(4, 1, 4, 1),
	(5, 1, 5, 1),
	(6, 1, 6, 1),
	(7, 1, 7, 1),
	(8, 2, 1, 1),
	(9, 2, 3, 0),
	(10, 2, 2, 0),
	(11, 3, 1, 0),
	(12, 1, 8, 1),
	(16, 1, 9, 0),
	(18, 11, 1, 1),
	(19, 11, 2, 1),
	(20, 11, 3, 1),
	(21, 11, 4, 1),
	(22, 11, 9, 0),
	(26, 13, 39, 0),
	(27, 13, 1, 0),
	(28, 13, 2, 0),
	(29, 13, 3, 0),
	(30, 13, 4, 0),
	(31, 1, 10, 0);

-- Listage de la structure de table projet_final_maximefutterer. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.reset_password_request : ~1 rows (environ)

-- Listage de la structure de table projet_final_maximefutterer. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_date` datetime NOT NULL,
  `google_user` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet_final_maximefutterer.utilisateur : ~4 rows (environ)
REPLACE INTO `utilisateur` (`id`, `email`, `roles`, `password`, `username`, `register_date`, `google_user`) VALUES
	(1, 'admin@maesterclass.com', '["ROLE_ADMIN"]', '$2y$13$UJkJ4XJcjkJji9kXxiKKWeajjb3eP1URQBF4Vl5pZA.WdP.XxufuG', 'FutRR', '2024-07-02 11:39:12', 0),
	(2, 'exemple@exemple.com', '["ROLE_USER"]', '$2y$13$.hS7yk5nrHkeBfPiiDDAVOXGDd4WCNAjC8saH.6dGR6KohqLhzJPu', 'exemple', '2024-07-05 14:33:10', 0),
	(11, 'maximefutterer68@gmail.com', '["ROLE_ADMIN"]', '6d9f60987b3d68f278072540c373bfa0', 'botspotter68', '2024-08-29 12:00:08', 1),
	(13, 'futterermaxime@gmail.com', '["ROLE_USER"]', 'dbcd94bb941d1f5f4863bfefb6a9e9f8', 'futterermaxime', '2024-09-18 16:47:13', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
