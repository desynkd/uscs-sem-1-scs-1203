<?php

declare(strict_types=1);

function isInputEmpty(string $username, string $pwd, string $email) {
    if (empty($username) || empty($pwd) || empty($email)) {
        //INPUT: string username, password, email
        //OUTPUT: True if even one is empty or false if else
        return true;
    }
    else{
        return false;
    }
}

function isEmailValid (string $email)
{
    //INPUT : Email variable
    //OUTPUT : True if email is valid and false if else
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isUsernameTaken(object $pdo, string $username) {
    //INPUT: php data object and string username and usertype
    //OUTPUT: True if email with usertype already in database
    if (getUsername($pdo, $username)) {
        return true;
    }
    else{
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email, string $usertype) {
    //INPUT: php data object and string email and usertype
    //OUTPUT: True if email with usertype already in database
    if (getEmail($pdo, $email, $usertype)) {
        return true;
    }
    else{
        return false;
    }
}

function createUser(object $pdo, string $username, string $pwd, string $email, string $usertype) 
{
    //INPUT: php data object, username, password, email, usertype
    //PROCESS: Instruct model to create new user in sys_users
    setUser($pdo, $username, $pwd, $email, $usertype);
}
