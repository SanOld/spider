ALTER TABLE `spi_request_school_finance`
	CHANGE COLUMN `month_count` `month_count` TINYINT(2) NULL DEFAULT '12' AFTER `rate`;