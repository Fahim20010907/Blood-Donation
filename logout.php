<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to the unified login portal
header("Location: login.php");
exit();
?>
