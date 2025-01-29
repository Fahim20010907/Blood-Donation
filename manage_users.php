<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Fetch only members from the database
$sql = "SELECT USER.User_id, USER.Name, MEMBER.gender, MEMBER.age, MEMBER.blood_group 
        FROM USER 
        INNER JOIN MEMBER ON USER.User_id = MEMBER.member_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Members</title>
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
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .edit {
            background-color: #28a745;
        }
        .edit:hover {
            background-color: #218838;
        }
        .delete {
            background-color: #dc3545;
        }
        .delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="navbar">Blood For Life</div>
    <div class="container">
        <h1>Manage Members</h1>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Blood Group</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['User_id'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['blood_group'] ?></td>
                    <td class="actions">
                        <a href="edit_user.php?user_id=<?= $row['User_id'] ?>" class="edit">Edit</a>
                        <a href="delete_user.php?user_id=<?= $row['User_id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
