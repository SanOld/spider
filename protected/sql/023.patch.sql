ALTER TABLE `spi_project` CHANGE COLUMN `district_id` `district_id` INT(11) NULL ;
UPDATE `spi_project_type` SET `name`='LM' WHERE `id`='1';
UPDATE `spi_project_type` SET `name`='LMS' WHERE `id`='2';
UPDATE `spi_project_type` SET `name`='BP' WHERE `id`='3';

ALTER TABLE `spi_finance_source` CHANGE COLUMN `finance_source_type` `project_type_id` INT(11) NOT NULL;


ALTER TABLE `spi_user` ADD COLUMN `is_super_user` TINYINT(1) NOT NULL DEFAULT 0;

INSERT INTO `spi_page` (`code`, `name`, `is_real_page`) VALUES ('page', 'Pages List', '1');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('1', '19', '1', '1', '1');


