<?php
include "header.php";
include 'db_connect.php';

$record_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receipt_number = $_POST['receipt_number'];

    $stmt = $conn->prepare("SELECT file_path FROM medical_records WHERE receipt_number = ?");
    $stmt->bind_param("s", $receipt_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $file_path = $row['file_path'];
        $record_message = "<div class='record-link'>Download your medical record: <a href='$file_path' target='_blank'>Click here</a></div>";
    } else {
        $record_message = "<div class='no-record'>No record found for this receipt number.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Medical Record</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="medical-record-section">
        <h2>Retrieve Medical Record</h2>
        <form method="post" class="medical-record-form">
            <label for="receipt_number">Enter Receipt Number:</label>
            <input type="text" id="receipt_number" name="receipt_number" required placeholder="Enter your receipt number">
            <button type="submit">Search</button>
        </form>

         <!-- This is where the result will be displayed -->
         <div id="record-result">
            <?php echo $record_message; ?>
        </div>
    </div>
</body>
</html>

