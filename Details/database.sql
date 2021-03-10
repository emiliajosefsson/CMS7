#Implementation
#DB name = Millhouse

#DROP SCHEMA IF EXISTS
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Entries;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Users; 

CREATE TABLE Users(
Id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
Username VARCHAR(50) NOT NULL,
Password VARCHAR(50) NOT NULL,
Role VARCHAR(10) DEFAULT "User"
)
ENGINE=InnoDB;
 
INSERT INTO Users(Username, Password, Role)
VALUES
("Elizar", "96b20044673dcccc263e4bf188bc961c", "Admin"),
#Lösenord = Elizar
("Emilia", "ccc49e40f4e1184914330ae0ef5a6bac", "Admin"), 
#Lösenord = Emilia
("Tea", "9e126372cb1fa5b510384452281e7770", "Admin");
#Lösenord = Tea

CREATE TABLE Categories(
Id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
CategoryName VARCHAR(50)
)
ENGINE=InnoDB;

INSERT INTO Categories(CategoryName)
VALUES
("Kläder"),
("Accessoarer"),
("Inredning");
 
CREATE TABLE Entries(
Id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
Title VARCHAR(30) NOT NULL,
Entry VARCHAR(500) NOT NULL,
EntryDate DATE NOT NULL,
CategoryId INT NOT NULL,
Image VARCHAR(100), 
UsersId INT NOT NULL,
CONSTRAINT FK_Users FOREIGN KEY(UsersId) REFERENCES Users(Id),
CONSTRAINT FK_Category FOREIGN KEY(CategoryId) REFERENCES Categories(Id)
)
ENGINE=InnoDB;

INSERT INTO Entries(Title, Entry, EntryDate, CategoryId, Image, UsersId)
VALUES
("VAD ÄR ERA VÅRFAVORITER?", "Vi börjar drömma oss bort till våren redan nu. 
Snart är det dags att plocka fram solglasögonen ur byrålådan.
Vi vill höra era tips - vilka solglasögon vill ni se hos oss? 
Överrös oss med tips. Vår läsare som kommer med det bästa 
tipset får 15% rabatt på våra solglasögon som vi börjar sälja 
på hemsidan den 1 april.", "2021-03-08", "2", "images/sunglasses-unsplash.jpg", "1"),
("TICK... TOCK...", "Nej vi pratar inte om appen utan om armbandsuret. Det är en
accesoar som ger dig möjlighet att göra ett statement. 
Två snabba frågor till er:
1. Silver eller guld? 
2. Vad är viktigast - märket eller designen? 
Vi på Millhouse jobbar hårt för att ständigt utöka vårt 
sortiment så du ska kunna hitta en klocka som passar just 
dig och din stil.", "2021-03-01", "2", "images/watches-unsplash.jpg", "3"),
("INREDNINGSTRENDER 2021", "I dessa pandemitider har hemmet fått en helt ny betydelse och
vi spenderar mer av våra vakna timmar i hemmets mysiga vrår.
Några utav årets inredningstrender för att inspirera er:
Beiget & Naturfärgat, Havets djur- och växtliv, Ljust trä, Blått som accentfärg & Ett statement piece 
Kanske är vårt statement piece som snart finns att köpa hos 
oss något för dig och ditt trendiga hem?", "2021-02-22", "3", "images/lamp-unsplash.jpg", "2");

CREATE TABLE Comments(
Id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
EntriesId INT NOT NULL,
Comment VARCHAR(200) NOT NULL,
CommentDate DATE NOT NULL, 
UsersId INT NOT NULL,
CONSTRAINT FK_Entries FOREIGN KEY(EntriesId) REFERENCES Entries(Id) ON DELETE CASCADE,
CONSTRAINT FK_UserComment FOREIGN KEY(UsersId) REFERENCES Users(Id)
)
ENGINE=InnoDB;

INSERT INTO Comments(EntriesId, Comment, CommentDate, UsersId)
VALUES
("1", "Pilotglasögon kan aldrig gå fel?", "2021-03-08", "2"),
("1", "Jag vill ha något som ingen annan har, satsa på att hitta
något unikt!", "2021-03-08", "3"),
("2", "Guld och självklart är märket viktigare än designen!", "2021-02-28", "3");