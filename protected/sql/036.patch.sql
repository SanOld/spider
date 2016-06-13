CREATE TABLE `spi_request_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `request_id` INT(11) NULL,
  `user_id` INT(11) NULL,
  `is_umlage` TINYINT(1) NOT NULL DEFAULT 0,
  `group_id` INT(11) NULL,
  `remuneration_level_id` INT(11) NULL,
  `other` VARCHAR(255) NULL,
  `cost_per_month_brutto` DECIMAL(10,2) NULL,
  `month_count` TINYINT(2) NULL,
  `hours_per_week` TINYINT(3) NULL,
  `have_annual_bonus` TINYINT(1) NOT NULL DEFAULT 0,
  `annual_bonus` DECIMAL(10,2) NULL,
  `have_additional_provision_vwl` TINYINT(1) NOT NULL DEFAULT 0,
  `additional_provision_vwl` DECIMAL(10,2) NULL,
  `have_supplementary_pension` TINYINT(1) NOT NULL DEFAULT 0,
  `supplementary_pension` DECIMAL(10,2) NULL,
  `brutto` DECIMAL(10,2) NULL,
  `add_cost` DECIMAL(10,2) NULL,
  `full_cost` DECIMAL(10,2) NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `spi_request_financial_group` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`));

INSERT INTO `spi_request_financial_group` (`name`) VALUES ('E6');
INSERT INTO `spi_request_financial_group` (`name`) VALUES ('E7');
INSERT INTO `spi_request_financial_group` (`name`) VALUES ('E8');
INSERT INTO `spi_request_financial_group` (`name`) VALUES ('E9');

CREATE TABLE `spi_remuneration_level` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`));

INSERT INTO `spi_remuneration_level` (`name`) VALUES ('Entgeltstufe 1 (TV-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('Entgeltstufe 2 (TV-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('Entgeltstufe 3 (TV-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('Entgeltstufe 4 (TV-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('Entgeltstufe 5 (TV-L Berlin, max. E9)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('Entgeltstufe 6 (TV-L Berlin, max. E8)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('indiv. Entgeltstufe 1 + (TVÜ-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('indiv. Entgeltstufe 2 + (TVÜ-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('indiv. Entgeltstufe 3 + (TVÜ-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('indiv. Entgeltstufe 4 + (TVÜ-L Berlin)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('indiv. Entgeltstufe 5 + (TVÜ-L Berlin, max. E9)');
INSERT INTO `spi_remuneration_level` (`name`) VALUES ('indiv. Entgeltstufe 6 + (TVÜ-L Berlin)');

CREATE TABLE `spi_request_school_finance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `request_id` INT(11) NOT NULL,
  `school_id` INT(11) NOT NULL,
  `rate` FLOAT(3,2) NULL,
  `month_count` TINYINT(2) NULL,
  `training_cost` DECIMAL(11,2) NULL,
  `overhead_cost` DECIMAL(11,2) NULL,
  PRIMARY KEY (`id`));

INSERT INTO `spi_page` (`code`, `name`, `is_real_page`, `is_system`) VALUES ('request_school_finance', 'Request School Finance', '0', '1');

ALTER TABLE `spi_request` 
ADD COLUMN `revenue_description` VARCHAR(255) NULL,
ADD COLUMN `revenue_sum` DECIMAL(11,2) NULL,
ADD COLUMN `emoloyees_cost` DECIMAL(11,2) NULL,
ADD COLUMN `training_cost` DECIMAL(11,2) NULL,
ADD COLUMN `overhead_cost` DECIMAL(11,2) NULL,
ADD COLUMN `prof_association_cost` DECIMAL(11,2) NULL,
ADD COLUMN `total_cost` DECIMAL(11,2) NULL;




CREATE TABLE `spi_request_prof_association` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `request_id` INT(11) NOT NULL,
  `name` VARCHAR(100) NOT NULL DEFAULT '',
  `sum` DECIMAL(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`));

INSERT INTO `spi_page` (`code`, `name`, `is_real_page`, `is_system`) VALUES ('remuneration_level', 'Remuneration Level', '0', '1');
INSERT INTO `spi_page` (`code`, `name`, `is_real_page`, `is_system`) VALUES ('request_financial_group', 'Request Financial Group', '0', '1');
INSERT INTO `spi_page` (`code`, `name`, `is_real_page`, `is_system`) VALUES ('request_prof_association', 'Request Prof Association', '0', '0');
INSERT INTO `spi_page` (`code`, `name`, `is_real_page`, `is_system`) VALUES ('request_user', 'Request User', '0', '0');
