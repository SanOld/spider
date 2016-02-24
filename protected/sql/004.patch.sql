ALTER TABLE `spi_finance_source` 
DROP COLUMN `finance_programm_id`,
DROP COLUMN `bank_name`,
DROP COLUMN `iban`,
DROP COLUMN `contact_person`,
DROP COLUMN `year`,
CHANGE COLUMN `finance_source_type` `finance_source_type` VARCHAR(1) NOT NULL DEFAULT 'l' AFTER `id`,
CHANGE COLUMN `name` `programm` VARCHAR(255) NOT NULL ,
ADD COLUMN `description` TEXT NULL AFTER `programm`;