ALTER TABLE `spi_project`
	CHANGE COLUMN `rate` `rate` DECIMAL(7,3) NOT NULL AFTER `code`;

ALTER TABLE `spi_request_school_finance`
	CHANGE COLUMN `rate` `rate` DECIMAL(7,3) NULL DEFAULT NULL AFTER `school_id`;