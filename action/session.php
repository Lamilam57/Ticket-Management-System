<?php
// Get the current page's file name
$currentPage = basename($_SERVER['PHP_SELF']);

// List of pages that require 'class/admin.php'
$adminPages = ['admin.php', 'user.php', 'deletedTicket.php', 'registerUser.php', 'index.php'];

// Dynamically include the appropriate file
require_once in_array($currentPage, $adminPages) ? 'class/admin.php' : '../class/admin.php';

// Initialize database and admin objects
$database = new Database();
$admin = new Admin();

// Set page title dynamically
$pageTitles = [
    'admin.php' => 'Dashboard',
    'user.php' => 'Dashboard',
    'deletedTicket.php' => 'Deleted Ticket',
    'registerUser.php' => 'Register User',
];
$pageTitle = $pageTitles[$currentPage] ?? 'Unknown Page'; // Default to 'Unknown Page' if not found

// Redirect to login if session is required but not set
if ($currentPage !== 'index.php' && empty($_SESSION['staff_id'])) {
    header('location: ../index.php');
    exit(); // Always use exit after a header redirect
}

// Helper function to retrieve session data
function getSessionData($key, $default = '') {
    return $_SESSION[$key] ?? $default;
}

// Retrieve session data
$staff_id = getSessionData('staff_id');
$name = getSessionData('name');
$who = getSessionData('who');
$passwordStatus = getSessionData('passwordStatus');

// Fetch user data only if logged in
$data = $staff_id ? $admin->loginUser($staff_id) : null;

// Set the href dynamically based on the current page
$href = match ($currentPage) {
    'admin.php', 'deletedTicket.php', 'registerUser.php' => 'admin.php',
    'user.php' => 'user.php',
    default => '#',
};


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset(); // Clear session variables
    session_destroy(); // Destroy the session
    header('location: ../index.php');
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();
?>
