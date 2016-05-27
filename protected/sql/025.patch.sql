ALTER TABLE `spi_request` ADD COLUMN `additional_info` TEXT ;
ALTER TABLE `spi_request` ADD COLUMN `senat_additional_info` TEXT ;
ALTER TABLE `spi_request` ADD COLUMN `request_user_id` INT(11) ;
ALTER TABLE `spi_request` ADD COLUMN `concept_user_id` INT(11) ;
ALTER TABLE `spi_request` ADD COLUMN `finance_user_id` INT(11) ;

INSERT INTO spi_page (code, name, is_real_page, is_system) VALUES ('DocumentTemplateType', 'Druck-Templates-Type', 0, 1);
SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'DocumentTemplateType';


INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @page_id, 1, 1, 1);


INSERT INTO spi_page (code, name, is_real_page, is_system) VALUES ('DocumentTemplatePlaceholder', 'Druck-Templates-Placeholder', 0, 1);
SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'DocumentTemplatePlaceholder';


INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @page_id, 1, 1, 1);