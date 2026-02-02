<?php
class Customer extends Db
{
    // Hàm lấy tất cả (đã có của bạn)
    public function get()
    {
        $sql = "SELECT * FROM customers ORDER BY total_spent DESC";
        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // HÀM MỚI: Lấy thông tin chi tiết của 1 người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM customers WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về mảng chứa tên, email, rank...
    }
    public function getCurrentUser($id)
    {
        $sql = "SELECT * FROM customers WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getUserWithVipCode($user_id)
    {
        $sql = "SELECT c.*, v.code as vip_code 
                FROM customers c
                LEFT JOIN vip_codes v ON c.id = v.customer_id
                WHERE c.id = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getInventoryCount($user_id)
    {
        $sql = "SELECT COUNT(*) as total FROM bids WHERE customer_id = ? AND is_winning_bid = 1";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    public function getTotalAssets($user_id)
    {
        // Cách 1: Lấy từ cột total_spent (Nhanh)
        // $sql = "SELECT total_spent FROM customers WHERE id = ?";

        // Cách 2: Nếu muốn tính tổng từ bảng lịch sử giao dịch (Chính xác hơn)
        $sql = "SELECT SUM(amount) as total_spent FROM financial_ledger WHERE customer_id = ? AND status = 'Success'";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data ? $data['total_spent'] : 0;
    }
    public function getInventoryList($user_id)
    {
        // Phải JOIN thêm bảng auctions nếu auction_id trỏ tới bảng đó
        // Hoặc nếu auction_id trong bảng bids của bạn chính là plate_id, hãy dùng câu lệnh dưới:
        $sql = "SELECT b.bid_time as win_date, p.plate_number, p.vehicle_type, p.rare_score, p.background_color
                FROM bids b
                JOIN plates p ON b.auction_id = p.id 
                WHERE b.customer_id = ? AND b.is_winning_bid = 1
                ORDER BY b.bid_time DESC";

        $stmt = self::$connection->prepare($sql);
        if (!$stmt) {
            // Nếu vẫn lỗi Unknown column 'p.rare_score', hãy chạy lệnh ALTER TABLE tôi gửi ở dưới
            die("Lỗi SQL: " . self::$connection->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
