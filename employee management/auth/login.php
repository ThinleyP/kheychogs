<?php
session_start();
include('../includes/db_connect.php'); // Include database connection

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if fields are filled
    if (empty($username) || empty($password)) {
        $error = 'Please fill in both username and password.';
    } else {
        // Query the database for the user
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Store user information in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on the role
            if ($user['role'] === 'admin') {
                header('Location: ../admin/dashboard.php');
            } elseif ($user['role'] === 'employee') {
                header('Location: ../employee/dashboard.php');
            }
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <!-- Display error message if login fails -->
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Login form -->
       <form action="login.php" method="POST" style="max-width: 400px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
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
    <button type="submit" class="btn" style="width: 100%; padding: 12px; border: none; border-radius: 6px; background-color: #4CAF50; color: #fff; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;">
        Login
    </button>
</form>
<p style="text-align: center; color: #666; margin-top: 20px;">Don't have an account? <a href="register.php" style="color: #0288d1; text-decoration: none;">Register here</a>.</p>

</body>
</html>
