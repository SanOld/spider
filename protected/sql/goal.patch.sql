CREATE TABLE `spi_request_school_goal` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`school_id` INT(11) NOT NULL,
	`goal_id` INT(11) NOT NULL,
	`request_id` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`description` TEXT NULL,
	`capacity` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0-не цель; 1 - приоритетная; 2-другая',
	`transition` TINYINT(1) NOT NULL DEFAULT '0',
	`reintegration` TINYINT(1) NOT NULL DEFAULT '0',
	`social_skill` TINYINT(1) NOT NULL DEFAULT '0',
	`prevantion_violence` TINYINT(1) NOT NULL DEFAULT '0',
	`health` TINYINT(1) NOT NULL DEFAULT '0',
	`sport` TINYINT(1) NOT NULL DEFAULT '0',
	`parent_skill` TINYINT(1) NOT NULL DEFAULT '0',
	`other_goal` TINYINT(1) NOT NULL DEFAULT '0',
	`other_description` TEXT NULL,
	`cooperation` TINYINT(1) NOT NULL DEFAULT '0',
	`participation` TINYINT(1) NOT NULL DEFAULT '0',
	`social_area` TINYINT(1) NOT NULL DEFAULT '0',
	`third_part` TINYINT(1) NOT NULL DEFAULT '0',
	`regional` TINYINT(1) NOT NULL DEFAULT '0',
	`concept` TINYINT(1) NOT NULL DEFAULT '0',
	`network_text` TEXT NULL,
	`implementation` TEXT NULL,
	`indicator_1` VARCHAR(255) NULL DEFAULT NULL,
	`indicator_2` VARCHAR(255) NULL DEFAULT NULL,
	`indicator_3` VARCHAR(255) NULL DEFAULT NULL,
	`indicator_4` VARCHAR(255) NULL DEFAULT NULL,
	`indicator_5` VARCHAR(255) NULL DEFAULT NULL,
	`notice` TEXT NULL,
	`status` VARCHAR(1) NOT NULL DEFAULT 'g' COMMENT 'r - ready for review, d - decline, a - accept, g - do not filled',
	PRIMARY KEY (`id`),
	INDEX `FK1_school` (`school_id`),
	INDEX `request_id` (`request_id`),
	CONSTRAINT `FK1_school` FOREIGN KEY (`school_id`) REFERENCES `spi_school` (`id`),
	CONSTRAINT `FK2_request` FOREIGN KEY (`request_id`) REFERENCES `spi_request` (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



INSERT INTO spi_page (name, code, is_real_page, is_system) VALUE ('Goal', 'request_school_goal', 0, 1);
SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'request_school_goal';

INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @page_id, 1, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @page_id, 1, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @page_id, 1, 0, 0);