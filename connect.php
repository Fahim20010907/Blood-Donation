<?php
// Database configuration
$servername = "localhost"; // Typically localhost if using XAMPP
$username = "root"; // Default MySQL username in XAMPP
$password = ""; // Default password is empty
$dbname = "Blood_for_Life"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Removed "Connected successfully!" echo to avoid unwanted messages on pages
?>
