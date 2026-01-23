<?php
// Thông tin kết nối
$servername = "localhost"; // Mặc định của XAMPP
$username = "root";        // Mặc định của XAMPP là root
$password = "";            // Mặc định của XAMPP là rỗng
$dbname = "sapphire_db"; // Tên database bạn đã tạo trong phpMyAdmin

// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Thiết lập bảng mã font chữ tiếng Việt để không bị lỗi font
mysqli_set_charset($conn, 'utf8');
?>