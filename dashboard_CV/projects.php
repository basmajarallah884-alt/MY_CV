<?php
require_once 'config.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check for upload limit errors
    if (empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $max_size = ini_get('post_max_size');
        echo "<div class='alert alert-danger m-3'>Error: File too large! The upload exceeds the server limit of $max_size. Please upload a smaller video or check configuration.</div>";
    } elseif (isset($_POST['title'])) {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $link = $_POST['link'];
        $tech = $_POST['technologies'];
    
    // Image Upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    // Video URL or Upload (For simplicity handled as URL or file too, let's treat video as file upload here or link? User said "upload video")
    // Let's add video file upload support
    $video = "";
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $target_dir = "uploads/";
        $video = time() . "_v_" . basename($_FILES["video"]["name"]);
        move_uploaded_file($_FILES["video"]["tmp_name"], $target_dir . $video);
    }
    
        $stmt = $conn->prepare("INSERT INTO projects (title, description, link, technologies, image, video) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $desc, $link, $tech, $image, $video);
        $stmt->execute();
        
        header("Location: projects.php");
        exit;
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM projects WHERE id = $id");
    header("Location: projects.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Dashboard</a>
        
        <div class="row">
            <!-- Add Project Form -->
            <div class="col-md-4">
                <div class="card p-4 mb-4">
                    <h4>Add New Project</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Link (URL)</label>
                            <input type="text" name="link" class="form-control" placeholder="http://...">
                        </div>
                         <div class="mb-3">
                            <label>Technologies</label>
                            <input type="text" name="technologies" class="form-control" placeholder="PHP, JS, CSS...">
                        </div>
                        <div class="mb-3">
                            <label>Project Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label>Project Video</label>
                            <input type="file" name="video" class="form-control" accept="video/*">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Project</button>
                    </form>
                </div>
            </div>
            
            <!-- List Projects -->
            <div class="col-md-8">
                <div class="card p-4">
                    <h4>Existing Projects</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image/Video</th>
                                <th>Title</th>
                                <th>Tech</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
                            while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td style="width: 100px;">
                                    <?php if($row['image']): ?>
                                        <img src="uploads/<?php echo $row['image']; ?>" width="80">
                                    <?php elseif($row['video']): ?>
                                        <i class="fas fa-video fa-2x"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                    <small><a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank">View Link</a></small>
                                </td>
                                <td><?php echo htmlspecialchars($row['technologies']); ?></td>
                                <td>
                                    <a href="edit_project.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="projects.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?');"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
