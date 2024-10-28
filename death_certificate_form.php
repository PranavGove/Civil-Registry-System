<?php 
include 'db_connect.php'; 
session_start();

$message = '';

if (isset($_POST['submit_death_certificate'])) {
    $user_id = $_SESSION['user_id'];
    $uploadsDir = 'uploads/';
    
    // Ensure uploads directory exists
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    // Initialize the path for the medical report
    $medicalReportPath = '';

    // Handle medical report file upload
    if (isset($_FILES['medical_report']) && $_FILES['medical_report']['error'] == 0) {
        $medicalReportPath = $uploadsDir . basename($_FILES['medical_report']['name']);
        if (!move_uploaded_file($_FILES['medical_report']['tmp_name'], $medicalReportPath)) {
            $message = "Error uploading Medical Report.";
        }
    }

    // Create JSON object for storing the application data
    $data = json_encode([
        "name" => $_POST['name'],
        "cause_of_death" => $_POST['cause_of_death'],
        "medical_report" => $medicalReportPath
    ]);

    // Insert application data into the database
    $sql = "INSERT INTO applications (user_id, type, data) VALUES ('$user_id', 'death_certificate', '$data')";
    if ($conn->query($sql) === TRUE) {
        header("Location: success.php");
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Death Certificate Application</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Apply for Death Certificate</h2>
        <form action="death_certificate_form.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="cause_of_death" placeholder="Cause of Death" required>

            <label for="medical_report" class="upload-label">Upload Medical Report</label>
            <input type="file" name="medical_report" id="medical_report" required>

            <button type="submit" name="submit_death_certificate">Apply</button>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
