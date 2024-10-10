<header>
    <div class="logo">
    <img style="height: 30px; width: 30px;" src="../public/img/logo.png" alt="Company Logo">
    </div>
    
    <nav>
        <ul>
            <li><a href="../public/index.php">Home</a></li>
            <li><a href="../public/about.php">About</a></li>
            <li><a href="../public/contact.php">Contact</a></li>

            <!-- If the user is logged in as Admin -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="../admin/dashboard.php">Admin Dashboard</a></li>
                <li><a href="../admin/manage_employees.php">Manage Employees</a></li>
                <li><a href="../admin/leave_requests.php">Manage Leave Requests</a></li>
                <li><a href="../admin/performance_ratings.php">Manage Performance Ratings</a></li>
                <li><a href="../admin/view_contact_requests.php">View Contact Requests</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'employee'): ?>
                <li><a href="../employee/dashboard.php">Employee Dashboard</a></li>
                <li><a href="../employee/apply_leave.php">Apply for Leave</a></li>
                <li><a href="../employee/view_leave_status.php">View Leave Status</a></li>
                <li><a href="../employee/view_performance.php">View Performance Ratings</a></li>
                <li><a href="../employee/profile.php">Edit Profile</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="../auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div class="banner">
        <img src="../public/img/banner.jpg" alt="Banner Image">
    </div>
</header>
