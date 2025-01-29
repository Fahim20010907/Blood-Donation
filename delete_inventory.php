<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
   // header("Location: admin_login.php");
    //exit();
//}

$blood_group = $_GET['blood_group'];
$bank_id = $_GET['bank_id'];

// Delete record
$sql_delete = "DELETE FROM AVAILABLE_BLOOD WHERE NAME = ? AND BLOOD_BANK_ID = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("si", $blood_group, $bank_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Blood inventory deleted successfully!');
        window.location.href = 'manage_inventory.php';
    </script>";
} else {
    echo "Error: " . $conn->error;
}
?>
