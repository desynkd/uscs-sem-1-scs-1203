<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/view/register_pharm_view.inc.php';

if (isset($_GET['action']) && $_GET['action'] === "load")
{
    //include 'includes/register_pharm.inc.php?action=load';
    try {
        require_once 'includes/dbh.inc.php';
        require_once 'includes/model/register_pharm_model.inc.php';
        require_once 'includes/contr/register_pharm_contr.inc.php';

        $pharmacies = avalPharmacies($pdo);
        $_SESSION["pharmacies"] = $pharmacies;
    
        header("Location: admin_register_pharm.php?load=success");
        $pdo = NULL;
        $stmt = NULL;
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
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
    <div class='container' style="margin-top: 150px;">
    <div class='window' style='height: 1000px;'>
        <div class='overlay' style='height: 1000px;'></div>
        <div class='content'>
            <div class='welcome'>Register New Pharmacist</div>
            <form action="includes/register_pharm.inc.php" method="post">
                <div class='input-fields'>
                    <?php 
                        registerInput();
                    ?>
                </div>
                <div><button class='ghost-round full-width'>Register</button></div>
            </form>
            <form action="admin_dashboard.php" method="post">
                <div style="padding: 5px 20px 20px;" ><button class='ghost-round full-width'>Return to Dashboard</button></div>
            </form>

            <?php 
                checkRegisterErrors();
            ?>
        </div>
    </div>
    </div>
</body>
</html>