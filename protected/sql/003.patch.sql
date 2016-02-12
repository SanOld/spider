ALTER TABLE `spi_performer` ADD COLUMN `representative_user_id` INT NULL;
ALTER TABLE `spi_performer` ADD COLUMN `application_processing_user_id` INT NULL;
ALTER TABLE `spi_performer` ADD COLUMN `budget_processing_user_id` INT NULL;
ALTER TABLE `spi_performer` ADD COLUMN `outer_id` VARCHAR(45) NULL;


CREATE TABLE `spi_bank_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contact_person` VARCHAR(45) NULL,
  `iban` VARCHAR(34) NOT NULL,
  `bank_name` VARCHAR(45) NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`)
);
