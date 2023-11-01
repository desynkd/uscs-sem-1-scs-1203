<?php

declare(strict_types=1);

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