update spi_user_type_right set can_edit = 0 where page_id = 4 and type_id not in(1,2);
update spi_user_type_right set can_view = 1 where page_id = 2;