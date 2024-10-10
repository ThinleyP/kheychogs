<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $rating_score = $_POST['rating_score'];
    $comments = $_POST['comments'];

    // Check if required fields are filled
    if (empty($employee_id) || empty($rating_score)) {
        $error = 'Employee and rating score are required.';
    } else {
        try {
            // Insert the performance rating into the database
            $stmt = $pdo->prepare('INSERT INTO performance_ratings (employee_id, rating_score, comments) VALUES (?, ?, ?)');
            if ($stmt->execute([$employee_id, $rating_score, $comments])) {
                $success = 'Performance rating added successfully.';
            } else {
                $error = 'There was an issue adding the performance rating.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch all employees for the dropdown
$employees = $pdo->query('SELECT employee_id, name FROM employees')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Performance Rating - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Add Performance Rating</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="add_performance_rating.php" method="POST">
            <div class="form-group">
                <label for="employee_id">Employee</label>
                <select id="employee_id" name="employee_id" required>
                    <option value="">Select Employee</option>
                    <?php foreach ($employees as $employee): ?>
                        <option value="<?= $employee['employee_id']; ?>"><?= htmlspecialchars($employee['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="rating_score">Rating Score</label>
                <input type="number" id="rating_score" name="rating_score" min="1" max="10" required>
            </div>
            <div class="form-group">
                <label for="comments">Comments</label>
                <textarea id="comments" name="comments"></textarea>
            </div>
            <button type="submit" class="btn">Add Rating</button>
        </form>
    </div>
</body>
</html>
