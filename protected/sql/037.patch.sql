ALTER TABLE `spi_request`
	ADD COLUMN `end_fill` DATE NULL DEFAULT NULL AFTER `last_change`;
