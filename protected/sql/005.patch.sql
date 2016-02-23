ALTER TABLE `spi_district` ADD CONSTRAINT `spi_district_user` FOREIGN KEY (`contact_id`) REFERENCES `spi_user` (`id`);

INSERT INTO spi_page (`code`, `name`) VALUE ('district', 'Bezirk');
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (6, 'header', 'Header');
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_view`, `can_edit`) VALUE (1, 6, 1, 1);