<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$rating_id = $_GET['id'];
$error = '';
$success = '';

// Fetch the rating details
$stmt = $pdo->prepare('SELECT * FROM performance_ratings WHERE rating_id = ?');
$stmt->execute([$rating_id]);
$rating = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating_score = $_POST['rating_score'];
    $comments = $_POST['comments'];

    if (empty($rating_score)) {
        $error = 'Rating score is required.';
    } else {
        // Update the rating in the database
        $stmt = $pdo->prepare('UPDATE performance_ratings SET rating_score = ?, comments = ? WHERE rating_id = ?');
        if ($stmt->execute([$rating_score, $comments, $rating_id])) {
            $success = 'Performance rating updated successfully.';
        } else {
            $error = 'There was an issue updating the performance rating.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Performance Rating - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Edit Performance Rating</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="edit_performance_rating.php?id=<?= $rating['rating_id']; ?>" method="POST">
            <div class="form-group">
                <label for="rating_score">Rating Score</label>
                <input type="number" id="rating_score" name="rating_score" value="<?= htmlspecialchars($rating['rating_score']); ?>" min="1" max="10" required>
            </div>
            <div class="form-group">
                <label for="comments">Comments</label>
                <textarea id="comments" name="comments"><?= htmlspecialchars($rating['comments']); ?></textarea>
            </div>
            <button type="submit" class="btn">Update Rating</button>
        </form>
    </div>
</body>
</html>
