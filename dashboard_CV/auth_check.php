<?php
// Secure credentials
define('ADMIN_USER', 'Basma');
define('ADMIN_PASS', 'bkjham&98765');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', 3600);
    session_set_cookie_params(3600);
    session_start();
}

// Function to check if user is logged in
function check_login() {
    // Whitelist login.php to prevent redirect loop
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page === 'login.php') {
        return;
    }

    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
}
?>
