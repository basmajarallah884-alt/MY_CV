<?php
require_once 'config.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update Settings
    // Auto-fix: Check if 'age' column exists in 'profile' table
    $col_check = $conn->query("SHOW COLUMNS FROM profile LIKE 'age'");
    if ($col_check->num_rows == 0) {
        $conn->query("ALTER TABLE profile ADD COLUMN age INT DEFAULT 0");
    }

    foreach ($_POST as $key => $value) {
        if ($key != 'profile_img') {
            $stmt = $conn->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
            $stmt->bind_param("sss", $key, $value, $value);
            $stmt->execute();
        }
    }
    
    // Update Profile Table
    $full_name = $_POST['full_name'];
    $job_title = $_POST['job_title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $age = intval($_POST['age']); // Handle Age
    
    $stmt_profile = $conn->prepare("UPDATE profile SET full_name=?, job_title=?, email=?, phone=?, location=?, age=? WHERE id=1");
    if ($stmt_profile) {
        $stmt_profile->bind_param("sssssi", $full_name, $job_title, $email, $phone, $location, $age);
        $stmt_profile->execute();
        $stmt_profile->close();
    } else {
        // Fallback or error handling if prepare fails (e.g. table issue)
        error_log("Prepare failed: " . $conn->error);
    }

    // Profile Image Upload
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $img_name = "profile_" . time() . "_" . basename($_FILES["profile_img"]["name"]);
        move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_dir . $img_name);
        
        $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('profile_img', '$img_name') ON DUPLICATE KEY UPDATE setting_value = '$img_name'");
    }
    
    header("Location: settings.php?success=1");
    exit;
}

$profile = $conn->query("SELECT * FROM profile LIMIT 1")->fetch_assoc();
$settings_res = $conn->query("SELECT * FROM settings");
$settings = [];
while ($row = $settings_res->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Dashboard</a>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">Settings updated successfully!</div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-4 mb-4">
                        <h4>General Profile</h4>
                         <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($profile['full_name']); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Job Title</label>
                            <input type="text" name="job_title" class="form-control" value="<?php echo htmlspecialchars($profile['job_title']); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Age</label>
                            <input type="number" name="age" class="form-control" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Profile Image</label>
                            <?php if(!empty($settings['profile_img'])): ?>
                                <div class="mb-2"><img src="uploads/<?php echo $settings['profile_img']; ?>" width="100" class="rounded-circle"></div>
                            <?php endif; ?>
                            <input type="file" name="profile_img" class="form-control">
                        </div>
                    </div>
                    
                    <div class="card p-4">
                        <h4>Contact Info</h4>
                         <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($profile['email']); ?>">
                        </div>
                         <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($profile['phone']); ?>">
                        </div>
                         <div class="mb-3">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($profile['location']); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card p-4 mb-4">
                        <h4>Hero Section</h4>
                        <div class="mb-3">
                            <label>Hero Title (e.g. WELCOME)</label>
                            <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($settings['hero_title'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Hero Subtitle (Bio Line)</label>
                            <textarea name="hero_subtitle" class="form-control" rows="2"><?php echo htmlspecialchars($settings['hero_subtitle'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="card p-4 mb-4">
                        <h4>Contact Section Text</h4>
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="contact_title" class="form-control" value="<?php echo htmlspecialchars($settings['contact_title'] ?? 'Let\'s work together!'); ?>">
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="contact_text" class="form-control" rows="3"><?php echo htmlspecialchars($settings['contact_text'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="card p-4">
                        <h4>About Section</h4>
                        <div class="mb-3">
                            <label>About Text</label>
                            <textarea name="about_text" class="form-control" rows="5"><?php echo htmlspecialchars($settings['about_text'] ?? ''); ?></textarea>
                        </div>
                         <div class="mb-3">
                            <label>Years of Experience</label>
                            <input type="text" name="about_years" class="form-control" value="<?php echo htmlspecialchars($settings['about_years'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
