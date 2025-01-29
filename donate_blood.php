<?php
session_start(); 
include 'connect.php'; 

// Fetch member's blood group from the database based on the session user ID
$member_id = $_SESSION['user_id']; 
$query = $conn->prepare("SELECT blood_group FROM member WHERE member_id = ?");
$query->bind_param("i", $member_id);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();
$blood_group = $row['blood_group'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Blood</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        h1 {
            color: #d9534f;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        input[type="number"], input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
            margin: 5px;
        }
        button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #218838;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Donate Blood</h1>
        <form action="donate_blood.php" method="POST">
            <label for="quantity">Quantity (in units):</label>
            <input type="number" id="quantity" name="quantity" required>
            <br>
            <label for="last_donation_date">Last Date of Donation:</label>
            <input type="date" id="last_donation_date" name="last_donation_date" required>
            <br>
            <button type="submit" name="donate">Donate</button>
        </form>
        <a href="member_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['donate'])) {
    $quantity = $_POST['quantity'];
    $last_donation_date = $_POST['last_donation_date'];
    $current_date = date('Y-m-d');

    // Calculate the date 3 months ago from today
    $three_months_ago = date('Y-m-d', strtotime('-3 months'));

    if ($last_donation_date > $three_months_ago) {
        echo "<script>alert('You cannot donate blood as the last donation date is less than 3 months ago.');</script>";
    } else {
        // Fetch the blood ID based on blood group
        $blood_query = $conn->prepare("SELECT BLOOD_ID FROM blood WHERE blood_group = ?");
        $blood_query->bind_param("s", $blood_group);
        $blood_query->execute();
        $blood_result = $blood_query->get_result();
        $blood_row = $blood_result->fetch_assoc();
        $blood_id = $blood_row['BLOOD_ID'];

        // Insert into the DONATE table
        $insert_query = $conn->prepare("INSERT INTO donate (D_ID, BLOOD_ID, DATE, QUANTITY) VALUES (?, ?, ?, ?)");
        $insert_query->bind_param("iisi", $member_id, $blood_id, $current_date, $quantity);
        
        if ($insert_query->execute()) {
            echo "<script>alert('Donation successful! Thank you for your contribution.'); window.location.href='member_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error occurred while donating blood. Please try again.');</script>";
        }
    }
}
?>
