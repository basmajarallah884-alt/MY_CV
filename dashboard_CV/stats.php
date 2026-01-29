<?php
require_once 'config.php';

// Handle Add/Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $icon = $_POST['icon'];
        $number = $_POST['number'];
        $label = $_POST['label'];
        $stmt = $conn->prepare("INSERT INTO stats (icon, number, label) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $icon, $number, $label);
        $stmt->execute();
    } elseif ($_POST['action'] == 'edit') {
        $id = intval($_POST['id']);
        $icon = $_POST['icon'];
        $number = $_POST['number'];
        $label = $_POST['label'];
        $stmt = $conn->prepare("UPDATE stats SET icon = ?, number = ?, label = ? WHERE id = ?");
        $stmt->bind_param("sssi", $icon, $number, $label, $id);
        $stmt->execute();
    }
    header("Location: stats.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM stats WHERE id = $id");
    header("Location: stats.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Stats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Dashboard</a>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <h4>Add New Stat</h4>
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label>Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-code">
                             <small class="text-muted">e.g., fas fa-code, fas fa-star</small>
                        </div>
                        <div class="mb-3">
                            <label>Number</label>
                            <input type="text" name="number" class="form-control" placeholder="5+">
                        </div>
                        <div class="mb-3">
                            <label>Label</label>
                            <input type="text" name="label" class="form-control" placeholder="Years Experience">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Stat</button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card p-4">
                    <h4>Current Stats Boxes</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Number</th>
                                <th>Label</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $conn->query("SELECT * FROM stats");
                            while($row = $res->fetch_assoc()):
                            ?>
                            <tr>
                                <td><i class="<?php echo $row['icon']; ?> fa-2x text-primary"></i></td>
                                <td>
                                    <form method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="icon" value="<?php echo $row['icon']; ?>">
                                        <input type="text" name="number" value="<?php echo $row['number']; ?>" class="form-control form-control-sm" style="width: 80px;">
                                </td>
                                <td>
                                        <input type="text" name="label" value="<?php echo $row['label']; ?>" class="form-control form-control-sm">
                                </td>
                                <td>
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i></button>
                                    </form>
                                    <a href="stats.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?');"><i class="fas fa-trash"></i></a>
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
