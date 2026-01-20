<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and is a staff member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="staff_dashboard.css">
</head>
<body>
    <h2>Staff Dashboard</h2>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="add_medicalrecords.php">Add Medical Records</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="view_registered_services.php">View Registered Services</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
       Welcome to the Care Compass Hospitals Staff Portal
    </div>
</body>
</html>
