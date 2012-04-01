--Database Table Creation

drop table Returns;
drop table Stores_Purchased;
drop table Makes;
drop table Creates;
drop table Modifies;
drop table Sells;
drop table Hires;
drop table Payment_Record;
drop table Account;
drop table Clerk;
drop table Manager;
drop table Employee;
drop table Hardware;
drop table Used_Game;
drop table New_Game;
drop table Game;
drop table Item;

CREATE TABLE Item
(Serial_Number integer not null PRIMARY KEY,
PName varchar(50),
Price float,
Quantity integer,
Check (serial_number >= 0 AND price >= 0 AND quantity >= 0));

create table Game
(Serial_Number integer not null PRIMARY KEY,
Genre varchar(20),
Is_Used integer,
Platform varchar(30),
Publisher varchar(60),
foreign key (Serial_Number) references Item ON DELETE CASCADE);

CREATE TABLE New_Game
(Serial_Number integer not null PRIMARY KEY,
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE);

CREATE TABLE Used_Game
(Serial_Number integer not null PRIMARY KEY,
Discount float,
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE,
check (discount >= 0));

CREATE TABLE Hardware
(Serial_Number integer not null PRIMARY KEY,
Type varCHAR(30),
Company varCHAR(30),
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE);

CREATE TABLE Employee
(Employee_ID integer not null PRIMARY KEY,
EName varCHAR(30),
EPhone INTeger,
EAddress varCHAR(60),
check (employee_id >= 0));

CREATE TABLE Manager
(Employee_ID integer not null PRIMARY KEY,
FOREIGN KEY (Employee_ID) REFERENCES Employee ON DELETE CASCADE);

CREATE TABLE Clerk
(Employee_ID integer not null PRIMARY KEY,
FOREIGN KEY (Employee_ID) REFERENCES Employee ON DELETE CASCADE);

CREATE TABLE Account
(Account_ID integer not null PRIMARY KEY,
Points integer,
AName varCHAR(30),
AAddress varCHAR(40),
APhone INTeger,
check (account_id >= 0));

CREATE TABLE Hires
(Manager_ID INTeger not null,
Employee_ID INTeger not null,
PRIMARY KEY (Manager_ID, Employee_ID),
FOREIGN KEY (Manager_ID) REFERENCES Employee ON DELETE CASCADE,
FOREIGN KEY (Employee_ID) REFERENCES Employee ON DELETE CASCADE);

CREATE TABLE Sells
(Employee_ID INTeger not null,
Serial_Number INTeger not null,
Number_Copies INTeger,
PRIMARY KEY (Employee_ID, Serial_Number),
FOREIGN KEY (Employee_ID) REFERENCES Employee ON DELETE CASCADE,
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE,
check (number_copies >= 0));

CREATE TABLE Modifies
(Employee_ID INTeger not null,
Serial_Number INTeger not null,
Mod_Date DATE,
PRIMARY KEY (Employee_ID, Serial_Number),
FOREIGN KEY (Employee_ID) REFERENCES Employee ON DELETE CASCADE,
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE);

CREATE TABLE Creates
(Employee_ID INTeger not null,
Account_ID INTeger not null,
PRIMARY KEY (Employee_ID, Account_ID),
FOREIGN KEY (Employee_ID) REFERENCES Employee ON DELETE CASCADE,
FOREIGN KEY (Account_ID) REFERENCES Account ON DELETE CASCADE);

CREATE TABLE Payment_Record
(Sale_Number INTeger not null PRIMARY KEY,
Method_Payment varCHAR(15),
Total_Cost float,
PDate DATE,
check (sale_number >= 0));

CREATE TABLE Makes
(Account_ID INTeger not null,
Sale_Number INTeger not null,
PRIMARY KEY (Account_ID, Sale_Number),
FOREIGN KEY (Account_ID) REFERENCES Account ON DELETE CASCADE,
FOREIGN KEY (Sale_Number) REFERENCES Payment_Record ON DELETE CASCADE);

CREATE TABLE Stores_Purchased
(Sale_Number INTeger not null,
Serial_Number INTeger not null,
PRIMARY KEY (Serial_Number, Sale_Number),
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE,
FOREIGN KEY (Sale_Number) REFERENCES Payment_Record ON DELETE CASCADE);

CREATE TABLE Returns
(Account_ID INTeger not null,
Serial_Number INTeger not null,
Return_Date DATE,
PRIMARY KEY (Account_ID, Serial_Number),
FOREIGN KEY (Serial_Number) REFERENCES Item ON DELETE CASCADE,
FOREIGN KEY (Account_ID) REFERENCES Account ON DELETE CASCADE);

