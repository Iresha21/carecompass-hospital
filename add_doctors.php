<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM doctors WHERE doctor_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header("Location: add_doctors.php"); // Reload the page after deletion
        exit();
    } else {
        echo "Error deleting doctor!";
    }
}

// Handle form submission to add a new doctor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $full_name = $_POST['full_name'];
    $specialty = $_POST['specialty'];
    $qualifications = $_POST['qualifications'];
    $contact_info = $_POST['contact_info'];
    $available_days = $_POST['available_days'];
    $available_time = $_POST['available_time'];

    // Handle image upload
    $target_dir = "uploads/doctors/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }

    $image_path = "";
    if (!empty($_FILES["image"]["name"])) {
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Save the file path
        } else {
            die("Error uploading image.");
        }
    }

    // Insert doctor data into the database
    $stmt = $conn->prepare("INSERT INTO doctors (full_name, specialty, qualifications, contact_info, available_days, available_time, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $full_name, $specialty, $qualifications, $contact_info, $available_days, $available_time, $image_path);

    if ($stmt->execute()) {
        // Success: Redirect to the same page to show the new doctor
        header("Location: add_doctors.php");
        exit();
    } else {
        // Error: Display error message
        echo "Error adding doctor!";
    }

    $stmt->close();
}

// Fetch all doctors from the database
$result = $conn->query("SELECT * FROM doctors");
?>

<!-- HTML Form for Adding Doctor -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="admin-container">
        <h2>Add Doctor</h2>

        <!-- Add Doctor Form -->
        <form action="add_doctors.php" method="POST" enctype="multipart/form-data">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" required>

            <label for="specialty">Specialty:</label>
            <select name="specialty" required>
                <option value="Cardiology">Cardiology</option>
                <option value="Neurology">Neurology</option>
                <option value="Orthopedics">Orthopedics</option>
                <option value="Pediatrics">Pediatrics</option>
            </select>

            <label for="qualifications">Qualifications:</label>
            <input type="text" name="qualifications" required>

            <label for="contact_info">Contact Info:</label>
            <input type="text" name="contact_info" required>

            <label for="available_days">Available Days:</label>
            <input type="text" name="available_days" required>

            <label for="available_time">Available Time:</label>
            <input type="text" name="available_time" required>

            <label for="image">Doctor's Photo (Passport Size):</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Doctor</button>
        </form>

        <hr>

        <!-- Display the list of doctors -->
        <h3>Existing Doctors</h3>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Specialty</th>
                    <th>Qualifications</th>
                    <th>Contact Info</th>
                    <th>Available Days</th>
                    <th>Available Time</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($doctor = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doctor['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['specialty']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['qualifications']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['contact_info']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['available_days']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['available_time']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($doctor['image']); ?>" alt="Doctor's Image" width="100"></td>
                        <td>
                        <div class="action-buttons">
                            <!-- Update Button -->
                            <a href="update_doctor.php?doctor_id=<?php echo $doctor['doctor_id']; ?>">Update</a>
                            <!-- Delete Button -->
                            <a href="add_doctors.php?delete_id=<?php echo $doctor['doctor_id']; ?>" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</a>
                </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
