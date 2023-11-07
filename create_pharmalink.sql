CREATE TABLE sys_users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    usertype VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    createdAt DATETIME NOT NULL DEFAULT CURRENT_TIME,
    userstatus INT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id)
);

INSERT INTO sys_users (usertype, username, pwd, email) VALUES (
    'admin',
    'useradmin',
    '$2y$12$/YqX9.5wZ27rrUt6YFFjWuxqTiu9jKfnWqqCwnXXwVXSQA.CMzKd6', /*admin*/
    'user@admin.com'
);

CREATE TABLE pharmacies (
    pharmacyId INT(5) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(100) NOT NULL,
    PRIMARY KEY (pharmacyId)
);

CREATE TABLE departments (
    depId INT(10) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    pharmacyId INT(5) NOT NULL,
    PRIMARY KEY (depId),
    CONSTRAINT FK_DepartmentPharmacy
    FOREIGN KEY (pharmacyId)
    REFERENCES pharmacies(pharmacyId)
);

CREATE TABLE staff (
    staffId INT(10) NOT NULL AUTO_INCREMENT,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50),
    address VARCHAR(255) NOT NULL,
    contactNo INT(10) NOT NULL,
    empStatus VARCHAR(4) NOT NULL,/*Full or Part*/
    pharmacyId INT(5) NOT NULL,
    PRIMARY KEY(staffId),
    CONSTRAINT FK_StaffPharmacy
    FOREIGN KEY (pharmacyId)
    REFERENCES pharmacies(pharmacyId)
);

CREATE TABLE department_staff (
    depId INT(10) NOT NULL,
    staffId INT(10) NOT NULL,
    role VARCHAR(50) NOT NULL,
    PRIMARY KEY (depId, staffId),
    CONSTRAINT FK_DepstaffDepartment
    FOREIGN KEY (depId)
    REFERENCES departments(depId),
    CONSTRAINT FK_DepStaffStaff
    FOREIGN KEY (staffId)
    REFERENCES staff(staffId)
);

CREATE TABLE sales_associates (
    associateNo INT(10) NOT NULL AUTO_INCREMENT,
    staffId INT(10) NOT NULL,
    PRIMARY KEY (associateNo),
    CONSTRAINT FK_SalesStaff
    FOREIGN KEY (staffId)
    REFERENCES staff(staffId)
);

CREATE TABLE ceos (
    associateNo INT(10) NOT NULL,
    dateAssigned DATE NOT NULL,
    PRIMARY KEY (associateNo),
    CONSTRAINT FK_SalesCEO
    FOREIGN KEY (associateNo)
    REFERENCES sales_associates(associateNo)
);

CREATE TABLE pharmacists (
    pharmacistId INT(10) NOT NULL AUTO_INCREMENT,
    staffId INT(10) NOT NULL,
    regNo INT(10),
    hireDate DATE,
    terminationDate DATE,
    PRIMARY KEY (pharmacistId),
    CONSTRAINT FK_PharamcistStaff
    FOREIGN KEY (staffId)
    REFERENCES staff(staffId)
);

CREATE TABLE chief_pharmacists (
    pharmacistId INT(10) NOT NULL,
    dateAssigned DATE NOT NULL,
    PRIMARY KEY (pharmacistId),
    CONSTRAINT FK_ChiefPharmcistPharmacist
    FOREIGN KEY (pharmacistId)
    REFERENCES pharmacists(pharmacistId)
);

CREATE TABLE patients (
    patientId INT(10) NOT NULL AUTO_INCREMENT,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50),
    dob DATE NOT NULL,
    contactNo INT(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    PRIMARY KEY (patientId)
);

CREATE TABLE vital_signs (
    vitalId INT(10) NOT NULL AUTO_INCREMENT,
    patientId INT(10) NOT NULL,
    vitalDateTime DATETIME NOT NULL,
    temperature INT(4),
    pulse INT(4),
    bloodPressure INT(4),
    PRIMARY KEY (vitalId),
    CONSTRAINT VitalPatient
    FOREIGN KEY (patientId)
    REFERENCES patients(patientId)
);

CREATE TABLE diagnoses (
    diagnosisId INT(10) NOT NULL AUTO_INCREMENT,
    patientId INT(10) NOT NULL,
    symptons VARCHAR(255),
    name VARCHAR(255),
    PRIMARY KEY (diagnosisId),
    CONSTRAINT FK_DiagnosisPatient
    FOREIGN KEY (patientId)
    REFERENCES patients(patientId)
);

CREATE TABLE diagnosis_by (
    diagnosisId INT(10) NOT NULL,
    pharmacistId INT(10) NOT NULL,
    diagDateTime DATETIME NOT NULL,
    PRIMARY KEY (diagnosisId, pharmacistId),
    CONSTRAINT FK_DiagByDiagnosis
    FOREIGN KEY (diagnosisId)
    REFERENCES diagnoses(diagnosisId),
    CONSTRAINT FK_DiagByPharmacist
    FOREIGN KEY (pharmacistId)
    REFERENCES pharmacists(pharmacistId)
);

