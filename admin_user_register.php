<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/register/register_view.inc.php';
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
            <form action="includes/register/register.inc.php" method="post">
                <div class='input-fields'>
                    <!-- <input type='text' name="username" placeholder='Username' class='input-line full-width'></input>
                    <input type='email' name="email" placeholder='Email' class='input-line full-width'></input>
                    <input type='password' name="pwd" placeholder='Password' class='input-line full-width'></input>
                    
                    <!--dropdown for usertypes -->
                    <!-- <label for="id_usertype" class="input-label full-width" >User Type</label>
                    <select name="usertype" id="id_usertype" class="input-select full-width" >
                        <option value="admin">Admin</option>
                        <option value="patient">Patient</option>
                        <option value="supplier">Supplier</option>
                        <option value="pharmacist">Pharmacist</option>
                        <option value="sales">Sales</option>
                    </select>  -->
                    
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