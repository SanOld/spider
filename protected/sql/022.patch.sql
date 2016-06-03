ALTER TABLE `spi_document_template_placeholder` ADD COLUMN `is_email` TINYINT(1) NOT NULL DEFAULT '0';
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`) VALUES ('EMAIL', 'Placeholder text.', '1');


CREATE TABLE `spi_email_template` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`description` VARCHAR(255),
	`last_change` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` INT(11) NOT NULL,
	`text` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `FK_spi_email_template_spi_user` (`user_id`),
	CONSTRAINT `FK_spi_email_template_spi_user` FOREIGN KEY (`user_id`) REFERENCES `spi_user` (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

INSERT INTO `spi_email_template` ( `name`, `description`, user_id, text) VALUES ('send_password', 'description', '1', 
'Guten Tag <%= @firstname %> <%= @lastname %>,<br>
<br>
Sie oder eine andere Person hat heute ein neues Passwort angefordert.<br>
Ihr neues Passwort lautet: <%= @new_password %><br>
<br>
Bitte melden Sie sich mit dem neuen Passwort an.<br>
<br>
Mit freundlichen Gruessen<br>
 <br>
Stiftung SPI<br>
Programmagentur "Jugendsozialarbeit an Berliner Schulen"<br>
Schicklerstrasse 5-7<br>
10179 Berlin<br>
 <br>
[FON] +49(0)30 2888 496-0<br>
[FAX] +49(0)30 2888 496-20<br>
 <br>
www.spi-programmagentur.de<br>
programmagentur@stiftung-spi.de<br>
 <br>
Stiftung SPI<br>
Sozialpaedagogisches Institut Berlin "Walter May"<br>
rechtsfaehige Stiftung des privaten Rechts<br>
Muellerstr. 74, 13349 Berlin<br>
Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>
 <br>
www.stiftung-spi.de<br>
info@stiftung-spi.de<br>
 <br>
[FON] +49(0)30 459 793-0<br>
[FAX] +49(0)30 459 793-66<br>' 
);

INSERT INTO `spi_email_template` ( `name`, `description`, user_id, text) VALUES ('antrag_acknowledge', 'description', '1', 
'<%= @greeting %><br>
<br>
Ihr foerderfaehiger Antrag mit der Kennziffer <%= @kennziffer %>  wird der Senatsverwaltung zur Bewilligung vorgelegt.<br>
Sowie uns die Bewilligung der Senatsverwaltung vorliegt, werden wir Sie ueber das weitere Vorgehen in Kenntnis setzen.<br>
<br>
Mit freundlichen Gruessen<br>
 <br>
Stiftung SPI<br>
Programmagentur "Jugendsozialarbeit an Berliner Schulen"<br>
Schicklerstrasse 5-7<br>
10179 Berlin<br>
 <br>
[FON] +49(0)30 2888 496-0<br>
[FAX] +49(0)30 2888 496-20<br>
 <br>
www.spi-programmagentur.de<br>
programmagentur@stiftung-spi.de<br>
 <br>
Stiftung SPI<br>
Sozialpaedagogisches Institut Berlin "Walter May"<br>
rechtsfaehige Stiftung des privaten Rechts<br>
Muellerstr. 74, 13349 Berlin<br>
Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>
 <br>
www.stiftung-spi.de<br>
info@stiftung-spi.de<br>
 <br>
[FON] +49(0)30 459 793-0<br>
[FAX] +49(0)30 459 793-66<br>' 
);

INSERT INTO `spi_email_template` ( `name`, `description`, user_id, text) VALUES ('antrag_approved', 'description', '1', 
'<%= @greeting %><br>
<br>
Ihr Antrag mit der Kennziffer <%= @kennziffer %> wurde von der Senatsverwaltung bewilligt. Bitte loggen Sie sich in die Programmdatenbank ein (https://spider.stiftung-spi.de), drucken Sie den Antrag EINMAL und den Foerdervertrag ZWEIMAL aus. Unterschreiben Sie ALLE DREI Exemplare und senden Sie diese (und falls noch nicht geschehen mit den entsprechenden Anlagen) bitte an die Programmagentur.<br>
<br>
Mit freundlichen Gruessen<br>
 <br>
Stiftung SPI<br>
Programmagentur "Jugendsozialarbeit an Berliner Schulen"<br>
Schicklerstrasse 5-7<br>
10179 Berlin<br>
 <br>
[FON] +49(0)30 2888 496-0<br>
[FAX] +49(0)30 2888 496-20<br>
 <br>
www.spi-programmagentur.de<br>
programmagentur@stiftung-spi.de<br>
 <br>
Stiftung SPI<br>
Sozialpaedagogisches Institut Berlin "Walter May"<br>
rechtsfaehige Stiftung des privaten Rechts<br>
Muellerstr. 74, 13349 Berlin<br>
Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>
 <br>
www.stiftung-spi.de<br>
info@stiftung-spi.de<br>
 <br>
[FON] +49(0)30 459 793-0<br>
[FAX] +49(0)30 459 793-66<br>' 
);

INSERT INTO `spi_email_template` ( `name`, `description`, user_id, text) VALUES ('antrag_reject', 'description', '1', 
'<%= @greeting %><br>
<br>
Ihr Antrag mit der Kennziffer <%= @kennziffer %> ist noch nicht foerderfaehig.<br>
Die entsprechenden Anmerkungen finden Sie im Antrag unter <%= @link %><br>
<br>
Mit freundlichen Gruessen<br>
 <br>
Stiftung SPI<br>
Programmagentur "Jugendsozialarbeit an Berliner Schulen"<br>
Schicklerstrasse 5-7<br>
10179 Berlin<br>
 <br>
[FON] +49(0)30 2888 496-0<br>
[FAX] +49(0)30 2888 496-20<br>
 <br>
www.spi-programmagentur.de<br>
programmagentur@stiftung-spi.de<br>
 <br>
Stiftung SPI<br>
Sozialpaedagogisches Institut Berlin "Walter May"<br>
rechtsfaehige Stiftung des privaten Rechts<br>
Muellerstr. 74, 13349 Berlin<br>
Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>
 <br>
www.stiftung-spi.de<br>
info@stiftung-spi.de<br>
 <br>
[FON] +49(0)30 459 793-0<br>
[FAX] +49(0)30 459 793-66<br>' 
);

INSERT INTO `spi_email_template` ( `name`, `description`, user_id, text) VALUES ('finanzbericht_reject', 'description', '1', 
'Sehr geehrte Damen und Herren,<br>
<br>
Ihr Verwendungsnachweis zu dem Projekt mit der Kennziffer <%= @kennziffer %><br>
wurden Ihnen zur Ueberarbeitung zurueckgeschickt.<br>
Bitte korrigieren und/oder ergaenzen Sie den Verwendungsnachweis: <%= @link %><br>
<br>
Mit freundlichen Gruessen<br>
 <br>
Stiftung SPI<br>
Programmagentur "Jugendsozialarbeit an Berliner Schulen"<br>
Schicklerstrasse 5-7<br>
10179 Berlin<br>
 <br>
[FON] +49(0)30 2888 496-0<br>
[FAX] +49(0)30 2888 496-20<br>
 <br>
www.spi-programmagentur.de<br>
programmagentur@stiftung-spi.de<br>
 <br>
Stiftung SPI<br>
Sozialpaedagogisches Institut Berlin "Walter May"<br>
rechtsfaehige Stiftung des privaten Rechts<br>
Muellerstr. 74, 13349 Berlin<br>
Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>
 <br>
www.stiftung-spi.de<br>
info@stiftung-spi.de<br>
 <br>
[FON] +49(0)30 459 793-0<br>
[FAX] +49(0)30 459 793-66<br>' 
);

INSERT INTO `spi_email_template` ( `name`, `description`, user_id, text) VALUES ('send_account_data', 'description', '1', 
'Sehr geehrte Damen und Herren,<br>
<br>
ab sofort ist das Online-Verfahren zum Ausfuellen der Antraege freigeschaltet.<br>
 <br>
Fuer den Traeger <%= @group_name %> ist ein Zugang unter<br>
 <br>
https://spider.stiftung-spi.de<br>
<br>
eingerichtet.<br>
 <br>
Bitte melden Sie sich mit folgenden Daten an:<br>
 <br>
==== Benutzername: <%= @login %><br>
==== Passwort: <%= @password %><br>
 <br>
Aus Sicherheitsgruenden aendern Sie bitte sofort nach dem ersten Login Ihr Passwort.<br>
<br>
Sollten Sie Hilfe benoetigen, schicken Sie bitte eine E-Mail an:<br>
hilfe@stiftung-spi.de<br>
<br>
Mit freundlichen Gruessen<br>
 <br>
Stiftung SPI<br>
Programmagentur "Jugendsozialarbeit an Berliner Schulen"<br>
Schicklerstrasse 5-7<br>
10179 Berlin<br>
 <br>
[FON] +49(0)30 2888 496-0<br>
[FAX] +49(0)30 2888 496-20<br>
 <br>
www.spi-programmagentur.de<br>
programmagentur@stiftung-spi.de<br>
 <br>
Stiftung SPI<br>
Sozialpaedagogisches Institut Berlin "Walter May"<br>
rechtsfaehige Stiftung des privaten Rechts<br>
Muellerstr. 74, 13349 Berlin<br>
Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>
 <br>
www.stiftung-spi.de<br>
info@stiftung-spi.de<br>
 <br>
[FON] +49(0)30 459 793-0<br>
[FAX] +49(0)30 459 793-66<br>' 
);

INSERT INTO `spi_page` (`code`, `name`, `is_real_page`) VALUES ('email_template', 'Email-Vorlagen', '1');
SELECT @e:=id FROM `spi_page` WHERE `code`= 'email_template';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'name', 'Name');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'description', 'Description');
SELECT @id2:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'text', 'Text');
SELECT @id3:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'header', 'Header');
SELECT @id4:=LAST_INSERT_ID() FROM  `spi_page_position`;


INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Example. Email-Vorlagen');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id2, '', 'Test message for temlate document type. Email-Vorlagen');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id3, '', 'Test message for temlate text. Email-Vorlagen');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id4, 'Druck-Templates', 'Test message for temlate text. Email-Vorlagen');


INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @e, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @e, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @e, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @e, 0, 0, 0);