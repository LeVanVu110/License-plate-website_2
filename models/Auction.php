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
    public function getAuctionDetail($id)
    {
        $sql = "SELECT a.*, p.plate_number, p.vehicle_type, p.starting_price 
            FROM auctions a 
            JOIN plates p ON a.plate_id = p.id 
            WHERE a.id = $id";
        $result = Db::$connection->query($sql);
        return $result->fetch_assoc();
    }
}
