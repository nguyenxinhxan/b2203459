<?php
session_start();

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

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);

    // Sử dụng câu lệnh SQL Injection để tránh trước
    $stmt = $conn->prepare("SELECT id, fullname, email FROM customers WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Đăng nhập thành công";
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['email'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['id'] = $row['id'];
        header('Location: homepage.php');
    } else {
        echo "Invalid username or password!";
        // Tro ve trang dang nhap sau 3 giay
        header('Refresh: 3;url=login.php');
    }
    $stmt->close();
} else {
    echo "Please enter email and password.";
}

$conn->close();
?>
