<?php 
require_once 'includes/config_session.inc.php';
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
    <div class='window'>
        <div class='overlay'></div>
        <div class='content'>
            <?php
            if (isset($_SESSION["user_id"])) {
                echo "<div class='welcome'>You are logged in as " . $_SESSION["user_type"] . "</div>";
            }
            ?>
            <form action="includes/login/logout.inc.php" method="post">
                <div style="padding: 20px;" ><button class='ghost-round full-width'>Logout</button></div>
            </form>
        </div>
    </div>
    </div>
</body>
</html>