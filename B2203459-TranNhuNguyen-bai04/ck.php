<!DOCTYPE html>
<?php
$cookie_name = "user";
$cookie_value = "Tran Nhu Nguyen";
setcookie($cookie_name, $cookie_value, time() + (86400 / 24), "/"); // 86400 = 24*3600 = 1 day
?>
<html>
<body>
<?php
if (!isset($_COOKIE[$cookie_name])) {
    echo "Cookie tên '" . $cookie_name . "' chưa được thiết lập, bạn vui lòng bấm F5 để thiết lập cookie!";
} else {
    echo "Cookie '" . $cookie_name . "' đã được thiết lập!<br>";
    echo "Giá trị là: " . $_COOKIE[$cookie_name];
}
?>
<p><strong>Lưu ý:</strong> Bạn có thể phải tải lại trang để thấy giá trị của cookie.</p>
</body>
</html>