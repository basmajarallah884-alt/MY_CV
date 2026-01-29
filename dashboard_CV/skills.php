<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['skill_name'];
    $conn->query("INSERT INTO skills (skill_name) VALUES ('$name')");
    header("Location: skills.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM skills WHERE id = $id");
    header("Location: skills.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Skills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Dashboard</a>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h4>Add Skill</h4>
                    <form method="POST">
                        <input type="text" name="skill_name" class="form-control mb-2" placeholder="Skill Name (e.g. PHP)" required>
                        <button class="btn btn-primary w-100">Add</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-3">
                    <h4>Skills List</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $res = $conn->query("SELECT * FROM skills");
                        while($row = $res->fetch_assoc()):
                        ?>
                        <span class="badge bg-primary p-2 fs-6">
                            <?php echo htmlspecialchars($row['skill_name']); ?>
                            <a href="skills.php?delete=<?php echo $row['id']; ?>" class="text-white ms-2"><i class="fas fa-times"></i></a>
                        </span>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
