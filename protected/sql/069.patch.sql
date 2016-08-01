<<<<<<< .mine
UPDATE `spi_request_status` SET `name` = 'Antrag ausfullen' WHERE `id` = '1'; 





=======

SELECT @page_id:=id FROM `spi_page` WHERE `code`= 'bank_details';

UPDATE spi_user_type_right SET can_view = 1 WHERE page_id = @page_id AND type_id = 4;


>>>>>>> .theirs
