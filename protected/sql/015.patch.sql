ALTER TABLE `spi_bank_details` ADD `performer_id` INT  NOT NULL AFTER `outer_id`;
ALTER TABLE `spi_performer` DROP FOREIGN KEY `spi_performer_bank_details`;
ALTER TABLE `spi_performer` DROP `bank_details_id`;
DELETE FROM spi_bank_details;
ALTER TABLE `spi_bank_details` ADD CONSTRAINT `spi_bank_details_performer` FOREIGN KEY (`performer_id`) REFERENCES `spi_performer` (`id`) ON DELETE CASCADE;
