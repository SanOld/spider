ALTER TABLE `spi_request_user` DROP COLUMN `is_umlage`;
ALTER TABLE `spi_request` ADD COLUMN `is_umlage` TINYINT(1) NOT NULL DEFAULT 0;
