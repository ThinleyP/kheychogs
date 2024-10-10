<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php'); // Redirect if not admin
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Welcome, Admin <?= htmlspecialchars($_SESSION['username']); ?></h1>
        <p>This is the admin dashboard where you can manage employees, leave requests, and performance ratings.</p>

        <!--    functionality links -->  a
        <div class="admin-links">
            <a href="manage_employees.php" class="btn">Manage Employees</a>
            <a href="leave_requests.php" class="btn">Manage Leave Requests</a>
            <a href="performance_ratings.php" class="btn">Manage Performance Ratings</a>
            <a href="view_contact_request.php" class="btn">View Contact Requests</a>
        </div>
    </div>
</body>
</html>
