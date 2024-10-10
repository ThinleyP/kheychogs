<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../auth/login.php'); // Redirect if not an employee
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Employee Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container" style="max-width: 800px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
    <h1 style="text-align: center; color: #333; font-size: 2rem;">Employee Dashboard</h1>
    <p style="text-align: center; color: #666; margin-bottom: 30px;">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
    <p style="text-align: center; color: #666; margin-bottom: 30px;">From here, you can apply for leave and view your performance ratings.</p>

    <div class="employee-links" style="text-align: center;">
        <a href="apply_leave.php" class="btn" style="display: inline-block; margin: 10px; padding: 12px 20px; background-color: #4CAF50; color: #fff; border-radius: 6px; text-decoration: none; font-size: 1.1rem;">Apply for Leave</a>
        <a href="view_leave_status.php" class="btn" style="display: inline-block; margin: 10px; padding: 12px 20px; background-color: #4CAF50; color: #fff; border-radius: 6px; text-decoration: none; font-size: 1.1rem;">View Leave Status</a>
        <a href="view_performance.php" class="btn" style="display: inline-block; margin: 10px; padding: 12px 20px; background-color: #4CAF50; color: #fff; border-radius: 6px; text-decoration: none; font-size: 1.1rem;">View Performance Ratings</a>
    </div>
</div>
    </div>
</body>
</html>
