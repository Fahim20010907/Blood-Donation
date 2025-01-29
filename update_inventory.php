<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Retrieve updated data from the form
$blood_id = $_POST['blood_id'];
$quantity = $_POST['quantity'];

// Update BLOOD table
$sql_update_blood = "UPDATE BLOOD SET QUANTITY = ? WHERE BLOOD_ID = ?";
$stmt = $conn->prepare($sql_update_blood);
$stmt->bind_param("ii", $quantity, $blood_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Blood inventory updated successfully!');
        window.location.href = 'manage_inventory.php';
    </script>";
} else {
    echo "Error updating blood inventory: " . $conn->error;
}

$conn->close();
?>
