<?php
class Bid extends Db {
    public function get($auction_id = null) {
        $sql = "SELECT * FROM bids";
        if ($auction_id) {
            $sql .= " WHERE auction_id = " . intval($auction_id);
        }
        $sql .= " ORDER BY bid_time ASC";
        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}