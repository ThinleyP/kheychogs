<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$employee_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch employee details
$stmt = $pdo->prepare('SELECT * FROM employees WHERE employee_id = ?');
$stmt->execute([$employee_id]);
$employee = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (empty($name) || empty($email) || empty($contact)) {
        $error = 'All fields are required.';
    } else {
        try {
            // Update employee details
            $stmt = $pdo->prepare('UPDATE employees SET name = ?, email = ?, contact = ? WHERE employee_id = ?');
            if ($stmt->execute([$name, $email, $contact, $employee_id])) {
                $success = 'Profile updated successfully.';
                // Update the session username
                $_SESSION['username'] = $name;
            } else {
                $error = 'There was an issue updating the profile.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Employee Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Edit Profile</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="profile.php" method="POST" style="max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="name" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($employee['name']); ?>" required 
               style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="email" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($employee['email']); ?>" required 
               style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="contact" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Contact</label>
        <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($employee['contact']); ?>" required 
               style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
    </div>
    <button type="submit" class="btn" style="width: 100%; padding: 12px; border: none; border-radius: 6px; background-color: #4CAF50; color: #fff; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;">Update Profile</button>
</form>
    </div>
</body>
</html>
