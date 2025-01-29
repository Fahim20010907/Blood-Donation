<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Fetch donation details along with donor names
$sql = "SELECT DONATE.D_ID, DONATE.BLOOD_ID, DONATE.DATE, MEMBER.blood_group, USER.Name AS donor_name
        FROM DONATE
        LEFT JOIN DONOR ON DONATE.D_ID = DONOR.D_ID
        LEFT JOIN MEMBER ON DONOR.D_ID = MEMBER.member_id
        LEFT JOIN USER ON MEMBER.member_id = USER.User_id";

$result = $conn->query($sql);

if (!$result) {
    die("Error fetching donations: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Donations</title>
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
    </style>
</head>
<body>
    <div class="navbar">Blood For Life</div>
    <div class="container">
        <h1>View Donations</h1>
        <table>
            <tr>
                <th>Donor ID</th>
                <th>Donor Name</th>
                <th>Blood ID</th>
                <th>Blood Group</th>
                <th>Donation Date</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['D_ID']) ?></td>
                        <td><?= htmlspecialchars($row['donor_name']) ?></td>
                        <td><?= htmlspecialchars($row['BLOOD_ID']) ?></td>
                        <td><?= htmlspecialchars($row['blood_group']) ?></td>
                        <td><?= htmlspecialchars($row['DATE']) ?></td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No donations found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
