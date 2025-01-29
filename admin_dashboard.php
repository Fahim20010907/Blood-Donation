<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
//    header("Location: admin_login.php");
//    exit();
//}

// Fetch dynamic data
$total_users_query = "SELECT COUNT(*) AS total_users FROM USER";
$total_donations_query = "SELECT COUNT(*) AS total_donations FROM DONATE";
$total_requests_query = "SELECT COUNT(*) AS total_requests FROM RECEIVE";
$total_blood_query = "SELECT SUM(QUANTITY) AS total_blood FROM AVAILABLE_BLOOD";

$total_users = $conn->query($total_users_query)->fetch_assoc()['total_users'];
$total_donations = $conn->query($total_donations_query)->fetch_assoc()['total_donations'];
$total_requests = $conn->query($total_requests_query)->fetch_assoc()['total_requests'];
$total_blood = $conn->query($total_blood_query)->fetch_assoc()['total_blood'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stats {
            margin-bottom: 20px;
        }
        .stats h2 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }
        .button {
            width: 100%;
            margin: 10px 0;
            text-align: center;
        }
        .button a {
            display: inline-block;
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        .button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">Admin Dashboard</div>
    <div class="container">
        <div class="stats">
            <h2>Total Users: <?= $total_users ?></h2>
            <h2>Total Donations: <?= $total_donations ?></h2>
            <h2>Total Requests: <?= $total_requests ?></h2>
            <h2>Available Blood: <?= $total_blood ?> units</h2>
        </div>
        <div class="button">
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_inventory.php">Manage Blood Inventory</a>
            <a href="add_inventory.php">Add Blood Inventory</a>
            <a href="view_donations.php">View Donations</a>
            <a href="view_blood_requests.php">View Blood Requests</a>
            <a href="generate_reports.php">Generate Reports</a>
            <a href="search_records.php">Search Records</a>
            <a href="logout.php?role=admin" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
