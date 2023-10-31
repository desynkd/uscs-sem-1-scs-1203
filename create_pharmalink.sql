CREATE TABLE sys_users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    usertype VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    createdAt DATETIME NOT NULL DEFAULT CURRENT_TIME,
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
    contactNo INT(10) NOT NULL,
    empStatus VARCHAR(4) NOT NULL,/*FULL or PART*/
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR(50),
    address VARCHAR(255) NOT NULL,
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
    dob DATETIME NOT NULL,
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