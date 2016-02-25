INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 1, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 1, 1, 0);
UPDATE spi_user_type_right SET can_edit = 1 WHERE id = 3;

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 2, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 2, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 2, 1, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 3, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 3, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 3, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 3, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 3, 0, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 3, 0, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 4, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 4, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 4, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 4, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 4, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 4, 1, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 5, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 5, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 5, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 5, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 5, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 5, 1, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 6, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 6, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 6, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 6, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 6, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 6, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 6, 1, 0);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 7, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 7, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 7, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 7, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 7, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 7, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 7, 1, 1);

INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (1, 8, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (2, 8, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (3, 8, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (7, 8, 1, 1);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (4, 8, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (5, 8, 1, 0);
INSERT INTO spi_user_type_right (type_id, page_id, can_view, can_edit) VALUES (6, 8, 1, 0);

UPDATE spi_school_type SET code = 's', name = 'Förderschule' where id = 1;
INSERT INTO spi_school_type (code, name) VALUES ('g', 'Grundschule');
INSERT INTO spi_school_type (code, name) VALUES ('k', 'Sekundarschule');
INSERT INTO spi_school_type (code, name) VALUES ('y', 'Gymnasium');
INSERT INTO spi_school_type (code, name) VALUES ('b', 'Berufsschule');