<?php
session_start();
session_destroy(); // Destroy all sessions
header('Location: ../public/index.php'); // Redirect to home page
exit;
?>
