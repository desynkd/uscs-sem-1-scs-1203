<?php

declare(strict_types=1);

function getUser(object $pdo, string $username)
{
    //INPUT : php data object and email variable
    //OUTPUT : array of record if matched usernamel is found and bool false if else
    
    $query = "SELECT * FROM sys_users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result;
}

function getUserType(object $pdo, string $username)
{
    //INPUT : php data object and email variable
    //OUTPUT : array of record if matched username is found and bool false if else
    
    $query = "SELECT usertype FROM sys_users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result['usertype'];
}

function getUsername(object $pdo, string $username) {
    //INPUT: php data object and string email and string usertype
    //OUTPUT: array of username if present and
    //          bool false if not

    $query = "SELECT username FROM sys_users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
 
    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result;
}

function getEmail(object $pdo, string $email, string $usertype) {
    //INPUT: php data object and string email and string usertype
    //OUTPUT: array of username if present and
    //          bool false if not

    $query = "SELECT username FROM sys_users WHERE email = :email AND usertype = :usertype;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":usertype", $usertype);
    $stmt->execute();
 
    $result = $stmt->fetch(PDO :: FETCH_ASSOC);
    return $result;
}

function updateEmail(object $pdo, string $username, string $email)
{
        $query = "UPDATE sys_users SET email = :email WHERE username = :username;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
}

function updatePassword(object $pdo, string $username, string $pwd)
{
        $query = "UPDATE sys_users SET pwd = :pwd WHERE username = :username;";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);


    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
}

function updateUsername(object $pdo, string $oldUsername, string $newUsername)
{
        $query = "UPDATE sys_users SET username = :newusername WHERE username = :oldusername;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":newusername", $newUsername);
    $stmt->bindParam(":oldusername", $oldUsername);
    $stmt->execute();
}