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
    "title" TEXT UNIQUE NOT NULL,
    "body" TEXT NOT NULL,
    "user" TEXT NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME
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
    "created" TIMESTAMP,
    "updated" DATETIME
);
