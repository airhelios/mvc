PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE saved (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, time DATETIME NOT NULL);
INSERT INTO saved VALUES(1,'Herman','2024-05-18 16:41:09');
INSERT INTO saved VALUES(2,'Owe','2024-05-18 17:23:03');
INSERT INTO saved VALUES(3,'Gurkan','2024-05-19 09:40:15');
INSERT INTO saved VALUES(4,'Kenneth','2024-05-19 11:47:22');
COMMIT;
