ALTER TABLE `spi_request`
	ADD COLUMN `status_id_ta` INT(11) NOT NULL DEFAULT '1' AFTER `status_id`;
	ADD COLUMN `status_concept_ta` VARCHAR(45) NOT NULL DEFAULT 'unfinished' AFTER `status_concept`;
	ADD COLUMN `status_goal_ta` VARCHAR(45) NOT NULL DEFAULT 'unfinished' AFTER `status_goal`;