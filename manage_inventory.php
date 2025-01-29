<?php
include 'connect.php';
session_start();

// Check if admin is logged in
//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Fetch inventory details
$sql = "SELECT AVAILABLE_BLOOD.NAME AS BLOOD_GROUP, AVAILABLE_BLOOD.QUANTITY, 
        BLOOD_BANK.BB_ID AS BLOOD_BANK_ID, BLOOD_BANK.Name AS BANK_NAME
        FROM AVAILABLE_BLOOD
        INNER JOIN BLOOD_BANK ON AVAILABLE_BLOOD.BLOOD_BANK_ID = BLOOD_BANK.BB_ID";

$result = $conn->query($sql);

if (!$result) {
    die("Error fetching blood inventory: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blood Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .delete {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">Blood For Life</div>
    <div class="container">
        <h1>Manage Blood Inventory</h1>
        <table>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Blood Bank</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['BLOOD_GROUP']) ?></td>
                        <td><?= htmlspecialchars($row['QUANTITY']) ?></td>
                        <td><?= htmlspecialchars($row['BANK_NAME']) ?></td>
                        <td>
                            <a href="delete_inventory.php?blood_group=<?= urlencode($row['BLOOD_GROUP']) ?>&bank_id=<?= urlencode($row['BLOOD_BANK_ID']) ?>" class="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No inventory records found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
