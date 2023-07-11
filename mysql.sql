-- Adminer 4.8.1 MySQL 10.11.2-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `complaints`;
CREATE DATABASE `complaints` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `complaints`;

DROP TABLE IF EXISTS `complaint`;
CREATE TABLE `complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('pending','process','success') NOT NULL DEFAULT 'pending',
  `publics` char(16) NOT NULL,
  `picture` varchar(150) NOT NULL,
  `contents` text NOT NULL,
  `timestamp` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE `complaint`;
INSERT INTO `complaint` (`id`, `status`, `publics`, `picture`, `contents`, `timestamp`) VALUES
(1,	'success',	'1234567890123456',	'/dist/img/1681558681;57a0daa34616017f.jpg',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',	1681558681),
(3,	'process',	'1234567890123456',	'/dist/img/1681563106;5cbc205d9f7fe9a7.jpg',	'Test Case Line #1\r\nTest Case Line #2',	1681563106),
(4,	'pending',	'1234567890123456',	'/dist/img/1681563190;28986f3ca789fa35.jpg',	'Test Case ',	1681563190);

DELIMITER ;;

CREATE TRIGGER `complaint_bd` BEFORE DELETE ON `complaint` FOR EACH ROW
DELETE FROM response WHERE complaint = old.id;;

DELIMITER ;

DROP TABLE IF EXISTS `officer`;
CREATE TABLE `officer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(150) NOT NULL DEFAULT '/dist/img/1681439839;ddLgSJGhL..png',
  `fullname` varchar(35) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `callable` varchar(20) NOT NULL,
  `level` enum('admin','officer') NOT NULL DEFAULT 'officer',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=593066 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE `officer`;
INSERT INTO `officer` (`id`, `avatar`, `fullname`, `username`, `password`, `callable`, `level`) VALUES
(593064,	'/dist/img/1681439839;f7WYVV7.mG.png',	'hxAre',	'hxare',	'$2y$10$f2lh.GtoS4ZRkJIyeQo4o.s2GoWilN75duDmUGUkAjZqE5FWA/nM2',	'85839211030',	'admin'),
(593065,	'/dist/img/1681439839;ddLgSJGhL..png',	'hxAra',	'hxara',	'$2y$10$PuN9DpuOyaU8SVfz4dBKBeTolpu0LJhJwIBIp/OpZDB8l5NVK/x6y',	'85839211930',	'officer');

DELIMITER ;;

CREATE TRIGGER `officer_bd` BEFORE DELETE ON `officer` FOR EACH ROW
DELETE FROM response WHERE officer = old.id;;

DELIMITER ;

DROP TABLE IF EXISTS `publics`;
CREATE TABLE `publics` (
  `nik` char(16) NOT NULL,
  `avatar` varchar(150) NOT NULL DEFAULT '/dist/img/1681439839;68jqGs2jcp.png',
  `fullname` varchar(35) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `callable` varchar(20) NOT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE `publics`;
INSERT INTO `publics` (`nik`, `avatar`, `fullname`, `username`, `password`, `callable`) VALUES
('1234567890123456',	'/dist/img/1681439839;68jqGs2jcp.png',	'hxAri',	'hxari',	'$2y$10$ovcPxLtvMML464xX9KudL.6d0hZvWzNmZCZUR9Ki0axvEXC9hQnfC',	'85839211030');

DELIMITER ;;

CREATE TRIGGER `publics_bd` BEFORE DELETE ON `publics` FOR EACH ROW
DELETE FROM complaint WHERE publics = old.nik;;

DELIMITER ;

DROP TABLE IF EXISTS `response`;
CREATE TABLE `response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `officer` int(11) NOT NULL,
  `complaint` int(11) NOT NULL,
  `response` text NOT NULL,
  `timestamp` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE `response`;
INSERT INTO `response` (`id`, `officer`, `complaint`, `response`, `timestamp`) VALUES
(1,	593064,	1,	'Unitialized',	1681558681);

DELIMITER ;;

CREATE TRIGGER `response_bi` BEFORE INSERT ON `response` FOR EACH ROW
UPDATE complaint SET status = 3 WHERE id = new.complaint;;

DELIMITER ;

-- 2023-04-15 12:56:35
