<?php
    require_once 'includes/config_session.inc.php';
    require_once 'includes/view/show_entities_view.inc.php';
    if (isset($_GET['action']) && $_GET['action'] === "load")
    {
        include 'includes/show_entities.inc.php?action=load';
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
            <div class="welcome"> Display Entities</div>            

            <form action="includes/show_entities.inc.php?update=true" method="post">
                <div class='input-fields'>
                    <?php
                        filterInputs();
                    ?>
                </div>
            </form>

            <div><?php displayRecords(); ?></div>

            <form action="admin_dashboard.php" method="post" style="position: absolute; bottom: 0;">
                <div style="padding: 5px 20px 20px;" ><button class='ghost-round full-width'>Return to Dashboard</button></div>
            </form>
        </div>
    </div>
    </div>
</body>
</html>