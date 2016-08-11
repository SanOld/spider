ALTER TABLE `spi_financial_request` CHANGE `rate_id` `rate_id` TINYINT(1) NULL;
ALTER TABLE `spi_financial_request` DROP FOREIGN KEY `spi_rate`; 