<?php 
include 'db_connect.php'; 
session_start();

$message = '';
$submission_success = false;

if (isset($_POST['submit_birth_certificate'])) {
    $user_id = $_SESSION['user_id'];
    $uploadsDir = 'uploads/';
    $marriageCertificatePath = '';

    // Ensure uploads directory exists
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    // Handle marriage certificate file upload
    if (isset($_FILES['marriage_certificate']) && $_FILES['marriage_certificate']['error'] == 0) {
        $marriageCertificatePath = $uploadsDir . basename($_FILES['marriage_certificate']['name']);
        if (!move_uploaded_file($_FILES['marriage_certificate']['tmp_name'], $marriageCertificatePath)) {
            $message = "Error uploading Marriage Certificate.";
        }
    }

    // JSON encode application data
    $data = json_encode([
        "name" => $_POST['name'],
        "father_name" => $_POST['father_name'],
        "mother_name" => $_POST['mother_name'],
        "marriage_certificate" => $marriageCertificatePath
    ]);

    // Insert data into applications table
    $sql = "INSERT INTO applications (user_id, type, data) VALUES ('$user_id', 'birth_certificate', '$data')";
    if ($conn->query($sql) === TRUE) {
        $submission_success = true;
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
    <title>Birth Certificate Application</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Apply for Birth Certificate</h2>
        <form action="birth_certificate_form.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="father_name" placeholder="Father's Name" required>
            <input type="text" name="mother_name" placeholder="Mother's Name" required>
            
            <label for="marriage_certificate" class="upload-label">Upload Marriage Certificate</label>
            <input type="file" name="marriage_certificate" id="marriage_certificate" required>

            <button type="submit" name="submit_birth_certificate">Apply</button>
        </form>

        <!-- Display error or success message -->
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Display applications -->
        <div class="applications">
            <?php
            $sql = "SELECT applications.id, users.username, applications.data 
                    FROM applications 
                    JOIN users ON applications.user_id = users.id 
                    WHERE applications.type = 'birth_certificate' AND applications.status IS NULL"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Applicant Name</th>
                            <th>Details</th>
                            <th>Action</th>
                            <th>Documents</th>
                        </tr>";
                while ($app = $result->fetch_assoc()) {
                    $data = json_decode($app['data'], true); 
                    $details = "<p>Name: {$data['name']}<br>
                                Father's Name: {$data['father_name']}<br>
                                Mother's Name: {$data['mother_name']}</p>";
                    $documents = "<a href='" . ($data['marriage_certificate'] ?? '#') . "' target='_blank'>View Marriage Certificate</a>";

                    echo "<tr>
                            <td>{$app['username']}</td>
                            <td>$details</td>
                            <td><a href='approve.php?id={$app['id']}'>Approve</a></td>
                            <td>$documents</td>
                          </tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
    </div>
</body>
</html>
