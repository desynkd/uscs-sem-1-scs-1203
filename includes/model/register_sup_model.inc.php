<?php

declare(strict_types=1);

function setSupplier(object $pdo, string $firstname, string $lastname, string $address, string $contactno, string $regno)
{
    //INPUT: php data object, firstname, lastname, address, contactno, regno
    //PROCESS: Create new supplier in suppliers

    $query = "INSERT INTO suppliers (fName, lName, address, contactNo, regNo) VALUES 
    (:firstname, :lastname, :address, :contactno, :regno);";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":regno", $regno);
    $stmt->execute();
}

function getSupplierId($pdo, string $firstname, string $lastname, string $address, string $contactno, string $regno) {
    //INPUT: php data object and string firstname, lastname, address, contactno, empstatus
    //OUTPUT: staffid if present and bool false if not

    $query = "SELECT supId FROM suppliers WHERE fName = :firstname AND lName = :lastname AND address = :address AND contactNo = :contactno AND regNo = :regno;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":contactno", $contactno);
    $stmt->bindParam(":regno", $regno);
    $stmt->execute();

    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result['supId'];
}
