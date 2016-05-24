
CREATE TABLE `spi_document_template_placeholder` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL DEFAULT '0',
	`text` VARCHAR(255) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;


INSERT INTO `spi_document_template_placeholder` (`name`, `text`) VALUES ('AUFLAGEN', 'Bei der Antragsabnahme können Auflagen durch die Programmagentur hinzugefügt bzw. formuliert werden.');
INSERT INTO `spi_document_template_placeholder` (`name`, `text`) VALUES ('FOERDERSUMME', 'Die Fördersumme aus dem förderfähigen Antrag.');
INSERT INTO `spi_document_template_placeholder` (`name`, `text`) VALUES ('JAHR', 'Förderjahr des Antrags.');
INSERT INTO `spi_document_template_placeholder` (`name`, `text`) VALUES ('KENNZIFFER', 'Die Kennziffer des Projekts wird aus dem Antrag übernommen.');
INSERT INTO `spi_document_template_placeholder` (`name`, `text`) VALUES ('TRAEGER', 'Name und Adresse des antragsstellenden Trägers.');
INSERT INTO `spi_document_template_placeholder` (`name`, `text`) VALUES ('ZEITRAUM', 'Laufzeit laut förderfähigem Antrag (Beginn und Ende).');



CREATE TABLE `spi_document_template_type` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

INSERT INTO `spi_document_template_type` (`name`) VALUES ('Alles anzeigen');
INSERT INTO `spi_document_template_type` (`name`) VALUES ('Fördervertrag');
INSERT INTO `spi_document_template_type` (`name`) VALUES ('Zielvereinbarung');
INSERT INTO `spi_document_template_type` (`name`) VALUES ('Antrag');
INSERT INTO `spi_document_template_type` (`name`) VALUES ('Mittelabruf');
INSERT INTO `spi_document_template_type` (`name`) VALUES ('Verwendungsnachweis');




CREATE TABLE `spi_document_template` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`type_id` INT(11) NOT NULL,
	`last_change` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` INT(11) NOT NULL,
	`text` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `spi_document_type` (`type_id`),
	INDEX `FK_spi_document_template_spi_user` (`user_id`),
	CONSTRAINT `FK_spi_document_template_spi_user` FOREIGN KEY (`user_id`) REFERENCES `spi_user` (`id`),
	CONSTRAINT `spi_document_type` FOREIGN KEY (`type_id`) REFERENCES `spi_document_template_type` (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

INSERT INTO `spi_page` (`code`, `name`, `is_real_page`) VALUES ('document_templates', 'Druck-Templates', '1');
SELECT @e:=id FROM `spi_page` WHERE `code`= 'document_templates';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'name', 'Name');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'document_type', 'Dokument-Typ');
SELECT @id2:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'text', 'Text');
SELECT @id3:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'header', 'Header');
SELECT @id4:=LAST_INSERT_ID() FROM  `spi_page_position`;


INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Example');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id2, '', 'Test message for temlate document type. Druck-Template bearbeiten');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id3, '', 'Test message for temlate text. Druck-Template bearbeiten');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id4, 'Druck-Templates', 'Test message for temlate text. Druck-Template bearbeiten');


INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @e, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @e, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @e, 0, 0, 0);
