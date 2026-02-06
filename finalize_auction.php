<?php
session_start();
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";

header('Content-Type: application/json');

try {
    $dbObject = new Db();
    $conn = Db::$connection;

    $auction_id = intval($_POST['auction_id'] ?? 0);
    if ($auction_id <= 0) throw new Exception("ID phiên không hợp lệ.");

    // 1. Kiểm tra xem phiên này đã có người thắng chưa để tránh trừ tiền 2 lần
    $check_sql = "SELECT id FROM bids WHERE auction_id = $auction_id AND is_winning_bid = 1";
    $check_res = $conn->query($check_sql);
    if ($check_res && $check_res->num_rows > 0) {
        echo json_encode(['status' => 'already_finalized', 'message' => 'Phiên này đã xử lý rồi.']);
        exit;
    }

    // 2. Lấy thông tin người trả giá cao nhất (Lấy cả cột ID)
    $sql_winner = "SELECT id, customer_id, bid_amount FROM bids 
                   WHERE auction_id = $auction_id 
                   ORDER BY bid_amount DESC LIMIT 1";
    $res_winner = $conn->query($sql_winner);

    if ($res_winner && $res_winner->num_rows > 0) {
        $winner = $res_winner->fetch_assoc();
        $bid_id = $winner['id']; // Dùng cái này để UPDATE cực chính xác
        $winner_id = $winner['customer_id'];
        $win_amount = $winner['bid_amount'];

        $conn->begin_transaction();
        try {
            // A. Cập nhật bằng ID lượt bid
            $conn->query("UPDATE bids SET is_winning_bid = 1 WHERE id = $bid_id");

            // B. Trừ tiền (bidding_limit)
            $conn->query("UPDATE customers SET bidding_limit = bidding_limit - $win_amount WHERE id = $winner_id");

            // C. Ghi vào Ledger (Để bạn SELECT ra dữ liệu)
            $conn->query("INSERT INTO financial_ledger (customer_id, amount, type, status, created_at) 
                          VALUES ($winner_id, $win_amount, 'Payment', 'Success', NOW())");

            $conn->commit();
            echo json_encode(['status' => 'success', 'message' => 'Đã trừ tiền Admin và chốt người thắng!']);
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
    } else {
        echo json_encode(['status' => 'no_bids', 'message' => 'Không có lượt đấu giá nào.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
