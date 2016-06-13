ALTER TABLE `spi_performer` DROP FOREIGN KEY `spi_performer_application_user`;
ALTER TABLE `spi_performer` DROP `application_processing_user_id`;
ALTER TABLE `spi_performer` DROP FOREIGN KEY `spi_performer_budget_user`;
ALTER TABLE `spi_performer` DROP `budget_processing_user_id`;