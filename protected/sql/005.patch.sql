ALTER TABLE spi_user ADD COLUMN function VARCHAR(45) AFTER title;
ALTER TABLE spi_performer DROP COLUMN outer_id;
ALTER TABLE spi_bank_details ADD COLUMN outer_id VARCHAR(45);
ALTER TABLE spi_bank_details ADD COLUMN performer_id INT(11);

ALTER TABLE `spi_bank_details` ADD CONSTRAINT `spi_bank_detals_performer` FOREIGN KEY (`performer_id`) REFERENCES `spi_performer` (`id`) ON DELETE CASCADE;
ALTER TABLE `spi_performer` ADD CONSTRAINT `spi_performer_representative_user` FOREIGN KEY (`representative_user_id`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL;
ALTER TABLE `spi_performer` ADD CONSTRAINT `spi_performer_application_user` FOREIGN KEY (`application_processing_user_id`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL;
ALTER TABLE `spi_performer` ADD CONSTRAINT `spi_performer_budget_user` FOREIGN KEY (`budget_processing_user_id`) REFERENCES `spi_user` (`id`) ON DELETE SET NULL;

INSERT INTO spi_page (code, name) VALUES ('performer', 'Träger Agentur');