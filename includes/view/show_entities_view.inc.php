<?php

declare(strict_types=1);

function filterInputs()
{
    echo '<div style="float: left;">';
    echo '<label for="id_entities" class="input-label full-width" >Display Type</label>';
    echo '<select name="entity" id="id_entities" class="input-select full-width" >';
    echo '<option value="admin">Admins</option>';
    echo '<option value="pharmacist">Pharmacists</option>';
    echo '<option value="sales">Sales Associates</option>';
    echo '<option value="tech">Pharmacy Technicians</option>';
    echo '<option value="patient">Patients</option>';
    echo '<option value="supplier">Suppliers</option>';
    echo '</select>';
    echo '<br>';

    if (isset($_SESSION["update_entity"]))
    {
        if ($_SESSION["update_entity"] == 'admin')
        {
            echo '<label class="input-label" >Currently Displaying : Admins</label>';
        }
        else if ($_SESSION["update_entity"] == 'pharmacist')
        {
            echo '<label class="input-label" >Currently Displaying : Pharmacists</label>';
        }
        else if ($_SESSION["update_entity"] == 'sales')
        {
            echo '<label class="input-label" >Currently Displaying : Sales Associates</label>';
        }
        else if ($_SESSION["update_entity"] == 'tech')
        {
            echo '<label class="input-label" >Currently Displaying : Pharmacy Technicians</label>';
        }
        else if ($_SESSION["update_entity"] == 'patient')
        {
            echo '<label class="input-label" >Currently Displaying : Patients</label>';
        }
        else if ($_SESSION["update_entity"] == 'supplier')
        {
            echo '<label class="input-label" >Currently Displaying : Suppliers</label>';
        }
    }
    else
    {
        echo '<label class="input-label" >Currently Displaying : Error</label>';
    }

    echo '</div>';
    echo '<div style="float: right;"><button class="ghost-round">Update</button></div>';

}

function displayRecords()
{
    if(isset($_SESSION["show_results"]))
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
            <div class="display-table-container" style="max-height: 360px">
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
    else
    {
        echo '<label>';
            echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
            echo '<div class="alert error">';
            echo '<span class="alertClose">X</span>';
            echo '<span class="alertText">Unable to load data</br>Update to refresh Data';
            echo '<br class="clear"/></span>';
            echo '</div>';
            echo '</label>';
    }
}