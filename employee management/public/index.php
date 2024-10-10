<?php
session_start(); // Start session for role-based access control
include('../includes/header.php'); // Include navigation

// Check if user is logged in and their role
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Home</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <section class="hero">
            <img src="../public/img/banner.jpg" alt="Office Environment" class="hero-img">
            <h1>Welcome to the Employee Management System</h1>
            <p>Manage employee data, leave applications, and performance reviews efficiently.</p>
            <?php if (!$role): ?>
                <a href="../auth/login.php" class="btn">Login to Get Started</a>
            <?php endif; ?>
        </section>

        <section class="features">
            <h2>What We Offer</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <img src="../public/img/manage.jpg" alt="Manage Employees" class="feature-img">
                    <h3>Manage Employees</h3>
                    <p>Admins can add, edit, and manage employee records effortlessly.</p>
                </div>
                <div class="feature-item">
                    <img src="../public/img/leave.jpg" alt="Leave Requests" class="feature-img">
                    <h3>Leave Applications</h3>
                    <p>Employees can easily apply for leave, and admins can approve or reject requests.</p>
                </div>
                <div class="feature-item">
                    <img src="../public/img/performance.jpg" alt="Performance" class="feature-img">
                    <h3>Performance Reviews</h3>
                    <p>Admins can review and rate employee performance, and employees can view their ratings.</p>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <h2>What Our Employees Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial-item">
                    <img src="../public/img/user1.png" alt="User Testimonial" class="testimonial-img">
                    <p>"This system has made leave management so much easier!"</p>
                    <h4>Tshering Yangzom</h4>
                </div>
                <div class="testimonial-item">
                    <img src="../public/img/user2.png" alt="User Testimonial" class="testimonial-img">
                    <p>"Performance reviews are transparent and straightforward."</p>
                    <h4>Kinley</h4>
                </div>
                <div class="testimonial-item">
                    <img src="../public/img/user3.png" alt="User Testimonial" class="testimonial-img">
                    <p>"Managing my team is now more efficient than ever."</p>
                    <h4>Pema</h4>
                </div>
            </div>
        </section>
    </div>

    <?php include('../includes/footer.php'); // Include footer ?>
</body>
</html>
