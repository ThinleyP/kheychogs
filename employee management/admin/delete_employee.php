<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$employee_id = $_GET['id'];

// Delete the employee from the database
$stmt = $pdo->prepare('DELETE FROM employees WHERE employee_id = ?');
$stmt->execute([$employee_id]);

header('Location: manage_employees.php'); // Redirect back to the employee management page
exit;
?>
