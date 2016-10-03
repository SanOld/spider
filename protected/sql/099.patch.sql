ALTER TABLE spi_request_school_finance MODIFY rate DECIMAL(7,4);
ALTER TABLE spi_request_user MODIFY hours_per_week DECIMAL(10,4);


ALTER TABLE `spider_st_db`.`spi_request_school_goal` DROP COLUMN `name`, DROP COLUMN `capacity`, 
DROP COLUMN `transition`, DROP COLUMN `reintegration`, DROP COLUMN `social_skill`,
DROP COLUMN `prevantion_violence`, DROP COLUMN `health`, DROP COLUMN `sport`, DROP COLUMN `parent_skill`,
DROP COLUMN `other_goal`, DROP COLUMN `other_description`, DROP COLUMN `cooperation`, DROP COLUMN `participation`, 
DROP COLUMN `social_area`, DROP COLUMN `third_part`, DROP COLUMN `regional`, DROP COLUMN `concept`, DROP COLUMN `net_other_goal`, 
CHANGE `goal_id` `goal_number` INT(1) NOT NULL; 

CREATE TABLE `spi_goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_actual` tinyint(1) NOT NULL DEFAULT '1',
  `is_with_desc` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `spi_goal` */

insert  into `spi_goal`(`id`,`name`,`is_actual`,`is_with_desc`) values 
(1,'Gestaltung von Übergängen',1,0),
(2,'Prävention von Schuldistanz',1,0),
(3,'Soziale Kompetenzen',1,0),
(4,'Gewaltprävention',1,0),
(5,'Suchtprävention',1,0),
(6,'Gesundheitsförderung',1,0),
(7,'Elternarbeit',1,0),
(8,'Kinderschutz',1,0),
(9,'Inklusion',1,0),
(10,'Vernetzung im Tandem/Tridem',1,0),
(11,'Mitwirkung in innerschulischen Gremien, AGs usw.',1,0),
(12,'Unterstützung bei der Öffnung in den Sozialraum oder der Einbindung Dritter an den Ort Schule',1,0),
(13,'Mitwirkung in außerschulischen Gremien, AGs, Netzwerken usw.',1,0),
(14,'Sonstiges',1,1);

CREATE TABLE `spi_request_goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_school_goal_id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_request_school_goal_id` (`request_school_goal_id`),
  KEY `spi_goal_id` (`goal_id`),
  CONSTRAINT `spi_goal_id` FOREIGN KEY (`goal_id`) REFERENCES `spi_goal` (`id`),
  CONSTRAINT `spi_request_school_goal_id` FOREIGN KEY (`request_school_goal_id`) REFERENCES `spi_request_school_goal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11425 DEFAULT CHARSET=utf8;


INSERT INTO `spi_page` (`code`, `page_code`, `name`, `is_real_page`, `is_editable`) VALUES ('goal', 'goal', 'Entwicklungziele', '0', '0'); 
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page`;
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('1', @id1, '1');  
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('2', @id1, '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('3', @id1, '1');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('4', @id1, '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('5', @id1, '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('6', @id1, '1');

INSERT INTO `spi_page` (`code`, `page_code`, `name`, `is_real_page`, `is_editable`) VALUES ('request_goal', 'request-goal', 'Antrag-Entwicklungziele', '0', '0');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page`;
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('1', @id1, '1');  
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('2', @id1, '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('3', @id1, '1');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('4', @id1, '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('5', @id1, '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('6', @id1, '1');

UPDATE `spi_document_template_placeholder` SET `name` = '{GD_SCHWERPUNKTZIEL}' WHERE `name` = '{GD_GROUPOFFER_SCHWERPUNKTZIEL}';
UPDATE `spi_document_template_placeholder` SET `name` = '{GD_WEITERESZIEL}' WHERE `name` = '{GD_GROUPOFFER_WEITERESZIEL}'; 
UPDATE `spi_document_template_placeholder` SET `name` = '{GD_OTHER}' WHERE `name` = '{GD_GROUPOFFER_OTHER}';

SELECT @id:=`id` FROM  `spi_document_template_placeholder` WHERE `name` = '{GD_GROUPNET_SCHWERPUNKTZIEL}';
DELETE FROM `spi_document_type_placeholder` WHERE `placeholder_id` = @id; 
SELECT @id:=`id` FROM  `spi_document_template_placeholder` WHERE `name` = '{GD_GROUPNET_WEITERESZIEL}';
DELETE FROM `spi_document_type_placeholder` WHERE `placeholder_id` = @id;
SELECT @id:=`id` FROM  `spi_document_template_placeholder` WHERE `name` = '{GD_GROUPNET_OTHER}';
DELETE FROM `spi_document_type_placeholder` WHERE `placeholder_id` = @id;

DELETE FROM `spi_document_template_placeholder` WHERE `name` = '{GD_GROUPNET_SCHWERPUNKTZIEL}'; 
DELETE FROM `spi_document_template_placeholder` WHERE `name` = '{GD_GROUPNET_WEITERESZIEL}'; 
DELETE FROM `spi_document_template_placeholder` WHERE `name` = '{GD_GROUPNET_OTHER}'; 