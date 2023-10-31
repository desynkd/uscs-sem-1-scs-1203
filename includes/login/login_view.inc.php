<?php

declare(strict_types=1);

function checkLoginErrors()
{
    //OUTPUT : List of erros if any
    if (isset($_SESSION["errors_login"]))
    {
        $errors = $_SESSION["errors_login"];

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

        unset($_SESSION["errors_login"]);
    }
    else if (isset($_GET['login']) && $_GET['login'] === "success")
    {
        echo '<label>';
        echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
        echo '<div class="alert success">';
        echo '<span class="alertClose">X</span>';
        echo '<span class="alertText">Login Success';
        echo '<br class="clear"/></span>';
        echo '</div>';
        echo '</label>';
    }
}