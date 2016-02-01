
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('a', 'Admin');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('a', 'PA');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('t', 'TA');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('s', 'School');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('d', 'District');
INSERT INTO `spi_user_type` (`type`, `name`) VALUES ('a', 'Senat');

ALTER TABLE `spi_user` ADD COLUMN `type_id` INT(11) NOT NULL ALTER `type`;
