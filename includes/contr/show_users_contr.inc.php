<?php

declare(strict_types=1);

function createRecords(object $pdo, int $isActive) 
{
    //INPUT: php data object, username, password, email, usertype
    //OUTPUT: Return associative array of users

    return getUsers($pdo, $isActive);
}


function isUserIdEmpty(string $userid) {
    if (empty($userid)) {
        //INPUT: string userid
        //OUTPUT: True if empty or false if else
        return true;
    }
    else{
        return false;
    }
}

function isUserIdValid (object $pdo, string $userid)
{
    //INPUT : userif variable
    //OUTPUT : True if userId is in database and false if else
    if (getUsername($pdo, $userid)) 
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isUserIdActive(object $pdo, string $userid) {
    //INPUT: php data object and string username and usertype
    //OUTPUT: True if email with usertype already in database
    if (getUserstatus($pdo, $userid) == '1') {
        return true;
    }
    else{
        return false;
    }
}

function userstatusChange(object $pdo, string $userid, int $newStatus)
{
    //INPUT: php data object and string username and newstatus
    //PROCESS: change userstatus of userid 
    switchUserstatus($pdo, $userid, $newStatus);
}