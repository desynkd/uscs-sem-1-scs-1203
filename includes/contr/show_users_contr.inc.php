<?php

declare(strict_types=1);

function createRecords(object $pdo) 
{
    //INPUT: php data object, username, password, email, usertype
    //OUTPUT: Return associative array of users
    return getUsers($pdo);
}