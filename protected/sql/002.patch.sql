ALTER TABLE `spi_user` ADD `recovery_token` VARCHAR(32)  NULL  DEFAULT NULL  AFTER `auth_token_created_at`;
ALTER TABLE `spi_user` ADD UNIQUE INDEX `spi_login_unq` (`login`);
ALTER TABLE `spi_user` ADD UNIQUE INDEX `spi_email_unq` (`email`);

