<?php

declare(strict_types=1);

function getUser(object $pdo, string $username)
{
    //INPUT : php data object and email variable
    //OUTPUT : array of record if matched email is found and bool false if else
    
    $query = "SELECT * FROM sys_users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result;
}