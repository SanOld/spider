CREATE TABLE `spi_request_school_concept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `school_number` varchar(45) DEFAULT NULL,
  `situation` text DEFAULT NULL,
  `offers_youth_social_work` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'r - ready for review, d - decline, a - accept',
  PRIMARY KEY (`id`),
  KEY `fk_spi_request_school_concept_request` (`request_id`),
  CONSTRAINT `fk_spi_request_school_concept_request` FOREIGN KEY (`request_id`) REFERENCES `spi_request` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO spi_page (name, code, is_real_page, is_system) VALUE ('Konzept', 'request_school_concept', 0, 0);
SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'request_school_concept';

INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (1, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (2, @page_id, 1, 1, 1);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (3, @page_id, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (4, @page_id, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (5, @page_id, 0, 0, 0);
INSERT INTO spi_user_type_right (`type_id`, `page_id`, `can_show`, `can_view`, `can_edit`) VALUE (6, @page_id, 0, 0, 0);

SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'request';
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@page_id, 'school_concept_situation', 'Situation an der Schule');
INSERT INTO spi_page_position (`page_id`, `code`, `name`) VALUE (@page_id, 'school_concept_offers_youth_social_work', 'Angebote der Jugendsozialarbeit an der Schule');