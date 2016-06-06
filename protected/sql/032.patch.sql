SELECT @e:=id FROM `spi_page` WHERE `code`= 'email_template';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'subject', 'Subject');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;



INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Example. Subject');

