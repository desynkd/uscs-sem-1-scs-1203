<?php

require_once 'config_session.inc.php';

if (!($_SESSION["user_type"] == 'admin'))
{
    header("Location: ../index.php?action=unauthorized");
    die();
}

if (isset($_GET['update']) && $_GET['update'] === "true")
{
    $doUpdate = 1;
}
else
{
    $doUpdate = 0;
}

if (isset($_GET['action']) && $_GET['action'] === "deactivate")
{
    $doDeactivate = 1;
    $doActivate = 0;
}
else if (isset($_GET['action']) && $_GET['action'] === "activate")
{
    $doDeactivate = 0;
    $doActivate = 1;
}
else
{
    $doDeactivate = 0;
    $doActivate = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST["showActive"]) || isset($_POST["showInactive"]))
    {
        $showActive =$_POST["showActive"];
        $showInactive =$_POST["showInactive"];
        $updateData = [
            "isActive" =>  $showActive,
            "isInactive" => $showInactive
        ];
        $_SESSION["update_data"] = $updateData;
    }
    else
    {
        $showActive =null;
        $showInactive =null;
    }

    
    try {
        require_once "dbh.inc.php";
        require_once 'model/show_users_model.inc.php';
        require_once 'contr/show_users_contr.inc.php';

        //ERROR HANDLES FOR DEACTIVATE USER
        if ($doDeactivate == 1 || $doActivate == 1)
        {
            $userid = $_POST["userid"];
            $errors = [];

            if (isUserIdEmpty($userid))
            {
                $errors["empty_userid"] = "Fill UserId!";
            }

            $isUserValid = isUserIdValid($pdo, $userid);
            if (!$isUserValid) {
                $errors["user_invalid"] = "UserId Invalid!";
            }
            if ($isUserValid)
            {
                $isUserActive = isUserIdActive($pdo, $userid);
                if ($doDeactivate == 1 && !$isUserActive)
                {
                    $errors["user_inactive"] = "User already Inactive";
                }
                else if ($doActivate == 1 && $isUserActive)
                {
                    $errors["user_active"] = "User already Active";
                }
            }
    
            if($errors)
            {
                $_SESSION["error_showusers"] = $errors;
                $locationAddDeactivate = NULL;
                $locationAddActivate = NULL;
            }
            else
            {
                if ($doDeactivate == 1)
                {
                    userstatusChange($pdo, $userid, 0);
                    $locationAddDeactivate = "&deactivation=success";
                    $locationAddActivate = NULL;
                }
                else if ($doActivate == 1)
                {
                    userstatusChange($pdo, $userid, 1);
                    $locationAddActivate = "&activation=success";
                    $locationAddDeactivate = NULL;
                }
            }
        }

        if (empty($showActive) && !empty($showInactive))
        {
            $_SESSION["show_results"] = createRecords($pdo, 0);
        }
        else if (!empty($showActive) && !empty($showInactive))
        {
            $_SESSION["show_results"] = createRecords($pdo, -1);
        }
        else
        {
            $_SESSION["show_results"] = createRecords($pdo, 1);
        }
        
        $pdo = null;
        $stmt = null;

        if ($doUpdate == 1)
        {
            if (empty($showActive) && !empty($showInactive))
            {
                //header("Location: ../admin_show_users.php?update=success&filter=positive");
                $locationAddUpdate = "update=success&filter=positive";
            }
            else if (!empty($showActive) && !empty($showInactive))
            {
                //header("Location: ../admin_show_users.php?update=success&filter=negative");
                $locationAddUpdate = "update=success&filter=negative";
            }
            else
            {
                //header("Location: ../admin_show_users.php?update=success&filter=default");
                $locationAddUpdate = "update=success&filter=default";
            }
            
            header("Location: ../admin_show_users.php?". $locationAddUpdate . $locationAddDeactivate . $locationAddActivate);
            //unset($_SESSION["do_update"]);
            die();
        }

    }
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
else
{
    header("Location: ../admin_dashboard.php?action=unauthorized");
}
