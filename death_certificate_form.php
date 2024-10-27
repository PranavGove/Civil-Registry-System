<?php 
include 'db_connect.php'; 
session_start();
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
        
        <?php
        if (isset($_POST['submit_death_certificate'])) {
            $user_id = $_SESSION['user_id'];
            $uploadDirectory = 'uploads/';

            
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            
            if (isset($_FILES['medical_report']) && $_FILES['medical_report']['error'] == 0) {
                $file = $_FILES['medical_report'];
                $filePath = $uploadDirectory . basename($file['name']);
                
                
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    
                    $data = json_encode([
                        "name" => $_POST['name'],
                        "cause_of_death" => $_POST['cause_of_death'],
                        "medical_report" => $filePath 
                    ]);
                    
                    
                    $sql = "INSERT INTO applications (user_id, type, data) VALUES ('$user_id', 'death_certificate', '$data')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='message'>Death certificate application submitted successfully.</div>";
                    } else {
                        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
                    }
                } else {
                    echo "<div class='error-message'>Error uploading the medical report.</div>";
                }
            } else {
                echo "<div class='error-message'>No file uploaded or there was an error.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
