UPDATE `spi_request_status` SET `name` = 'Antrag initial ausfüllen' WHERE `id` = '1'; .
INSERT INTO `spi_request_status` (`code`, `name`) VALUES ('wait', 'Nach Überprüfung');
UPDATE `spi_request_status` SET `name` = 'Antragsprüfung' WHERE `id` = '3'; 