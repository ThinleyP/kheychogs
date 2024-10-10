<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

// Fetch all contact requests
$stmt = $pdo->query('SELECT * FROM contact_requests WHERE status = "Pending"');
$contact_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact Requests - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>View Contact Requests</h1>

        <table class="contact-requests-table">
            <thead>
                <tr>
                    <th>Contact ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contact_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['contact_id']); ?></td>
                        <td><?= htmlspecialchars($request['name']); ?></td>
                        <td><?= htmlspecialchars($request['email']); ?></td>
                        <td><?= htmlspecialchars($request['message']); ?></td>
                        <td>
                            <a href="mark_contact_reviewed.php?id=<?= $request['contact_id']; ?>" class="btn">Mark as Reviewed</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
