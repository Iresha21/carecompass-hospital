<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["medical_file"])) {
    $receipt_number = $_POST['receipt_number'];
    $file_name = basename($_FILES["medical_file"]["name"]);
    $target_dir = "uploads/medical_records/";
    $target_file = $target_dir . time() . "_" . $file_name; // Unique filename

    // Check if the receipt number already exists
    $stmt = $conn->prepare("SELECT * FROM medical_records WHERE receipt_number = ?");
    $stmt->bind_param("s", $receipt_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A record with this receipt number already exists!";
    } elseif (move_uploaded_file($_FILES["medical_file"]["tmp_name"], $target_file)) {
        // Save file details to the database
        $stmt = $conn->prepare("INSERT INTO medical_records (receipt_number, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $receipt_number, $target_file);

        if ($stmt->execute()) {
            echo "Medical record uploaded successfully!";
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "Error uploading file.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Medical Record</title>
    <link rel="stylesheet" href="staff_dashboard.css">
</head>
<body>
    <h2>Upload Medical Record</h2>
    <div class="form-container">
    <form method="post" enctype="multipart/form-data">
        <label>Receipt Number:</label>
        <input type="text" name="receipt_number" required><br>
        <label>Upload File:</label>
        <input type="file" name="medical_file" required><br>
        <button type="submit">Upload</button>
    </form>
</div>
</body>
</html>
