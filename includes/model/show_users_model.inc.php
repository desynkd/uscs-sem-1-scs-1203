<?php

declare(strict_types=1);

function getUsers(object $pdo)
{
    //INPUT: php data object
    //OUTPUT: Associative Array of records

    $query = "SELECT id, usertype, username, email, createdAt FROM sys_users WHERE userstatus = 1;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}