<?php
session_start();
include 'db_connect.php';

// Ensure staff is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    die("Access denied. Staff only.");
}

// Fetch all registered services
$sql = "SELECT id, name, phone, address, service, receipt_number, registered_at, payment_status
        FROM service_registrations 
        ORDER BY registered_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Services - Staff Dashboard</title>
    <link rel="stylesheet" href="staff_dashboard.css">
</head>
<body>
    <h2>Registered Services</h2>
    
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Service</th>
                <th>Receipt Number</th>
                <th>Registered At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['service']) ?></td>
                    <td><?= htmlspecialchars($row['receipt_number']) ?></td>
                    <td><?= $row['registered_at'] ?></td>
                    <td><?= $row['payment_status'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>
