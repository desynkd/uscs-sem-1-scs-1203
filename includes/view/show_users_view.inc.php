<?php

declare(strict_types=1);

function filterInputs(int $isLoad)
{
    echo '<div style="float: left;">';
    echo '<input type="radio" id="id_radioActive" name="showActive" value="Active" class="input-line"></input>';
    echo '<label for="id_radioActive" class="input-label" >Active Users</label>';

    echo '<input type="radio" id="id_radioInactive" name="showInactive" value="Inactive" class="input-line"></input>';
    echo '<label for="id_radioInactive" class="input-label" >Inactive Users</label>';
    echo '<br>';

    if ($isLoad == 1)
    {
        if (isset($_SESSION["update_data"]["isActive"]) && isset($_SESSION["update_data"]["isInactive"]))
        {
            echo '<label class="input-label" >Currently Displaying : Active & Inactive Users</label>';
        }
        else if (isset($_SESSION["update_data"]["isInactive"]))
        {
            echo '<label class="input-label" >Currently Displaying : Inactive Users</label>';
        }
        else
        {
            echo '<label class="input-label" >Currently Displaying : Active Users</label>';
        }
    }
    else
    {
        echo '<label class="input-label" >Currently Displaying : Active Users</label>';
    }

    echo '</div>';
    echo '<div style="float: right;"><button class="ghost-round">Update</button></div>';

}

function displayRecords()
{
    $results = $_SESSION["show_results"];
    unset($_SESSION["show_results"]);

    if (empty($results))
    {
        echo '<label>';
        echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
        echo '<div class="alert error">';
        echo '<span class="alertClose">X</span>';
        echo '<span class="alertText"> No Results!';
        echo '<br class="clear"/></span>';
        echo '</div>';
        echo '</label>';
    }
    else
    {             
        ?>
        <div class="display-table-container">
        <table class="display-table">
        <thead class="display-thead">
            <tr class="display-tr">
            <th class="display-th"><?php echo implode('</th><th class="display-th">', array_keys(current($results))); ?></th>
            </tr>
        </thead>
        <tbody class="display-tbody">
        <?php foreach ($results as $row): array_map('htmlentities', $row); ?>
            <tr class="display-tr">
            <td class="display-td"><?php echo implode('</td><td class="display-td">', $row); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        </div>
    <?php
    }
}