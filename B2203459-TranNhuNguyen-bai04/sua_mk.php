<?php
session_start();

if (!isset($_SESSION['fullname'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = md5($_POST['old_password']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu cũ
    $stmt = $conn->prepare("SELECT password FROM customers WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($old_password != $row['password']) {
        echo "Old password is incorrect!!";
    } elseif ($new_password != $confirm_password) {
        echo "New passwords do not match!";
    } elseif ($old_password == md5($new_password)) {
        echo "New password cannot be the same as the old password!!";
    } else {
        // Cập nhật mật khẩu mới
        $new_password_hashed = md5($new_password);
        $update_stmt = $conn->prepare("UPDATE customers SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_password_hashed, $_SESSION['id']);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            echo "Password changed successfully!";
        } else {
            echo "An error occurred, please try again.";
        }
        // Kiểm tra nếu biến $update_stmt đã được định nghĩa
        if (isset($update_stmt)) {
            $update_stmt->close();
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đổi Mật Khẩu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <div class="w3-container">
        <h2>Change Password</h2>
        <form action="sua_mk.php" method="POST">
            Old password: <input type="password" name="old_password" required><br>
            New password: <input type="password" name="new_password" required><br>
            Confirm password: <input type="password" name="confirm_password" required><br>
            <button type="submit">Change password</button>
        </form>
    </div>
</body>
</html>
