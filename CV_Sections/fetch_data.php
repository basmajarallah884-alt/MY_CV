<?php
// Force localhost settings for CLI
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("DB Error");

$p = $conn->query('SELECT * FROM profile LIMIT 1')->fetch_assoc();
echo "--- PROFILE ---\n";
print_r($p);
$s = $conn->query('SELECT * FROM skills')->fetch_all(MYSQLI_ASSOC);
echo "--- SKILLS ---\n";
print_r($s);
$pr = $conn->query('SELECT * FROM projects')->fetch_all(MYSQLI_ASSOC);
echo "--- PROJECTS ---\n";
print_r($pr);
?>
