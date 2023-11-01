<?php

declare(strict_types=1);

function getUsers(object $pdo, int $isActive)
{
    //INPUT: php data object
    //OUTPUT: Associative Array of records

    if ($isActive == 1)
    {
        $query = "SELECT id, usertype, username, email, createdAt FROM sys_users WHERE userstatus = 1;";
    }
    else if ($isActive == 0)
    {
        $query = "SELECT id, usertype, username, email, createdAt FROM sys_users WHERE userstatus = 0;";
    }
    else
    {
        $query = "SELECT id, usertype, username, email, createdAt FROM sys_users";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}