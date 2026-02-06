<?php
// Sử dụng đường dẫn tương đối để tránh lỗi trên Linux Server của InfinityFree
require_once dirname(__DIR__) . "/config.php";

// 2. Nạp db.php (Cùng nằm trong thư mục Models với file này)
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Auction.php";

header('Content-Type: application/json');

$auctionId = $_POST['auction_id'] ?? 0;
$paused = $_POST['paused'] === 'true'; // Chuyển từ string "true"/"false" sang boolean

if ($auctionId > 0) {
    $auctionModel = new Auction();
    if ($auctionModel->toggleAuctionStatus($auctionId, $paused)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật DB']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
}
