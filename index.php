<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://kit.fontawesome.com/YOUR-FONT-AWESOME-KEY.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="home-section">
        <h1>Welcome to Care Compass Hospitals</h1>
        <p>For Your Better Health</p>
        <div class="home-links">
            <a href="appointments.php" class="home-btn"><i class="fas fa-calendar-check"></i> Manage Appointments</a>
            <a href="doctors.php" class="home-btn"><i class="fas fa-user-md"></i> View Doctors</a>
            <a href="medical_records.php" class="home-btn"><i class="fas fa-file-medical"></i> Medical Records</a>
            <a href="payments.php" class="home-btn"><i class="fas fa-credit-card"></i> Payments</a>
        </div>

        <div class="info-section">
            <div class="info-box">
                <i class="fas fa-hospital"></i>
                <h3>24/7 Emergency</h3>
                <p>We are always here to provide emergency healthcare services.</p>
            </div>
            <div class="info-box">
                <i class="fas fa-stethoscope"></i>
                <h3>Expert Doctors</h3>
                <p>Highly qualified doctors to serve your medical needs.</p>
            </div>
            <div class="info-box">
                <i class="fas fa-ambulance"></i>
                <h3>Fast Ambulance</h3>
                <p>Quick ambulance service to assist in emergencies.</p>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us">
        <h2>About Us</h2>
        <p>Care Compass Hospitals has been providing world-class healthcare services for over a decade. Our team of 
           skilled doctors, nurses, and staff are committed to ensuring the best treatment for our patients.</p>
    </section>

    <!-- Our Branches Section -->
    <section class="branches">
        <h2>Our Branches</h2>
        <div class="branch-container">
            <div class="branch">
                <img src="uploads/branch1.jpg" alt="Branch 1">
                <h3>Colombo</h3>
                <p>Located in the heart of Colombo, offering state-of-the-art medical facilities.</p>
            </div>
            <div class="branch">
                <img src="uploads/branch2.jpg" alt="Branch 2">
                <h3>Kandy</h3>
                <p>Bringing world-class healthcare to the Central Province.</p>
            </div>
            <div class="branch">
                <img src="uploads/branch3.jpg" alt="Branch 3">
                <h3>Kurunegala</h3>
                <p>Ensuring quality healthcare services for the Southern Province.</p>
            </div>
        </div>
    </section>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/+94763786696" class="whatsapp-button" target="_blank">
        <img src="uploads/whatsapp.png" alt="WhatsApp"> For inquiries
    </a>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><i class="fas fa-phone"></i> +94 763 786 696</p>
                <p><i class="fas fa-envelope"></i> info@carecompass.com</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
            <div class="footer-section">
                <h3>Location</h3>
                <iframe src="https://www.google.com/maps/embed?..."></iframe>
            </div>
        </div>
    </footer>

</body>
</html>
