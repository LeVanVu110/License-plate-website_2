<?php
class Customer extends Db {
    public function get() {
        $sql = "SELECT * FROM customers ORDER BY total_spent DESC";
        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
