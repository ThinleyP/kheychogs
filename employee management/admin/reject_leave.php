<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$leave_id = $_GET['id'];

// Reject the leave request
$stmt = $pdo->prepare('UPDATE leave_applications SET status = "Rejected" WHERE leave_id = ?');
$stmt->execute([$leave_id]);

header('Location: leave_requests.php');
exit;
?>
