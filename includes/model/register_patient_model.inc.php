<?php

declare(strict_types=1);

function setPatient(object $pdo, string $firstname, string $lastname, string $address, string $contactno, string $dob)
{
    //INPUT: php data object, firstname, lastname, address, contactno, dob
    //PROCESS: Create new patient in patients

    $query = "INSERT INTO patients (fName, lName, address, contactNo, dob) VALUES 
    (:firstname, :lastname, :staffaddress, :contactno, :dob);";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":staffaddress", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":dob", $dob);
    $stmt->execute();
}

function getPatientId($pdo, string $firstname, string $lastname, string $address, string $contactno, string $dob) {
    //INPUT: php data object and string firstname, lastname, address, contactno, dob
    //OUTPUT: patientid if present and bool false if not

    $query = "SELECT patientId FROM patients WHERE fName = :firstname AND lName = :lastname AND address = :useraddress AND contactNo = :contactno AND dob = :dob";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":useraddress", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":dob", $dob);
    $stmt->execute();

    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result['patientId'];
}
