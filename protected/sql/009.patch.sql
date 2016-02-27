UPDATE spi_user_type_right SET can_view = 0 where id IN(6,23,24,25);
ALTER TABLE `spi_user` ADD CONSTRAINT `spi_user_type_id` FOREIGN KEY (`type_id`) REFERENCES `spi_user_type` (`id`);