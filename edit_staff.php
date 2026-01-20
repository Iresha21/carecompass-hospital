<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT full_name, email FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $stmt->bind_result($full_name, $email);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $full_name, $email, $staff_id);

    if ($stmt->execute()) {
        echo "Staff updated successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating staff!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <h2>Edit Staff</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $staff_id; ?>">
        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        <button type="submit">Update Staff</button>
    </form>
</body>
</html>
