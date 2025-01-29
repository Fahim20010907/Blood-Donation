<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Generate reports
$donation_summary = "SELECT blood_group, COUNT(*) AS total_donations FROM DONATE
                     LEFT JOIN MEMBER ON DONATE.D_ID = MEMBER.member_id
                     GROUP BY blood_group";

$request_summary = "SELECT blood_group, COUNT(*) AS total_requests FROM RECEIVE
                    LEFT JOIN MEMBER ON RECEIVE.P_ID = MEMBER.member_id
                    GROUP BY blood_group";

$inventory_summary = "SELECT NAME, SUM(QUANTITY) AS total_stock FROM AVAILABLE_BLOOD GROUP BY NAME";

$donations = $conn->query($donation_summary);
$requests = $conn->query($request_summary);
$inventory = $conn->query($inventory_summary);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #007BFF;
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="navbar">Blood For Life</div>
    <div class="container">
        <h1>Reports</h1>

        <div class="section">
            <h2>Donation Summary</h2>
            <table>
                <tr>
                    <th>Blood Group</th>
                    <th>Total Donations</th>
                </tr>
                <?php while ($row = $donations->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['blood_group'] ?></td>
                        <td><?= $row['total_donations'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="section">
            <h2>Request Summary</h2>
            <table>
                <tr>
                    <th>Blood Group</th>
                    <th>Total Requests</th>
                </tr>
                <?php while ($row = $requests->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['blood_group'] ?></td>
                        <td><?= $row['total_requests'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="section">
            <h2>Inventory Summary</h2>
            <table>
                <tr>
                    <th>Blood Group</th>
                    <th>Total Stock</th>
                </tr>
                <?php while ($row = $inventory->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['NAME'] ?></td>
                        <td><?= $row['total_stock'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
