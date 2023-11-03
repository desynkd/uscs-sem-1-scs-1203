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

    echo '<label for="id_empstatus" class="input-label full-width" >User Type</label>';
    echo '<select name="empstatus" id="id_empstatus" class="input-select full-width" >';
    echo '<option value="Full">Full</option>';
    echo '<option value="Part">Part</option>';
    echo '</select>';
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