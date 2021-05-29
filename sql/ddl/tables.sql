--
-- Creating a User table.
--



--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "username" TEXT UNIQUE NOT NULL,
    "email" TEXT NOT NULL,
    "password" TEXT,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);

--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "title" TEXT NOT NULL,
    "body" TEXT NOT NULL,
    "user" TEXT NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME
);

--
-- Table Tag
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "body" TEXT NOT NULL,
    "timesUsed" INTEGER DEFAULT 0
);

--
-- Table Question_Tag
--
DROP TABLE IF EXISTS QuestionTag;
CREATE TABLE QuestionTag (
    "tagId" INTEGER NOT NULL,
    "questionId" INTEGER NOT NULL,

    FOREIGN KEY("tagId") REFERENCES Tag("id"),
    FOREIGN KEY("questionId") REFERENCES Tag("id")
);

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "body" TEXT NOT NULL,
    "user" TEXT NOT NULL,
    "questionId" INTEGER NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME
);

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "body" TEXT NOT NULL,
    "user" TEXT NOT NULL,
    "parentId" INTEGER NOT NULL,
    "parentIsAnswer" BOOLEAN NOT NULL,
    "questionId" INTEGER NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME
);
