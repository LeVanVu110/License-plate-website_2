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
    public function getAllAdmin($page = 1, $limit = 3)
    {
        $offset = ($page - 1) * $limit;

        // Câu lệnh lấy dữ liệu có LIMIT và OFFSET
        $sql = "SELECT n.*, a.full_name as author_name 
            FROM news n 
            LEFT JOIN admin_accounts a ON n.author_id = a.id 
            ORDER BY n.created_at DESC 
            LIMIT ? OFFSET ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Hàm bổ sung để đếm tổng số bài (phục vụ phân trang)
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM news";
        $result = self::$connection->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    public function insert($title, $slug, $summary, $content, $thumbnail, $tag, $category, $author_id, $status)
    {
        // Câu lệnh SQL với các tham số ẩn (?) để chống SQL Injection
        $sql = "INSERT INTO `news` 
            (`title`, `slug`, `summary`, `content`, `thumbnail`, `tag`, `category`, `author_id`, `status`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = self::$connection->prepare($sql);

        // Kiểm tra nếu prepare lỗi
        if (!$stmt) {
            return false;
        }

        /* Giải thích tham số trong bind_param:
       s: string (chuỗi)
       i: integer (số nguyên)
       Thứ tự: title(s), slug(s), summary(s), content(s), thumbnail(s), tag(s), category(s), author_id(i), status(s)
    */
        $stmt->bind_param(
            "sssssssis",
            $title,
            $slug,
            $summary,
            $content,
            $thumbnail,
            $tag,
            $category,
            $author_id,
            $status
        );

        $result = $stmt->execute();

        // Trả về ID của bài viết vừa chèn nếu thành công, ngược lại trả về false
        return $result ? $stmt->insert_id : false;
    }
    public function getAllNewsWithAuthor()
    {
        // Sử dụng INNER JOIN để lấy name từ bảng customer dựa trên author_id
        $sql = "SELECT news.*, customer.full_name as author_name 
            FROM news 
            INNER JOIN customer ON news.author_id = customer.id 
            ORDER BY news.created_at DESC";

        $result = self::$connection->query($sql);
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
}
