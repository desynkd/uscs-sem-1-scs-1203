<?php
require_once "includes/config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    try {
        require_once "includes/dbh.inc.php";

        $query = "SELECT s.supId AS 'Supplier ID', CONCAT(s.fName, ' ', s.lName) AS 'Full Name', s.address AS Address, s.contactNo AS 'Contact Number', s.regNo AS 'RA Registration Number' FROM suppliers s RIGHT JOIN sys_accounts a ON s.supId = a.supId WHERE a.id = :userid;";
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
    header("Location: ../sup_dashboard.php?action=unauthorized");
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
        <div class='overlay' style='Height: 560px;'></div>
        <div class='content' style='Height: 560px;'>
        <?php
                echo "<div class='welcome' style='margin-top: 25px;'>Supplier Profile</div>";
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

        <form action="sup_dashboard.php" method="post">
                <div style="padding: 20px 20px 10px;" ><button class='ghost-round full-width'>Return to Dashboard</button></div>
        </form>
    </div>
    </div>
</div>
</body>
</html>