SELECT @e:=id FROM `spi_page` WHERE `code`= 'financial_request';
INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('38', 'header', '<Überschrift>', '1');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title` , `description`) VALUES (@e,@id1,'Title','Mittelabrufe <Überschrift>');