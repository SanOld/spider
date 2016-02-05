
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
