<?php 
include 'db_connect.php'; 
session_start();


$message = '';

if (isset($_POST['submit_passport'])) {
    $user_id = $_SESSION['user_id'];
    
    
    $uploadsDir = 'uploads/';
    
    
    $aadhaarPhotoPath = '';
    $nationalityCertificatePath = '';
    
    
    if (isset($_FILES['aadhaar_photo']) && $_FILES['aadhaar_photo']['error'] == 0) {
        $aadhaarPhotoPath = $uploadsDir . basename($_FILES['aadhaar_photo']['name']);
        if (!move_uploaded_file($_FILES['aadhaar_photo']['tmp_name'], $aadhaarPhotoPath)) {
            $message = "Error uploading Aadhaar photo.";
        }
    }
    
    
    if (isset($_FILES['nationality_certificate']) && $_FILES['nationality_certificate']['error'] == 0) {
        $nationalityCertificatePath = $uploadsDir . basename($_FILES['nationality_certificate']['name']);
        if (!move_uploaded_file($_FILES['nationality_certificate']['tmp_name'], $nationalityCertificatePath)) {
            $message = "Error uploading Nationality Certificate.";
        }
    }
    
    
    $data = json_encode([
        "first_name" => $_POST['first_name'],
        "middle_name" => $_POST['middle_name'],
        "last_name" => $_POST['last_name'],
        "aadhaar_number" => $_POST['aadhaar_number'],
        "aadhaar_photo" => $aadhaarPhotoPath,
        "nationality_certificate" => $nationalityCertificatePath
    ]);
    
    
    $sql = "INSERT INTO applications (user_id, type, data) VALUES ('$user_id', 'passport', '$data')";
    if ($conn->query($sql) === TRUE) {
        $message = "Passport application submitted successfully.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Passport Application</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Passport Application</h1>
        <form action="passport_form.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="middle_name" placeholder="Middle Name">
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="aadhaar_number" placeholder="Aadhaar Number" required>
            
            
            <label for="aadhaar_photo" class="upload-label">Upload Aadhaar</label>
            <input type="file" name="aadhaar_photo" id="aadhaar_photo" required>

            
            <label for="nationality_certificate" class="upload-label">Upload Nationality Certificate</label>
            <input type="file" name="nationality_certificate" id="nationality_certificate" required>
            
            <button type="submit" name="submit_passport">Apply</button>
        </form>
        
        
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
