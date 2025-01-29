<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $blood_group = $_GET['blood_group'];
    $bank_id = $_GET['bank_id'];

    // Fetch current record
    $sql = "SELECT QUANTITY FROM AVAILABLE_BLOOD WHERE NAME = ? AND BLOOD_BANK_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $blood_group, $bank_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = $_POST['blood_group'];
    $bank_id = $_POST['bank_id'];
    $quantity = $_POST['quantity'];

    // Update quantity
    $sql_update = "UPDATE AVAILABLE_BLOOD SET QUANTITY = ? WHERE NAME = ? AND BLOOD_BANK_ID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("isi", $quantity, $blood_group, $bank_id);

    if ($stmt_update->execute()) {
        echo "<script>
            alert('Blood inventory updated successfully!');
            window.location.href = 'manage_inventory.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Inventory</title>
</head>
<body>
    <h1>Edit Inventory</h1>
    <form action="" method="post">
        <input type="hidden" name="blood_group" value="<?= $blood_group ?>">
        <input type="hidden" name="bank_id" value="<?= $bank_id ?>">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?= $row['QUANTITY'] ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
