<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

include('../includes/db_connect.php');

$contact_id = $_GET['id'];

// Mark the contact request as reviewed
$stmt = $pdo->prepare('UPDATE contact_requests SET status = "Reviewed" WHERE contact_id = ?');
$stmt->execute([$contact_id]);

header('Location: view_contact_requests.php');
exit;
?>
