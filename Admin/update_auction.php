<?php
// 1. Tắt hiển thị lỗi ra ngoài để tránh làm hỏng JSON
error_reporting(0);
ini_set('display_errors', 0);

// 2. Xóa sạch mọi nội dung đã in ra trước đó (nếu có)
ob_start();

require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Auction.php";

header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_time') {

    $auctionModel = new Auction();
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $seconds = isset($_POST['seconds']) ? intval($_POST['seconds']) : 0;

    if ($id > 0 && $seconds > 0) {
        if ($auctionModel->addAuctionTime($id, $seconds)) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false, 'message' => 'Lỗi cập nhật cơ sở dữ liệu'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
    }
}

// 3. Xóa mọi ký tự trắng hoặc Warning phát sinh trước đó
ob_end_clean();

// 4. Chỉ in ra đúng 1 chuỗi JSON duy nhất
echo json_encode($response);
exit;
