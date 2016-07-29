INSERT INTO spi_project_school (project_id, school_id)
SELECT prj.id, 0 FROM spi_project prj LEFT JOIN spi_project_school prs ON prj.id = prs.project_id WHERE prs.school_id IS NULL;
