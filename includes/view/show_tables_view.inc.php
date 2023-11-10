<?php

declare(strict_types=1);

function filterInputs()
{
    echo '<div style="float: left;">';
    echo '<label for="id_tables" class="input-label full-width" >Display Table</label>';
    echo '<select name="table" id="id_tables" class="input-select full-width" >';
    echo '<option value="Pharmacies">Pharmacies</option>';
    echo '<option value="Departments">Departments</option>';
    echo '<option value="Department Staff">Department Staff</option>';
    echo '<option value="CEOs">CEOs</option>';
    echo '<option value="Chief Pharmacists">Chief Pharmacists</option>';
    echo '<option value="Vital Signs">Vital Signs</option>';
    echo '<option value="Diagnoses">Diagnoses</option>';
    echo '<option value="Diagnosis By">Diagnosis By</option>';
    echo '<option value="Products">Products</option>';
    echo '<option value="Categories">Categories</option>';
    echo '<option value="Shelves">Shelves</option>';
    echo '<option value="Medications">Medication</option>';
    echo '<option value="Dispensings">Dispensings</option>';
    echo '<option value="Orders">Order</option>';
    echo '<option value="Delivery Orders">Delivery Orders</option>';
    echo '</select>';
    echo '<br>';

    if (isset($_SESSION["update_table"]))
    {
        echo '<label class="input-label" >Currently Displaying : ' . $_SESSION["update_table"] . '</label>';
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