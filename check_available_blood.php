<?php
session_start();
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit;
}

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Available Blood in Blood Banks</title>
    <link rel='stylesheet' href='styles.css'>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }
        table, th, td {
            border: none;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 8px;
        }
        a:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Available Blood in Blood Banks</h1>
        <table>
            <thead>
                <tr>
                    <th>Blood Bank Name</th>
                    <th>Blood Group</th>
                    <th>Quantity (Units)</th>
                </tr>
            </thead>
            <tbody>";

// SQL query to fetch available blood with blood bank details
$sql = "
SELECT bb.Name AS blood_bank_name, ab.NAME AS blood_group, ab.QUANTITY
FROM blood_bank bb
JOIN available_blood ab ON bb.BB_ID = ab.BLOOD_BANK_ID;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data from each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['blood_bank_name']) . "</td>
                <td>" . htmlspecialchars($row['blood_group']) . "</td>
                <td>" . htmlspecialchars($row['QUANTITY']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No blood available.</td></tr>";
}

echo "      </tbody>
        </table>
        <div style='text-align: center;'>
            <a href='member_dashboard.php'>Back to Dashboard</a>
        </div>
    </div>
</body>
</html>";

// Close the database connection
$conn->close();
?>
