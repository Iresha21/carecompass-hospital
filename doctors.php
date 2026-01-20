<?php
include "header.php";
include 'db_connect.php';

// Fetch doctors from the database
$result = $conn->query("SELECT * FROM doctors");

// Categorize doctors by specialty
$categories = ['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div class="doctors-page">
        <!-- Title -->
        <h1 class="doctor-title">Our Doctors</h1>

        <!-- Filter by specialty -->
        <div class="categories">
            <?php foreach ($categories as $category): ?>
                <button class="category-btn" data-category="<?= $category ?>"><?= $category ?></button>
            <?php endforeach; ?>
        </div>

        <div class="doctor-cards">
            <?php while ($doctor = $result->fetch_assoc()): ?>
                <div class="doctor-card" data-specialty="<?= $doctor['specialty'] ?>">
                    <img src="<?= htmlspecialchars($doctor['image']) ?>" alt="Doctor Image" class="doctor-image">
                    <div class="doctor-card-content">
                        <h3 class="doctor-name"><?= htmlspecialchars($doctor['full_name']) ?></h3>
                        <p class="doctor-specialty"><?= htmlspecialchars($doctor['specialty']) ?></p>
                        <p class="doctor-qualifications"><?= htmlspecialchars($doctor['qualifications']) ?></p>
                        <p class="doctor-contact">Contact: <?= htmlspecialchars($doctor['contact_info']) ?></p>
                        <p class="doctor-availability">Available on: <?= htmlspecialchars($doctor['available_days']) ?> at <?= htmlspecialchars($doctor['available_time']) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        // Filter doctors by specialty
        const buttons = document.querySelectorAll('.category-btn');
        const cards = document.querySelectorAll('.doctor-card');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;

                cards.forEach(card => {
                    if (card.dataset.specialty === category || category === 'All') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>
</html>
