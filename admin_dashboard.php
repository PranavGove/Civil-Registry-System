<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="options">
            <h3>Manage Applications</h3>
            <ul>
                <li><a href="?type=passport">Passport Applications</a></li>
                <li><a href="?type=birth_certificate">Birth Certificate Applications</a></li>
                <li><a href="?type=death_certificate">Death Certificate Applications</a></li>
            </ul>
        </div>

        <div class="applications">
            <?php
            if (isset($_GET['type'])) {
                $type = $_GET['type'];
                $sql = "SELECT applications.id, users.username, applications.data, applications.status 
                        FROM applications JOIN users ON applications.user_id = users.id 
                        WHERE applications.type = '$type'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>Applicant Name</th>
                                <th>Details</th>
                                <th>Documents</th>
                                <th>Status</th>
                            </tr>";
                    while ($app = $result->fetch_assoc()) {
                        $data = json_decode($app['data'], true); 
                        $details = '';
                        $documents = '';

                        // Display applicant details based on the application type
                        switch ($type) {
                            case 'passport':
                                $details = "First Name: {$data['first_name']}<br>
                                            Middle Name: {$data['middle_name']}<br>
                                            Last Name: {$data['last_name']}<br>
                                            Aadhaar Number: {$data['aadhaar_number']}";
                                $documents = "<a href='" . ($data['aadhaar_photo'] ?? '#') . "' target='_blank'>" . ($data['aadhaar_photo'] ? "View Aadhaar Photo" : "Aadhaar Photo Not Uploaded") . "</a> | 
                                              <a href='" . ($data['nationality_certificate'] ?? '#') . "' target='_blank'>" . ($data['nationality_certificate'] ? "View Nationality Certificate" : "Nationality Certificate Not Uploaded") . "</a>";
                                break;
                            case 'birth_certificate':
                                $details = "Name: {$data['name']}<br>
                                            Father's Name: {$data['father_name']}<br>
                                            Mother's Name: {$data['mother_name']}";
                                $documents = "<a href='" . ($data['marriage_certificate'] ?? '#') . "' target='_blank'>" . ($data['marriage_certificate'] ? "View Marriage Certificate" : "Marriage Certificate Not Uploaded") . "</a>";
                                break;
                            case 'death_certificate':
                                $details = "Name: {$data['name']}<br>
                                            Cause of Death: {$data['cause_of_death']}";
                                $documents = "<a href='" . ($data['medical_report'] ?? '#') . "' target='_blank'>" . ($data['medical_report'] ? "View Medical Report" : "Medical Report Not Uploaded") . "</a>";
                                break;
                        }

                        // Dropdown to select status
                        echo "<tr>
                                <td>{$app['username']}</td>
                                <td>$details</td>
                                <td>$documents</td>
                                <td>
                                    <form action='update_status.php' method='POST'>
                                        <input type='hidden' name='application_id' value='{$app['id']}'>
                                        <input type='hidden' name='type' value='$type'>
                                        <select name='status' onchange='this.form.submit()'>
                                            <option value='verifying documents' " . ($app['status'] == 'verifying documents' ? "selected" : "") . ">Verifying Documents</option>
                                            <option value='checking background' " . ($app['status'] == 'checking background' ? "selected" : "") . ">Checking Background</option>
                                            <option value='in final review' " . ($app['status'] == 'in final review' ? "selected" : "") . ">In Final Review</option>
                                            <option value='approved' " . ($app['status'] == 'approved' ? "selected" : "") . ">Approved</option>
                                        </select>
                                    </form>
                                </td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No applications found for this type.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
