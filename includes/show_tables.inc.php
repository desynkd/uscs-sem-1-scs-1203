<?php

require_once 'config_session.inc.php';

if (!($_SESSION["user_type"] == 'admin'))
{
    header("Location: ../index.php?action=unauthorized");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST["table"]))
    {
        $table = $_POST["table"];
        $_SESSION["update_table"] = $table;
    }
    else
    {
        $table = NULL;
    }
    


    try {
        require_once 'dbh.inc.php';
        require_once 'model/show_tables_model.inc.php';
        require_once 'contr/show_tables_contr.inc.php';

        $_SESSION["show_results"] = createRecords($pdo, $table);
        
        $pdo = null;
        $stmt = null;

        // if (isset($_GET['action']) && $_GET['action'] === "load")
        // {
        //     header("Location: admin_show_entities.php");
        // }
        header("Location: ../admin_show_tables.php");
        die();
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
