ALTER TABLE `spi_financial_request` ADD COLUMN `is_partial_rate` INT(1) NOT NULL AFTER `representative_user_id`;
UPDATE `spi_rate` SET `name` = 'Sep-Okt' WHERE `id` = '5'; 
UPDATE `spi_rate` SET `name` = 'Mrz-Apr' WHERE `id` = '2'; 
ALTER TABLE `spi_financial_request` CHANGE `is_partial_rate` `is_partial_rate` VARCHAR(3) NULL;