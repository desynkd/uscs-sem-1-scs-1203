<?php

declare(strict_types=1);

function setStaff(object $pdo, string $firstname, string $lastname, string $address, string $contactno, string $empstatus, string $pharmacyid)
{
    //INPUT: php data object, firstname, lastname, address, contactno, empstatus, pharmacyid
    //PROCESS: Create new staff memeber in staff

    $query = "INSERT INTO staff (fname, lname, address, contactNo, empStatus, pharmacyId) VALUES 
    (:firstname, :lastname, :address, :contactNo,)";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":regno", $regno);
    $stmt->bindParam(":hiredate", $hiredate);
    $stmt->bindParam(":termdate", $termdate);
    $stmt->bindParam(":empstatus", $empstatus);
    $stmt->execute();
}

function setPharmacist(object $pdo, string $firstname, string $lastname, string $address, string $contactno, string $regno, string $hiredate, string $termdate, string $empstatus)
{
    //INPUT: php data object, username, password, email, usertype
    //PROCESS: Create new user in sys_users

    $query = "INSERT INTO sys_users (username, usertype, pwd, email) VALUES 
    (:username, :usertype, :pwd, :email)";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":regno", $regno);
    $stmt->bindParam(":hiredate", $hiredate);
    $stmt->bindParam(":termdate", $termdate);
    $stmt->bindParam(":empstatus", $empstatus);
    $stmt->execute();
}