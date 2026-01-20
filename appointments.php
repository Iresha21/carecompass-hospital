<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "header.php";
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $doctor_id = $_POST['doctor_id'];
    $patient_name = $_POST['patient_name'];
    $contact_info = $_POST['contact_info'];
    $appointment_date = $_POST['appointment_date'];

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO appointments (doctor_id, patient_name, contact_info, appointment_date, status) VALUES (?, ?, ?, ?, 'Scheduled')");
    $stmt->bind_param("isss", $doctor_id, $patient_name, $contact_info, $appointment_date);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect with success message
        echo "<script>alert('Appointment booked successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error booking appointment!";
    }

    // Close the prepared statement and connection
    $stmt->close();
}

// Fetch doctors and group them by specialty
$sql = "SELECT * FROM doctors ORDER BY specialty, full_name";
$result = $conn->query($sql);

// Initialize an empty array to group doctors by specialty
$doctors_by_specialty = [];

while ($doctor = $result->fetch_assoc()) {
    $specialty = $doctor['specialty'];
    $doctors_by_specialty[$specialty][] = $doctor;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="appointment-section">
    <h2>Book an Appointment</h2>
    <form action="appointments.php" method="POST" class="appointment-form">
        <label for="doctor_id">Select Doctor:</label>
        <select name="doctor_id" required>
            <?php 
            // Loop through the specialties
            foreach ($doctors_by_specialty as $specialty => $doctors) { 
            ?>
                <optgroup label="<?= htmlspecialchars($specialty) ?>">
                    <?php 
                    // Loop through doctors in this specialty
                    foreach ($doctors as $doctor) {
                    ?>
                        <option value="<?= $doctor['doctor_id'] ?>"><?= htmlspecialchars($doctor['full_name']) ?></option>
                    <?php } ?>
                </optgroup>
            <?php } ?>
        </select>

        <label for="patient_name">Full Name:</label>
        <input type="text" name="patient_name" required>

        <label for="contact_info">Contact Info:</label>
        <input type="text" name="contact_info" required>

        <label for="appointment_date">Preferred Date & Time:</label>
        <input type="datetime-local" name="appointment_date" required>

        <button type="submit">Book Appointment</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