insert into Item values
(00000001,'The Elder Scrolls V Skyrim', 59.99,20);

insert into Item values
(00000002, 'The Elder Scrolls IV Oblivion', 49.99, 15);

insert into Item values
(00000003, 'Final Fantasy XIII', 39.99, 15);

insert into Item values
(00000004, 'Resident Evil 5', 29.99, 10);

insert into Item values
(00000005, 'Little Big Planet', 29.99, 10);

insert into Item values
(00000006, 'InFamous', 29.99, 15);

insert into Item values
(00000007, 'Assassins Creed Brotherhood', 39.99, 20);

insert into Item values
(00000008, 'Mass Effect 3', 59.99, 20);

insert into Item values
(00000009, 'Call of Duty Black Ops', 39.99, 20);

insert into Item values
(00000010, 'Mario Kart', 29.99, 10);

insert into Item values
(00000011, 'Playstation 3', 299.99, 10);

insert into Item values
(00000012, 'XBOX 360', 199.99, 10);

insert into Item values
(00000013, 'WII', 129.99, 8);

insert into Item values
(00000014, 'Sony Headphones', 29.99, 6);

insert into Item values
(00000015, 'Stevensons Microphone', 39.99, 6);

insert into Item values
(00000016, 'Mass Effect 3', 49.99, 10);

insert into Item values
(00000017, 'Mass Effect 3', 59.99, 10);

insert into Item values
(00000018, 'Mass Effect 3', 59.99, 10);

insert into Item values
(00000019, 'Nintendo 3DS', 169.99, 15);

insert into Item values
(00000020, 'Playstation VITA', 249.99, 15);

insert into Item values
(00000021, 'Super Stardust Delta', 49.99, 2);

insert into Item values
(00000022, 'Kingdoms of Amalur Reckoning', 59.99, 5);

insert into Item values
(00000023, 'Street Fighter x Tekken', 59.99, 4);

insert into Item values
(00000024, 'UFC Undisputed 3', 59.99, 1);

insert into Item values
(00000025, 'Star Wars The Old Republic', 59.99, 10);

insert into Item values
(00000026, 'Unit 13', 49.99, 5);

insert into Item values
(00000027, 'Resident Evil Operation Raccoon City', 59.99, 2);

insert into Item values
(00000028, 'Kid Icarus Uprising', 39.99, 5);

insert into Item values
(00000029, 'Batman Arkham City', 39.99, 10);

insert into Item values
(00000030, 'Xenoblade Chronicles', 49.99, 2);

insert into Hardware values
(00000011, 'Console', 'Sony');

insert into Hardware values
(00000012, 'Console', 'Microsoft');

insert into Hardware values
(00000013, 'Console', 'Nintendo');

insert into Hardware values
(00000014, 'Accessory', 'Sony');

insert into Hardware values
(00000015, 'Accessory', 'Stevenson');

insert into Hardware values
(00000019, 'Handheld', 'Nintendo');

insert into Hardware values
(00000020, 'Handheld', 'Sony');

insert into game values
(00000001, 'RPG', 0, 'PS3', 'Bethesda');

insert into game values
(00000002, 'RPG', 1, 'PC', 'Bethesda');

insert into game values
(00000003, 'RPG', 0, 'PS3', 'Square-Enix');

insert into game values
(00000004, 'HORROR', 1, 'XBOX 360', 'Capcom');

insert into game values
(00000005, 'PLATFORMER', 1, 'PS3', 'Sony');

insert into game values
(00000006, 'ACTION', 0, 'PS3', 'Sony');

insert into game values
(00000007, 'ACTION', 0, 'XBOX 360', 'Ubisoft');

insert into game values
(00000008, 'RPG', 0, 'PC', 'Electronic Arts');

insert into game values
(00000009, 'FPS', 1, 'PS3', 'Activision');

insert into game values
(00000010, 'RACING', 1, 'WII', 'Nintendo');

insert into game values
(00000016, 'RPG', 1, 'PC', 'Electronic Arts');

insert into game values
(00000017, 'RPG', 0, 'XBOX 360', 'Electronic Arts');

insert into game values
(00000018, 'RPG', 0, 'PS3','Electronic Arts');

insert into game values
(00000021, 'SHOOTER', 0, 'VITA', 'Sony');

insert into game values
(00000022, 'RPG', 0, 'XBOX 360', 'Electronic Arts');

insert into game values
(00000023, 'FIGHTING', 1, 'PS3', 'Capcom');

insert into game values
(00000024, 'FIGHTING', 0, 'PS3', 'THQ');

