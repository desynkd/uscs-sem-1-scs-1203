<?php

declare(strict_types=1);

function updateInput()
{
    if (isset($_SESSION["update_data"]["oldusername"])) {
        echo '<input type="text" name="oldusername" placeholder="Username" value="' . $_SESSION["update_data"]["oldusername"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="text" name="oldusername" placeholder="Username" class="input-line full-width"></input>';
    }
    
    if (isset($_SESSION["update_data"]["newusername"]) && !isset($_SESSION["errors_update"]["username_taken"])) {
        echo '<input type="text" name="newusername" placeholder="New Username" value="' . $_SESSION["update_data"]["newusername"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="text" name="newusername" placeholder="New Username" class="input-line full-width"></input>';
    }

    if (isset($_SESSION["update_data"]["email"]) && !isset($_SESSION["errors_update"]["email_used"]) && !isset($_SESSION["errors_update"]["invalid_email"])) {
        echo '<input type="email" name="email" placeholder="New Email" value="' . $_SESSION["update_data"]["email"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="email" name="email" placeholder="New Email" class="input-line full-width"></input>';
    }

    echo '<input type="password" name="pwd" placeholder="New Password" class="input-line full-width"></input>';
}

function checkUpdateErrors()
{
    if (isset($_SESSION['error_update'])) {
        $errors = $_SESSION['error_update'];

        echo "<br>";

        foreach($errors as $error)
        {
            echo '<label>';
            echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
            echo '<div class="alert error">';
            echo '<span class="alertClose">X</span>';
            echo '<span class="alertText">' . $error;
            echo '<br class="clear"/></span>';
            echo '</div>';
            echo '</label>';
        }

        unset($_SESSION['error_update']);
    } else if (isset($_GET["update"]) && $_GET["update"] === "success" ) {
        echo '<label>';
        echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
        echo '<div class="alert success">';
        echo '<span class="alertClose">X</span>';
        echo '<span class="alertText">Update Success';
        echo '<br class="clear"/></span>';
        echo '</div>';
        echo '</label>';
    }
}