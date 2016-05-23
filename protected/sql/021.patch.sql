START TRANSACTION;

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


INSERT INTO `spider`.`spi_document_template_placeholder` (`name`, `text`) VALUES ('AUFLAGEN', 'Bei der Antragsabnahme können Auflagen durch die Programmagentur hinzugefügt bzw. formuliert werden.');
INSERT INTO `spider`.`spi_document_template_placeholder` (`name`, `text`) VALUES ('FOERDERSUMME', 'Die Fördersumme aus dem förderfähigen Antrag.');
INSERT INTO `spider`.`spi_document_template_placeholder` (`name`, `text`) VALUES ('JAHR', 'Förderjahr des Antrags.');
INSERT INTO `spider`.`spi_document_template_placeholder` (`name`, `text`) VALUES ('KENNZIFFER', 'Die Kennziffer des Projekts wird aus dem Antrag übernommen.');
INSERT INTO `spider`.`spi_document_template_placeholder` (`name`, `text`) VALUES ('TRAEGER', 'Name und Adresse des antragsstellenden Trägers.');
INSERT INTO `spider`.`spi_document_template_placeholder` (`name`, `text`) VALUES ('ZEITRAUM', 'Laufzeit laut förderfähigem Antrag (Beginn und Ende).');



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

INSERT INTO `spider`.`spi_document_template_type` (`name`) VALUES ('Alles anzeigen');
INSERT INTO `spider`.`spi_document_template_type` (`name`) VALUES ('Fördervertrag');
INSERT INTO `spider`.`spi_document_template_type` (`name`) VALUES ('Zielvereinbarung');
INSERT INTO `spider`.`spi_document_template_type` (`name`) VALUES ('Antrag');
INSERT INTO `spider`.`spi_document_template_type` (`name`) VALUES ('Mittelabruf');
INSERT INTO `spider`.`spi_document_template_type` (`name`) VALUES ('Verwendungsnachweis');




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

INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2013_Sonderkündigung', 1, '2016-05-18 12:51:31', 1, 
    '<b>Zwischen</b><br>
    der<br>
    Stiftung Sozialpädagogisches Institut Berlin<br>
    Programmagentur “Jugendsozialarbeit an Berliner Schulen”<br>
    Schicklerstraße 5-7 in 10179 Berlin<br>

    - nachstehend Programmagentur SPI genannt -<br>
    und dem Träger<br>

    <strong>{TRAEGER}</strong> mit der Kennziffer <strong>{KENNZIFFER}</strong><br>

    - nachstehend Förderungsempfänger genannt -<br>
    wird folgender<br>
    <h3>FÖRDERVERTRAG (Weiterleitungsvertrag)</h3>
    geschlossen.<br>

    <h4>§ 1 Grundsätzliche Regelungen</h4>

    (1) Die Programmagentur SPI ist vom Land Berlin, vertreten durch die Senatsverwaltung für Bildung, Jugend und Wissenschaft beauftragt worden, das Programm „Jugendsozialarbeit an Berliner Schulen“ umzusetzen. Das Programm wird durch Mittel des Berliner Landeshaushalts finanziert.<br>

    (2) Zur Umsetzung des Programms entwickeln die freien Träger der Kinder- und Jugendhilfe zusammen mit einer Schule bzw. mehreren Schulen (betrifft Jugendsozialarbeit mit besonderen Aufgaben) konkrete auf die jeweilige Schule bezogene Konzepte. Dazu werden Kooperationsverträge zwischen den Schulen und den freien Trägern der Kinder- und Jugendhilfe abgeschlossen.<br>

    (3) Die freien Träger verpflichten sich, das Gender-Mainstreaming-Prinzip anzuwenden, d. h. bei der Planung, Durchführung und Begleitung der Maßnahme sind Auswirkungen auf die Gleichstellung von Frauen und Männern aktiv zu berücksichtigen und in der Berichterstattung darzustellen.<br>

    <h4>§ 2 Vertragsgegenstand und -bestandteile</h4>

    (1) Gegenstand dieses privatrechtlichen Vertrages ist die Weitergabe von Zuwendungen des Landes Berlin durch die Programmagentur SPI an die Förderungsempfänger auf der Grundlage entsprechender Bewilligungsbescheide der Senatsverwaltung für Bildung, Jugend und Wissenschaft.<br>

    (2) Bestandteile dieses Vertrages sind – in ihrer jeweils geltenden Fassung – insbesondere:<br>
    Antrag des Förderungsempfängers inkl. Finanzplan,'
);
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2013_Z010', 1, '2016-05-18 12:51:31', 1, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2014_Bonus', 3, '2016-05-18 12:51:31', 1, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2014_LM', 2, '2016-05-18 12:51:31', 3, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2014_Sonderkündigung', 2, '2016-05-18 12:51:31', 7, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2014_Z010', 3, '2016-05-18 12:51:31', 3, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2015_Bonus', 2, '2016-05-18 12:51:31', 5, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2015_LM', 1, '2016-05-18 12:51:31', 1, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2015_S', 1, '2016-05-18 12:51:31', 1, 'text');
INSERT INTO `spider`.`spi_document_template` (`name`, `type_id`, `last_change`, `user_id`, `text`) VALUES ('FV_2015_S', 1, '2016-05-18 12:51:31', 1, 'text');



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


INSERT INTO `spider`.`spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Example');
INSERT INTO `spider`.`spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id2, '', 'Test message for temlate document type. Druck-Template bearbeiten');
INSERT INTO `spider`.`spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id3, '', 'Test message for temlate text. Druck-Template bearbeiten');
INSERT INTO `spider`.`spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id4, 'Druck-Templates', 'Test message for temlate text. Druck-Template bearbeiten');


INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @e, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @e, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @e, 0, 0, 0);

COMMIT;