insert into game values
(00000025, 'RPG', 1, 'PC', 'Electronic Arts');

insert into game values
(00000026, 'ACTION', 0, 'VITA', 'SCEA');

insert into game values
(00000027, 'ACTION', 1, 'PS3', 'Capcom');

insert into game values
(00000028, 'ACTION', 0, '3DS', 'Nintendo');

insert into game values
(00000029, 'ACTION', 0, 'PC', 'Warner Bros. Interactive Entertainment');

insert into game values
(00000030, 'RPG', 1, 'WII', 'Nintendo');

insert into new_game values
(00000001);

insert into new_game values
(00000003);

insert into new_game values
(00000006);

insert into new_game values
(00000007);

insert into new_game values
(00000008);

insert into new_game values
(00000017);

insert into new_game values
(00000018);

insert into new_game values
(00000021);

insert into new_game values
(00000022);

insert into new_game values
(00000024);

insert into new_game values
(00000026);

insert into new_game values
(00000028);

insert into new_game values
(00000029);

insert into used_game values
(00000002, 10.00);

insert into used_game values
(00000004, 15.00);

insert into used_game values
(00000005, 5.00);

insert into used_game values
(00000009, 10.00);

insert into used_game values
(00000010, 25.00);

insert into used_game values
(00000016, 15.00);

insert into used_game values
(00000023, 10.00);

insert into used_game values
(00000025, 5.00);

insert into used_game values
(00000027, 5.00);

insert into used_game values
(00000030, 10.00);

insert into Employee values
(44406106, 'William Loui', 6048882222, '1407 Sunset Road, West Vancouver, BC, Canada');

insert into Employee values
(44406107, 'Lilian Cheng', 7780934823, '1643 Shakespears Road, North Vancouver, B.C, Canada');

insert into Employee values
(44406108, 'Johnny Deep', 6044720332, '1982 Smith Street, Vancouver, B.C, Canada');

insert into Employee values
(44406109, 'Harry Poker', 6042835832, '1332 Willington Street, North Vancouver, B.C. Canada');

insert into Employee values
(44406110, 'Todd Richardson', 7789034821, '1066 Steveston Road, Richmond, B.C., Canada');

insert into Employee values
(44406111, 'Susie Loo', 7782931424, '1089 Kings Street, Vancouver, B.C., Canada');

insert into Employee values
(44406112, 'Ricardo Mason', 6046556512, '1232 Victoria Street, Vancouver, B.C., Canada');

insert into Employee values
(44406113, 'Leonard Williams', 7782935819, '1889 Fedrickson Street, Vancouver, B.C, Canada');

insert into Employee values
(44406114, 'Alice Wilson', 7785631423, '1056 Ottawa Road, Vancouver, B.C.,Canada');

insert into Employee values
(44406115, 'Phillip Watson', 6045893023, '1522 Bell Street, Surrey, B.C., Canada');

insert into Manager values
(44406106);

insert into Manager values
(44406107);

insert into Manager values
(44406108);

insert into Manager values
(44406109);

insert into Manager values
(44406110);

insert into Clerk values
(44406111);

insert into Clerk values
(44406112);

insert into Clerk values
(44406113);

insert into Clerk values
(44406114);

insert into Clerk values
(44406115);

insert into sells values
(44406106, 00000001, 1);

insert into sells values
(44406106, 00000002, 1);

insert into sells values
(44406108, 00000003, 1);

insert into sells values
(44406112, 00000004, 1);

insert into sells values
(44406110, 00000005, 1);

insert into sells values
(44406111, 00000006, 1);

insert into sells values
(44406112, 00000007, 1);

insert into sells values
(44406113, 00000008, 1);

insert into sells values
(44406107, 00000009, 1);

insert into sells values
(44406107, 00000010, 1);

insert into sells values
(44406111, 00000011, 1);

insert into sells values
(44406112, 00000012, 2);

insert into sells values
(44406113, 00000013, 1);

insert into account values
(00000001, 5, 'John Zee', '5775 Toronto Road, Vancouver, Canada', 7789966117);

insert into account values
(00000002, 10, 'Bread Pitt', '268 Flower Road, Vancouver, Canada', 6785421864);

insert into account values
(00000003, 100, 'Tessa Moma', 'Sticker Road, Vancouver, Canada', 7782226666);

insert into account values
(00000004, 20, 'Olive Cube', '123 Alphabet Road, Seattle, US', 7642535221);

insert into account values
(00000005, 25, 'Jeffery Roul', '1235 Key Road, Surrey, Canada', 3902931890);

