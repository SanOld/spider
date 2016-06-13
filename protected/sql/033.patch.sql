ALTER TABLE `spi_request_school_goal`
	CHANGE COLUMN `status` `status` VARCHAR(20) NOT NULL DEFAULT 'unfinished' COMMENT '' AFTER `notice`,
	CHANGE COLUMN `option` `option` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `status`;
	DROP COLUMN `offer_field_count`,
	DROP COLUMN `net_field_count`;

UPDATE `spi_request_school_goal` SET status = 'unfinished' WHERE status = 'g';
UPDATE `spi_request_school_goal` SET status = 'in_progress' WHERE status = 'r';
UPDATE `spi_request_school_goal` SET status = 'accepted' WHERE status = 'a';
UPDATE `spi_request_school_goal` SET status = 'rejected' WHERE status = 'd';


ALTER TABLE `spi_request` ADD COLUMN `bank_details_id` INT(11) NULL AFTER `status_goal`;
