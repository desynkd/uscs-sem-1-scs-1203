<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/view/register_sup_view.inc.php';
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
    <div class='window' style='height: 700px;'>
        <div class='overlay' style='height: 700px;'></div>
        <div class='content'>
            <div class='welcome'>Register New Supplier</div>
            <form action="includes/register_sup.inc.php" method="post">
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