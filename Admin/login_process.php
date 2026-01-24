<?php
session_start();
require_once "../config.php";
require_once "../Models/db.php";

$db = new Db();

if (isset($_POST['btn_login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Khởi tạo kết nối
    $db = new Db();

    // 2. Truy vấn - Đảm bảo bảng customers đã được chạy lệnh ALTER TABLE ở Bước 1
    $sql = "SELECT c.*, r.role_name 
            FROM customers c 
            JOIN roles r ON c.role_id = r.id 
            WHERE c.email = ?";

    $stmt = Db::$connection->prepare($sql);

    if (!$stmt) {
        die("Lỗi truy vấn: " . Db::$connection->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // 3. Kiểm tra mật khẩu
    if ($user && password_verify($password, $user['password_hash'])) {
        // Lưu thông tin vào Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['rank'] = $user['rank'];

        // Chuyển hướng về trang chủ (index.php) nằm ở thư mục gốc
        $admin_roles = [1, 2, 3, 4, 5];

        if (in_array($user['role_id'], $admin_roles)) {
            // Nếu thuộc nhóm quản trị, chuyển đến trang Dashboard của Admin
            header("Location: Dashboard.php");
        } else {
            // Nếu là khách hàng (6: VIP, 7: Standard), chuyển về trang chủ người dùng
            header("Location: ../index.php");
        }
        exit();
    } else {
        // Sai tài khoản hoặc mật khẩu
        header("Location: login.php?error=invalid");
        exit();
    }
}
