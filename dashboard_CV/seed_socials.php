<?php
require_once 'config.php';

// Add Socials
$conn->query("INSERT INTO socials (platform, url, icon_class) VALUES ('GitHub', 'https://github.com/osama', 'fab fa-github')");
$conn->query("INSERT INTO socials (platform, url, icon_class) VALUES ('LinkedIn', 'https://linkedin.com/in/osama', 'fab fa-linkedin')");
$conn->query("INSERT INTO socials (platform, url, icon_class) VALUES ('Twitter', 'https://twitter.com/osama', 'fab fa-twitter')");

// Add Skills
$conn->query("INSERT INTO skills (skill_name, type) VALUES ('PHP & MySQL', 'hard')");
$conn->query("INSERT INTO skills (skill_name, type) VALUES ('HTML5 & CSS3', 'hard')");
$conn->query("INSERT INTO skills (skill_name, type) VALUES ('JavaScript', 'hard')");

echo "Added Socials and Skills.";
?>
