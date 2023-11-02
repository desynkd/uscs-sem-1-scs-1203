<?php

declare(strict_types=1);

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

function setUser(object $pdo, string $username, string $pwd, string $email, string $usertype)
{
    //INPUT: php data object, username, password, email, usertype
    //PROCESS: Create new user in sys_users

    $query = "INSERT INTO sys_users (username, usertype, pwd, email) VALUES 
    (:username, :usertype, :pwd, :email)";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":usertype", $usertype);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
}