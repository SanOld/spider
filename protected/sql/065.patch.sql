
SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'contact';

INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @page_id, 1, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @page_id, 1, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @page_id, 1, 0, 0); 

