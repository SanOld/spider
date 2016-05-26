ALTER TABLE `spi_project` CHANGE COLUMN `district_id` `district_id` INT(11) NULL ;
UPDATE `spi_project_type` SET `name`='LM' WHERE `id`='1';
UPDATE `spi_project_type` SET `name`='LMS' WHERE `id`='2';
UPDATE `spi_project_type` SET `name`='BP' WHERE `id`='3';

ALTER TABLE `spi_finance_source` CHANGE COLUMN `finance_source_type` `project_type_id` INT(11) NOT NULL;