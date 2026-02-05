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
    public function getAllAuctionsDetail()
    {
        // Query lấy tất cả các phiên từ bảng auctions, kết nối với bảng plates
        $sql = "SELECT a.*, p.plate_number, p.category, p.starting_price, p.status as plate_status, p.vehicle_type,
        -- 1. Lấy giá cao nhất từ bảng bids, nếu chưa có ai thầu thì lấy giá khởi điểm
        COALESCE((SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id), p.starting_price) as current_max_bid,
        -- 2. Lấy thời gian của lượt thầu cuối cùng để tính toán Sniper
        (SELECT bid_time FROM bids WHERE auction_id = a.id ORDER BY bid_time DESC LIMIT 1) as last_bid_time,
        -- 3. Đếm tổng số lượt thầu cho mỗi phiên
        (SELECT COUNT(*) FROM bids WHERE auction_id = a.id) as total_bids
        FROM auctions a
        JOIN plates p ON a.plate_id = p.id
        ORDER BY 
            -- Ưu tiên hiện phiên 'Đang đấu giá' lên đầu, sau đó đến 'Sắp đấu' và 'Đã bán'
            (CASE WHEN p.status = 'Auctioning' THEN 1 
                  WHEN p.status = 'Available' THEN 2 
                  ELSE 3 END) ASC, 
            a.end_time ASC";

        $result = self::$connection->query($sql);
        $auctions = $result->fetch_all(MYSQLI_ASSOC);

        // Xử lý logic thời gian hiển thị sau khi lấy từ DB
        foreach ($auctions as &$auc) {
            $auc['display_end_time'] = strtotime($auc['end_time']);

            // Nếu có lượt thầu cuối, kiểm tra xem có rơi vào khoảng Sniper (bù giờ) không
            if ($auc['last_bid_time']) {
                $lastBidTs = strtotime($auc['last_bid_time']);
                $originalEndTs = strtotime($auc['end_time']);

                // Nếu giây thầu cuối nằm trong khoảng bù giờ, cộng thêm sniper_time vào display_end_time
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
}
