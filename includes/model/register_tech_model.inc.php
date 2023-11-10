<?php

declare(strict_types=1);

function getPharmacies(object $pdo) {
    //INPUT: php data object 
    //OUTPUT: array of pharmacies if present and
    //          bool false if not

    $query = "SELECT pharmacyId AS id, name FROM pharmacies;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function setStaff(object $pdo, string $firstname, string $lastname, string $address, string $contactno, string $empstatus, string $pharmacyid)
{
    //INPUT: php data object, firstname, lastname, address, contactno, empstatus, pharmacyid
    //PROCESS: Create new staff memeber in staff

    $query = "INSERT INTO staff (fName, lName, address, contactNo, empStatus, pharmacyId) VALUES 
    (:firstname, :lastname, :staffaddress, :contactno, :empstatus, :pharmacyid);";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":staffaddress", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":empstatus", $empstatus);
    $stmt->bindParam(":pharmacyid", $pharmacyid);
    $stmt->execute();
}

function getStaffId($pdo, string $firstname, string $lastname, string $address, string $contactno, string $empstatus, string $pharmacyid) {
    //INPUT: php data object and string firstname, lastname, address, contactno, empstatus
    //OUTPUT: staffid if present and bool false if not

    $query = "SELECT staffId FROM staff WHERE fName = :firstname AND lName = :lastname AND address = :useraddress AND contactNo = :contactno AND empStatus = :empstatus AND pharmacyId = :pharmacyid;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":useraddress", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":empstatus", $empstatus);
    $stmt->bindParam(":pharmacyid", $pharmacyid);
    $stmt->execute();

    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result['staffId'];
}

function setPharmTech(object $pdo, string $staffid)
{
    //INPUT: php data object, staffid
    //PROCESS: Create new user in pharmacy Technician
    $query = "INSERT INTO pharmacy_technicians (staffId) VALUES 
    (:staffid);";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":staffid", $staffid);
    $stmt->execute();
}