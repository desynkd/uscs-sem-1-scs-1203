<?php

declare(strict_types=1);

function isInputEmpty(string $username, string $pwd, string $email) {
    if (empty($username) && empty($pwd) && empty($email)) {
        //INPUT: string username, password, email
        //OUTPUT: True if all is empty or false if else
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

function changeEmail(object $pdo, string $username, string $email)
{
    updateEmail($pdo, $username, $email);
}

function changePassword(object $pdo, string $username, string $pwd)
{
    updatePassword($pdo, $username, $pwd);
}

function changeUsername(object $pdo, string $oldUsername, string $newUsername)
{
    updateUsername($pdo, $oldUsername, $newUsername);
}