<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //$username = $_SESSION["user_username"];
    
    try {
        require_once "includes/dbh.inc.php";

        $query = "SELECT id, usertype, username, email, createdAt FROM sys_users";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        $stmt = null;

        //die();
    }
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
else
{
    header("Location: admin_dashboard.php?action=unauthorized");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Pharmalink</title>
</head>
<body>


<div class='bold-line'></div>
    <div class='container'>
    <div class='window-large'>
        <div class='overlay-large'></div>
        <div class='content'>
            <div class='welcome'>Displaying all users in system</div>
            
            <?php 
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
            { ?>
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
            <?php }
            ?>


        </div>
    </div>
    </div>
</body>
</html>