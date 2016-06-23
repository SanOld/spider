ALTER TABLE `spi_document_template_placeholder` ADD COLUMN `document_id` INT(11) NULL DEFAULT NULL;

ALTER TABLE `spi_document_template_placeholder`
	DROP INDEX `name`;

SELECT @id1:=id FROM  `spi_email_template` WHERE system_come = 'send_password';


UPDATE `spi_document_template_placeholder` SET `document_id` = @id1 WHERE name = 'NAME';
UPDATE `spi_document_template_placeholder` SET `document_id` = @id1 WHERE name = 'LINK';



SELECT @id2:=id FROM  `spi_email_template` WHERE system_come = 'send_account_data';

INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`, `document_id`) VALUES ('AKTEUR', 'AKTEUR', '1', @id2);
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`, `document_id`) VALUES ('BENUTZERROLLEN', 'BENUTZERROLLEN', '1', @id2);
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`, `document_id`) VALUES ('LOGIN', 'LOGIN', '1', @id2);
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`, `document_id`) VALUES ('PASSWORD', 'PASSWORD', '1', @id2);
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`, `document_id`) VALUES ('NAME', 'Benutzername', '1', @id2);
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`, `document_id`) VALUES ('SITE_URL', 'SITE_URL', '1', @id2);
