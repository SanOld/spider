ALTER TABLE spi_performer ADD COLUMN checked_by INT(11) AFTER is_checked;
ALTER TABLE spi_performer ADD COLUMN checked_date DATE AFTER checked_by;
ALTER TABLE `spi_performer` ADD CONSTRAINT `spi_performer_checked_by_user` FOREIGN KEY (`checked_by`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL;
ALTER TABLE spi_performer ADD COLUMN bank_details_id INT(11);
ALTER TABLE `spi_performer` ADD CONSTRAINT `spi_performer_bank_details` FOREIGN KEY (`bank_details_id`) REFERENCES `spi_bank_details` (`id`) ON DELETE SET NULL;
ALTER TABLE `spi_bank_details` DROP FOREIGN KEY `spi_bank_detals_performer`;
ALTER TABLE `spi_bank_details` DROP `performer_id`;

