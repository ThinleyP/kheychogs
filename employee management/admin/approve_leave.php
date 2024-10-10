<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$leave_id = $_GET['id'];

// Approve the leave request
$stmt = $pdo->prepare('UPDATE leave_applications SET status = "Approved" WHERE leave_id = ?');
$stmt->execute([$leave_id]);

header('Location: leave_requests.php');
exit;
?>
