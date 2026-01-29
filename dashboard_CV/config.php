<?php
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    // Localhost Settings (XAMPP)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'portfolio_db');
} else {
    // Live Server Settings (InfinityFree)
    define('DB_HOST', 'sql112.infinityfree.com');
    define('DB_USER', 'if0_41008514');
    define('DB_PASS', '84YSrhXvCQ3sAS'); // User needs to put their vPanel password here
    define('DB_NAME', 'if0_41008514_cv');
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function for base URL - Automatically handles live domains
function base_url($path = '') {
    return "/dashboard_CV/" . ltrim($path, '/');
}

// Authentication Check - Only for dashboard pages
if (strpos($_SERVER['SCRIPT_NAME'], 'dashboard_CV') !== false && strpos($_SERVER['SCRIPT_NAME'], 'login.php') === false) {
    require_once __DIR__ . '/auth_check.php';
    if (function_exists('check_login')) {
        check_login();
    }
}
?>
