-- SHIVAM JANDA
-- 2022-12-07
-- WEBD 3201



DROP TABLE IF EXISTS calls;
CREATE TABLE calls
(
	SalespersonID INT NOT NULL,
	FirstName VARCHAR(128),
	LastName VARCHAR(128),
	EmailAddress VARCHAR(255),
	PhoneNumber VARCHAR(10),
	CallDate VARCHAR(10),
	CallTime VARCHAR(5),
	FOREIGN KEY (SalespersonID) REFERENCES users(Id)
);


INSERT INTO calls(SalespersonID, FirstName, LastName, EmailAddress, PhoneNumber, CallDate, CallTime)
VALUES ('1014', 'a', 'b', 'ab@gmail.com', 'pass', '2020-10-20', '18:00')