<?php
// Start session to access session variables
session_start();

// Destroy all session variables and session
session_unset();   // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to login page (or homepage)
header('Location: ../index.php'); // Change to your desired redirect URL
exit();
?>
