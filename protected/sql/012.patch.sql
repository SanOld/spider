UPDATE spi_user_type_right SET can_show = 0, can_view = 0, can_edit = 0 WHERE page_id = 7 and type_id not in(1,2);
update spi_user_type_right set can_show = 0, can_view = 1 WHERE page_id = 1 and type_id not in(1,2,6);
