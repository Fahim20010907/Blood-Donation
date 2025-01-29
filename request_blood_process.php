<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieving form data
$blood_group = $_POST['blood_group'];
$quantity = $_POST['quantity'];
$reason = $_POST['reason'];
$patient_id = $_SESSION['user_id']; // Ensuring the logged-in user ID is used

// Step 1: Fetch BLOOD_ID based on blood group
$stmt = $conn->prepare("SELECT BLOOD_ID FROM blood WHERE blood_group = ?");
$stmt->bind_param("s", $blood_group);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $blood_data = $result->fetch_assoc();
    $blood_id = $blood_data['BLOOD_ID'];

    // Step 2: Insert the request into the `receive` table
    $insert_stmt = $conn->prepare("INSERT INTO receive (P_ID, BLOOD_ID, DATE, REASON, QUANTITY) VALUES (?, ?, CURDATE(), ?, ?)");
    $insert_stmt->bind_param("iisi", $patient_id, $blood_id, $reason, $quantity);

    if ($insert_stmt->execute()) {
        echo "<script>alert('Blood Request submitted successfully!'); window.location.href = 'view_history.php';</script>";
    } else {
        echo "<script>alert('Error submitting the blood request. Please try again.'); window.location.href = 'request_blood.php';</script>";
    }

    $insert_stmt->close();
} else {
    echo "<script>alert('Invalid blood group selected. Please try again.'); window.location.href = 'request_blood.php';</script>";
}

$stmt->close();
$conn->close();
?>
