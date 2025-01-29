<?php
session_start();
include('connect.php'); 

if (!isset($_SESSION['name'])) {
    echo "Error: User not logged in.";
    exit;
}

$member_name = $_SESSION['name'];

// Fetch user_id from the user table to link it with the member table
$stmt = $conn->prepare("SELECT user_id FROM user WHERE name = ?");
$stmt->bind_param("s", $member_name);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

if ($user_data) {
    $user_id = $user_data['user_id'];
    
    // Fetch member details from the member table using user_id
    $stmt = $conn->prepare("SELECT gender, age, blood_group, medical_history FROM member WHERE member_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Error: No matching user found.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Personal Details</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            margin-top: 50px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #007BFF;
            text-align: center;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
        }
        strong {
            color: #333;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Personal Details</h2>
            <?php if ($member): ?>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($member_name); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($member['gender']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($member['age']); ?></p>
                <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($member['blood_group']); ?></p>
                <p><strong>Medical History:</strong> <?php echo htmlspecialchars($member['medical_history']); ?></p>
            <?php else: ?>
                <p>No personal details found for this user.</p>
            <?php endif; ?>
            <a href="member_dashboard.php" class="back-button">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
