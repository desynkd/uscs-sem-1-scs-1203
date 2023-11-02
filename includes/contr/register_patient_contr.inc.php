<?php

declare(strict_types=1);

function isPatientInputEmpty(string $firstname, string $address, string $contactno, string $dob)
{
    //INPUT: string firstname, lastname, address, contactno, dob
    //OUTPUT: True if even one is empty or false if else
    if (empty($firstname) || empty($address) || empty($contactno) || empty($dob)) {
        return true;
    }
    else
    {
        return false;
    }
}

function isContactNoValid (string $contactNo)
{
    //INPUT : ContactNo variable
    //OUTPUT : True if contactNo is valid and false if else
    if (is_numeric($contactNo) && strlen($contactNo) == 10 ) 
    {
        return true;
    }
    else
    {
        return false;
    }
}


function isDatePassed(string $inputDate)
{
    //INPUT : Date string variable
    //OUTPUT : True if inputdate is larger than current date and false if else
    $currentDate = date("Y-m-d"); 

    if ($currentDate < $inputDate) 
    {
        return true;
    }
    else
    {
        return false;
    }
}

function createPatient(object $pdo, string $firstname, string $lastname, string $address, string $contactno,  string $dob)
{
    //INPUT: php data object, firstname, lastname, address, contactno, dob
    //PROCESS: Instruct model to create new pharmacist in pharmacist
    setPatient($pdo, $firstname, $lastname, $address, $contactno, $dob);
    $patientid = (string)getPatientId($pdo, $firstname, $lastname, $address, $contactno, $dob);
    return $patientid;
}

function createPatientAccount(object $pdo, string $username, string $patientid)
{
    //INPUT: php data object, username, staffid
    //PROCESS: Instruct model to create new pharmacist in pharmacist
    $userid = (string)getUserId($pdo, $username);
    setAccount($pdo, $userid, NULL, NULL, $patientid);
}