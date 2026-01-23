<?php
class Financial extends Db {
    public function get() {
        $sql = "SELECT * FROM financial_ledger ORDER BY created_at DESC";
        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}