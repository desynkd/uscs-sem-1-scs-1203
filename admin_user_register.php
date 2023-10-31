<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/view/register_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>
<body>
<div class='bold-line'></div>
    <div class='container'>
    <div class='window-long'>
        <div class='overlay-long'></div>
        <div class='content'>
            <div class='welcome'>Register New User</div>
            <form action="includes/register.inc.php" method="post">
                <div class='input-fields'>
                    <?php 
                        registerInput();
                    ?>
                </div>
                <div><button class='ghost-round full-width'>Register</button></div>
            </form>
            
            <?php 
                checkRegisterErrors();
            ?>
        </div>
    </div>
    </div>
</body>
</html>