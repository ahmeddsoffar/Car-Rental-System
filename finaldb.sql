Create Database car_rental_system;

CREATE TABLE Car(
    CarID int not null PRIMARY KEY AUTO_INCREMENT,
    Year int(4) not null,
    Car_status varchar(10) not null,
 	model varchar(20) not null,
    PlateID int not null,
    color varchar(20) not null,
    motor_type varchar(20) not null,
    No_of_seats int not null,
    carType varchar(20) not null,
    office_ID int not null   
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

CREATE TABLE payment(
	payment_ID int not null,
    amount_of_money int not null,
    method_of_payment varchar(100) not null,
    payment_date date,
    reservation_ID int not null,
    PRIMARY key(payment_ID,reservation_ID)
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

ALTER TABLE payment
ADD FOREIGN KEY(reservation_ID) REFERENCES reservation(reservation_ID);

ALTER TABLE Reservation
ADD FOREIGN KEY (CustomerID) REFERENCES Customer(ID);

ALTER TABLE car
ADD FOREIGN KEY(office_ID) REFERENCES office(office_ID);