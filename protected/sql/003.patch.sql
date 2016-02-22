CREATE TABLE `spi_school_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(1) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `spi_school` ADD COLUMN `type_id` int(11) NOT NULL;
ALTER TABLE `spi_school` ADD CONSTRAINT `spi_school_type` FOREIGN KEY (`type_id`) REFERENCES `spi_school_type` (`id`);
ALTER TABLE `spi_school` ADD CONSTRAINT `spi_school_district` FOREIGN KEY (`district_id`) REFERENCES `spi_district` (`id`);
ALTER TABLE `spi_school` ADD CONSTRAINT `spi_school_user` FOREIGN KEY (`contact_id`) REFERENCES `spi_user` (`id`);

INSERT INTO spi_school_type (`code`, `name`) VALUES ('h', 'Hauptschulen');
INSERT INTO spi_page (`code`, `name`) VALUE ('school', 'Schule');
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (5, 'header', 'Header');
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_view`, `can_edit`) VALUE (1, 5, 1, 1);
UPDATE spi_page SET name = 'Benutzerliste' WHERE id = 1;
UPDATE spi_page SET name = 'Benutzerrollen' WHERE id = 2;
UPDATE spi_page SET name = 'Hilfetexte' WHERE id = 3;