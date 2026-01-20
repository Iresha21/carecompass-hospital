<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
</head>
<body>
    <?php include 'header.php'; ?>
    <section class="form-section">
        <h2>Login</h2>
        <form method="post" action="login.php">
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit">Login</button>
        </form>
    </section>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.querySelector(".toggle-password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>




<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Fetch user details
    $stmt = $conn->prepare("SELECT user_id, full_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $full_name, $hashed_password, $role);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            // Allow only admin and staff
            if ($role == 'admin' || $role == 'staff') {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['role'] = $role;
                
                // Redirect based on role
                if ($role == 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: staff_dashboard.php");
                }
                exit();
            } else {
                echo "Access denied! Only admins and staff can log in.";
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
    
    $stmt->close();
    $conn->close();
}
?>

