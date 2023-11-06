<?php

declare(strict_types=1);

function getUsers(object $pdo, string $entity)
{
    //INPUT: php data object
    //OUTPUT: Associative Array of records

    if ($entity == 'admin')
    {
        $query = "SELECT id AS 'User ID', username AS 'User Name', email AS 'E-Mail', createdAt AS 'Created Date' FROM sys_users WHERE userstatus = 1; AND usertype = 'admin'";
    }
    else if ($entity == 'pharmacist')
    {
        $query = "SELECT s.staffId AS 'Staff ID', p.pharmacistId AS 'Pharmacist ID', CONCAT(s.fName, ' ', s.lName) AS 'Full Name', s.address AS Address, s.contactNo AS 'Contact Number', s.empStatus AS 'Employee Status', p.regNo AS 'SPB Registration Number', p.hiredate AS 'SPB Hire Date', p.terminationDate AS 'SPB Termination Date' FROM pharmacists p INNER JOIN staff s ON p.staffId = s.staffId;";
    }
    else if ($entity == 'sales')
    {
        $query = "SELECT s.staffId AS 'Staff ID', sa.associateNo AS 'Associate No', CONCAT(s.fName, ' ', s.lName) AS 'Full Name', s.address AS Address, s.contactNo AS 'Contact Number', s.empStatus AS 'Employee Status' FROM sales_associates sa INNER JOIN staff s ON sa.staffId = s.staffId";
    }
    else if ($entity == 'patient')
    {
        $query = "SELECT patientId AS 'Patient ID', CONCAT(fName, ' ', lName) AS 'Full Name', address AS Address, contactNo AS 'Contact Number', dob AS 'Date of Birth' FROM patients;";
    }
    else if ($entity == 'supplier')
    {
        $query = "SELECT supId AS 'Supplier ID', CONCAT(fName, ' ', lName) AS 'Full Name', address AS Address, contactNo AS 'Contact Number', regNo AS 'RA Registration Number' FROM suppliers;";
    }
    else
    {
        exit("Error show_users_model/switchUserstatus: Invalid New Userstatus");
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
