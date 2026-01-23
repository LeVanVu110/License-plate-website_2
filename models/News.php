<?php
class News extends Db
{
    public function get()
    {
        $sql = "SELECT n.*, a.full_name as author_name 
                FROM news n 
                LEFT JOIN admin_accounts a ON n.author_id = a.id 
                WHERE n.status = 'Published' 
                ORDER BY n.created_at DESC";

        $result = self::$connection->query($sql);
        $allNews = $result->fetch_all(MYSQLI_ASSOC);

        // Tách bài đầu tiên ra
        $featured = array_shift($allNews);

        return [
            'featured' => $featured, // 1 bài mới nhất
            'list' => $allNews       // Các bài còn lại
        ];
    }
}
