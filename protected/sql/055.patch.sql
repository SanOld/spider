

INSERT INTO spi_page (name, code, page_code, is_system) VALUE ('Benutzerliste', 'user_lock', 'user-lock', 1);

SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'user_lock';

INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @page_id, 1, 1, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @page_id, 1, 1, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @page_id, 1, 1, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @page_id, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @page_id, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @page_id, 0, 0, 0);

CREATE TABLE `spi_bank_details_lock` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`contact_person` VARCHAR(45) NULL DEFAULT NULL,
	`iban` VARCHAR(34) NOT NULL,
	`bank_name` VARCHAR(45) NULL DEFAULT NULL,
	`description` TEXT NULL,
	`outer_id` VARCHAR(45) NULL DEFAULT NULL,
	`performer_id` INT(11) NOT NULL,
	`request_id` INT(11) NOT NULL,
	`bank_details_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=0
;


CREATE TABLE `spi_request_lock` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`year` VARCHAR(4) NULL DEFAULT NULL,
	`start_date` DATE NULL DEFAULT NULL,
	`due_date` DATE NULL DEFAULT NULL,
	`last_change` DATE NULL DEFAULT NULL,
	`end_fill` DATE NULL DEFAULT NULL,
	`request_id` INT(11) NOT NULL,
	`request_user_id` INT(11) NULL DEFAULT NULL,
	`request_user` TEXT NULL,
	`concept_user_id` INT(11) NULL DEFAULT NULL,
	`concept_user` TEXT NULL,
	`finance_user_id` INT(11) NULL DEFAULT NULL,
	`finance_user` TEXT NULL,
	`bank_details_id` INT(11) NULL DEFAULT NULL,
	`bank_name` TEXT NULL,
	`description` TEXT NULL,
	`outer_id` INT(11) NULL DEFAULT NULL,
	`iban` TEXT NULL,
	`contact_person` TEXT NULL,
	`revenue_description` VARCHAR(255) NULL DEFAULT NULL,
	`revenue_sum` DECIMAL(11,2) NULL DEFAULT NULL,
	`emoloyees_cost` DECIMAL(11,2) NULL DEFAULT NULL,
	`training_cost` DECIMAL(11,2) NULL DEFAULT NULL,
	`overhead_cost` DECIMAL(11,2) NULL DEFAULT NULL,
	`prof_association_cost` DECIMAL(11,2) NULL DEFAULT NULL,
	`total_cost` DECIMAL(11,2) NULL DEFAULT NULL,
	`project_id` INT(11) NOT NULL,
	`code` VARCHAR(10) NOT NULL,
	`performer_id` INT(11) NULL DEFAULT NULL,
	`performer_checked_by` TEXT NULL,
	`performer_name` TEXT NULL,
	`performer_long_name` TEXT NULL,
	`performer_contact_function` TEXT NULL,
	`performer_contact` TEXT NULL,
	`district_id` INT(11) NULL DEFAULT NULL,
	`district_name` TEXT NULL,
	`district_contact` TEXT NULL,
	`doc_target_agreement_id` INT(11) NULL DEFAULT NULL,
	`doc_request_id` INT(11) NULL DEFAULT NULL,
	`doc_financing_agreement_id` INT(11) NULL DEFAULT NULL,
	`additional_info` TEXT NULL,
	`senat_additional_info` TEXT NULL,
	`finance_comment` TEXT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


CREATE TABLE `spi_school_lock` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`request_id` INT(11) NOT NULL,
	`school_id` INT(11) NOT NULL,
	`number` VARCHAR(45) NOT NULL,
	`name` TEXT NULL,
	`user_name` TEXT NULL,
	`user_function` TEXT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;

CREATE TABLE `spi_user_lock` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(1) NOT NULL DEFAULT '',
	`type_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`relation_id` INT(11) NULL DEFAULT NULL,
	`login` VARCHAR(45) NOT NULL,
	`password` VARCHAR(45) NULL DEFAULT NULL,
	`is_finansist` TINYINT(1) NOT NULL DEFAULT '0',
	`sex` TINYINT(1) NOT NULL,
	`title` VARCHAR(45) NULL DEFAULT NULL,
	`function` VARCHAR(45) NULL DEFAULT NULL,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`email` VARCHAR(45) NOT NULL,
	`phone` VARCHAR(45) NULL DEFAULT NULL,
	`is_active` TINYINT(1) NOT NULL DEFAULT '1',
	`auth_token` VARCHAR(32) NULL DEFAULT NULL,
	`auth_token_created_at` DATETIME NULL DEFAULT NULL,
	`recovery_token` VARCHAR(32) NULL DEFAULT NULL,
	`is_super_user` TINYINT(1) NOT NULL DEFAULT '0',
	`is_virtual` TINYINT(1) NOT NULL DEFAULT '0',
	`request_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=0
;

