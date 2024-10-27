<?php include 'db_connect.php'; session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Your Applications</h2>
        <table>
            <tr>
                <th>Application Type</th>
                <th>Status</th>
            </tr>
            <?php
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT type, status FROM applications WHERE user_id='$user_id'";
            $result = $conn->query($sql);

            while ($app = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$app['type']}</td>
                        <td>{$app['status']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
