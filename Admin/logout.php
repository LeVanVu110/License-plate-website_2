<?php
// 1. Khởi động session
session_start();

// 2. Xóa sạch tất cả các biến session
$_SESSION = array();

// 3. Nếu muốn xóa hoàn toàn session cookie, hãy thực hiện lệnh này (tùy chọn nhưng nên làm)
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// 4. Hủy bỏ session trên server
session_destroy();

// 5. Chuyển hướng về trang chủ hoặc trang đăng nhập
header("Location: login.php");
exit();
?>