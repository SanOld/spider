DROP TABLE IF EXISTS `spi_audit_event`;

CREATE TABLE `spi_audit_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(25) NOT NULL,
  `record_id` int(11) NOT NULL,
  `event_type` varchar(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spi_audit_data`;

CREATE TABLE `spi_audit_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `column_name` varchar(45) DEFAULT NULL,
  `old_value` text,
  `new_value` text,
  PRIMARY KEY (`id`),
  KEY `FK_SYSTEM_EVENT_ID_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `spi_audit_setting`;

CREATE TABLE `spi_audit_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(45) DEFAULT NULL,
  `is_enabled_audit` tinyint(1) NOT NULL DEFAULT '1',
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DELIMITER ;

/* Function  structure for function  `check_audit` */

/*!50003 DROP FUNCTION IF EXISTS `check_audit` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `check_audit`(tablename VARCHAR(45)) RETURNS int(11)
    READS SQL DATA
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE fl INT;  
  SET fl=-1;
  SELECT is_enabled_audit INTO fl FROM spi_audit_setting WHERE table_name=tablename;
  RETURN fl;
END */$$
DELIMITER ;


ALTER TABLE `spi_page` ADD COLUMN `is_system` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_real_page`;
