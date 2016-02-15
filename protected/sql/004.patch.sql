CREATE TABLE `spi_finance_source` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `year` YEAR NOT NULL,
  `contact_person` VARCHAR(45) NOT NULL,
  `iban` VARCHAR(34) NOT NULL,
  `bank_name` VARCHAR(45) NULL,
  `finance_source_type` VARCHAR(1) NOT NULL DEFAULT 'l',
  `finance_programm_id` INT NOT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `spi_project` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NOT NULL,
  `school_type_id` INT NOT NULL,
  `finance_source_type` VARCHAR(1) NOT NULL DEFAULT 'l',
  `finance_programm_id` INT NOT NULL,
  `performer_id` INT NOT NULL,
  `district_id` INT NOT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `spi_project_school` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_id` INT NOT NULL,
  `school_id` INT NOT NULL,
  PRIMARY KEY (`id`));