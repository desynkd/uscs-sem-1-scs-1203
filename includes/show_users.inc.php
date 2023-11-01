<?php

require_once 'config_session.inc.php';

if (!$_SESSION["user_type"] == 'admin')
{
    header("Location: ../index.php?action=unauthorized");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //$username = $_SESSION["user_username"];
    
    try {
        require_once "dbh.inc.php";
        require_once 'model/show_users_model.inc.php';
        require_once 'contr/show_users_contr.inc.php';

        $_SESSION["show_results"] = createRecords($pdo);

        $pdo = null;
        $stmt = null;

        //header("Location: ../admin_show_users.php?action=success");
        //die();
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
