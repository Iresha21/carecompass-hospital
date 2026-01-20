<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $service = $_POST['service'];

    // Generate unique receipt number
    $receipt = "RCPT-" . time() . rand(100, 999); // Example: RCPT-171239823456


    // Insert into database with amount
    $sql = "INSERT INTO service_registrations (name, phone, address, service, receipt_number, amount) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssd", $name, $phone, $address, $service, $receipt, $amount);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful! Your receipt number is: $receipt');
        window.location.href = 'services.php'; // Redirect to the services page
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Service</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Register for <?php echo htmlspecialchars($_GET['service'] ?? 'Service'); ?></h2>
    
    <form method="post">
        <input type="hidden" name="service" value="<?php echo htmlspecialchars($_GET['service'] ?? ''); ?>">
        
        <label for="name">Full Name:</label>
        <input type="text" name="name" required>
        
        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" required>
        
        <label for="address">Address:</label>
        <input type="text" name="address" required>

        <p><strong>Receipt Number:</strong> Will be generated after submission</p>

        <button type="submit">Register Now</button>
    </form>
</body>
</html>
