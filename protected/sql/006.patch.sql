CREATE TABLE `spi_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `year` varchar(4) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `last_change` date DEFAULT NULL,
  `doc_target agreement_id` int(11) DEFAULT NULL,
  `doc_request_id` int(11) DEFAULT NULL,
  `doc_financing agreement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spi_request_unq` (`project_id`,`year`),
  KEY `spi_request_performer` (`performer_id`),
  KEY `spi_request_project` (`project_id`),
  KEY `spi_request_status` (`status_id`),
  CONSTRAINT `spi_request_performer` FOREIGN KEY (`performer_id`) REFERENCES `spi_performer` (`id`),
  CONSTRAINT `spi_request_project` FOREIGN KEY (`project_id`) REFERENCES `spi_project` (`id`),
  CONSTRAINT `spi_request_status` FOREIGN KEY (`status_id`) REFERENCES `spi_request_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `spi_request_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spi_request_status_code_unq` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;