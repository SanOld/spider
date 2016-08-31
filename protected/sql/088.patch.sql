ALTER TABLE `spi_document_template` ADD COLUMN `is_prototype` TINYINT(1) DEFAULT 0 NOT NULL AFTER `text`; 

UPDATE `spi_document_template` SET `is_prototype` = '1' WHERE `id` = '3'; 
UPDATE `spi_document_template` SET `is_prototype` = '1' WHERE `id` = '5'; 
UPDATE `spi_document_template` SET `is_prototype` = '1' WHERE `id` = '14'; 
UPDATE `spi_document_template` SET `is_prototype` = '1' WHERE `id` = '13'; 