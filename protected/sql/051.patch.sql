ALTER TABLE `spi_finance_source` ADD COLUMN `prefix` VARCHAR(10) NULL AFTER `description`; 
ALTER TABLE `spi_project` ADD COLUMN `programm_id` INT(11) NOT NULL AFTER `type_id`;
INSERT INTO `spi_page_position` (`page_id`, `code`, `name`) VALUES ('7', 'prefix', 'Präfix'); 
INSERT INTO `spi_hint` (, `page_id`, `position_id`, `description`) VALUES ('7', '123', 'Test message for Fördertöpf hinzufügen - Präfix. Lorem ipsum dolor sit amet, in est quot impetus eleifend.');  