insert into account values
(00000006, 40, 'Dennis Birk','1446 Rushford Street, Richmond, Canada',7782938080);

insert into account values
(00000007, 20, 'Kenneth Jones', '1285 Mills Road, White Rock, Canada', 7789223222);

insert into account values
(00000008, 80, 'Laurel Starrett', '5353 Smolen Road, Richmond, Canada', 6049990321);

insert into account values
(00000009, 10, 'George Chapman', '1727 Token Street, Vancouver, Canada', 6048976522);

insert into account values
(00000010, 30, 'Eric Yen', '1433 Matthew Street, Vancouver, Canada', 7789022311);

insert into Payment_Record values
(00000001, 'Credit Card', 29.99, '02-FEB-2011');

insert into Payment_Record values
(00000002, 'Debit Card', 24.99, '03-FEB-2012');

insert into Payment_Record values
(00000003, 'Cash', 29.99, '05-FEB-2012');

insert into Payment_Record values
(00000004, 'Credit Card', 24.99, '01-DEC-2012');

insert into Payment_Record values
(00000005, 'Points', 39.99, '02-JAN-2011');

insert into Payment_Record values
(00000006, 'Cash', 59.99, '03-FEB-2012');

insert into Payment_Record values
(00000007, 'Points', 129.97, '24-MAR-2011');

insert into Payment_Record values
(00000008, 'Debit Card', 299.99, '04-APR-2012');

insert into Payment_Record values
(00000009, 'Points', 199.99, '13-JUN-2010');

insert into Payment_Record values
(00000010, 'Credit Card', 634.96, '09-NOV-2013');

insert into Makes values
(00000001, 00000001);

insert into Makes values
(00000002, 00000002);

insert into Makes values
(00000003, 00000003);

insert into Makes values
(00000004, 00000004);

insert into Makes values
(00000005, 00000005);

insert into Makes values
(00000006, 00000006);

insert into Makes values
(00000007, 00000007);

insert into Makes values
(00000008, 00000008);

insert into Makes values
(00000008, 00000009);

insert into Makes values
(00000007, 00000010);

insert into Stores_Purchased values
(00000001, 00000006);

insert into Stores_Purchased values
(00000002, 00000005);

insert into Stores_Purchased values
(00000003, 00000004);

insert into Stores_Purchased values
(00000004, 00000003);

insert into Stores_Purchased values
(00000005, 00000002);

insert into Stores_Purchased values
(00000006, 00000001);

insert into Stores_Purchased values
(00000007, 00000007);

insert into Stores_Purchased values
(00000007, 00000008);

insert into Stores_Purchased values
(00000007, 00000009);

insert into Stores_Purchased values
(00000008, 00000011);

insert into Stores_Purchased values
(00000009, 00000012);

insert into Stores_Purchased values
(00000009, 00000013);

insert into Stores_Purchased values
(00000010, 00000011);

insert into Stores_Purchased values
(00000010, 00000012);

insert into Stores_Purchased values
(00000010, 00000013);

insert into Stores_Purchased values
(00000010, 00000010);

insert into returns values
(00000001, 00000002, '15-FEB-2009');

insert into returns values
(00000002, 00000004, '23-MAR-2011');

insert into returns values
(00000003, 00000005, '22-FEB-2011');

insert into returns values
(00000004, 00000010, '01-JUL-2012');

insert into returns values
(00000005, 00000009, '06-MAR-2008');

insert into returns values
(00000002, 00000002, '19-APR-2010');

insert into returns values
(00000006, 00000011, '20-JAN-2010');

insert into returns values
(00000006, 00000012, '05-APR-2011');

insert into returns values
(00000006, 00000013, '15-SEP-2010');

insert into returns values
(00000007, 00000011, '11-AUG-2012');

insert into returns values
(00000007, 00000012, '20-FEB-2010');

insert into modifies values
(44406106, 00000007, '01-FEB-2011');

insert into modifies values
(44406106, 00000012, '03-FEB-2010');

insert into modifies values
(44406106, 00000013, '03-OCT-2011');

insert into modifies values
(44406107, 00000006, '03-FEB-2009');

insert into modifies values
(44406109, 00000009, '08-FEB-2011');

insert into hires values
(44406106, 44406107);

insert into hires values
(44406106, 44406108);

insert into hires values
(44406106, 44406109);

insert into hires values
(44406109, 44406110);

insert into hires values
(44406106, 44406111);

insert into hires values
(44406106, 44406112);

insert into hires values
(44406108, 44406113);

insert into hires values
(44406107, 44406114);

insert into hires values
(44406110, 44406115);

commit;