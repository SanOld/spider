ALTER TABLE `spi_page_position` ADD COLUMN `is_double` TINYINT(1) DEFAULT 0 NOT NULL AFTER `name`;

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`) VALUES ('8', 'projectData', 'Projektdaten'); 
INSERT INTO `spi_page_position` (`page_id`, `code`, `name`) VALUES ('8', 'finData', 'Finanzplan'); 
INSERT INTO `spi_page_position` (`page_id`, `code`, `name`) VALUES ('8', 'conceptData', 'Konzept'); 
INSERT INTO `spi_page_position` (`page_id`, `code`,`name`) VALUES ('8', 'goalData','Entwicklungsziele');

DELETE FROM `spi_page_position` WHERE `code`= 'projectDataHeader'; 
DELETE FROM `spi_page_position` WHERE `code`= 'projectDataText';
DELETE FROM `spi_page_position` WHERE `code`= 'finDataHeader'; 
DELETE FROM `spi_page_position` WHERE `code`= 'finDataText';
DELETE FROM `spi_page_position` WHERE `code`= 'conceptDataHeader'; 
DELETE FROM `spi_page_position` WHERE `code`= 'conceptDataText';
DELETE FROM `spi_page_position` WHERE `code`= 'goalDataHeader'; 
DELETE FROM `spi_page_position` WHERE `code`= 'goalDataText'; 

UPDATE `spi_page_position` SET `is_double` = '1' WHERE `code` = 'header'; 
UPDATE `spi_page_position` SET `is_double` = '1' WHERE `code` = 'projectData'; 
UPDATE `spi_page_position` SET `is_double` = '1' WHERE `code` = 'finData'; 
UPDATE `spi_page_position` SET `is_double` = '1' WHERE `code` = 'conceptData'; 
UPDATE `spi_page_position` SET `is_double` = '1' WHERE `code` = 'goalData';