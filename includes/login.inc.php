<?php

//check if login is not accessed maliciously
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    //$email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try
    {
        require_once 'dbh.inc.php';
        require_once 'model/login_model.inc.php';
        require_once 'contr/login_contr.inc.php';
        require_once 'config_session.inc.php';

        //ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($username, $pwd)) 
        {
            $errors["empty_input"] = "Fill all fields!";
        }

        $result = getUser($pdo, $username);

        if (!empty($result))
        {
            if (!isUserActive($result["userstatus"]))
            {
                $errors["user_inactive"] = "User is no longer active!";
            }
        }
        if (!isUsernameCorrect($result))
        {
            $errors["username_incorrect"] = "Incorrect Username!";
        }
        if (isUsernameCorrect($result) && !isPasswordCorrect($pwd, $result["pwd"]))
        {
            $errors["password_incorrect"] = "Incorrect Password!";
        }

        if($errors)
        {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../index.php?login=fail");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . " " . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["user_type"] = $result["usertype"];

        $_SESSION["last_regeneration"] = time();

        if( $_SESSION["user_type"] === 'admin' )
        {
            header("Location: ../admin_dashboard.php");
        }
        else if ( $_SESSION["user_type"] === 'pharmacist' )
        {
            header("Location: ../pharm_dashboard.php");
        } 
        else if ( $_SESSION["user_type"] === 'supplier' )
        {
            header("Location: ../sup_dashboard.php");
        }
        else
        {
            header("Location: ../index.php?login=success&usertype=undefined");
        }
        //header("Location: ../../index.php?login=success");
        //header("Location: ../../dashboard.php");
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
    header("Location: ../index.php?login=unauthorized");
    die();
}
