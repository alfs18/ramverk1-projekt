--
-- Creating an AnswerComments table.
--



--
-- Table AnswerComments
--
DROP TABLE IF EXISTS AnswerComments;
CREATE TABLE AnswerComments (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "answerId" INTEGER,
    "acronym" TEXT,
    "comment" TEXT,
    "points" INTEGER,
    "created" TIMESTAMP
);
