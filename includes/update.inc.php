<?php

require_once 'config_session.inc.php';

//Check if register is done by a admin usertype
if (!$_SESSION["user_type"] === 'admin')
{
    header("Location: ../index.php?action=unauthorized");
    die();
}



//If register is not accessed maliciously
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $oldUsername = $_POST["oldusername"];
    $newUsername = $_POST["newusername"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        
        require_once 'dbh.inc.php';
        require_once 'model/update_model.inc.php';
        require_once 'contr/update_contr.inc.php';

        //ERROR HANDLES
        $errors = [];

        if (isInputEmpty($newUsername, $pwd, $email))
        {
            $errors["empty_input"] = "No Data to Update!";
        }

        $result = getUser($pdo, $oldUsername);

        if (empty($result))
        {
            $errors["user_notfound"] = "User does not exist!";
        }

        if (!empty($email) && !isEmailValid($email))
        {
            $errors["invalid_email"] = "Invalid Email used!";
        }
        if (!empty($newUsername) && isUsernameTaken($pdo, $newUsername)) {
            $errors["username_used"] = "Username already taken!";
        }
        if (!empty($email) && !empty($result)) {
            $usertype = getUserType($pdo, $oldUsername);
            if (isEmailRegistered($pdo, $email, $usertype))
            {
                $errors["email_used"] = "Email already registered for Role!";
            }
        }

        if($errors)
        {
            $_SESSION["error_update"] = $errors;

            $updateData = [
                "oldusername" =>  $oldUsername,
                "newusername" =>  $newUsername,
                "email" => $email
            ];
            $_SESSION["update_data"] = $updateData;

            header("Location: ../admin_user_update.php?register=fail");
            die();
        }

        if (!empty($email))
        {
            changeEmail($pdo, $oldUsername, $email);
        }
        if (!empty($pwd))
        {
            changePassword($pdo, $oldUsername, $pwd);
        }
        if (!empty($newUsername))
        {
            changeUsername($pdo, $oldUsername, $newUsername);
        }

        header("Location: ../admin_user_update.php?update=success");
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

}
else
{
    header("Location: ../admin_user_update.php?update=unauthorized");
    die();
}