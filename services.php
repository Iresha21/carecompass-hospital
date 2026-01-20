<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="index.css"> <!-- Add your CSS file -->
   
</head>
<body>
<?php include('header.php'); ?>
<h2 class="services-title">Our Medical Services</h2>

<div class="services-container">
    <?php
    // Define services
    $services = [
        "diabetes_scan" => ["Diabetes Scan", "Check blood sugar levels to detect diabetes early and manage health conditions effectively.", "uploads/services/diabetes_scan.jpg"],
        "blood_test" => ["Blood Test", "A comprehensive blood analysis to assess overall health and detect underlying conditions.", "uploads/services/blood_test.jpg"],
        "brain_spine_scan" => ["Brain & Spine Scan", "Advanced imaging to diagnose neurological disorders, spinal injuries, and brain conditions.", "uploads/services/brain_spine_scan.jpg"],
        "mri_scan" => ["MRI Scan", "Detailed body imaging using magnetic fields to detect abnormalities in soft tissues and organs.", "uploads/services/mri_scan.jpg"],
        "ct_scan" => ["CT Scan", "3D imaging technique for a detailed view of bones, organs, and tissues for accurate diagnosis.", "uploads/services/ct_scan.jpg"]
    ];

    // Get the highlighted service from the URL (if any)
    $highlightedService = isset($_GET['highlight']) ? htmlspecialchars($_GET['highlight']) : '';

    foreach ($services as $key => $service) {
        $isHighlighted = ($key === $highlightedService) ? 'highlight' : '';
        echo "
        <div class='service-card $isHighlighted'>
            <img src='{$service[2]}' alt='{$service[0]}'>
            <h3>{$service[0]}</h3>
            <p>{$service[1]}</p>
            <a href='register_service.php?service=" . urlencode($service[0]) . "'>
                <button>Register Now</button>
            </a>
        </div>";
    }
    ?>
</div>

</body>
</html>
