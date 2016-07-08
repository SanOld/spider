
UPDATE `spi_document_template_placeholder` SET `text` = 'Name des antragsstellenden Trägers' WHERE `name` = 'TRAEGER';
INSERT INTO `spi_document_template_placeholder` (`name`, `text`, `is_email`) VALUES ('TRAGERADRESSE', 'Adresse des antragsstellenden Trägers', '0');