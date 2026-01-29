<?php
require_once 'config.php';

// Handle Add/Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? 'add';
    
    if($action == 'add') {
        $title = $_POST['title'];
        $issuer = $_POST['issuer'];
        $date = $_POST['issue_date'];
        
        $image = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            $image = time() . "_c_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
        }
        
        $stmt = $conn->prepare("INSERT INTO certificates (title, issuer, issue_date, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $issuer, $date, $image);
        $stmt->execute();
    } elseif ($action == 'edit') {
        $id = intval($_POST['id']);
        $title = $_POST['title'];
        $issuer = $_POST['issuer'];
        $date = $_POST['issue_date'];
        
        // Get old image
        $old = $conn->query("SELECT image FROM certificates WHERE id=$id")->fetch_assoc();
        $image = $old['image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            $image = time() . "_c_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
        }
        
        $stmt = $conn->prepare("UPDATE certificates SET title=?, issuer=?, issue_date=?, image=? WHERE id=?");
        $stmt->bind_param("ssssi", $title, $issuer, $date, $image, $id);
        $stmt->execute();
    }
    header("Location: certificates.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM certificates WHERE id = $id");
    header("Location: certificates.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Certificates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function fillEdit(id, title, issuer, date) {
            document.querySelector('[name=action]').value = 'edit';
            document.querySelector('[name=id]').value = id;
            document.querySelector('[name=title]').value = title;
            document.querySelector('[name=issuer]').value = issuer;
            document.querySelector('[name=issue_date]').value = date;
            document.querySelector('.submit-btn').innerText = 'Update Certificate';
            window.scrollTo(0,0);
        }
    </script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Dashboard</a>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4 mb-4">
                    <h4>Certificate Form</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label>Certificate Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Issuer (Organization)</label>
                            <input type="text" name="issuer" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Issue Date</label>
                            <input type="date" name="issue_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 submit-btn">Add Certificate</button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card p-4">
                    <h4>Certificates List</h4>
                    <div class="row g-3">
                        <?php
                        $res = $conn->query("SELECT * FROM certificates ORDER BY created_at DESC");
                        while($row = $res->fetch_assoc()):
                        ?>
                        <div class="col-md-6">
                            <div class="border rounded p-2 d-flex gap-3 align-items-center bg-white">
                                <?php if($row['image']): ?>
                                    <img src="uploads/<?php echo $row['image']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: #eee; display: flex; align-items: center; justify-content: center;"><i class="fas fa-certificate"></i></div>
                                <?php endif; ?>
                                
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($row['title']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($row['issuer']); ?></small>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                     <button class="btn btn-warning btn-sm" onclick="fillEdit('<?php echo $row['id']; ?>', '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['issuer']); ?>', '<?php echo $row['issue_date']; ?>')"><i class="fas fa-edit"></i></button>
                                     <a href="certificates.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?');"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
