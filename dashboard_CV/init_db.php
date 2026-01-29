<?php
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = file_get_contents('portfolio_schema.sql');
if ($conn->multi_query($sql)) {
    echo "Database initialized successfully.";
    while ($conn->next_result()) {;} // flush multi_queries
} else {
    echo "Error initializing database: " . $conn->error;
}
$conn->close();
?>
