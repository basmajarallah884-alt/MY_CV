<?php
require_once 'config.php';

// Add Institute Project
$title = "Institute Management System";
$desc = "A comprehensive dashboard for managing students, courses, payments, and online registrations. Built with PHP and MySQL.";
$link = "/institute/admin";
$tech = "PHP, MySQL, Bootstrap, JS";

// Check if exists
$check = $conn->query("SELECT id FROM projects WHERE title = '$title'");
if ($check->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO projects (title, description, link, technologies, image) VALUES (?, ?, ?, ?, 'institute_preview.jpg')");
    $stmt->bind_param("ssss", $title, $desc, $link, $tech);
    $stmt->execute();
    echo "Added Institute Project.<br>";
} else {
    echo "Institute Project already exists.<br>";
}

// Add Profile Data Update
$conn->query("UPDATE profile SET full_name = 'Osama Developer', job_title = 'Full Stack Engineer' WHERE id = 1");
echo "Profile updated.";
?>
