<?php
class News extends Db {
    public function get() {
        $sql = "SELECT n.*, a.full_name as author_name 
                FROM news n 
                LEFT JOIN admin_accounts a ON n.author_id = a.id 
                WHERE n.status = 'Published' 
                ORDER BY n.created_at DESC";
        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}