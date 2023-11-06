<?php
require_once "includes/config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    try {
        require_once "includes/dbh.inc.php";

        $query = "SELECT p.patientId AS 'Patient ID', CONCAT(p.fName, ' ', p.lName) AS 'Full Name', p.address AS Address, p.contactNo AS 'Contact Number', p.dob AS 'Date of Birth' FROM patients p INNER JOIN sys_accounts a ON p.patientId = a.patientId WHERE a.id = :userid;";
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
    <div class='window'>
        <div class='overlay' style='Height: 620px;'></div>
        <div class='content' style='Height: 620px;'>
        <?php
                echo "<div class='welcome' style='margin-top: 25px;'>Patient Profile</div>";
                echo "<div class='subtitle'>User - " . $_SESSION["user_username"] . "</div>";
        ?>

        <div class="display-table-container" style="max-height: 700px;">
            <table class="display-table">
                <tbody class="display-tbody">
                    <?php foreach ($results as $row): ?>
                        <?php foreach ($row as $column => $value): ?>
                            <tr class="display-tr">
                                <td class="display-td"><?php echo htmlentities($column); ?></td>
                                <td class="display-td"><?php echo htmlentities($value); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <form action="patient_dashboard.php" method="post">
                <div style="padding: 20px 20px 10px;" ><button class='ghost-round full-width'>Return to Dashboard</button></div>
        </form>
    </div>
    </div>
</div>
</body>
</html>