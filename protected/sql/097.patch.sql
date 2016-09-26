INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'year', 'Jahr', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Jahr');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'project_code', 'Projekt', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Projekt');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'report_type', 'Beleg-Typ', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Beleg-Typ');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'cost_type', 'Kostenart', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Kostenart');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'code', 'Belegnummer', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Belegnummer');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'receipt_date', 'Belegdatum', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Belegdatum');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'payment_date', 'Zahlungsdatum', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Zahlungsdatum');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'payment_method', 'Zahlungsweise', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Zahlungsweise');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'report_cost', 'Betrag', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Betrag');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'payer', 'Empfänger', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Empfänger');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'base', 'Grund der Zahlung', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Grund der Zahlung');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'reference', 'Bemerkung', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Bemerkung');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'chargeable_cost', 'Anrechenbarer Betrag', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Anrechenbarer Betrag');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'reasoning', 'Begründung', 1);
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Begründung');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('35', 'header', '<Überschrift>', 1); 
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('35', @id, 'Title', 'Belege <Überschrift>');

INSERT INTO `spi_page_position` (`page_id`, `code`, `name`, `is_double`) VALUES ('36', 'header', '<Überschrift>', 1); 
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page_position`;
INSERT INTO `spi_hint` (`page_id`, `position_id`, `title`, `description`) VALUES ('36', @id, 'Title', 'Finanzübersicht <Überschrift>');