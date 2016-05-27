ALTER TABLE `spi_request` ADD COLUMN `additional_info` TEXT ;
ALTER TABLE `spi_request` ADD COLUMN `senat_additional_info` TEXT ;
ALTER TABLE `spi_request` ADD COLUMN `request_user_id` INT(11) ;
ALTER TABLE `spi_request` ADD COLUMN `concept_user_id` INT(11) ;
ALTER TABLE `spi_request` ADD COLUMN `finance_user_id` INT(11) ;