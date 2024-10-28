<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>

        <!-- Error Message -->
        <?php
        session_start();
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] === 'applicant') {
                    header("Location: applicant_dashboard.php");
                } else {
                    header("Location: admin_dashboard.php");
                }
                exit;
            } else {
                echo "<p class='error-message' style='color: red; text-align: center; margin-top: 10px;'>Invalid username or password</p>";

            }
        }
        ?>
    </form>
</body>
</html>
