<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $staff_id);
    
    if ($stmt->execute()) {
        echo "Staff deleted successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error deleting staff!";
    }

    $stmt->close();
}
?>
