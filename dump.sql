SET NAMES utf8;

DROP DATABASE IF EXISTS `legacy_app`;
CREATE DATABASE `legacy_app`;
USE `legacy_app`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`) VALUES
(1,	'Bob'),
(2,	'Alice'),
(3,	'John');
