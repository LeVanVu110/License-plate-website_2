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
    public function getAuctionSummary($user_id)
    {
        // Đếm số cuộc đấu giá thắng
        $sqlWin = "SELECT COUNT(DISTINCT auction_id) as total_win FROM bids WHERE customer_id = ? AND is_winning_bid = 1";
        $stmt = self::$connection->prepare($sqlWin);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $wins = $stmt->get_result()->fetch_assoc()['total_win'];

        // Đếm tổng số cuộc đấu giá đã tham gia
        $sqlTotal = "SELECT COUNT(DISTINCT auction_id) as total_joined FROM bids WHERE customer_id = ?";
        $stmt = self::$connection->prepare($sqlTotal);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total_joined'];

        // Tính Win Rate
        $winRate = ($total > 0) ? round(($wins / $total) * 100) : 0;

        // Tính tiền cọc (Giả định mỗi cuộc tham gia cọc 40tr hoặc lấy từ total_spent)
        // Ở đây tôi lấy total_spent từ bảng customers để đại diện cho Capital
        $sqlCap = "SELECT total_spent FROM customers WHERE id = ?";
        $stmt = self::$connection->prepare($sqlCap);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $capital = $stmt->get_result()->fetch_assoc()['total_spent'] ?? 0;

        return [
            'wins' => $wins,
            'lost' => ($total - $wins),
            'win_rate' => $winRate,
            'capital' => $capital
        ];
    }
    public function getLiveWarRoom($user_id)
    {
        // b.auction_id nối với a.id
        // a.plate_id nối với p.id
        $sql = "SELECT 
                a.id as auction_id, -- Bắt buộc phải lấy ID này để làm link
                p.id as plate_id, 
                p.plate_number, 
                p.address, 
                p.current_price, 
                a.end_time,
                MAX(b.bid_amount) as user_last_bid,
                (SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id) as highest_bid
            FROM bids b
            JOIN auctions a ON b.auction_id = a.id
            JOIN plates p ON a.plate_id = p.id
            WHERE b.customer_id = ? AND a.end_time > NOW()
            GROUP BY a.id
            ORDER BY a.end_time ASC";

        $stmt = self::$connection->prepare($sql);

        if (!$stmt) {
            die("Lỗi truy vấn SQL: " . self::$connection->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getAuctionHistory($user_id)
    {
        // Lưu ý: Lấy current_price từ bảng p (plates)
        // Lấy is_winning_bid để xác định Thắng/Thua
        $sql = "SELECT 
                p.plate_number, 
                a.end_time, 
                MAX(b.bid_amount) as user_max_bid,
                p.current_price as final_price, 
                MAX(b.is_winning_bid) as is_winner
            FROM bids b
            JOIN auctions a ON b.auction_id = a.id
            JOIN plates p ON a.plate_id = p.id
            WHERE b.customer_id = ? 
              AND a.end_time <= NOW() -- Chỉ lấy các phiên đã kết thúc
            GROUP BY a.id
            ORDER BY a.end_time DESC";

        $stmt = self::$connection->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . self::$connection->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getTransactionHistory($user_id)
    {
        $sql = "SELECT t.*, p.plate_number 
            FROM transactions t
            LEFT JOIN plates p ON t.plate_id = p.id
            WHERE t.customer_id = ? 
            ORDER BY t.created_at DESC";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
