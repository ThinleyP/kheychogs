<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$employee_id = $_GET['id'];
$error = '';
$success = '';

// Fetch the employee details
$stmt = $pdo->prepare('SELECT * FROM employees WHERE employee_id = ?');
$stmt->execute([$employee_id]);
$employee = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (empty($name) || empty($department) || empty($email) || empty($contact)) {
        $error = 'All fields are required.';
    } else {
        // Update employee in the database
        $stmt = $pdo->prepare('UPDATE employees SET name = ?, department = ?, email = ?, contact = ? WHERE employee_id = ?');
        $stmt->execute([$name, $department, $email, $contact, $employee_id]);

        $success = 'Employee updated successfully.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Edit Employee</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="edit_employee.php?id=<?= $employee['employee_id']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($employee['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" value="<?= htmlspecialchars($employee['department']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($employee['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($employee['contact']); ?>" required>
            </div>
            <button type="submit" class="btn">Update Employee</button>
        </form>
    </div>
</body>
</html>
