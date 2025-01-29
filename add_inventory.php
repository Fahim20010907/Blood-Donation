<?php
include 'connect.php';
session_start();

//if (!isset($_SESSION['admin_logged_in'])) {
  //  header("Location: admin_login.php");
    //exit();
//}

// Initialize variables
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = $_POST['blood_group'];
    $quantity = intval($_POST['quantity']);
    $action = $_POST['action'];
    $bank_id = $_POST['bank_id'];

    if ($action == "add") {
        // Try to update the existing record
        $sql = "UPDATE AVAILABLE_BLOOD SET QUANTITY = QUANTITY + ? WHERE NAME = ? AND BLOOD_BANK_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $quantity, $blood_group, $bank_id);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            $message = "Inventory added successfully!";
        } else {
            // Insert a new record if the update failed
            $sql_insert = "INSERT INTO AVAILABLE_BLOOD (NAME, QUANTITY, BLOOD_BANK_ID) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sii", $blood_group, $quantity, $bank_id);

            if ($stmt_insert->execute()) {
                $message = "Inventory added successfully!";
            } else {
                $message = "Failed to add inventory!";
            }
        }
    } else {
        // Reduce inventory
        $sql = "UPDATE AVAILABLE_BLOOD SET QUANTITY = QUANTITY - ? WHERE NAME = ? AND BLOOD_BANK_ID = ? AND QUANTITY >= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $quantity, $blood_group, $bank_id, $quantity);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            $message = "Inventory reduced successfully!";
        } else {
            $message = "Failed to reduce inventory! Check the quantity.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Reduce Blood Inventory</title>
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
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-align: left;
        }
        select, input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">Blood For Life</div>
    <div class="container">
        <h1>Add/Reduce Blood Inventory</h1>
        <?php if ($message): ?>
            <p class="<?= strpos($message, 'successfully') !== false ? 'message' : 'error' ?>"><?= $message ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="blood_group">Blood Group:</label>
            <select name="blood_group" id="blood_group" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="bank_id">Blood Bank:</label>
            <select name="bank_id" id="bank_id" required>
                <option value="1">City Hospital Blood Bank</option>
                <option value="2">National Blood Bank</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required>

            <label for="action">Action:</label>
            <select name="action" id="action" required>
                <option value="add">Add Inventory</option>
                <option value="reduce">Reduce Inventory</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
