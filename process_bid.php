<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";

header('Content-Type: application/json');

try {
    // Khởi tạo kết nối
    $db = new Db();
    if (!isset(Db::$connection)) {
        throw new Exception("Lỗi kết nối cơ sở dữ liệu.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Vui lòng đăng nhập để đấu giá!");
        }

        $auction_id = intval($_POST['auction_id']);
        $customer_id = intval($_SESSION['user_id']);
        $bid_amount = floatval($_POST['bid_amount']);

        // --- BƯỚC 1: KIỂM TRA HẠN MỨC (BIDDING_LIMIT) ---
        // Theo SQL của bạn: bảng `customers`, cột `bidding_limit`
        $sql_user = "SELECT bidding_limit, full_name FROM customers WHERE id = $customer_id";
        $res_user = Db::$connection->query($sql_user);
        if (!$res_user || $res_user->num_rows == 0) {
            throw new Exception("Không tìm thấy thông tin người dùng.");
        }
        $user_data = $res_user->fetch_assoc();

        // Kiểm tra nếu giá thầu lớn hơn hạn mức cho phép
        if ($bid_amount > $user_data['bidding_limit']) {
            throw new Exception("Giá thầu vượt quá hạn mức của bạn (" . number_format($user_data['bidding_limit'], 0, ',', '.') . "đ). Vui lòng nạp thêm cọc!");
        }

        // --- BƯỚC 2: KIỂM TRA GIÁ HIỆN TẠI ---
        $sql_check = "SELECT MAX(bid_amount) as max_bid FROM bids WHERE auction_id = $auction_id";
        $res = Db::$connection->query($sql_check);
        $current_max = ($res->fetch_assoc())['max_bid'] ?? 0;

        if ($current_max == 0) {
            // Lấy giá khởi điểm từ bảng plates nếu chưa có ai thầu
            $sql_start = "SELECT starting_price FROM plates p JOIN auctions a ON p.id = a.plate_id WHERE a.id = $auction_id";
            $res_start = Db::$connection->query($sql_start);
            $current_max = ($res_start->fetch_assoc())['starting_price'] ?? 0;
        }

        if ($bid_amount <= $current_max) {
            throw new Exception("Giá thầu phải cao hơn giá hiện tại (" . number_format($current_max, 0, ',', '.') . "đ)");
        }

        // --- BƯỚC 3: GHI DỮ LIỆU (INSERT) ---
        // Theo SQL của bạn: bảng `bids` có các cột id, auction_id, customer_id, bid_amount, bid_time, is_winning_bid
        $sql_insert = "INSERT INTO bids (auction_id, customer_id, bid_amount, bid_time) VALUES (?, ?, ?, NOW(3))";
        $stmt = Db::$connection->prepare($sql_insert);
        $stmt->bind_param("iid", $auction_id, $customer_id, $bid_amount);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Đặt giá thành công!',
                'new_price' => number_format($bid_amount, 0, ',', '.'),
                'raw_price' => $bid_amount
            ]);
        } else {
            throw new Exception("Lỗi hệ thống khi lưu giá thầu.");
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
