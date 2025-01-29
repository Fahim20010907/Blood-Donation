<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
   // header("Location: admin_login.php");
    //exit();
//}

$search_results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = $_POST['blood_group'];

    // Search for records with the selected blood group
    $sql = "SELECT USER.User_id, USER.Name, MEMBER.gender, MEMBER.age, MEMBER.blood_group
            FROM USER 
            INNER JOIN MEMBER ON USER.User_id = MEMBER.member_id
            WHERE MEMBER.blood_group = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $blood_group);
    $stmt->execute();
    $search_results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        select, button {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Records by Blood Group</h1>
        <form action="" method="post">
            <label for="blood_group">Select Blood Group:</label>
            <select name="blood_group" id="blood_group" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($search_results)) { ?>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                </tr>
                <?php while ($row = $search_results->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['User_id'] ?></td>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['gender'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= $row['blood_group'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <p style="text-align: center; color: red;">No records found for the selected blood group.</p>
        <?php } ?>
    </div>
</body>
</html>
