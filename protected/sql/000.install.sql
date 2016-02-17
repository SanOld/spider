/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table spi_bank_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_bank_details`;

CREATE TABLE `spi_bank_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_person` varchar(45) DEFAULT NULL,
  `iban` varchar(34) NOT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `description` text,
  `outer_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_district
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_district`;

CREATE TABLE `spi_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text,
  `plz` varchar(45) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_finance_source
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_finance_source`;

CREATE TABLE `spi_finance_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `contact_person` varchar(45) NOT NULL,
  `iban` varchar(34) NOT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `finance_source_type` varchar(1) NOT NULL DEFAULT 'l',
  `finance_programm_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_hint
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_hint`;

CREATE TABLE `spi_hint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spi_hint_position_unq` (`position_id`),
  KEY `spi_hint_page` (`page_id`),
  KEY `spi_hint_position` (`position_id`),
  CONSTRAINT `spi_hint_page` FOREIGN KEY (`page_id`) REFERENCES `spi_page` (`id`) ON DELETE CASCADE,
  CONSTRAINT `spi_hint_position` FOREIGN KEY (`position_id`) REFERENCES `spi_page_position` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `spi_hint` WRITE;
/*!40000 ALTER TABLE `spi_hint` DISABLE KEYS */;

INSERT INTO `spi_hint` (`id`, `page_id`, `position_id`, `title`, `description`)
VALUES
	(1,3,8,NULL,'Choose page here'),
	(5,3,9,NULL,'sdfsdf'),
	(6,3,13,'test','test'),
	(7,3,11,NULL,'desc'),
	(8,3,10,NULL,'www'),
	(10,4,15,'test','eet');

/*!40000 ALTER TABLE `spi_hint` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table spi_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_page`;

CREATE TABLE `spi_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `spi_page` WRITE;
/*!40000 ALTER TABLE `spi_page` DISABLE KEYS */;

INSERT INTO `spi_page` (`id`, `code`, `name`)
VALUES
	(1,'user','Users'),
	(2,'user_type','User Roles'),
	(3,'hint','Hints module'),
	(4,'performer','Träger Agentur');

/*!40000 ALTER TABLE `spi_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table spi_page_position
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_page_position`;

CREATE TABLE `spi_page_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_page_position_page` (`page_id`),
  CONSTRAINT `spi_page_position_page` FOREIGN KEY (`page_id`) REFERENCES `spi_page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `spi_page_position` WRITE;
/*!40000 ALTER TABLE `spi_page_position` DISABLE KEYS */;

INSERT INTO `spi_page_position` (`id`, `page_id`, `code`, `name`)
VALUES
	(1,1,'is_active','Status'),
	(2,1,'type_id','Benutzer-Typ'),
	(3,1,'relation_id','Organisation'),
	(4,1,'is_finansist','Finanzielle Rechte'),
	(5,1,'login','Benutzername'),
	(6,1,'email','Email'),
	(7,1,'phone','Telefon'),
	(8,3,'page_id','Seite'),
	(9,3,'position_id','Position'),
	(10,3,'title','Hilfetext'),
	(11,3,'description','Description'),
	(12,1,'header','Header'),
	(13,3,'header','Header'),
	(14,2,'header','Header'),
	(15,4,'header','Header');

