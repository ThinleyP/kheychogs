<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

// Fetch all performance ratings
$stmt = $pdo->query('
    SELECT performance_ratings.rating_id, employees.name, performance_ratings.rating_score, performance_ratings.comments 
    FROM performance_ratings 
    JOIN employees ON performance_ratings.employee_id = employees.employee_id
');
$ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Performance Ratings - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Manage Performance Ratings</h1>
        <a href="add_performance_rating.php" class="btn">Add Performance Rating</a>

        <table class="performance-table">
            <thead>
                <tr>
                    <th>Rating ID</th>
                    <th>Employee Name</th>
                    <th>Rating Score</th>
                    <th>Comments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ratings as $rating): ?>
                    <tr>
                        <td><?= htmlspecialchars($rating['rating_id']); ?></td>
                        <td><?= htmlspecialchars($rating['name']); ?></td>
                        <td><?= htmlspecialchars($rating['rating_score']); ?></td>
                        <td><?= htmlspecialchars($rating['comments']); ?></td>
                        <td>
                            <a href="edit_performance_rating.php?id=<?= $rating['rating_id']; ?>" class="btn">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
