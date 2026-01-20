<?php
session_start();
include 'db_connect.php';

// Check if user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Check if the doctor_id is provided in the URL
if (!isset($_GET['doctor_id'])) {
    header("Location: add_doctors.php");
    exit();
}

$doctor_id = $_GET['doctor_id'];

// Fetch doctor data for editing
$stmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

if (!$doctor) {
    die("Doctor not found.");
}

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
    $image_path = $doctor['image']; // Default to the existing image

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }

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
            $image_path = $target_file; // Save the new file path
        } else {
            die("Error uploading image.");
        }
    }

    // Update doctor data in the database
    $stmt = $conn->prepare("UPDATE doctors SET full_name = ?, specialty = ?, qualifications = ?, contact_info = ?, available_days = ?, available_time = ?, image = ? WHERE doctor_id = ?");
    $stmt->bind_param("sssssssi", $full_name, $specialty, $qualifications, $contact_info, $available_days, $available_time, $image_path, $doctor_id);

    if ($stmt->execute()) {
        // Success: Redirect to the same page or any other page
        echo "Doctor updated successfully!";
        header("Location: add_doctors.php");
        exit();
    } else {
        // Error: Display error message
        echo "Error updating doctor!";
    }

    $stmt->close();
}
?>

<!-- HTML Form for Editing Doctor -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Doctor</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="admin-container">
        <h2>Update Doctor</h2>

        <!-- Edit Doctor Form -->
        <form action="update_doctor.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($doctor['full_name']); ?>" required>

            <label for="specialty">Specialty:</label>
            <select name="specialty" required>
                <option value="Cardiology" <?php echo ($doctor['specialty'] == 'Cardiology') ? 'selected' : ''; ?>>Cardiology</option>
                <option value="Neurology" <?php echo ($doctor['specialty'] == 'Neurology') ? 'selected' : ''; ?>>Neurology</option>
                <option value="Orthopedics" <?php echo ($doctor['specialty'] == 'Orthopedics') ? 'selected' : ''; ?>>Orthopedics</option>
                <option value="Pediatrics" <?php echo ($doctor['specialty'] == 'Pediatrics') ? 'selected' : ''; ?>>Pediatrics</option>
            </select>

            <label for="qualifications">Qualifications:</label>
            <input type="text" name="qualifications" value="<?php echo htmlspecialchars($doctor['qualifications']); ?>" required>

            <label for="contact_info">Contact Info:</label>
            <input type="text" name="contact_info" value="<?php echo htmlspecialchars($doctor['contact_info']); ?>" required>

            <label for="available_days">Available Days:</label>
            <input type="text" name="available_days" value="<?php echo htmlspecialchars($doctor['available_days']); ?>" required>

            <label for="available_time">Available Time:</label>
            <input type="text" name="available_time" value="<?php echo htmlspecialchars($doctor['available_time']); ?>" required>

            <label for="image">Doctor's Photo (Passport Size):</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Update Doctor</button>
        </form>
    </div>
</body>
</html>
