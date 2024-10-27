<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       
        .dashboard-button {
            display: inline-block !important;
            background-color: #4CAF50 !important;
            color: white !important;
            padding: 10px !important;
            margin: 8px 0 !important;
            border-radius: 4px !important;
            text-align: center !important;
            text-decoration: none !important; 
            width: calc(100% - 16px) !important; 
            box-sizing: border-box !important;
        }

        .dashboard-button:hover {
            background-color: #45a049 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Applicant Dashboard</h2>
        <div class="dashboard-container">
            <a href="passport_form.php" class="dashboard-button">Apply for Passport</a>
            <a href="birth_certificate_form.php" class="dashboard-button">Apply for Birth Certificate</a>
            <a href="death_certificate_form.php" class="dashboard-button">Apply for Death Certificate</a>
            <a href="application_status.php" class="dashboard-button">Check Application Status</a>
        </div>
    </div>
</body>
</html>
