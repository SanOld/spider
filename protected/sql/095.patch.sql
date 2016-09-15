SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `spi_finance_cost_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

insert  into `spi_finance_cost_type`(`id`,`name`,`description`) values 
(1,'cash','Bar '),
(2,'ecash','Unbar');

CREATE TABLE `spi_finance_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `request_id` int(11) NOT NULL,
  `cost_type_id` int(11) NOT NULL,
  `report_cost` decimal(11,2) NOT NULL,
  `receipt_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `base` varchar(255) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL,
  `chargeable_cost` decimal(11,2) DEFAULT NULL,
  `reasoning` varchar(255) NOT NULL,
  `payer` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `status_id_pa` int(11) NOT NULL DEFAULT '1',
  `status_message` varchar(30) DEFAULT NULL,
  `is_chargeable` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `spi_report_cost` (`cost_type_id`),
  KEY `spi_report_request` (`request_id`),
  KEY `spi_report_payment_method` (`payment_method_id`),
  KEY `spi_report_status` (`status_id`),
  CONSTRAINT `spi_report_cost` FOREIGN KEY (`cost_type_id`) REFERENCES `spi_finance_cost_type` (`id`),
  CONSTRAINT `spi_report_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `spi_payment_method_type` (`id`),
  CONSTRAINT `spi_report_request` FOREIGN KEY (`request_id`) REFERENCES `spi_request` (`id`),
  CONSTRAINT `spi_report_status` FOREIGN KEY (`status_id`) REFERENCES `spi_finance_report_status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

CREATE TABLE `spi_finance_report_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spi_request_status_code_unq` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

insert  into `spi_finance_report_status`(`id`,`code`,`name`) values 
(1,'open','Neu Beleg'),
(2,'in_progress','Bitte bearbeiten'),
(3,'acceptable','Sachlich richtig'),
(4,'wait','Zur Prüfung übermittelt');

CREATE TABLE `spi_finance_report_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

insert  into `spi_finance_report_type`(`id`,`name`,`description`) values 
(1,'income','Einnahme'),
(2,'spending','Ausgabe ');

CREATE TABLE `spi_payment_method_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  `report_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spi_method_report_type` (`report_type_id`),
  CONSTRAINT `spi_method_report_type` FOREIGN KEY (`report_type_id`) REFERENCES `spi_finance_report_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


insert  into `spi_payment_method_type`(`id`,`name`,`description`,`report_type_id`) values 
(1,'interest','Zinsen',1),
(2,'own_resources','Eigenmittel',1),
(3,'donation','Spenden',1),
(4,'prof_association_cost','Berufsgenossenschaft',2),
(5,'overhead_cost','Regiekosten',2),
(6,'training_cost','Fortbildungskosten',2),
(7,'employees_cost','Personalkosten',2);

SET FOREIGN_KEY_CHECKS=1;

UPDATE `spi_page` SET `name` = 'Finanzbericht' WHERE `code` = 'finance_report'; 

INSERT INTO `spi_page` (`code`, `page_code`, `name`, `is_real_page`, `is_system`, `is_without_login`, `is_editable`) VALUES ('finance_report_type', 'finance-report-type', 'Finanzbericht-Typ', '0', '0', '0', '0');
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page`;
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('1', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('2', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('3', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('4', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('5', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('6', @id, '0', '1', '0');

INSERT INTO `spi_page` (`code`, `page_code`, `name`, `is_real_page`, `is_system`, `is_without_login`, `is_editable`) VALUES ('finance_cost_type', 'finance-cost-type', 'Kostenart', '0', '0', '0', '0');
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page`;
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('1', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('2', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('3', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('4', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('5', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('6', @id, '0', '1', '0');

INSERT INTO `spi_page` (`code`, `page_code`, `name`, `is_real_page`, `is_system`, `is_without_login`, `is_editable`) VALUES ('payment_method_type', 'payment-method-type', 'Zahlungsweise', '0', '0', '0', '0');
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page`;
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('1', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('2', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('3', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('4', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('5', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('6', @id, '0', '1', '0');

INSERT INTO `spi_page` (`code`, `page_code`, `name`, `is_real_page`, `is_system`, `is_without_login`, `is_editable`) VALUES ('finance_report_status', 'finance-report-status', 'Beleg Status', '0', '0', '0', '0');
SELECT @id:=LAST_INSERT_ID() FROM  `spi_page`;
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('1', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('2', @id, '1', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('3', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('4', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('5', @id, '0', '1', '0');
INSERT INTO `spi_user_type_right` (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUES ('6', @id, '0', '1', '0');


