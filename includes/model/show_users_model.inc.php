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

function getUsername(object $pdo, string $userid)
{
    //INPUT: php data object and string userid
    //OUTPUT: username of userid if found and false if else

    $query = "SELECT username FROM sys_users WHERE id = :userid";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userid", $userid);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function getUserstatus(object $pdo, string $userid)
{
    //INPUT: php data object and string userid
    //OUTPUT: username of userid if found and false if else

    $query = "SELECT userstatus FROM sys_users WHERE id = :userid";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userid", $userid);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $result[0]['userstatus'];
}

function switchUserstatus(object $pdo, string $userid, int $newstatus)
{
    //INPUT: php data object, usernid, new userstatus
    //PROCESS: change userstatus to new user status

    if ($newstatus == 1 || $newstatus == 0)
    {
        $query = "UPDATE sys_users SET userstatus = :newstatus WHERE id = :userid;";
    }
    else
    {
        exit("Error show_users_model/switchUserstatus: Invalid New Userstatus");
    }
 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userid", $userid);
    $stmt->bindParam(":newstatus", $newstatus);
    $stmt->execute();
}