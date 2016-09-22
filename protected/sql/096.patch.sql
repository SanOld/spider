RENAME TABLE `spi_finance_cost_type` TO `spi_finance_method_type`;
RENAME TABLE `spi_payment_method_type` TO `spi_finance_cost_type`;
RENAME TABLE `spi_finance_method_type` TO `spi_payment_method_type`;

ALTER TABLE `spi_finance_report` DROP FOREIGN KEY `spi_report_cost`; 
ALTER TABLE `spi_finance_report` ADD CONSTRAINT `spi_report_cost` FOREIGN KEY (`cost_type_id`) REFERENCES `spi_finance_cost_type`(`id`); 
ALTER TABLE `spi_finance_report` CHANGE `payer` `payer` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `spi_finance_report` CHANGE `base` `base` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci NULL, CHANGE `payment_method_id` `payment_method_id` INT(11) NULL, CHANGE `reasoning` `reasoning` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci NULL;
UPDATE `spi_finance_report_status` SET `name` = 'Ungeprüfter Beleg' WHERE `id` = '1';
