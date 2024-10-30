<?php
include 'db_connect.php';

if (isset($_POST['application_id']) && isset($_POST['status']) && isset($_POST['type'])) {
    $applicationId = $_POST['application_id'];
    $status = $_POST['status'];
    $type = $_POST['type'];

    $sql = "UPDATE applications SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $applicationId);

    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: admin_dashboard.php?type=" . $type);
    exit();
}
?>
