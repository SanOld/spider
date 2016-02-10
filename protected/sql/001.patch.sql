
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('a', 'Admin');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('a', 'PA');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('t', 'TA');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('s', 'School');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('d', 'District');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('a', 'Senat');

ALTER TABLE `spi_user` ADD COLUMN `type_id` INT(11) NOT NULL ALTER `type`;

UPDATE`spi_user` SET `type_id`='1' WHERE `id`='1';

CREATE TABLE `spi_user_type_right` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type_id` INT NOT NULL,
  `page_id` INT NOT NULL,
  `can_view` TINYINT(1) NOT NULL DEFAULT 0,
  `can_edit` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

CREATE TABLE `spi_page` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
PRIMARY KEY (`id`));

INSERT INTO spi_page (code, name) VALUES ('user', 'Users');
INSERT INTO spi_page (code, name) VALUES ('user_type', 'User Roles');
INSERT INTO spi_page (code, name) VALUES ('hint', 'Hints module');

ALTER TABLE spi_user_type ADD COLUMN `default` TINYINT(1) DEFAULT '0';
UPDATE spi_user_type SET `default` = 1;

ALTER TABLE `spi_user_type_right` ADD CONSTRAINT `spi_user_type_right_page` FOREIGN KEY (`page_id`) REFERENCES `spi_page` (`id`) ON DELETE CASCADE;
ALTER TABLE `spi_user_type_right` ADD CONSTRAINT `spi_user_type_right_type` FOREIGN KEY (`type_id`) REFERENCES `spi_user_type` (`id`) ON DELETE CASCADE;

CREATE TABLE `spi_performer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `address` text,
  `plz` varchar(45) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `company_overview` text,
  `diversity` text,
  `further_education` text,
  `quality_standards` text,
  `comment` text,
  `is_checked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `spi_page_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_page_position_page` (`page_id`),
  CONSTRAINT `spi_page_position_page` FOREIGN KEY (`page_id`) REFERENCES `spi_page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `spi_hint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `position_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_hint_page` (`page_id`),
  KEY `spi_hint_position` (`position_id`),
  CONSTRAINT `spi_hint_page` FOREIGN KEY (`page_id`) REFERENCES `spi_page` (`id`) ON DELETE CASCADE,
  CONSTRAINT `spi_hint_position` FOREIGN KEY (`position_id`) REFERENCES `spi_page_position` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'is_active', 'Status');
INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'type_id', 'Benutzer-Typ');
INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'relation_id', 'Organisation');
INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'is_finansist', 'Finanzielle Rechte');
INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'login', 'Benutzername');
INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'email', 'Email');
INSERT INTO spi_page_position (page_id, code, name) VALUES (1, 'phone', 'Telefon');

INSERT INTO spi_page_position (page_id, code, name) VALUES (3, 'page_id', 'Seite');
INSERT INTO spi_page_position (page_id, code, name) VALUES (3, 'position_id', 'Position');
INSERT INTO spi_page_position (page_id, code, name) VALUES (3, 'title', 'Hilfetext');
INSERT INTO spi_page_position (page_id, code, name) VALUES (3, 'description', 'Description');
