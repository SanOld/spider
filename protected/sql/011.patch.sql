insert into spi_page (`code`, `name`) VALUES ('dashboard', 'Startseite');
insert into spi_page_position (`page_id`, `code`, `name`) VALUES (9, 'header', 'Header');

ALTER TABLE `spi_user_type_right` ADD `can_show` TINYINT(1)  NOT NULL  DEFAULT '0'  AFTER `page_id`;
ALTER TABLE `spi_page` ADD `is_real_page` TINYINT(1)  NOT NULL  DEFAULT '1'  AFTER `name`;
UPDATE spi_user_type_right SET can_show = 1 WHERE can_view = 1;

INSERT INTO spi_page (code, name, is_real_page) VALUES ('bank_details', 'Bankverbindungen', 0);
INSERT INTO spi_page (code, name, is_real_page) VALUES ('page_position', 'Position auf der Seite', 0);
INSERT INTO spi_page (code, name, is_real_page) VALUES ('performer_document', 'Träger Agentur dokumente', 0);
INSERT INTO spi_page (code, name, is_real_page) VALUES ('request_status', 'Anträge status', 0);
INSERT INTO spi_page (code, name, is_real_page) VALUES ('school_type', 'Schultyp', 0);


INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 10, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 10, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 10, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 10, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 10, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 10, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 10, 1, 1);


INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 11, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 11, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 11, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 11, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 11, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 11, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 11, 0, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 12, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 12, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 12, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 12, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 12, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 12, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 12, 1, 1);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 13, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 13, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 13, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 13, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 13, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 13, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 13, 1, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 14, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 14, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 14, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 14, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 14, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 14, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 14, 1, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (1, 9, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (2, 9, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (3, 9, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (4, 9, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (5, 9, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (6, 9, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_show, can_view, can_edit) VALUES (7, 9, 1, 1, 0);

ALTER TABLE `spi_performer` ADD UNIQUE INDEX `spi_performer_name_unq` (`name`);
ALTER TABLE `spi_performer` ADD UNIQUE INDEX `spi_performer_short_name_unq` (`short_name`);

ALTER TABLE `spi_district` ADD UNIQUE INDEX `spi_district_name_unq` (`name`);

ALTER TABLE `spi_school` ADD UNIQUE INDEX `spi_school_name_unq` (`district_id`, `name`, `number`);


