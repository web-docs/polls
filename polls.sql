-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.5.11-MariaDBdepartments - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.3.0.6376
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп структуры для таблица polls.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы polls.departments: ~0 rows (приблизительно)
INSERT INTO `departments` (`id`, `title`, `created_at`) VALUES
	(1, 'IT', '2022-11-29 14:11:20'),
	(2, 'Accountant', '2022-11-29 14:11:34');

-- Дамп структуры для таблица polls.polls
CREATE TABLE IF NOT EXISTS `polls` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_from` int(10) unsigned DEFAULT NULL,
  `user_to` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_to` (`user_to`),
  KEY `user_id` (`user_from`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы polls.polls: ~7 rows (приблизительно)
INSERT INTO `polls` (`id`, `user_from`, `user_to`, `created_at`) VALUES
	(1, 1, 4, '2022-11-29 13:50:16'),
	(2, 2, 1, '2022-11-29 13:50:16'),
	(3, 2, 2, '2022-11-29 13:50:16'),
	(4, 2, 3, '2022-11-29 13:50:16'),
	(5, 1, 3, '2022-11-29 13:50:16'),
	(6, 1, 4, '2022-11-29 13:59:43'),
	(7, 1, 3, '2022-11-29 13:59:44'),
	(8, 1, 4, '2022-11-29 14:12:29'),
	(9, 1, 4, '2022-11-29 14:13:01');

-- Дамп структуры для таблица polls.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT NULL,
  `department_id` int(10) unsigned NOT NULL DEFAULT 0,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы polls.users: ~4 rows (приблизительно)
INSERT INTO `users` (`id`, `role`, `status`, `department_id`, `firstname`, `lastname`, `phone`, `password`, `created_at`) VALUES
	(1, 9, 1, 1, 'user', 'lastname', '998903002010', '1bbd886460827015e5d605ed44252251', '2022-11-29 11:34:05'),
	(2, 1, 1, 1, 'user 2', 'lastname', '998903002011', '1bbd886460827015e5d605ed44252251', '2022-11-29 11:34:05'),
	(3, 1, 1, 1, 'user 3', 'lastname', '998903002012', '1bbd886460827015e5d605ed44252251', '2022-11-29 11:34:05'),
	(4, 1, 1, 1, 'user 4', 'lastname', '998903002013', '1bbd886460827015e5d605ed44252251', '2022-11-29 11:34:05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
