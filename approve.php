<?php
include 'db_connect.php';
session_start();


if (isset($_GET['id'])) {
    $app_id = $_GET['id'];

    
    $sql = "UPDATE applications SET status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $app_id);

    if ($stmt->execute()) {
        $message = "Application approved successfully.";
    } else {
        $error_message = "Error: " . $conn->error;
    }

    $stmt->close();
}


$sql = "SELECT applications.id, users.username, applications.type, applications.status 
        FROM applications JOIN users ON applications.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Approve Applications</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Approve Applications</h2>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <table>
            <tr>
                <th>Applicant Name</th>
                <th>Application Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($app = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $app['username']; ?></td>
                    <td><?php echo $app['type']; ?></td>
                    <td><?php echo $app['status']; ?></td>
                    <td>
                        <?php if ($app['status'] !== 'approved'): ?>
                            <a href="approve.php?id=<?php echo $app['id']; ?>" class="dashboard-button">Approve</a>
                        <?php else: ?>
                            Approved
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
