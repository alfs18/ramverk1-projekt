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
