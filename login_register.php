<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login or Register</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #74ebd5, #9face6); /* Beautiful gradient background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background for a soft effect */
            padding: 40px;
            width: 100%;
            max-width: 450px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2em;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 15px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        button {
            padding: 15px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .link-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .link-container a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .link-container a:hover {
            text-decoration: underline;
        }

        /* Animation for page load */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        body {
            animation: fadeIn 2s ease-in;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login or Register</h2>
        <form action="login_process.php" method="post">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>

        <div class="link-container">
            <a href="register.php">Don't have an account? Register here</a>
        </div>
    </div>
</body>
</html>
