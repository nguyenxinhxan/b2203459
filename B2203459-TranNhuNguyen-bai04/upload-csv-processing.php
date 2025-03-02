<?php
$servername = "localhost";
$username = "root";  // Cập nhật với tên đăng nhập của bạn
$password = "";      // Cập nhật với mật khẩu của bạn
$dbname = "qlbanhang";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_FILES["csv_file"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["csv_file"]["name"]);

        // Di chuyển tệp tải lên vào thư mục mục tiêu
        if (move_uploaded_file($_FILES["csv_file"]["tmp_name"], $target_file)) {
            echo "Tệp " . basename($_FILES["csv_file"]["name"]) . " đã được tải lên.";

            // Mở tệp CSV và đọc nội dung của nó
            if (($handle = fopen($target_file, "r")) !== FALSE) {
                fgetcsv($handle); // Bỏ qua dòng tiêu đề
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Băm mật khẩu thành chuỗi hex sử dụng SHA-256
                    $hashed_password = hash('sha256', $data[4]);

                    $stmt = $conn->prepare("INSERT INTO customers (id, fullname, email, Birthday, password, img_profile) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssss", $data[0], $data[1], $data[2], $data[3], $hashed_password, $data[5]);
                    $stmt->execute();
                }
                fclose($handle);
            }
            $conn->close();
        } else {
            echo "Xin lỗi, đã xảy ra lỗi khi tải lên tệp của bạn.";
        }
    } else {
        echo "Không có tệp nào được chọn.";
    }
}
?>
