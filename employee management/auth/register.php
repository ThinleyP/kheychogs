<?php
session_start();
include('../includes/db_connect.php'); // Include the database connection

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if all fields are filled
    if (empty($name) || empty($username) || empty($password) || empty($role)) {
        $error = 'All fields are required.';
    } else {
        // Check if the username already exists
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error = 'Username already taken. Please choose another one.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $pdo->prepare('INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $username, $hashed_password, $role]);

            $success = 'Account created successfully! You can now log in.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Employee Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        <!-- Display success or error messages -->
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- Registration form -->
        <form action="register.php" method="POST" style="max-width: 400px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="name" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required 
               style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="username" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required 
               style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="password" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required 
               style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="role" style="display: block; margin-bottom: 10px; font-size: 1rem; color: #333; font-weight: bold;">Role</label>
        <select id="role" name="role" required 
                style="width: 100%; padding: 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 6px; outline: none; transition: all 0.3s ease;">
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select>
    </div>
    <button type="submit" class="btn" style="width: 100%; padding: 12px; border: none; border-radius: 6px; background-color: #4CAF50; color: #fff; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;">
        Register
    </button>
</form>
<p style="text-align: center; color: #666; margin-top: 20px;">Already have an account? <a href="login.php" style="color: #0288d1; text-decoration: none;">Login here</a>.</p>

</body>
</html>
