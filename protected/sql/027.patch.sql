ALTER TABLE `spi_request` ADD COLUMN `status_finance` VARCHAR(1) NOT NULL DEFAULT 'g' ;
ALTER TABLE `spi_request` ADD COLUMN `status_concept` VARCHAR(1) NOT NULL DEFAULT 'g' ;
ALTER TABLE `spi_request` ADD COLUMN `status_goal` VARCHAR(1) NOT NULL DEFAULT 'g' ;