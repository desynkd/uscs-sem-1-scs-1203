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
    '$2y$12$/YqX9.5wZ27rrUt6YFFjWuxqTiu9jKfnWqqCwnXXwVXSQA.CMzKd6',
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
    empStatus VARCHAR(4) NOT NULL,/*FULL or PART*/
    pharmacyId INT(5) NOT NULL,
    PRIMARY KEY(staffId),
    CONSTRAINT FK_StaffPharmacy
    FOREIGN KEY (pharmacyId)
    REFERENCES pharmacies(pharmacyId)
);

CREATE TABLE department_staff (
    depId INT(10) NOT NULL AUTO_INCREMENT,
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
    patientId INT(10) NOT NULL,
    diagDateTime DATETIME NOT NULL,
    PRIMARY KEY (diagnosisId, patientId),
    CONSTRAINT FK_DiagByDiagnosis
    FOREIGN KEY (diagnosisId)
    REFERENCES diagnoses(diagnosisId),
    CONSTRAINT FK_DiagByPatient
    FOREIGN KEY (patientId)
    REFERENCES patients(patientId)
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

INSERT INTO pharmacies (name, location) VALUES
('Millenial Pharmacy', '123 Main Street');


/*Sample data for the 'departments' table*/
INSERT INTO departments (name, pharmacyId) VALUES
('Pharmacy Department', 1),
('Laboratory Department', 1),
('Pharmacy Department', 2),
('Laboratory Department', 2);

/*Sample data for the 'staff' table*/
INSERT INTO staff (contactNo, empStatus, fName, lName, address, pharmacyId) VALUES
(1234567890, 'FULL', 'John', 'Doe', '456 Elm Street', 1),
(9876543210, 'PART', 'Jane', 'Smith', '789 Oak Street', 2);

/*Sample data for the 'department_staff' table*/
INSERT INTO department_staff (depId, staffId, role) VALUES
(1, 1, 'Pharmacist'),
(2, 2, 'Lab Technician');

/*Sample data for the 'sales_associates' table*/
INSERT INTO sales_associates (staffId) VALUES
(1),
(2);

/*Sample data for the 'ceos' table*/
INSERT INTO ceos (associateNo, dateAssigned) VALUES
(1, '2023-01-15'),
(2, '2023-02-20');

/*Sample data for the 'pharmacists' table*/
INSERT INTO pharmacists (staffId, regNo, hireDate, terminationDate) VALUES
(1, 12345, '2020-05-10', NULL),
(2, 54321, '2019-08-15', '2022-03-30');

/*Sample data for the 'chief_pharmacists' table*/
INSERT INTO chief_pharmacists (pharmacistId, dateAssigned) VALUES
(1, '2023-01-15');

/*Sample data for the 'patients' table*/
INSERT INTO patients (fName, lName, dob, contactNo, address) VALUES
('Alice', 'Johnson', '1990-03-15', 987654321, '123 Pine Street'),
('Bob', 'Smith', '1985-12-10', 123456789, '456 Maple Street');

/*Sample data for the 'vital_signs' table*/
INSERT INTO vital_signs (patientId, vitalDateTime, temperature, pulse, bloodPressure) VALUES
(1, '2023-03-01 08:00:00', 98.6, 75, 120/80),
(2, '2023-03-02 09:30:00', 99.2, 80, 130/70);

/*Sample data for the 'diagnoses' table*/
INSERT INTO diagnoses (patientId, symptons, name) VALUES
(1, 'Fever, Cough', 'Common Cold'),
(2, 'Headache, Fatigue', 'Migraine');

/*Sample data for the 'diagnosis_by' table*/
INSERT INTO diagnosis_by (diagnosisId, patientId, diagDateTime) VALUES
(1, 1, '2023-03-01 08:30:00'),
(2, 2, '2023-03-02 10:00:00');

/*Sample data for the 'suppliers' table*/
INSERT INTO suppliers (contactNo, address, regNo, fName, lName) VALUES
(9876543210, '123 Supplier Street', 5678, 'Supplier', 'One'),
(1234567890, '456 Supplier Avenue', 9876, 'Supplier', 'Two');

/*Sample data for the 'products' table*/
INSERT INTO products (supId, Name, suppliedDate, quantity, unitCost, totalCost) VALUES
(1, 'Medicine A', '2023-03-01', 100, 10, 1000),
(2, 'Medicine B', '2023-03-02', 200, 15, 3000);

/*Sample data for the 'categories' table*/
INSERT INTO categories (name, type) VALUES
('Pain Relief', 'OTC'),
('Antibiotics', 'Prescription');

/*Sample data for the 'shelves' table*/
INSERT INTO shelves (location) VALUES
('A1'),
('B2');

/*Sample data for the 'medications' table*/
INSERT INTO medications (productId, name, shelfId, categoryId) VALUES
(1, 'Medicine A', 1, 1),
(2, 'Medicine B', 2, 2);

/*Sample data for the 'dispensings' table*/
INSERT INTO dispensings (dispDateTime, pharmacistId) VALUES
('2023-03-01 10:00:00', 1),
('2023-03-02 11:30:00', 2);

/*Sample data for the 'orders' table*/
INSERT INTO orders (medId, dispensingId, diagnosisId, patientId, quantity, totalCost) VALUES
(1, 1, 1, 1, 10, 100),
(2, 2, 2, 2, 20, 300);

/*Sample data for the 'delivery_orders' table*/
INSERT INTO delivery_orders (orderId, address, deliveryDate) VALUES
(1, '123 Main Street', '2023-03-05'),
(2, '456 Elm Street', '2023-03-06');

