<?php

require_once 'config_session.inc.php';

if (!$_SESSION["user_type"] == 'admin')
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
                header("Location: ../admin_show_users.php?update=success&filter=positive");
            }
            else if (!empty($showActive) && !empty($showInactive))
            {
                header("Location: ../admin_show_users.php?update=success&filter=negative");
            }
            else
            {
                header("Location: ../admin_show_users.php?update=success&filter=default");
            }
            
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
