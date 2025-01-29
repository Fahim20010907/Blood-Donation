<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Retrieve updated data from the form
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$blood_group = $_POST['blood_group'];

// Update USER table
$sql_user = "UPDATE USER SET Name = ? WHERE User_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("si", $name, $user_id);

// Update MEMBER table
$sql_member = "UPDATE MEMBER SET gender = ?, age = ?, blood_group = ? WHERE member_id = ?";
$stmt_member = $conn->prepare($sql_member);
$stmt_member->bind_param("sisi", $gender, $age, $blood_group, $user_id);

if ($stmt_user->execute() && $stmt_member->execute()) {
    echo "<script>
        alert('Member information updated successfully!');
        window.location.href = 'manage_users.php';
    </script>";
} else {
    echo "Error updating member information: " . $conn->error;
}

$conn->close();
?>
