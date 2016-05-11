ALTER TABLE `spi_project` 
DROP COLUMN `finance_programm_id`,
DROP COLUMN `finance_source_type`,
ADD COLUMN `rate` FLOAT(3,2) NOT NULL AFTER `code`,
ADD COLUMN `type_id` INT(11) NOT NULL AFTER `district_id`,
ADD COLUMN `is_old` TINYINT(1) NOT NULL DEFAULT 0 AFTER `type_id`,
CHANGE COLUMN `code` `code` VARCHAR(10) NOT NULL ;

CREATE TABLE `spi_project_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));


INSERT INTO `spi_project_type` (`name`) VALUES ('Schulsozialarbeit');
INSERT INTO `spi_project_type` (`name`) VALUES ('Zusatzprojekte');
INSERT INTO `spi_project_type` (`name`) VALUES ('Bonusprogramm');