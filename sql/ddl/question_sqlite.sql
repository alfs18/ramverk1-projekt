--
-- Creating a Question table.
--



--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "acronym" TEXT,
    "question" TEXT,
    "tags" TEXT,
    "points" INTEGER,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME
);
