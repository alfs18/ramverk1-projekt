--
-- Creating an Answers table.
--



--
-- Table Answers
--
DROP TABLE IF EXISTS Answers;
CREATE TABLE Answers (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "questionId" INTEGER NOT NULL,
    "acronym" TEXT,
    "answer" TEXT,
    "points" INTEGER,
    "created" TIMESTAMP
);
