<?php
session_start();
include "header.php";
include 'db_connect.php';

$receipt_number = "";
$amount = 0;
$payment_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_receipt'])) {
    $receipt_number = $_POST['receipt_number'];
    $sql = "SELECT amount, payment_status FROM service_registrations WHERE receipt_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receipt_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $amount = $row['amount'];
        $payment_status = $row['payment_status'];
    } else {
        echo "<script>alert('Invalid Receipt Number');</script>";
    }
}

// Handle Payment Confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_now'])) {
    $receipt_number = $_POST['receipt_number'];

    // Update payment status in the database
    $update_sql = "UPDATE service_registrations SET payment_status = 'Paid' WHERE receipt_number = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("s", $receipt_number);

    if ($update_stmt->execute()) {
        echo "<script>
                alert('Payment Successful! Redirecting to homepage...');
                window.location.href = 'index.php'; 
              </script>";
        exit();
    } else {
        echo "<script>alert('Error processing payment. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Portal</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div class="payment-page">
    <h2>Make a Payment</h2>

    <!-- Search for receipt -->
    <form method="post">
        <label for="receipt_number">Enter Receipt Number:</label>
        <input type="text" name="receipt_number" required>
        <button type="submit" name="search_receipt">Search</button>
    </form>

    <!-- Payment Form (Only if receipt is valid and pending) -->
    <?php if ($amount > 0 && $payment_status == "Pending") { ?>
        <h3>Service Amount: Rs.<?= number_format($amount, 2) ?></h3>
        <form method="post">
            <input type="hidden" name="receipt_number" value="<?= htmlspecialchars($receipt_number) ?>">
            
            <label for="card_name">Cardholder Name:</label>
            <input type="text" name="card_name" required>
            
            <label for="card_number">Card Number:</label>
            <input type="text" name="card_number" pattern="\d{16}" maxlength="16" required>
            
            <label for="expiry_date">Expiry Date:</label>
            <input type="month" name="expiry_date" required>
            
            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" pattern="\d{3}" maxlength="3" required>
            
            <button type="submit" name="pay_now">Confirm Payment</button>
        </form>
    <?php } elseif ($payment_status == "Paid") { ?>
        <p style="color: green;"><strong>Payment already completed for this receipt.</strong></p>
    <?php } ?>

</body>
</html>

<?php $conn->close(); ?>
