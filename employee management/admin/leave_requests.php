<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

// Fetch all leave applications
$stmt = $pdo->query('
    SELECT leave_applications.leave_id, employees.name, leave_applications.leave_type, leave_applications.start_date, leave_applications.end_date, leave_applications.status 
    FROM leave_applications 
    JOIN employees ON leave_applications.employee_id = employees.employee_id
');
$leave_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave Requests - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Manage Leave Requests</h1>

        <table class="leave-requests-table">
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leave_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['leave_id']); ?></td>
                        <td><?= htmlspecialchars($request['name']); ?></td>
                        <td><?= htmlspecialchars($request['leave_type']); ?></td>
                        <td><?= htmlspecialchars($request['start_date']); ?></td>
                        <td><?= htmlspecialchars($request['end_date']); ?></td>
                        <td><?= htmlspecialchars($request['status']); ?></td>
                        <td>
                            <?php if ($request['status'] === 'Pending'): ?>
                                <a href="approve_leave.php?id=<?= $request['leave_id']; ?>" class="btn">Approve</a>
                                <a href="reject_leave.php?id=<?= $request['leave_id']; ?>" class="btn">Reject</a>
                            <?php else: ?>
                                <?= htmlspecialchars($request['status']); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
