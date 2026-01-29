<?php
require_once 'config.php';

$id = intval($_GET['id']);
$project = $conn->query("SELECT * FROM projects WHERE id = $id")->fetch_assoc();

if (!$project) {
    die("Project not found");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $link = $_POST['link'];
    $tech = $_POST['technologies'];
    
    // Image Upload
    $image = $project['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    // Video Upload
    $video = $project['video'];
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $target_dir = "uploads/";
        $video = time() . "_v_" . basename($_FILES["video"]["name"]);
        move_uploaded_file($_FILES["video"]["tmp_name"], $target_dir . $video);
    }
    
    $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, link=?, technologies=?, image=?, video=? WHERE id=?");
    $stmt->bind_param("ssssssi", $title, $desc, $link, $tech, $image, $video, $id);
    $stmt->execute();
    
    header("Location: projects.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="projects.php" class="btn btn-secondary mb-4">Back</a>
        <div class="card p-4">
            <h4>Edit Project</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($project['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Link</label>
                    <input type="text" name="link" class="form-control" value="<?php echo htmlspecialchars($project['link']); ?>">
                </div>
                <div class="mb-3">
                    <label>Technologies</label>
                    <input type="text" name="technologies" class="form-control" value="<?php echo htmlspecialchars($project['technologies']); ?>">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Current Image</label><br>
                        <?php if($project['image']): ?><img src="uploads/<?php echo $project['image']; ?>" width="100"><?php endif; ?>
                        <input type="file" name="image" class="form-control mt-2">
                    </div>
                    <div class="col-md-6">
                        <label>Current Video</label><br>
                        <?php if($project['video']): ?><small>Video Set</small><?php endif; ?>
                        <input type="file" name="video" class="form-control mt-2" accept="video/*">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-4">Update Project</button>
            </form>
        </div>
    </div>
</body>
</html>
