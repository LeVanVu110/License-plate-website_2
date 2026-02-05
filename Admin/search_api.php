<?php
// Sử dụng đường dẫn tương đối để tránh lỗi trên Linux Server của InfinityFree
require_once dirname(__DIR__) . "/config.php";

// 2. Nạp db.php (Cùng nằm trong thư mục Models với file này)
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Auction.php";

$query = $_GET['q'] ?? '';
$auctionModel = new Auction();

// Trả về mảng rỗng nếu từ khóa quá ngắn
if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

$results = $auctionModel->searchAuctions($query);

header('Content-Type: application/json');
echo json_encode($results);