CREATE TABLE suppliers (
    supId INT(10) NOT NULL AUTO_INCREMENT,
    contactNo INT(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    regNo INT(10) NOT NULL,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50) NOT NULL,
    PRIMARY KEY (supId)
);

CREATE TABLE products (
    productId INT(10) AUTO_INCREMENT,
    supId INT(10),
    Name VARCHAR(50) NOT NULL,
    suppliedDate DATE NOT NULL,
    quantity INT(10) NOT NULL,
    unitCost INT(10) NOT NULL,
    totalCost INT(100) NOT NULL,
    PRIMARY KEY (productId),
    CONSTRAINT FK_ProductSupplier
    FOREIGN KEY (supId)
    REFERENCES suppliers(supId)
);

CREATE TABLE categories (
    categoryId INT(10) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    PRIMARY KEY (categoryId)
);

CREATE TABLE shelves (
    shelfId INT(10) NOT NULL AUTO_INCREMENT,
    location VARCHAR(50) NOT NULL,
    PRIMARY KEY (shelfId)
);

CREATE TABLE medications (
    medId INT(10) NOT NULL AUTO_INCREMENT,
    productId INT(10) NOT NULL,
    name VARCHAR(50) NOT NULL,
    shelfId INT(10) NOT NULL,
    categoryId INT(10) NOT NULL,
    PRIMARY KEY (medId),
    CONSTRAINT FK_MedProduct
    FOREIGN KEY (productId)
    REFERENCES products(productId),
    CONSTRAINT FK_MedCategory
    FOREIGN KEY (categoryId)
    REFERENCES categories(categoryId),
    CONSTRAINT FK_MedShelf
    FOREIGN KEY (shelfId)
    REFERENCES shelves(shelfId)
);

CREATE TABLE dispensings (
    dispensingId INT(10) NOT NULL AUTO_INCREMENT,
    dispDateTime DATETIME NOT NULL,
    pharmacistId INT(10) NOT NULL,
    PRIMARY KEY (dispensingId),
    CONSTRAINT FK_DispPharmacist
    FOREIGN KEY (pharmacistId)
    REFERENCES pharmacists(pharmacistId)
);

CREATE TABLE orders (
    orderId INT(10) NOT NULL AUTO_INCREMENT,
    medId INT(10) NOT NULL,
    dispensingId INT(10) NOT NULL,
    diagnosisId INT(10) NOT NULL,
    patientId INT(10) NOT NULL,
    quantity INT(10) NOT NULL,
    totalCost INT(100) NOT NULL,
    PRIMARY KEY (orderId),
    CONSTRAINT FK_OrderMed
    FOREIGN KEY (medId)
    REFERENCES medications(medId),
    CONSTRAINT FK_OrderDisp
    FOREIGN KEY (dispensingId)
    REFERENCES dispensings(dispensingId),
    CONSTRAINT FK_OrderDiagnosis
    FOREIGN KEY (diagnosisId)
    REFERENCES diagnoses(diagnosisId),
    CONSTRAINT FK_OrderPatient
    FOREIGN KEY (patientId)
    REFERENCES patients(patientId)
);

