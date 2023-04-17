--
-- Creating a Pictures table.
--



--
-- Table Pictures
--
DROP TABLE IF EXISTS Pictures;
CREATE TABLE Pictures (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "acronym" TEXT NOT NULL,
    "name" TEXT NOT NULL
);

INSERT INTO Pictures (acronym, name) VALUES ("default", "default/butterfly.jpg");
INSERT INTO Pictures (acronym, name) VALUES ("default", "default/butterfly2.jpg");
INSERT INTO Pictures (acronym, name) VALUES ("default", "default/butterfly3.jpg");
INSERT INTO Pictures (acronym, name) VALUES ("default", "default/sprout.jpg");
