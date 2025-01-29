<?php
session_start(); 
include 'connect.php'; 

$member_id = $_SESSION['user_id']; 

// Fetch donation history
$donation_query = $conn->prepare("SELECT DATE, QUANTITY FROM donate WHERE D_ID = ?");
$donation_query->bind_param("i", $member_id);
$donation_query->execute();
$donation_result = $donation_query->get_result();

// Fetch blood request history
$request_query = $conn->prepare("SELECT DATE, BLOOD_ID, REASON, QUANTITY FROM receive WHERE P_ID = ?");
$request_query->bind_param("i", $member_id);
$request_query->execute();
$request_result = $request_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation and Request History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 80%;
            text-align: center;
        }
        h1 {
            color: #d9534f;
            font-size: 28px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Donation and Request History</h1>

        <!-- Donation History -->
        <h2>Donation History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($donation_result->num_rows > 0) {
                    while ($row = $donation_result->fetch_assoc()) {
                        echo "<tr><td>{$row['DATE']}</td><td>{$row['QUANTITY']}</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No donation history found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Blood Request History -->
        <h2>Blood Request History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Blood Group</th>
                    <th>Reason</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($request_result->num_rows > 0) {
                    while ($row = $request_result->fetch_assoc()) {
                        // Fetch blood group based on BLOOD_ID
                        $blood_id = $row['BLOOD_ID'];
                        $blood_group_query = $conn->prepare("SELECT blood_group FROM blood WHERE BLOOD_ID = ?");
                        $blood_group_query->bind_param("i", $blood_id);
                        $blood_group_query->execute();
                        $blood_group_result = $blood_group_query->get_result();
                        $blood_group = $blood_group_result->fetch_assoc()['blood_group'];

                        echo "<tr><td>{$row['DATE']}</td><td>{$blood_group}</td><td>{$row['REASON']}</td><td>{$row['QUANTITY']}</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No blood request history found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Back Button -->
        <a href="member_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
