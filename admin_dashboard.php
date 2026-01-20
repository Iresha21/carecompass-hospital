<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <h2>Admin Dashboard </h2>
    <div class="navbar">
    <a href="add_staff.php">Add New Staff</a>
    <a href="add_doctors.php">Add Doctors</a>
    <a href="logout.php">Logout</a>
</div>
   
<div class="admin_container">
       Welcome to the Care Compass Hospitals Admin Portal
    </div>

</body>
</html>
