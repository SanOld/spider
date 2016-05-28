update spi_page SET is_system=1 where code = 'request_school_concept';
SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'request_school_concept';

update spi_user_type_right SET can_show=1, can_view=1 where page_id = @page_id;

ALTER TABLE `spi_page` ADD UNIQUE INDEX `unq_code` (`code`);

ALTER TABLE `spi_request_school_concept`
DROP `school_name`,
DROP `school_number`;
