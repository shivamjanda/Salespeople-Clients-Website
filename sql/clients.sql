-- SHIVAM JANDA
-- 2022-12-07
-- WEBD 3201


DROP TABLE IF EXISTS clients;
CREATE TABLE clients
(
	ClientID INT NOT NULL,
	FirstName VARCHAR(128), 
	LastName VARCHAR(128),
	EmailAddress VARCHAR(255) UNIQUE,
	PhoneNumber VARCHAR(10) UNIQUE,
	FilePath VARCHAR(255),
	FOREIGN KEY (ClientID) REFERENCES users(Id)
);


INSERT INTO clients (ClientID, FirstName, LastName, EmailAddress, PhoneNumber, FilePath)
VALUES ('1014', 'a', 'b', 'ab@gmail.com', '4163575445', './logos/client.png')