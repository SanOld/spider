ALTER TABLE `spi_email_template` ADD COLUMN `system_come` VARCHAR(45) NOT NULL AFTER `id`;
ALTER TABLE `spi_user` CHANGE COLUMN `password` `password` VARCHAR(45) NULL ;
ALTER TABLE `spi_user` ADD COLUMN `is_system` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_super_user`;