update spi_school set type_id = 3 where type_id is null;
update spi_project set school_type_id = 3 where code like 'H%';
update spi_project set is_old = 1 where code like 'H%';