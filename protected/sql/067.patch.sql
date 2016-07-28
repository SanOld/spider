DELIMITER $$
DROP TRIGGER /*!50032 IF EXISTS */ `spi_user_BUPD`$$

CREATE
    TRIGGER `spi_user_BUPD` BEFORE UPDATE ON `spi_user` 
    FOR EACH ROW BEGIN
      SET new.password = MD5(new.password);
    END;
$$

DELIMITER ;