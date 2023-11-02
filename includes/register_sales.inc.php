<?php

require_once 'config_session.inc.php';

//If register is not accessed maliciously
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $contactno = $_POST["contactno"];
    $empstatus = $_POST["empstatus"];

    $username = $_SESSION["create_username"];
    $pwd = $_SESSION["create_pwd"];
    $email = $_SESSION["create_email"];
    $usertype = "sales";


    try {
        
        require_once 'dbh.inc.php';
        require_once 'model/register_sales_model.inc.php';
        require_once 'model/register_model.inc.php';
        require_once 'contr/register_contr.inc.php';
        require_once 'contr/register_sales_contr.inc.php';

        //ERROR HANDLES
        $errors = [];

        if (isSalesInputEmpty($firstname, $address, $contactno))
        {
            $errors["empty_input"] = "Fill in all neccesary Fields!";
        }
        if (!isContactNoValid($contactno))
        {
            $errors["contactno_invalid"] = "Invalid Contact Number used!";
        }


        if($errors)
        {
            $_SESSION["error_register"] = $errors;

            $registerData = [
                "firstname" =>  $firstname,
                "lastname" => $lastname,
                "address" => $address,
                "contactno" => $contactno,
            ];
            $_SESSION["register_data"] = $registerData;

            header("Location: ../admin_register_patient.php?register=fail");
            die();
        }

        createUser($pdo, $username, $pwd, $email, $usertype);
        $staffid = createSalesAssoc($pdo, $firstname, $lastname, $address, $contactno, $empstatus);
        createSalesAccount($pdo, $username, $staffid);

        header("Location: ../admin_user_register.php?signup=success");

        
        unset($_SESSION["create_username"]);
        unset($_SESSION["create_pwd"]);
        unset($_SESSION["create_email"]);
        $pdo = null;
        $stmt = null;
        

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

}
else
{
    header("Location: ../admin_user_register.php?register=unauthorized");
    die();
}