ALTER TABLE `spi_user` CHANGE COLUMN `is_system` `is_virtual` TINYINT(1) NOT NULL DEFAULT '0' ;

SELECT @e:=id FROM `spi_page` WHERE `code`= 'email_template';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'subject', 'Subject');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;

INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Example. Subject');

ALTER TABLE `spi_request_status` CHANGE COLUMN `code` `code` VARCHAR(45) NOT NULL ;
UPDATE `spi_request_status` SET `code`='open' WHERE `id`='1';
UPDATE `spi_request_status` SET `code`='decline' WHERE `id`='2';
UPDATE `spi_request_status` SET `code`='in_progress' WHERE `id`='3';
UPDATE `spi_request_status` SET `code`='acceptable' WHERE `id`='4';
UPDATE `spi_request_status` SET `code`='accept' WHERE `id`='5';


ALTER TABLE `spi_request` 
CHANGE COLUMN `status_finance` `status_finance` VARCHAR(45) NOT NULL DEFAULT 'open' ,
CHANGE COLUMN `status_concept` `status_concept` VARCHAR(45) NOT NULL DEFAULT 'open' ,
CHANGE COLUMN `status_goal` `status_goal` VARCHAR(45) NOT NULL DEFAULT 'open' ;


UPDATE `spi_request` SET `status_finance`='unfinished' WHERE `status_finance`='a';
UPDATE `spi_request` SET `status_concept`='unfinished' WHERE `status_concept`='a';
UPDATE `spi_request` SET `status_goal`='unfinished' WHERE `status_goal`='a';


ALTER TABLE `spi_request` 
CHANGE COLUMN `doc_target agreement_id` `doc_target_agreement_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `doc_financing agreement_id` `doc_financing_agreement_id` INT(11) NULL DEFAULT NULL ;


TRUNCATE TABLE `spi_document_template`;
TRUNCATE TABLE `spi_document_template_type`;
ALTER TABLE `spi_document_template_type` ADD COLUMN `code` VARCHAR(45) NOT NULL AFTER `id`;
INSERT INTO `spi_document_template_type` (`id`, `name`, `code`) VALUES ('1', 'Fördervertrag', 'funding_agreement');
INSERT INTO `spi_document_template_type` (`id`, `name`, `code`) VALUES ('2', 'Zielvereinbarung', 'goal_agreement');
INSERT INTO `spi_document_template_type` (`id`, `name`, `code`) VALUES ('3', 'Antrag', 'request');
INSERT INTO `spi_document_template_type` (`id`, `name`, `code`) VALUES ('4', 'Mittelabruf', 'financing_request');
INSERT INTO `spi_document_template_type` (`id`, `name`, `code`) VALUES ('5', 'Verwendungsnachweis', 'spending_report');

ALTER TABLE `spi_document_template` ADD COLUMN `type_code` VARCHAR(45) NOT NULL AFTER `type_id`;

