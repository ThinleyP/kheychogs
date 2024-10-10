<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$employee_id = $_SESSION['user_id'];

// Fetch the employee's performance ratings
$stmt = $pdo->prepare('SELECT * FROM performance_ratings WHERE employee_id = ?');
$stmt->execute([$employee_id]);
$ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Performance Ratings - Employee Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>View Performance Ratings</h1>

        <table class="performance-table">
            <thead>
                <tr>
                    <th>Rating Score</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ratings as $rating): ?>
                    <tr>
                        <td><?= htmlspecialchars($rating['rating_score']); ?></td>
                        <td><?= htmlspecialchars($rating['comments']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
