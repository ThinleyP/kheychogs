<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

// Fetch the logged-in employee's leave requests
$employee_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM leave_applications WHERE employee_id = ?');
$stmt->execute([$employee_id]);
$leave_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Status - Employee Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>View Leave Status</h1>

        <table class="leave-status-table">
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leave_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['leave_id']); ?></td>
                        <td><?= htmlspecialchars($request['leave_type']); ?></td>
                        <td><?= htmlspecialchars($request['start_date']); ?></td>
                        <td><?= htmlspecialchars($request['end_date']); ?></td>
                        <td><?= htmlspecialchars($request['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
