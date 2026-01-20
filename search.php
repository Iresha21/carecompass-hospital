<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

// Get the search query from the URL
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

$doctors = [];
$services = [
    "diabetes_scan" => "Diabetes Scan",
    "blood_test" => "Blood Test",
    "brain_spine_scan" => "Brain & Spine Scan",
    "mri_scan" => "MRI Scan",
    "ct_scan" => "CT Scan"
];

// If a search query is provided, search in the `doctors` table
if ($searchQuery) {
    $searchPattern = "%$searchQuery%";
    $sql = "SELECT doctor_id, full_name, specialty, image, contact_info, qualifications FROM doctors WHERE full_name LIKE ? OR specialty LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $searchPattern, $searchPattern);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }

    // Filter static services based on search
    $matchedServices = [];
    foreach ($services as $key => $service) {
        if (stripos($service, $searchQuery) !== false) {
            $matchedServices[$key] = $service;
        }
    }
} else {
    $matchedServices = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<h2>Search Results for "<?= htmlspecialchars($searchQuery) ?>"</h2>

<!-- Doctors Results -->
<?php if (!empty($doctors)): ?>
    <h3>Doctors:</h3>
    <div class="doctor-cards">
        <?php foreach ($doctors as $doctor): ?>
            <div class="doctor-card <?= isset($doctor['highlight']) ? 'highlight' : '' ?>">
                <img src="<?= htmlspecialchars($doctor['image'] ?? 'default-doctor.png') ?>" alt="Doctor Image">
                <div class="doctor-card-content">
                    <h3><?= htmlspecialchars($doctor['full_name']) ?></h3>
                    <p class="doctor-specialty"><?= htmlspecialchars($doctor['specialty']) ?></p>
                    <p>Qualifications: <?= htmlspecialchars($doctor['qualifications'] ?? 'N/A') ?></p>
                    <p>Contact: <?= htmlspecialchars($doctor['contact_info'] ?? 'N/A') ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<!-- Services Results -->
<?php if (!empty($matchedServices)): ?>
    <h3>Services:</h3>
    <ul>
        <?php foreach ($matchedServices as $key => $service): ?>
            <!-- Redirect to services.php and highlight matched service -->
            <script>
                window.location.href = 'services.php?highlight=<?= urlencode($key) ?>';
            </script>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- No Results Found -->
<?php if (empty($doctors) && empty($matchedServices)): ?>
    <p>No results found for "<?= htmlspecialchars($searchQuery) ?>".</p>
<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
