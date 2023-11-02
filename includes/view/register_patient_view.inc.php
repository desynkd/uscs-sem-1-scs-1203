<?php

declare(strict_types=1);

function registerInput()
{
    /*
    hireDate DATE,
    terminationDate DATE,*/
    if (isset($_SESSION["register_data"]["firstname"])) {
        echo '<input type="text" name="firstname" placeholder="First Name" value="' . $_SESSION["register_data"]["firstname"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="text" name="firstname" placeholder="First Name" class="input-line full-width"></input>';
    }

    if (isset($_SESSION["register_data"]["lastname"])) {
        echo '<input type="text" name="lastname" placeholder="Last Name" value="' . $_SESSION["register_data"]["lastname"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="text" name="lastname" placeholder="Last Name" class="input-line full-width"></input>';
    }

    if (isset($_SESSION["register_data"]["address"])) {
        echo '<input type="text" name="address" placeholder="Address" value="' . $_SESSION["register_data"]["address"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="text" name="address" placeholder="Address" class="input-line full-width"></input>';
    }

    if (isset($_SESSION["register_data"]["contactno"]) && !isset($_SESSION["errors_register"]["contactno_invalid"])) {
        echo '<input type="text" name="contactno" placeholder="Contact Number" value="' . $_SESSION["register_data"]["contactno"]  .'" class="input-line full-width"></input>';
    }
    else{
        echo '<input type="text" name="contactno" placeholder="Contact Number" class="input-line full-width"></input>';
    }

    echo '<label for="id_dob" class="input-label full-width" >Date of Birth</label>';
    echo '<input type="date" id="id_dob" name="dob" class="input-line full-width"></input>';
}


function checkRegisterErrors()
{
    if (isset($_SESSION['error_register'])) {
        $errors = $_SESSION['error_register'];

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

        unset($_SESSION['error_register']);
    }
}