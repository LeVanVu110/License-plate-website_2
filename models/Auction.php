<?php
class Auction extends Db
{
    // Lấy danh sách các phiên đang đấu giá (Auctioning)
    public function getLiveAuctions()
    {
        $sql = "SELECT a.*, p.plate_number, p.category, p.starting_price,
            (SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id) as current_max_bid,
            (SELECT bid_time FROM bids WHERE auction_id = a.id ORDER BY bid_time DESC LIMIT 1) as last_bid_time
            FROM auctions a
            JOIN plates p ON a.plate_id = p.id
            WHERE p.status = 'Auctioning'
            ORDER BY a.end_time ASC";

        $result = self::$connection->query($sql);
        $auctions = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($auctions as &$auc) {
            // Logic Sniper: Nếu có lượt thầu cuối trong khoảng X giây trước khi hết hạn
            // Ở đây chúng ta tính thời gian kết thúc hiển thị cho người dùng
            $auc['display_end_time'] = strtotime($auc['end_time']);

            if ($auc['last_bid_time']) {
                $lastBidTs = strtotime($auc['last_bid_time']);
                $originalEndTs = strtotime($auc['end_time']);

                // Nếu giây thầu cuối nằm trong khoảng bù giờ, cộng thêm sniper_time vào display
                if (($originalEndTs - $lastBidTs) <= $auc['sniper_time']) {
                    $auc['display_end_time'] = $lastBidTs + $auc['sniper_time'];
                }
            }
        }
        return $auctions;
    }

