<?php

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try
    {
        require_once '../dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        require_once '../config_session.inc.php';

        //ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($email, $pwd)) 
        {
            $errors["empty_input"] = "Fill all fields!";
        }
        if (!isEmailValid($email))
        {
            $errors["email_invalid"] = "Invalid Email!";
        }

        $result = getUser($pdo, $email);

        if (!isEmailCorrect($result))
        {
            $errors["email_incorrect"] = "Incorrect Email!";
        }
        if (isEmailCorrect($result) && !isPasswordCorrect($pwd, $result["pwd"]))
        {
            $errors["password_incorrect"] = "Incorrect Password!";
        }

        if($errors)
        {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../../index.php?login=fail");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . " " . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["user_type"] = $result["usertype"];

        $_SESSION["last_regeneration"] = time();

        //header("Location: ../../index.php?login=success");
        header("Location: ../../dashboard.php");
        $pdo = null;
        $stmt = null;
        die();
    } 
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
else
{
    header("Location: ../../index.php?login=unauthorized");
    die();
}
