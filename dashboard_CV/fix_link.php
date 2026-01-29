<?php
require_once 'config.php';

// Fix Institute Link
$new_link = "http://localhost/institute/admin/index.php";
$conn->query("UPDATE projects SET link = '$new_link' WHERE title LIKE '%Institute%'");
echo "Updated Institute link to: $new_link";
?>
