
SELECT @e:=id FROM `spi_page` WHERE `code`= 'request';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'projectDataHeader', 'Projektdaten Header');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'projectDataText', 'Projektdaten Text');
SELECT @id2:=LAST_INSERT_ID() FROM  `spi_page_position`;

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'finDataHeader', 'Finanzplan Header');
SELECT @id3:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'finDataText', 'Finanzplan Text');
SELECT @id4:=LAST_INSERT_ID() FROM  `spi_page_position`;

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'conceptDataHeader', 'Konzept Header');
SELECT @id5:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'conceptDataText', 'Konzept Text');
SELECT @id6:=LAST_INSERT_ID() FROM  `spi_page_position`;

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'goalDataHeader', 'Entwicklungsziele Header');
SELECT @id7:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'goalDataText', 'Entwicklungsziele Text');
SELECT @id8:=LAST_INSERT_ID() FROM  `spi_page_position`;


INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, '', 'Example. Projektdaten Header');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id2, '', 'Example. Projektdaten Text');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id3, '', 'Example. Finanzplan Header');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id4, '', 'Example. Finanzplan Text');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id5, '', 'Example. Konzept Header');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id6, '', 'Example. Konzept Text');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id7, '', 'Example. Entwicklungsziele Header');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id8, '', 'Example. Entwicklungsziele Text');