Create Database car_rental_system;

CREATE TABLE Car(
    CarID int not null PRIMARY KEY AUTO_INCREMENT,
    Year int(4) not null,
    Final_status varchar(20) not null ,
    price_per_day decimal(10,2),
 	model varchar(20) not null,
    PlateID int not null,
    color varchar(20) not null,
    motor_type varchar(20) not null,
    No_of_seats int not null,
    carType varchar(20) not null,
    office_ID int not null   
);

CREATE TABLE CarStatus (
    statusID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    CarID int NOT NULL,
    current_status varchar(20) NOT NULL, 
    StartDate date NOT NULL,
    EndDate date NOT NULL,
    FOREIGN KEY (CarID) REFERENCES Car(CarID)
);

CREATE TABLE Customer(
    ID int not null PRIMARY key AUTO_INCREMENT,
    Address varchar(100) not null,
    username varchar(20) not null UNIQUE,
    First_name varchar(20) not null,
    Last_name varchar(20) not null,
    DOB date not null,
    email varchar(100) not null ,
    phone_no varchar(11) not null ,
    license_no int not null,
    password varchar(200) not null
);

CREATE TABLE admin(
    ID int not null PRIMARY key AUTO_INCREMENT,
    Address varchar(100) not null,
    username varchar(20) not null UNIQUE,
    First_name varchar(20) not null,
    Last_name varchar(20) not null,
    email varchar(100) not null ,
    phone_no varchar(11) not null ,
    office_no int not null,
    password varchar(200) not null
);


CREATE TABLE office(
    office_ID int not null PRIMARY KEY AUTO_INCREMENT,
    location varchar(100) not null,
    phone_number int(11) not null
);



CREATE TABLE reservation(
    reservation_ID int not null PRIMARY KEY AUTO_INCREMENT,
    reservation_Date date,
    pickup_date date,
    return_date date,
    CarID int not null,
    CustomerID int not null
);


ALTER TABLE reservation
ADD FOREIGN KEY(CarID) REFERENCES car(CarID);


ALTER TABLE reservation
ADD FOREIGN KEY (CustomerID) REFERENCES Customer(ID);

ALTER TABLE car
ADD FOREIGN KEY(office_ID) REFERENCES office(office_ID);