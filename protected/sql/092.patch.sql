INSERT INTO `spi_email_template` (`system_come`, `name`, `user_id`, `text`, `subject`) VALUES ('antrag_erstellt', 'Create Antrag', '75', '<span style=\"line-height: 21.4286px;\">\n Der Antrag wurde erstellt: {REQUEST_CODE} - {YEAR}</span> \n<a href=\"{URL}\">Gehen</a>\n\n<br> <br> Mit freundlichen Grüßen<br>  <br> Stiftung SPI<br> Programmagentur \"Jugendsozialarbeit an Berliner Schulen\"<br> Schicklerstrasse 5-7<br> 10179 Berlin<br>  <br> [FON] +49(0)30 2888 496-0<br> [FAX] +49(0)30 2888 496-20<br>  <br> www.spi-programmagentur.de<br> programmagentur@stiftung-spi.de<br>  <br> Stiftung SPI<br> Sozialpaedagogisches Institut Berlin \"Walter May\"<br> rechtsfaehige Stiftung des privaten Rechts<br> Muellerstr. 74, 13349 Berlin<br> Vorstandsvorsitzende/Direktorin: Dr. Birgit Hoppe<br>  <br> www.stiftung-spi.de<br> info@stiftung-spi.de<br>  <br> [FON] +49(0)30 459 793-0<br> [FAX] +49(0)30 459 793-66<br> ', 'Subject');
INSERT INTO `spi_email_template` (`system_come`, `name`, `user_id`, `text`, `subject`) VALUES ('akteure_created', 'Create Akteur', '75', 'The {TYPE} {NAME} was created at {DATE}. You can open editor using this link: {URL}', 'The {TYPE} {NAME} was created');