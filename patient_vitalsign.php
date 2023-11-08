<?php
require_once "includes/config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    try {
        require_once "includes/dbh.inc.php";

        $query = "SELECT v.vitalId AS 'Vital Sign ID', v.vitalDateTime AS 'Taken Date and Time', v.temperature AS 'Temperature (Celsius)', v.pulse AS 'Pusle (bpm)', v.bloodPressure AS 'Blood Pressure (mmHg)' FROM vital_signs v LEFT JOIN sys_accounts a ON v.patientId = a.patientId WHERE a.id = :userid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userid", $_SESSION["user_id"]);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        $stmt = null;
    }
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
else
{
    header("Location: ../patient_dashboard.php?action=unauthorized");
}

function checkViewErrors()
{
    if (empty($results))
    {
        echo '<label>';
        echo '<input type="checkbox" class="alertCheckbox" autocomplete="off" />';
        echo '<div class="alert error">';
        echo '<span class="alertClose">X</span>';
        echo '<span class="alertText">Empty Records';
        echo '<br class="clear"/></span>';
        echo '</div>';
        echo '</label>';
    }
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
        <?php
                echo "<div class='welcome' style='margin-top: 25px;'>Vital Sign Records</div>";
                echo "<div class='subtitle'>User - " . $_SESSION["user_username"] . "</div>";

        if (!empty($results)){?>
        <div class="display-table-container" style="max-height: 450px;">
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
        <?php }else{
            checkViewErrors(); }?>

        <form action="patient_dashboard.php" method="post" style="position: absolute; bottom: 0;">
                <div style="padding: 20px 20px 10px;" >
                <button class='ghost-round full-width'>Return to Dashboard</button>
                </div>
        </form>
    </div>
    </div>
</div>
</body>
</html>