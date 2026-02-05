<?php
error_reporting(0);
ini_set('display_errors', 0);
ob_start();

// Sử dụng đường dẫn tương đối để tránh lỗi trên Linux Server của InfinityFree
require_once dirname(__DIR__) . "/config.php";

// 2. Nạp db.php (Cùng nằm trong thư mục Models với file này)
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Auction.php";

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Lỗi không xác định'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plateId = intval($_POST['plate_id']);
    $startingPrice = floatval($_POST['starting_price']);
    $durationHours = intval($_POST['duration_hours']); // Ví dụ: 24, 48 tiếng

    // ... bên trong file create_auction_api.php ...
    // ... bên trong file create_auction_api.php ...
    if ($plateId > 0 && $startingPrice > 0 && $durationHours > 0) {
        $auctionModel = new Auction();

        // Tính end_time
        $endTime = date('Y-m-d H:i:s', strtotime("+$durationHours hours"));

        // Bước giá (Lấy từ giao diện hoặc mặc định)
        $minStep = 10000000; // 10 triệu

        if ($auctionModel->createNewAuction($plateId, $endTime, $startingPrice, $minStep)) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false, 'message' => 'Lỗi SQL: Không thể chèn dữ liệu. Kiểm tra trùng lặp hoặc khóa ngoại.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Dữ liệu đầu vào không hợp lệ'];
    }
}

ob_end_clean();
echo json_encode($response);
