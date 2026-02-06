<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";

$auction_id = intval($_GET['auction_id'] ?? 0);
$db = new Db();
$conn = Db::$connection;

// Lấy 10 lượt bid mới nhất, kết hợp với bảng customers để lấy tên
$sql = "SELECT b.bid_amount, b.bid_time, c.full_name 
        FROM bids b
        JOIN customers c ON b.customer_id = c.id
        WHERE b.auction_id = $auction_id
        ORDER BY b.bid_time DESC
        LIMIT 10";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    // Ẩn bớt tên khách hàng để bảo mật (Ví dụ: Nguyễn Văn A -> Nguy*** A)
    $name = $row['full_name'];
    $display_name = mb_substr($name, 0, 3) . "***" . mb_substr($name, -1);

    $data[] = [
        'name' => $display_name,
        'amount' => number_format($row['bid_amount'], 0, ',', '.') . 'đ',
        'time' => date('H:i:s', strtotime($row['bid_time']))
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