    // Lấy chi tiết 1 phiên đấu giá cụ thể kèm thông tin người đang dẫn đầu
    // public function getAuctionDetail($id)
    // {
    //     $sql = "SELECT a.*, p.plate_number, p.vehicle_type, p.starting_price 
    //         FROM auctions a 
    //         JOIN plates p ON a.plate_id = p.id 
    //         WHERE a.id = $id";
    //     $result = Db::$connection->query($sql);
    //     return $result->fetch_assoc();
    // }
    public function getAuctionDetail($id)
    {
        $sql = "SELECT a.*, p.plate_number, p.vehicle_type, p.starting_price,
            -- Lấy giá cao nhất từ bảng bids, nếu chưa có ai thầu thì lấy starting_price
            COALESCE((SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id), p.starting_price) as current_max_bid
            FROM auctions a
            JOIN plates p ON a.plate_id = p.id
            WHERE a.id = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // public function getAllAuctionsDetail()
    // {
    //     // Query lấy tất cả các phiên từ bảng auctions, kết nối với bảng plates
    //     $sql = "SELECT a.*, p.plate_number, p.category, p.starting_price, p.status as plate_status, p.vehicle_type,
    //     -- 1. Lấy giá cao nhất từ bảng bids, nếu chưa có ai thầu thì lấy giá khởi điểm
    //     COALESCE((SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id), p.starting_price) as current_max_bid,
    //     -- 2. Lấy thời gian của lượt thầu cuối cùng để tính toán Sniper
    //     (SELECT bid_time FROM bids WHERE auction_id = a.id ORDER BY bid_time DESC LIMIT 1) as last_bid_time,
    //     -- 3. Đếm tổng số lượt thầu cho mỗi phiên
    //     (SELECT COUNT(*) FROM bids WHERE auction_id = a.id) as total_bids
    //     FROM auctions a
    //     JOIN plates p ON a.plate_id = p.id
    //     ORDER BY 
    //         -- Ưu tiên hiện phiên 'Đang đấu giá' lên đầu, sau đó đến 'Sắp đấu' và 'Đã bán'
    //         (CASE WHEN p.status = 'Auctioning' THEN 1 
    //               WHEN p.status = 'Available' THEN 2 
    //               ELSE 3 END) ASC, 
    //         a.end_time ASC";

    //     $result = self::$connection->query($sql);
    //     $auctions = $result->fetch_all(MYSQLI_ASSOC);

    //     // Trong Auction.php
    //     foreach ($auctions as &$auc) {
    //         // Chuyển end_time từ chuỗi (Y-m-d H:i:s) sang số giây (Timestamp)
    //         $auc['display_end_time'] = strtotime($auc['end_time']);

    //         if ($auc['last_bid_time']) {
    //             $lastBidTs = strtotime($auc['last_bid_time']);
    //             $originalEndTs = strtotime($auc['end_time']);

    //             // Logic bù giờ Sniper
    //             if (($originalEndTs - $lastBidTs) <= $auc['sniper_time']) {
    //                 $auc['display_end_time'] = $lastBidTs + $auc['sniper_time'];
    //             }
    //         }
    //     }
    //     return $auctions;
    // }
    public function getAllAuctionsDetail($search = null)
    {
        $whereClause = "";
        $params = [];
        $types = "";

        // Nếu có từ khóa search, lọc theo biển số hoặc loại xe
        if (!empty($search)) {
            $whereClause = " WHERE p.plate_number LIKE ? OR p.category LIKE ? ";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm];
            $types = "ss";
        }

        $sql = "SELECT a.*, p.plate_number, p.category, p.starting_price, p.status as plate_status, p.vehicle_type,
            COALESCE((SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id), p.starting_price) as current_max_bid,
            (SELECT bid_time FROM bids WHERE auction_id = a.id ORDER BY bid_time DESC LIMIT 1) as last_bid_time,
            (SELECT COUNT(*) FROM bids WHERE auction_id = a.id) as total_bids
            FROM auctions a
            JOIN plates p ON a.plate_id = p.id
            $whereClause
            ORDER BY 
                (CASE WHEN p.status = 'Auctioning' THEN 1 
                      WHEN p.status = 'Available' THEN 2 
                      ELSE 3 END) ASC, 
                a.end_time ASC";

        $stmt = self::$connection->prepare($sql);
        if (!empty($search)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $auctions = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($auctions as &$auc) {
            $auc['display_end_time'] = strtotime($auc['end_time']);
            if ($auc['last_bid_time']) {
                $lastBidTs = strtotime($auc['last_bid_time']);
                $originalEndTs = strtotime($auc['end_time']);
                if (($originalEndTs - $lastBidTs) <= $auc['sniper_time']) {
                    $auc['display_end_time'] = $lastBidTs + $auc['sniper_time'];
                }
            }
        }
        return $auctions;
    }
    public function addAuctionTime($id, $seconds)
    {
        $id = intval($id);
        $seconds = intval($seconds);

        // Sử dụng self::$connection vì class Auction kế thừa từ Db
        $sql = "UPDATE auctions SET end_time = DATE_ADD(end_time, INTERVAL $seconds SECOND) WHERE id = $id";

        return self::$connection->query($sql);
    }
    // Trong class Plate hoặc Auction
    public function getAvailablePlates()
    {
        // Sử dụng self::$connection vì class này kế thừa từ Db
        $sql = "SELECT * FROM plates WHERE status = 'Available' ORDER BY plate_number ASC";
        $result = self::$connection->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    // Trong class Auction (file models/Auction.php)
    public function createNewAuction($plateId, $endTime, $startingPrice, $minStep)
    {
        try {
            // 1. Bắt đầu giao dịch
            self::$connection->begin_transaction();

            // 2. DỌN DẸP DỮ LIỆU CŨ (QUAN TRỌNG)
            // Xóa tất cả các phiên đấu giá đã tồn tại của biển số này 
            // để đảm bảo không bị hiện 2 cái (1 cũ hết hạn, 1 mới tạo)
            $sqlDelete = "DELETE FROM auctions WHERE plate_id = ?";
            $stmtDel = self::$connection->prepare($sqlDelete);
            $stmtDel->bind_param("i", $plateId);
            $stmtDel->execute();

            // 3. Chuẩn bị dữ liệu mới
            $startTime = date('Y-m-d H:i:s');

            // 4. Thêm phiên đấu giá mới vào bảng auctions
            // Cột theo DB của bạn: plate_id, start_time, end_time, bid_increment, sniper_time
            $sqlAuction = "INSERT INTO auctions (plate_id, start_time, end_time, bid_increment, sniper_time) 
                           VALUES (?, ?, ?, ?, 30)";

            $stmt1 = self::$connection->prepare($sqlAuction);
            if (!$stmt1) {
                throw new Exception("Lỗi Prepare Auction: " . self::$connection->error);
            }

            // i: int (plateId), s: string (startTime), s: string (endTime), d: double (minStep)
            $stmt1->bind_param("issd", $plateId, $startTime, $endTime, $minStep);
            $stmt1->execute();

            // 5. Cập nhật trạng thái và giá khởi điểm trong bảng plates
            $sqlPlate = "UPDATE plates SET status = 'Auctioning', starting_price = ? WHERE id = ?";
            $stmt2 = self::$connection->prepare($sqlPlate);
            if (!$stmt2) {
                throw new Exception("Lỗi Prepare Plate: " . self::$connection->error);
            }

            // d: double (startingPrice), i: int (plateId)
            $stmt2->bind_param("di", $startingPrice, $plateId);
            $stmt2->execute();

            // 6. Hoàn tất giao dịch thành công
            self::$connection->commit();
            return true;
        } catch (Exception $e) {
            // Nếu có bất kỳ lỗi nào, hủy bỏ toàn bộ thay đổi
            self::$connection->rollback();
            error_log("Forge Error (createNewAuction): " . $e->getMessage());
            return false;
        }
    }
    // Trong file Auction.php hoặc Plate.php
    // Thêm vào class Auction trong Auction.php
    public function toggleAuctionStatus($auctionId, $isPaused)
    {
        $val = $isPaused ? 1 : 0;
        $sql = "UPDATE auctions SET is_paused = ? WHERE plate_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ii", $val, $auctionId);
        return $stmt->execute();
    }
    // Trong class Auction (models/Auction.php)
    public function togglePause($auctionId)
    {
        // 1. Lấy thông tin phiên hiện tại
        $sql = "SELECT is_paused, end_time, remaining_seconds FROM auctions WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $auctionId);
        $stmt->execute();
        $auc = $stmt->get_result()->fetch_assoc();

        $now = time();

        if ($auc['is_paused'] == 0) {
            // --- HÀNH ĐỘNG: BẤM DỪNG (PAUSE) ---
            $endTimeTs = strtotime($auc['end_time']);
            $diff = $endTimeTs - $now;
            $remaining = ($diff > 0) ? $diff : 0; // Tính số giây còn lại

            $sqlPause = "UPDATE auctions SET is_paused = 1, remaining_seconds = ? WHERE id = ?";
            $stmtP = self::$connection->prepare($sqlPause);
            $stmtP->bind_param("ii", $remaining, $auctionId);
            return $stmtP->execute();
        } else {
            // --- HÀNH ĐỘNG: CHẠY TIẾP (RESUME) ---
            $remaining = $auc['remaining_seconds'];
            // Tính end_time mới = bây giờ + số giây còn thừa
            $newEndTime = date('Y-m-d H:i:s', $now + $remaining);

            $sqlResume = "UPDATE auctions SET is_paused = 0, end_time = ?, remaining_seconds = NULL WHERE id = ?";
            $stmtR = self::$connection->prepare($sqlResume);
            $stmtR->bind_param("si", $newEndTime, $auctionId);
            return $stmtR->execute();
        }
    }
    public function searchAuctions($query)
    {
        $searchTerm = "%" . $query . "%";
        $sql = "SELECT a.*, p.plate_number, p.category, p.starting_price,
            (SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id) as current_max_bid
            FROM auctions a
            JOIN plates p ON a.plate_id = p.id
            WHERE p.plate_number LIKE ? OR p.category LIKE ?
            LIMIT 5"; // Giới hạn 5 kết quả cho tìm kiếm nhanh

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
