<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'staff'; // Only adding staff

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $password, $role);

    if ($stmt->execute()) {
        echo "Staff added successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error adding staff!";
    }

    $stmt->close();
}
// Fetch all staff members
$stmt = $conn->prepare("SELECT user_id, full_name, email FROM users WHERE role = 'staff'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <h2>Add New Staff</h2>
    <form method="post">
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Add Staff</button>
    </form>
    <hr>
    <table border="1">
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="edit_staff.php?id=<?php echo $row['user_id']; ?>">Edit</a> | 
                <a href="delete_staff.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
