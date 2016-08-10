ALTER TABLE `spi_request_user`
CHANGE COLUMN `group_id` `group_id` INT(11) NULL DEFAULT '4';
UPDATE `spi_request_user` SET `group_id` = '4' WHERE `group_id` is null ;