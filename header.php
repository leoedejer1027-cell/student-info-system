<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <h2><a href="index.php">Student Info System</a></h2>
        </div>
        <ul class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_student.php">Add Student</a></li>
                <li><a href="logout.php" class="btn-logout">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="container">