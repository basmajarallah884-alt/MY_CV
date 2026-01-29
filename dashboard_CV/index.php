<?php
require_once 'config.php';
// Main Admin Dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover, .sidebar a.active { background: #0d6efd; color: white; }
        .card { border: none; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3" style="width: 250px;">
            <h4 class="mb-4 text-center">Admin Panel</h4>
            <a href="index.php" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="messages.php"><i class="fas fa-envelope me-2"></i> Messages <span class="badge bg-danger ms-2"><?php echo $conn->query("SELECT COUNT(*) FROM messages")->fetch_row()[0]; ?></span></a>
            <a href="projects.php"><i class="fas fa-layer-group me-2"></i> Projects</a>
            <a href="certificates.php"><i class="fas fa-certificate me-2"></i> Certificates</a>
            <a href="stats.php"><i class="fas fa-chart-bar me-2"></i> Stats Boxes</a>
            <a href="skills.php"><i class="fas fa-code me-2"></i> Skills</a>
            <a href="socials.php"><i class="fas fa-share-alt me-2"></i> Social Links</a>
            <a href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
            <a href="/CV_Sections" target="_blank" class="mt-5 btn btn-outline-light w-100"><i class="fas fa-external-link-alt me-2"></i> View Site</a>
            <hr class="border-secondary">
            <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
        
        <!-- Content -->
        <div class="flex-grow-1 p-4">
            <h2 class="mb-4">Dashboard Overview</h2>
            
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white p-3">
                        <h3><?php echo $conn->query("SELECT COUNT(*) FROM projects")->fetch_row()[0]; ?></h3>
                        <p class="mb-0">Projects</p>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="card bg-success text-white p-3">
                        <h3><?php echo $conn->query("SELECT COUNT(*) FROM certificates")->fetch_row()[0]; ?></h3>
                        <p class="mb-0">Certificates</p>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="card bg-info text-white p-3">
                        <h3><?php echo $conn->query("SELECT COUNT(*) FROM skills")->fetch_row()[0]; ?></h3>
                        <p class="mb-0">Skills</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark p-3">
                        <h3><?php echo $conn->query("SELECT COUNT(*) FROM messages")->fetch_row()[0]; ?></h3>
                        <p class="mb-0">Messages</p>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4>Quick Actions</h4>
                <a href="projects.php" class="btn btn-primary me-2"><i class="fas fa-plus me-2"></i> Add Project</a>
                <a href="certificates.php" class="btn btn-success"><i class="fas fa-plus me-2"></i> Add Certificate</a>
            </div>
        </div>
    </div>
</body>
</html>