/*!40000 ALTER TABLE `spi_page_position` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table spi_performer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_performer`;

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
  `checked_by` int(11) DEFAULT NULL,
  `checked_date` date DEFAULT NULL,
  `representative_user_id` int(11) DEFAULT NULL,
  `application_processing_user_id` int(11) DEFAULT NULL,
  `budget_processing_user_id` int(11) DEFAULT NULL,
  `bank_details_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_performer_representative_user` (`representative_user_id`),
  KEY `spi_performer_application_user` (`application_processing_user_id`),
  KEY `spi_performer_budget_user` (`budget_processing_user_id`),
  KEY `spi_performer_checked_by_user` (`checked_by`),
  KEY `spi_performer_bank_details` (`bank_details_id`),
  CONSTRAINT `spi_performer_application_user` FOREIGN KEY (`application_processing_user_id`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `spi_performer_bank_details` FOREIGN KEY (`bank_details_id`) REFERENCES `spi_bank_details` (`id`) ON DELETE SET NULL,
  CONSTRAINT `spi_performer_budget_user` FOREIGN KEY (`budget_processing_user_id`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `spi_performer_checked_by_user` FOREIGN KEY (`checked_by`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `spi_performer_representative_user` FOREIGN KEY (`representative_user_id`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_performer_document
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_performer_document`;

CREATE TABLE `spi_performer_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `performer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_performer_document` (`performer_id`),
  CONSTRAINT `spi_performer_document` FOREIGN KEY (`performer_id`) REFERENCES `spi_performer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_project`;

CREATE TABLE `spi_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `school_type_id` int(11) NOT NULL,
  `finance_source_type` varchar(1) NOT NULL DEFAULT 'l',
  `finance_programm_id` int(11) NOT NULL,
  `performer_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_project_school
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_project_school`;

CREATE TABLE `spi_project_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_school
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_school`;

CREATE TABLE `spi_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL,
  `number` varchar(45) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `plz` varchar(45) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table spi_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_user`;

CREATE TABLE `spi_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(1) NOT NULL DEFAULT '',
  `type_id` int(11) NOT NULL,
  `relation_id` int(11) DEFAULT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `is_finansist` tinyint(1) NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `function` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `auth_token` varchar(32) DEFAULT NULL,
  `auth_token_created_at` datetime DEFAULT NULL,
  `recovery_token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spi_login_unq` (`login`),
  KEY `spi_email_unq` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `spi_user` WRITE;
/*!40000 ALTER TABLE `spi_user` DISABLE KEYS */;

INSERT INTO `spi_user` (`id`, `type`, `type_id`, `relation_id`, `login`, `password`, `is_finansist`, `sex`, `title`, `function`, `first_name`, `last_name`, `email`, `phone`, `is_active`, `auth_token`, `auth_token_created_at`, `recovery_token`)
VALUES
	(1,'a',1,NULL,'test','098f6bcd4621d373cade4e832627b4f6',1,1,'Nice titile',NULL,'Mister','Test','test@ma.rt','1234567890',1,'bae4d11fce0e71521dcc74f802f11a2c','2016-02-17 07:51:51','427e6bd7ac6b908a27ca18f5a0400344');

/*!40000 ALTER TABLE `spi_user` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `spi_user_BINS` BEFORE INSERT ON `spi_user` FOR EACH ROW BEGIN
	set new.password = md5(new.password);
    END */;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `spi_user_BUPD` BEFORE UPDATE ON `spi_user` FOR EACH ROW BEGIN
    IF new.password!=old.password THEN
	set new.password = md5(new.password);
    END if;
    END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table spi_user_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_user_type`;

CREATE TABLE `spi_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `spi_user_type` WRITE;
/*!40000 ALTER TABLE `spi_user_type` DISABLE KEYS */;

INSERT INTO `spi_user_type` (`id`, `type`, `name`, `default`)
VALUES
	(1,'a','Admin',1),
	(2,'a','PA',1),
	(3,'t','TA',1),
	(4,'s','School',1),
	(5,'d','District',1),
	(6,'a','Senat',1);

/*!40000 ALTER TABLE `spi_user_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table spi_user_type_right
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_user_type_right`;

CREATE TABLE `spi_user_type_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT '0',
  `can_edit` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `spi_user_type_right_page` (`page_id`),
  KEY `spi_user_type_right_type` (`type_id`),
  CONSTRAINT `spi_user_type_right_page` FOREIGN KEY (`page_id`) REFERENCES `spi_page` (`id`) ON DELETE CASCADE,
  CONSTRAINT `spi_user_type_right_type` FOREIGN KEY (`type_id`) REFERENCES `spi_user_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `spi_user_type_right` WRITE;
/*!40000 ALTER TABLE `spi_user_type_right` DISABLE KEYS */;

INSERT INTO `spi_user_type_right` (`id`, `type_id`, `page_id`, `can_view`, `can_edit`)
VALUES
	(1,1,1,1,1),
	(2,1,2,1,1),
	(3,2,1,1,0),
	(4,2,2,1,0),
	(5,3,1,1,0),
	(6,3,2,1,0),
	(7,4,1,1,0),
	(8,4,2,0,0),
	(9,5,1,1,0),
	(10,1,3,1,1);

/*!40000 ALTER TABLE `spi_user_type_right` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table spi_user_type_system
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spi_user_type_system`;

CREATE TABLE `spi_user_type_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
