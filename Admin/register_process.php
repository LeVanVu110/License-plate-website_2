<?php
session_start();
require_once "../config.php";
require_once "../Models/db.php";

if (isset($_POST['btn_register'])) {
    // Lấy và làm sạch dữ liệu đầu vào
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Khởi tạo kết nối DB
    $db = new Db();

    // 1. Kiểm tra xem email đã tồn tại hay chưa
    $check_sql = "SELECT id FROM customers WHERE email = ?";
    $check_stmt = Db::$connection->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Email đã được sử dụng
        header("Location: login.php?error=email_exists");
        exit();
    }

    // 2. Mã hóa mật khẩu (Bắt buộc để bảo mật)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 3. Chèn người dùng mới vào bảng customers
    // Mặc định role_id = 7 (Standard_User), rank = 'Gold' theo file SQL của bạn
    $sql = "INSERT INTO customers (role_id, full_name, email, password_hash, rank, avatar, created_at) 
            VALUES (7, ?, ?, ?, 'Gold', 'img/vips/default.jpg', NOW())";
    
    $stmt = Db::$connection->prepare($sql);
    
    if (!$stmt) {
        die("Lỗi truy vấn: " . Db::$connection->error);
    }

    $stmt->bind_param("sss", $full_name, $email, $password_hash);

    if ($stmt->execute()) {
        // Đăng ký thành công, tự động đăng nhập hoặc chuyển về trang login
        $_SESSION['register_success'] = "Tài khoản đã được tạo thành công!";
        header("Location: login.php?success=registered");
        exit();
    } else {
        // Lỗi hệ thống khi insert
        header("Location: login.php?error=server_error");
        exit();
    }
} else {
    // Nếu truy cập trực tiếp file này mà không qua form
    header("Location: login.php");
    exit();
}