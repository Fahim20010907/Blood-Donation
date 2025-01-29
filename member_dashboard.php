<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}

$member_name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood For Life - Member Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        nav {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            position: relative;
        }

        .logout-button {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            text-decoration: none;
            color: white;
            background-color: red;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #007BFF;
        }

        .features {
            margin-top: 30px;
        }

        .feature-box {
            padding: 15px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
        }

        .feature-box a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .feature-box:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <nav>
        Blood For Life
        <a href="logout.php" class="logout-button">Logout</a>
    </nav>

    <div class="container">
        <h2>Welcome <?php echo htmlspecialchars($member_name); ?>!</h2>
        <p style="text-align: center;">A small drop for you, a giant leap for humanity.</p>

        <div class="features">
            <!-- Feature 1: View Personal Details -->
            <div class="feature-box">
                <a href="view_personal_details.php">View Personal Details</a>
            </div>

            <!-- Feature 2: Donate Blood -->
            <div class="feature-box">
                <a href="donate_blood.php">Donate Blood</a>
            </div>

            <!-- Feature 3: Request Blood -->
            <div class="feature-box">
                <a href="request_blood.php">Request Blood</a>
            </div>

            <!-- Feature 4: View Donation and Request History -->
            <div class="feature-box">
                <a href="view_history.php">View Donation and Request History</a>
            </div>

            <!-- Feature 5: Check Available Blood -->
            <div class="feature-box">
                <a href="check_available_blood.php">Check Available Blood in Blood Banks</a>
            </div>
        </div>
    </div>
</body>
</html>
