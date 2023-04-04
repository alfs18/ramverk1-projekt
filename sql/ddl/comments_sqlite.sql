--
-- Creating a Comments table.
--



--
-- Table Comments
--
DROP TABLE IF EXISTS Comments;
CREATE TABLE Comments (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "questionId" INTEGER,
    "acronym" TEXT,
    "comment" TEXT,
    "points" INTEGER,
    "created" TIMESTAMP
);
