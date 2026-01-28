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
    public function get_PhongThuy()
    {
        $sql = "SELECT * FROM `news` 
            WHERE `tag`= '#PhongThuy' 
            ORDER BY `created_at` DESC";

        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function get_ThiTruong()
    {
        $sql = "SELECT * FROM `news` 
            WHERE `tag`= '#ThiTruong' 
            ORDER BY `created_at` DESC";

        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function get_PhapLy()
    {
        $sql = "SELECT * FROM `news` 
            WHERE `tag`= '#PhapLy' 
            ORDER BY `created_at` DESC";

        $result = self::$connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id)
    {
        // Sử dụng Prepared Statement để chống tấn công SQL Injection
        $sql = "SELECT n.*, a.full_name as author_name 
            FROM news n 
            LEFT JOIN admin_accounts a ON n.author_id = a.id 
            WHERE n.id = ? 
            LIMIT 1";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $id); // "i" nghĩa là id là kiểu integer
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về 1 mảng chứa dữ liệu bài viết hoặc null
    }
    // Thêm hàm lấy theo Slug (để dùng cho đường dẫn đẹp như: chitiet_tintuc.php?slug=tieu-de-bai-viet)
    public function getBySlug($slug)
    {
        $sql = "SELECT n.*, a.full_name as author_name 
            FROM news n 
            LEFT JOIN admin_accounts a ON n.author_id = a.id 
            WHERE n.slug = ? 
            LIMIT 1";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("s", $slug); // "s" nghĩa là slug là kiểu string
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
