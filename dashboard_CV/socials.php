<?php
require_once 'config.php';

// Edit / Add
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? 'add';
    $platform = $_POST['platform'];
    $url = $_POST['url'];
    $icon = $_POST['icon_class'];
    
    if($action == 'add'){
        $conn->query("INSERT INTO socials (platform, url, icon_class) VALUES ('$platform', '$url', '$icon')");
    } elseif($action == 'edit') {
        $id = intval($_POST['id']);
        $conn->query("UPDATE socials SET platform='$platform', url='$url', icon_class='$icon' WHERE id=$id");
    }
    header("Location: socials.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM socials WHERE id = $id");
    header("Location: socials.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Socials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function fillEdit(id, plat, url, icon) {
             document.querySelector('[name=action]').value = 'edit';
             document.querySelector('[name=id]').value = id;
             document.querySelector('[name=platform]').value = plat;
             document.querySelector('[name=url]').value = url;
             document.querySelector('[name=icon_class]').value = icon;
             document.querySelector('.submit-btn').innerText = 'Update';
        }
    </script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Dashboard</a>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h4>Social Link</h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="">
                        <input type="text" name="platform" class="form-control mb-2" placeholder="Platform Name" required>
                        <input type="url" name="url" class="form-control mb-2" placeholder="URL" required>
                        <input type="text" name="icon_class" class="form-control mb-2" placeholder="Icon (fab fa-github)" required>
                        <button class="btn btn-primary w-100 submit-btn">Add</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-3">
                    <table class="table">
                        <thead><tr><th>Icon</th><th>Platform</th><th>URL</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php $res = $conn->query("SELECT * FROM socials"); while($row=$res->fetch_assoc()): ?>
                            <tr>
                                <td><i class="<?php echo $row['icon_class']; ?>"></i></td>
                                <td><?php echo $row['platform']; ?></td>
                                <td><?php echo $row['url']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="fillEdit('<?php echo $row['id']; ?>','<?php echo htmlspecialchars($row['platform']); ?>','<?php echo htmlspecialchars($row['url']); ?>','<?php echo htmlspecialchars($row['icon_class']); ?>')"><i class="fas fa-edit"></i></button>
                                    <a href="socials.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
