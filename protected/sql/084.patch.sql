CREATE TABLE `spi_document_type_placeholder` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`document_type_id` INT(11) NULL DEFAULT NULL,
	`placeholder_id` INT(11) NOT NULL,
	`is_email` TINYINT(1) NOT NULL DEFAULT '0',
	`email_document_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=0
;


INSERT INTO spi_document_type_placeholder (document_type_id, placeholder_id)
select  3 as d, tbl.id from spi_document_template_placeholder  tbl where tbl.is_email = '0';

INSERT INTO spi_document_type_placeholder (document_type_id, placeholder_id)
select  2 as d, tbl.id from spi_document_template_placeholder  tbl 
where tbl.name = '{KENNZIFFER}' 
or tbl.name = '{TRAEGER}' 
or tbl.name = '{JAHR}' 
or tbl.name = '{FOREACH=SCHOOL KEY=SC}' 
or tbl.name = '{FOREACH_END=SCHOOL}' 
or tbl.name = '{SC_SCHOOLNAME}' 
or tbl.name = '{SC_SCHOOLNUMBER}' 
or tbl.name = '{SC_SCHOOLNUMBER}' 

or tbl.name = '{GD_NAME}' 
or tbl.name = '{GD_DESCRIPTION}' 
or tbl.name = '{GD_GROUPOFFER_SCHWERPUNKTZIEL}' 
or tbl.name = '{GD_GROUPOFFER_WEITERESZIEL}' 
or tbl.name = '{GD_GROUPOFFER_OTHER}' 
or tbl.name = '{GD_GROUPNET_SCHWERPUNKTZIEL}' 
or tbl.name = '{GD_GROUPNET_WEITERESZIEL}' 
or tbl.name = '{GD_GROUPNET_OTHER}' 
or tbl.name = '{GD_UMSETZUNG}' 
or tbl.name = '{GD_INDIKATOREN1}' 
or tbl.name = '{GD_INDIKATOREN2}' 
or tbl.name = '{GD_INDIKATOREN3}' 
or tbl.name = '{GD_INDIKATOREN4}' 
or tbl.name = '{GD_INDIKATOREN5}' 
;


INSERT INTO spi_document_type_placeholder (document_type_id, placeholder_id)
select  1 as d, tbl.id from spi_document_template_placeholder  tbl 
where tbl.name = '{KENNZIFFER}' 
or tbl.name = '{TRAEGER}' 
or tbl.name = '{JAHR}' 
or tbl.name = '{ZEITRAUM}' 
or tbl.name = '{FOERDERSUMME}' 
or tbl.name = '{AUFLAGEN}' 
;


INSERT INTO spi_document_type_placeholder (email_document_id, placeholder_id, is_email)
select  tbl.document_id, tbl.id, tbl.is_email from spi_document_template_placeholder  tbl 
where tbl.is_email = '1' 
;

ALTER TABLE `spi_document_template_placeholder` 
drop COLUMN `is_email`,
drop COLUMN `document_id`;