CREATE TABLE delivery_orders (
    deliveryId INT(10) NOT NULL AUTO_INCREMENT,
    orderId INT(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    deliveryDate DATE NOT NULL,
    PRIMARY KEY (deliveryId),
    CONSTRAINT FK_DelOrderOrder
    FOREIGN KEY (orderId)
    REFERENCES orders(orderId)
);

CREATE TABLE sys_accounts (
    id INT(11) NOT NULL,
    staffId INT(10),
    supId INT(10),
    patientId INT(10),
    PRIMARY KEY (id),
    CONSTRAINT FK_AccountUser
    FOREIGN KEY (id)
    REFERENCES sys_users(id),
    CONSTRAINT FK_AccountStaff
    FOREIGN KEY (staffId)
    REFERENCES staff(staffId),
    CONSTRAINT FK_AccountSupplier
    FOREIGN KEY (supId)
    REFERENCES suppliers(supId),
    CONSTRAINT FK_AccountPatient
    FOREIGN KEY (patientId)
    REFERENCES patients(patientId)
);

INSERT INTO sys_accounts (id) 
SELECT id FROM sys_users WHERE username = 'useradmin';

INSERT INTO pharmacies (name, location) 
VALUES
    ('Millenial Pharmacy', '123 Main Street');


/*INSERT INTO pharmacies (name, location) 
VALUES
    ('Captial Pharmacy', '234 Temple Trees');*/

INSERT INTO departments (name, pharmacyId) 
VALUES
    ('Adminstative', '1'),
    ('Prescription Dispensing', '1'),
    ('OTC Dispensing', '1');

/*INSERT INTO departments (name, pharmacyId) 
VALUES
    ('Adminstative', '2'),
    ('Dispensing', '2'),
    ('Welfare Services', '2');*/

INSERT INTO staff (fName, lName, address, contactNo, empStatus, pharmacyId)
VALUES 
    ('Daham', 'Samarasinghe', '145/1, Meewathura, Peradeniya', 0779999999, 'Full', '1'),
    ('Thenuka', 'Thennakoon', '154/1, Meewathura, Peradeniya', 0759999999, 'Part', '1');

INSERT INTO department_staff 
VALUES 
    (2, 1, 'Dispenser'),
    (1, 2, 'Accountant');

INSERT INTO sales_associates (staffId) 
VALUES 
    (2);

INSERT INTO ceos 
VALUES 
    (1, '2023-11-08');

INSERT INTO pharmacists (staffId, regNo, hireDate, terminationDate) 
VALUES 
    (1, 1023, '2021-10-06', '2024-10-06');

INSERT INTO chief_pharmacists 
VALUES 
    (1, '2023-11-08');

INSERT INTO patients (fName, lName, dob, contactNo, address) 
VALUES 
    ('Thamindu', 'Dassanayake', '2002-02-21', 0719999999, '541/1, Meewathura, Peradeniya');

INSERT INTO vital_signs (patientId, vitalDateTime, temperature, pulse, bloodPressure)
VALUES
    (1, '2023-01-01 08:00:00', 98, 80, 120),
    (1, '2023-01-01 12:00:00', 99, 82, 122),
    (1, '2023-01-01 16:00:00', 98, 78, 118);

INSERT INTO diagnoses (patientId, symptons, name)
VALUES
    (1, 'Fever, Cough', 'Common Cold'),
    (1, 'Headache, Fatigue', 'Migraine'),
    (1, 'Sore Throat, Difficulty Swallowing', 'Strep Throat');

INSERT INTO diagnosis_by (diagnosisId, pharmacistId, diagDateTime)
VALUES
    (1, 1, '2023-01-01 09:00:00'),
    (2, 1, '2023-01-02 10:30:00'),
    (3, 1, '2023-01-03 15:15:00');

INSERT INTO suppliers (fName, lName, contactNo, address, regNo)
VALUES
    ('Thaqib', 'Akbar', 0729999999, '451/1, Meewathura, Peradeniya', '223398');

INSERT INTO products (supId, Name, suppliedDate, quantity, unitCost, totalCost)
VALUES
    (1, 'Aspirin', '2023-01-15', 100, 5, 500),
    (1, 'Ibuprofen', '2023-02-10', 150, 4, 600),
    (1, 'Lisinopril', '2023-03-05', 200, 6, 1200);

INSERT INTO categories (name, type)
VALUES
    ('Pain Relievers', 'OTC'),
    ('Anti-Inflammatories', 'OTC'),
    ('Hypertension Medications', 'Prescription');

INSERT INTO shelves (location)
VALUES
    ('Shelf 1'),
    ('Shelf 2'),
    ('Shelf 3');

INSERT INTO medications (productId, name, shelfId, categoryId)
VALUES
    (1, 'Aspirin Tablets', 1, 1),
    (2, 'Ibuprofen Tablets', 2, 2),
    (3, 'Lisinopril Tablets', 3, 3);

INSERT INTO dispensings (dispDateTime, pharmacistId)
VALUES
    ('2023-01-15 09:30:00', 1),
    ('2023-02-10 10:15:00', 1),
    ('2023-03-05 11:00:00', 1);

INSERT INTO orders (medId, dispensingId, diagnosisId, patientId, quantity, totalCost)
VALUES
    (1, 1, 1, 1, 50, 250),
    (2, 2, 2, 1, 75, 300),
    (3, 3, 3, 1, 100, 600);

INSERT INTO delivery_orders (orderId, address, deliveryDate)
VALUES
    (1, '123 Elm Street, Cityville', '2023-01-20'),
    (2, '456 Oak Avenue, Townsville', '2023-02-15'),
    (3, '789 Maple Lane, Villagetown', '2023-03-10');

INSERT INTO sys_users (usertype, username, pwd, email) 
VALUES 
    ('pharmacist',
    'Daham010',
    '$2y$12$wOUtO9BnqIWauHbS3scHautgQokQxZZqpuImjqao1kupLO.UylcD.', /*daham*/
    'daham@gmail.com'),
    ('sales',
    'Thenuka011',
    '$2y$12$I6Xcz46.AoHUUQetqZwf/eWtABLdK2VbZblD4cbl8imT1UHQAW8YS', /*Thenuka*/
    'thenuka@gmail.com'),
    ('patient',
    'Thamidu012',
    '$2y$12$ZG2txo0kdP5G1DL7Uqvp1urAyWMyM47rBZFtXDz6WaEDshaeueWde', /*Thamindu*/
    'thamindu@gmail.com'),
    ('supplier',
    'Thaqib014',
    '$2y$12$sDw5aolGw1C64bpM80z81ufkObdbDxsiDk0rIEYE7Ijq0KSCPKUuG', /*Thaqib*/
    'thaqib@gmail.com');

INSERT INTO sys_accounts (id, staffId, supId, patientId) 
VALUES
    (2, 1, NULL, NULL),
    (3, 2, NULL, NULL),
    (4, NULL, NULL, 1),
    (5, NULL, 1, NULL);