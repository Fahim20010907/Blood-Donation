<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Get user ID from URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    die("Invalid user ID.");
}

// Fetch user details
$sql = "SELECT USER.Name, MEMBER.gender, MEMBER.age, MEMBER.blood_group 
        FROM USER 
        LEFT JOIN MEMBER ON USER.User_id = MEMBER.member_id 
        WHERE USER.User_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found. Please check the user ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form action="update_user.php" method="post">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['Name']) ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $user['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($user['age']) ?>" required>

            <label for="blood_group">Blood Group:</label>
            <select id="blood_group" name="blood_group" required>
                <option value="A+" <?= $user['blood_group'] == 'A+' ? 'selected' : '' ?>>A+</option>
                <option value="A-" <?= $user['blood_group'] == 'A-' ? 'selected' : '' ?>>A-</option>
                <option value="B+" <?= $user['blood_group'] == 'B+' ? 'selected' : '' ?>>B+</option>
                <option value="B-" <?= $user['blood_group'] == 'B-' ? 'selected' : '' ?>>B-</option>
                <option value="AB+" <?= $user['blood_group'] == 'AB+' ? 'selected' : '' ?>>AB+</option>
                <option value="AB-" <?= $user['blood_group'] == 'AB-' ? 'selected' : '' ?>>AB-</option>
                <option value="O+" <?= $user['blood_group'] == 'O+' ? 'selected' : '' ?>>O+</option>
                <option value="O-" <?= $user['blood_group'] == 'O-' ? 'selected' : '' ?>>O-</option>
            </select>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
