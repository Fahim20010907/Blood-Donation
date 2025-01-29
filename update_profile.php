<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch the current admin details
$admin_id = $_SESSION['admin_id']; // Store admin ID in session during login
$sql = "SELECT USER.Name, ADMIN.Email FROM USER INNER JOIN ADMIN ON USER.User_id = ADMIN.Admin_id WHERE USER.User_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update the admin details
    $sql_update_user = "UPDATE USER SET Name = ?, Password = ? WHERE User_id = ?";
    $stmt_user = $conn->prepare($sql_update_user);
    $stmt_user->bind_param("ssi", $name, $password, $admin_id);

    $sql_update_admin = "UPDATE ADMIN SET Email = ? WHERE Admin_id = ?";
    $stmt_admin = $conn->prepare($sql_update_admin);
    $stmt_admin->bind_param("si", $email, $admin_id);

    if ($stmt_user->execute() && $stmt_admin->execute()) {
        echo "<script>
            alert('Profile updated successfully!');
            window.location.href = 'admin_dashboard.php';
        </script>";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input, button {
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
        <h1>Update Profile</h1>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $admin['Name'] ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $admin['Email'] ?>" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter new password" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
