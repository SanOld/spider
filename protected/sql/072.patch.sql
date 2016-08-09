SELECT @e:=id FROM `spi_page` WHERE `code`= 'request';

INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'goals_goal', 'Entwicklungsziel ');
SELECT @id1:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'goals_groupOffer', 'Angebote für Schüler/innen und Eltern');
SELECT @id2:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'goals_groupNet', 'Interne / Externe Vernetzung');
SELECT @id3:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'implementation', 'Umsetzung');
SELECT @id4:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@e, 'indicators', 'Indikatoren und Zielwerte');
SELECT @id5:=LAST_INSERT_ID() FROM  `spi_page_position`;

INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id1, 'Title', 'Example. Entwicklungsziel');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id2, 'Title', 'Example. Angebote für Schüler/innen und Eltern');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id3, 'Title', 'Example. Interne / Externe Vernetzung');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id4, 'Title', 'Example. Umsetzung');
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES (@e, @id5, 'Title', 'Example. Indikatoren und Zielwerte');

UPDATE `spi_page_position` SET `is_double`=1 WHERE 1=1