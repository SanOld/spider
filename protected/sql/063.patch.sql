ALTER TABLE `spi_page` ADD COLUMN `is_editable` TINYINT(1) DEFAULT 1 NOT NULL AFTER `is_without_login`;
UPDATE `spi_page` SET `is_editable` = '0' WHERE `id` = '31'; 
UPDATE `spi_page` SET `is_editable` = '0' WHERE `id` = '30'; 
UPDATE `spi_page` SET `is_editable` = '0' WHERE `id` = '21';