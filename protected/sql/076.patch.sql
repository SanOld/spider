DROP TABLE IF EXISTS `spi_financial_request`;

CREATE TABLE `spi_financial_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `document_template_id` int(11) NOT NULL,
  `request_cost` decimal(11,2) NOT NULL,
  `rate_id` tinyint(1) NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  `receipt_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `status_id_pa` int(11) NOT NULL DEFAULT '1',
  `description` varchar(255) DEFAULT NULL,
  `representative_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_financial_request_request` (`request_id`),
  KEY `spi_payment_type` (`payment_type_id`),
  KEY `spi_rate` (`rate_id`),
  KEY `spi_request_bank_account` (`bank_account_id`),
  KEY `spi_representative_user` (`representative_user_id`),
  KEY `spi_financial_request_status` (`status_id`),
  CONSTRAINT `spi_financial_request_request` FOREIGN KEY (`request_id`) REFERENCES `spi_request` (`id`),
  CONSTRAINT `spi_financial_request_status` FOREIGN KEY (`status_id`) REFERENCES `spi_financial_request_status` (`id`),
  CONSTRAINT `spi_payment_type` FOREIGN KEY (`payment_type_id`) REFERENCES `spi_payment_type` (`id`),
  CONSTRAINT `spi_rate` FOREIGN KEY (`rate_id`) REFERENCES `spi_rate` (`id`),
  CONSTRAINT `spi_representative_user` FOREIGN KEY (`representative_user_id`) REFERENCES `spi_user` (`id`),
  CONSTRAINT `spi_request_bank_account` FOREIGN KEY (`bank_account_id`) REFERENCES `spi_bank_details` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

/*Table structure for table `spi_financial_request_status` */

DROP TABLE IF EXISTS `spi_financial_request_status`;

CREATE TABLE `spi_financial_request_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spi_request_status_code_unq` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `spi_financial_request_status` */

insert  into `spi_financial_request_status`(`id`,`code`,`name`) values 
(1,'open','Aktiv'),
(2,'in_progress','Bitte bearbeiten'),
(3,'acceptable','Genehmigt'),
(4,'wait','Verabschiedung');

/*Table structure for table `spi_payment_type` */

DROP TABLE IF EXISTS `spi_payment_type`;

CREATE TABLE `spi_payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `template_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `spi_payment_type` */

insert  into `spi_payment_type`(`id`,`name`,`template_type_id`) values 
(1,'Mittelabruf',4),
(2,'Freimeldung',6),
(3,'Ergänzung',7);

/*Table structure for table `spi_rate` */

DROP TABLE IF EXISTS `spi_rate`;

CREATE TABLE `spi_rate` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `spi_rate` */

insert  into `spi_rate`(`id`,`name`) values 
(1,'Jan-Feb'),
(2,'März-Apr'),
(3,'Mai-Jun'),
(4,'Jul-Aug'),
(5,'Sept-Oct'),
(6,'Nov-Dez');



INSERT INTO `spi_page` (`code`, `page_code`, `name`) VALUES ('payment_type', 'payment-type', 'Beleg-Typ');

INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`, `can_edit` ) VALUES ('1', '40', '1', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('2', '40', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('3', '40', '1');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('4', '40', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('5', '40', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('6', '40', '1');

INSERT INTO `spi_page` (`code`, `page_code`, `name`) VALUES ('financial_request_status', 'financial-request-status', 'Status');

INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`, `can_edit` ) VALUES ('1', '41', '1', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('2', '41', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('3', '41', '1');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('4', '41', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('5', '41', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('6', '41', '1');

INSERT INTO `spi_page` (`code`, `page_code`, `name`) VALUES ('rate', 'rate', 'Rate');

INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`, `can_edit` ) VALUES ('1', '41', '1', '1');  
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('2', '42', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('3', '42', '1');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('4', '42', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('5', '42', '1'); 
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_view`) VALUES ('6', '42', '1');

INSERT INTO `spi_document_template_type` (`id`, `code`, `name`) VALUES ('6', 'financial_reduction', 'Freimeldung'); 
INSERT INTO `spi_document_template_type` (`id`, `code`, `name`) VALUES ('7', 'financial_increase', 'Ergänzung');
UPDATE `spi_document_template_type` SET `code` = 'financial_request' WHERE `id` = '4';
UPDATE `spi_document_template` SET `type_code` = 'financial_request' WHERE `id` = '5';

INSERT INTO `spi_document_template` (`name`, `type_id`, `type_code`, `last_change`, `user_id`, `text`) VALUES ('Freimeldung ', '6', 'financial_reduction', '2016-08-11 15:02:50', '1', '<p style=\"margin-left: 700px;\">KREDITORENNUMMER</p><p style=\"margin-left: 700px;\">Fünfstellige Ziffer (ggf. mehr Stellen, aber nur&nbsp;Ziffern)</p><p>Zuwendungsempfänger:</p><p><span style=\"line-height: 1.42857;\">{Trägername}</span><br></p><p><span style=\"line-height: 1.42857;\">[Straße Träger]</span><br></p><p><span style=\"line-height: 1.42857;\">[Postleitzahl] Berlin</span><br></p><p><span style=\"line-height: 1.42857;\"><br></span></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">Stiftung SPI</span><br></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">Programmagentur</span><br></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">Schicklerstraße 5-7</span><br></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">10179 Berlin</span></p><p><span style=\"line-height: 1.42857;\"><br></span></p><p><span style=\"line-height: 21.4285px;\">Landesprogramm „Jugendsozialarbeit an Berliner Schulen“ – (Bonus-Programm)</span></p><p><span style=\"line-height: 21.4285px;\">Kennziffer: [Projektkennziffer]</span></p><p><span style=\"line-height: 21.4285px;\">Mittelanforderung für das Haushaltsjahr 2015</span></p><p><span style=\"line-height: 1.42857;\"><br></span></p><p><span style=\"line-height: 1.42857;\"><br></span><br></p>');
INSERT INTO `spi_document_template` (`id`, `name`, `type_id`, `type_code`, `last_change`, `user_id`, `text`) VALUES ('Ergänzung ', '7', 'financial_increase', '2016-08-11 15:03:36', '1', '<p style=\"margin-left: 700px;\">KREDITORENNUMMER</p><p style=\"margin-left: 700px;\">Fünfstellige Ziffer (ggf. mehr Stellen, aber nur&nbsp;Ziffern)</p><p>Zuwendungsempfänger:</p><p><span style=\"line-height: 1.42857;\">{Trägername}</span><br></p><p><span style=\"line-height: 1.42857;\">[Straße Träger]</span><br></p><p><span style=\"line-height: 1.42857;\">[Postleitzahl] Berlin</span><br></p><p><span style=\"line-height: 1.42857;\"><br></span></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">Stiftung SPI</span><br></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">Programmagentur</span><br></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">Schicklerstraße 5-7</span><br></p><p style=\"line-height: 1;\"><span style=\"line-height: 1.42857; font-size: 10px;\">10179 Berlin</span></p><p><span style=\"line-height: 1.42857;\"><br></span></p><p><span style=\"line-height: 21.4285px;\">Landesprogramm „Jugendsozialarbeit an Berliner Schulen“ – (Bonus-Programm)</span></p><p><span style=\"line-height: 21.4285px;\">Kennziffer: [Projektkennziffer]</span></p><p><span style=\"line-height: 21.4285px;\">Mittelanforderung für das Haushaltsjahr 2015</span></p><p><span style=\"line-height: 1.42857;\"><br></span></p><p><span style=\"line-height: 1.42857;\"><br></span><br></p>');

