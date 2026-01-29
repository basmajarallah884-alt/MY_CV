<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
        <div class="card p-4">
            <h4>Inbox</h4>
            <table class="table table-striped">
                <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Message</th></tr></thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
                    while($row=$res->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
