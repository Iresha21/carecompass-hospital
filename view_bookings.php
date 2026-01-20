<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'db_connect.php';

// Ensure staff is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    die("Access denied. Staff only.");
}

// Fetch all appointments for staff to view
$appointments_result = $conn->query("SELECT a.id, a.patient_name, d.full_name AS doctor_name, d.specialty, 
                                           DATE_FORMAT(a.appointment_date, '%Y-%m-%d') AS appointment_date, 
                                           DATE_FORMAT(a.appointment_date, '%H:%i') AS appointment_time, 
                                           a.status 
                                     FROM appointments a 
                                     JOIN doctors d ON a.doctor_id = d.doctor_id 
                                     ORDER BY a.appointment_date");

if (!$appointments_result) {
    die("Error fetching appointments: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings - Staff Dashboard</title>
    <link rel="stylesheet" href="staff_dashboard.css">
</head>
<body>
    <h2>View Bookings</h2>

    <h3>All Appointments</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Specialty</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($appointment = $appointments_result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $appointment['id'] ?></td>
                    <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['doctor_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['specialty']) ?></td>
                    <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                    <td><?= htmlspecialchars($appointment['status']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
