<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit;
}

include('../includes/db_connect.php');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_SESSION['user_id'];
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $comments = $_POST['comments'];

    // Validation
    if (empty($leave_type) || empty($start_date) || empty($end_date)) {
        $error = 'All fields are required';
    } elseif (strtotime($start_date) > strtotime($end_date)) {
        $error = 'Start date cannot be later than end date';
    } else {
        // Insert leave application into the database
        try {
            $stmt = $pdo->prepare('INSERT INTO leave_applications (employee_id, leave_type, start_date, end_date, comments) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$employee_id, $leave_type, $start_date, $end_date, $comments]);
            $success = 'Leave application submitted successfully.';
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave - Employee Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Apply for Leave</h1>

        <!-- Display error message -->
        <?php if ($error): ?>
            <div class="error" style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if ($success): ?>
            <div class="success" style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 15px;">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <!-- Leave Application Form -->
        <form action="apply_leave.php" method="POST" style="max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="leave_type" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Leave Type</label>
                <select id="leave_type" name="leave_type" required 
                        style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
                    <option value="">Select Leave Type</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Annual Leave">Annual Leave</option>
                    <option value="Casual Leave">Casual Leave</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="start_date" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Start Date</label>
                <input type="date" id="start_date" name="start_date" required 
                       style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="end_date" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">End Date</label>
                <input type="date" id="end_date" name="end_date" required 
                       style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="comments" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Comments</label>
                <textarea id="comments" name="comments" style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;"></textarea>
            </div>
            <button type="submit" class="btn" style="width: 100%; padding: 12px; border: none; border-radius: 6px; background-color: #4CAF50; color: #fff; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;">Submit Leave Application</button>
        </form>

    </div>
</body>
</html>
