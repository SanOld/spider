SELECT @id FROM  `spi_page_position` WHERE code = 'last_name';
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('1', @id, 'Title', 'Test description for Nachname');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('1', 'is_virtual', 'Virtual', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('1', @id, 'Title', 'Test description for Virtualbenutzer');


