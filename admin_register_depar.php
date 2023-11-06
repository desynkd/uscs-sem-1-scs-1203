<?php 
require_once 'includes/config_session.inc.php';

if (isset($_GET['action']) && $_GET['action'] === "load")
{
    if (isset($_SESSION["create_pharmacy"]))
    {
        try {
            require_once 'includes/dbh.inc.php';
    
            $query = "SELECT depId AS id, name FROM departments WHERE pharmacyId = :pharmacyid;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pharmacyid", $_SESSION["create_pharmacy"]);
            $stmt->execute();
         
            $_SESSION["departments"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        
            header("Location: admin_register_depar.php?load=success");
            $pdo = NULL;
            $stmt = NULL;
            die();
    
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    else
    {
        header("Location: admin_user_register.php?deparload=invalid");
        die();
    }
}
else if (isset($_GET['action']) && $_GET['action'] === "update")
{
    try {
        require_once 'includes/dbh.inc.php';

        $department = $_POST["department"];
        $role = $_POST["role"];

        $query = "INSERT INTO department_staff (depId, staffId, role) VALUES (:depid, :staffid, :role);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":depid", $department);
        $stmt->bindParam(":staffid", $_SESSION["create_staff"]);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
    
        header("Location: admin_user_register.php?signup=success");

        unset($_SESSION["departments"]);
        unset($_SESSION["create_staff"]);
        unset($_SESSION["create_pharmacy"]);
        $pdo = NULL;
        $stmt = NULL;
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else if (!(isset($_GET['load']) && $_GET['load'] === "success"))
{
    header("Location: admin_user_register.php?deparupdate=fail");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Pharmalink</title>
</head>
<body>
<div class='bold-line'></div>
    <div class='container'>
    <div class='window' style='height: 560px;'>
        <div class='overlay' style='height: 560px;'></div>
        <div class='content'>
            <div class='welcome'>Select Department</div>
            <form action="admin_register_depar.php?action=update" method="post">
                <div class='input-fields'>
                    <?php 
                        if (isset($_SESSION["departments"]))
                        {
                            echo '<label for="id_departments" class="input-label full-width" >Departments</label>';
                            echo '<select name="department" id="id_departments" class="input-select full-width" >';
                            foreach ($_SESSION["departments"] as $department) {
                                echo '<option value="' . (string)$department["id"] . '">' . $department["name"] . '</option>';
                            }
                            echo '</select>';
                            //var_dump($_SESSION["departments"]);
                        }
                        else
                        {
                            //redirect to register user
                            echo '<label>';
                            echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
                            echo '<div class="alert error">';
                            echo '<span class="alertClose">X</span>';
                            echo '<span class="alertText">Unable to Load pharmacies';
                            echo '<br class="clear"/></span>';
                            echo '</div>';
                            echo '</label>';
                        }
                    
                    ?>
                    <input type="text" name="role" placeholder="Role in Department" class="input-line full-width"></input>
                </div>
                <div><button class='ghost-round full-width'>Confirm</button></div>
            </form>

            <?php 
                //checkRegisterErrors();
            ?>
        </div>
    </div>
    </div>
</body>
</html>