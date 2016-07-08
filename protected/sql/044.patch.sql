
SELECT @e:=id FROM `spi_page` WHERE `code`= 'request';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'fin_plan_school_traning_cost', 'Fortbildungskosten');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;

INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Fortbildungskosten');