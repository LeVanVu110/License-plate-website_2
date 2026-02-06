<?php
class Customer extends Db
{
    public function get($keyword = null)
    {
        if ($keyword) {
            // Nếu có từ khóa, thực hiện tìm kiếm (Deep Search)
            $search = "%$keyword%";
            $sql = "SELECT * FROM customers 
                WHERE full_name LIKE ? 
                OR email LIKE ? 
                OR phone_number LIKE ? 
                ORDER BY total_spent DESC";

            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("sss", $search, $search, $search);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Nếu không có từ khóa, lấy tất cả như cũ
            $sql = "SELECT * FROM customers ORDER BY total_spent DESC";
            $result = self::$connection->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    // public function get($keyword = null, $page = 1, $limit = 6, $rank = null)
    // {
    //     $offset = ($page - 1) * $limit;
    //     $sql = "SELECT * FROM customers WHERE 1=1";
    //     $params = [];
    //     $types = "";

    //     if ($keyword) {
    //         $sql .= " AND (full_name LIKE ? OR email LIKE ? OR phone_number LIKE ?)";
    //         $search = "%$keyword%";
    //         array_push($params, $search, $search, $search);
    //         $types .= "sss";
    //     }

    //     if ($rank && $rank !== 'all') {
    //         $sql .= " AND rank = ?";
    //         array_push($params, $rank);
    //         $types .= "s";
    //     }

    //     $sql .= " ORDER BY total_spent DESC LIMIT ? OFFSET ?";
    //     array_push($params, $limit, $offset);
    //     $types .= "ii";

    //     $stmt = self::$connection->prepare($sql);
    //     $stmt->bind_param($types, ...$params);
    //     $stmt->execute();
    //     return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // }

    // Hàm bổ sung để tính tổng số trang
    public function countAll($keyword = null)
    {
        if ($keyword) {
            $search = "%$keyword%";
            $sql = "SELECT COUNT(*) as total FROM customers WHERE full_name LIKE ? OR email LIKE ? OR phone_number LIKE ?";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("sss", $search, $search, $search);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc()['total'];
        }
        $result = self::$connection->query("SELECT COUNT(*) as total FROM customers");
        return $result->fetch_assoc()['total'];
    }
    // HÀM MỚI: Lấy thông tin chi tiết của 1 người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM customers WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về mảng chứa tên, email, rank...
    }
    public function getCurrentUser($id)
    {
        $sql = "SELECT * FROM customers WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getUserWithVipCode($user_id)
    {
        $sql = "SELECT c.*, v.code as vip_code 
                FROM customers c
                LEFT JOIN vip_codes v ON c.id = v.customer_id
                WHERE c.id = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getInventoryCount($user_id)
    {
        $sql = "SELECT COUNT(*) as total FROM bids WHERE customer_id = ? AND is_winning_bid = 1";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    public function getTotalAssets($user_id)
    {
        // Cách 1: Lấy từ cột total_spent (Nhanh)
        // $sql = "SELECT total_spent FROM customers WHERE id = ?";

        // Cách 2: Nếu muốn tính tổng từ bảng lịch sử giao dịch (Chính xác hơn)
        $sql = "SELECT SUM(amount) as total_spent FROM financial_ledger WHERE customer_id = ? AND status = 'Success'";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data ? $data['total_spent'] : 0;
    }
    public function getInventoryList($user_id)
    {
        // Phải JOIN thêm bảng auctions nếu auction_id trỏ tới bảng đó
        // Hoặc nếu auction_id trong bảng bids của bạn chính là plate_id, hãy dùng câu lệnh dưới:
        $sql = "SELECT b.bid_time as win_date, p.plate_number, p.vehicle_type, p.rare_score, p.background_color
                FROM bids b
                JOIN plates p ON b.auction_id = p.id 
                WHERE b.customer_id = ? AND b.is_winning_bid = 1
                ORDER BY b.bid_time DESC";

        $stmt = self::$connection->prepare($sql);
        if (!$stmt) {
            // Nếu vẫn lỗi Unknown column 'p.rare_score', hãy chạy lệnh ALTER TABLE tôi gửi ở dưới
            die("Lỗi SQL: " . self::$connection->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAuctionSummary($user_id)
    {
        // Đếm số cuộc đấu giá thắng
        $sqlWin = "SELECT COUNT(DISTINCT auction_id) as total_win FROM bids WHERE customer_id = ? AND is_winning_bid = 1";
        $stmt = self::$connection->prepare($sqlWin);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $wins = $stmt->get_result()->fetch_assoc()['total_win'];

        // Đếm tổng số cuộc đấu giá đã tham gia
        $sqlTotal = "SELECT COUNT(DISTINCT auction_id) as total_joined FROM bids WHERE customer_id = ?";
        $stmt = self::$connection->prepare($sqlTotal);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total_joined'];

        // Tính Win Rate
        $winRate = ($total > 0) ? round(($wins / $total) * 100) : 0;

        // Tính tiền cọc (Giả định mỗi cuộc tham gia cọc 40tr hoặc lấy từ total_spent)
        // Ở đây tôi lấy total_spent từ bảng customers để đại diện cho Capital
        $sqlCap = "SELECT total_spent FROM customers WHERE id = ?";
        $stmt = self::$connection->prepare($sqlCap);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $capital = $stmt->get_result()->fetch_assoc()['total_spent'] ?? 0;

        return [
            'wins' => $wins,
            'lost' => ($total - $wins),
            'win_rate' => $winRate,
            'capital' => $capital
        ];
    }
    public function getLiveWarRoom($user_id)
    {
        // b.auction_id nối với a.id
        // a.plate_id nối với p.id
        $sql = "SELECT 
                a.id as auction_id, -- Bắt buộc phải lấy ID này để làm link
                p.id as plate_id, 
                p.plate_number, 
                p.address, 
                p.current_price, 
                a.end_time,
                MAX(b.bid_amount) as user_last_bid,
                (SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id) as highest_bid
            FROM bids b
            JOIN auctions a ON b.auction_id = a.id
            JOIN plates p ON a.plate_id = p.id
            WHERE b.customer_id = ? AND a.end_time > NOW()
            GROUP BY a.id
            ORDER BY a.end_time ASC";

        $stmt = self::$connection->prepare($sql);

        if (!$stmt) {
            die("Lỗi truy vấn SQL: " . self::$connection->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getAuctionHistory($user_id)
    {
        // Lưu ý: Lấy current_price từ bảng p (plates)
        // Lấy is_winning_bid để xác định Thắng/Thua
        $sql = "SELECT 
                p.plate_number, 
                a.end_time, 
                MAX(b.bid_amount) as user_max_bid,
                p.current_price as final_price, 
                MAX(b.is_winning_bid) as is_winner
            FROM bids b
            JOIN auctions a ON b.auction_id = a.id
            JOIN plates p ON a.plate_id = p.id
            WHERE b.customer_id = ? 
              AND a.end_time <= NOW() -- Chỉ lấy các phiên đã kết thúc
            GROUP BY a.id
            ORDER BY a.end_time DESC";

        $stmt = self::$connection->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . self::$connection->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getTransactionHistory($user_id)
    {
        $sql = "SELECT t.*, p.plate_number 
            FROM transactions t
            LEFT JOIN plates p ON t.plate_id = p.id
            WHERE t.customer_id = ? 
            ORDER BY t.created_at DESC";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function renderVipCard($customer)
    {
        $rank = strtolower($customer['rank']);
        $name = htmlspecialchars($customer['full_name']);
        $id = $customer['id'];
        $spent = number_format($customer['total_spent'] / 1000000000, 1) . 'B';
        $limit = number_format($customer['bidding_limit'] / 1000000000, 1) . 'B';
        // $avatar = !empty($customer['avatar']) ? $customer['avatar'] : "https://i.pravatar.cc/150?u=" . $id;
        // Tìm dòng này trong Customer.php và sửa lại:
        $avatar = htmlspecialchars($customer['avatar']);

        $configs = [
            'diamond' => [
                'border' => 'border-cyan-500/30',
                'hover_border' => 'hover:border-cyan-400',
                'shadow' => 'hover:shadow-[0_0_30px_rgba(6,182,212,0.2)]',
                'tag_bg' => 'bg-cyan-500/10',
                'tag_border' => 'border-cyan-500/20',
                'tag_text' => 'text-cyan-400',
                'label' => 'Diamond Club',
                'led' => 'bg-cyan-400 shadow-[0_0_10px_#001695] animate-pulse',
                'limit_color' => 'text-cyan-400',
                'texture' => 'radial-gradient(#0891B2 0.5px, transparent 0.5px)',
                'texture_opacity' => 'group-hover:opacity-10'
            ],
            'platinum' => [
                'border' => 'border-[#E5E4E2]/20',
                'hover_border' => 'hover:border-[#E5E4E2]',
                'shadow' => 'hover:shadow-[0_0_30px_rgba(229,228,226,0.25)]',
                'tag_bg' => 'bg-[#E5E4E2]/10',
                'tag_border' => 'border-[#E5E4E2]/20',
                'tag_text' => 'text-[#E5E4E2]',
                'label' => 'Platinum Member',
                'led' => 'bg-emerald-500 shadow-[0_0_10px_#22d3ee]',
                'limit_color' => 'text-[#E5E4E2]',
                'texture' => "url('https://www.transparenttextures.com/patterns/brushed-alum.png')",
                'texture_opacity' => 'group-hover:opacity-10'
            ],
            'gold' => [
                'custom_bg' => '#524200',
                'border' => 'border-[#D4AF37]/30',
                'hover_border' => 'hover:border-[#D4AF37]',
                'shadow' => 'hover:shadow-[0_0_30px_rgba(212,175,55,0.2)]',
                'tag_bg' => 'bg-black/20',
                'tag_border' => 'border-[#D4AF37]/20',
                'tag_text' => 'text-[#D4AF37]',
                'label' => 'Gold Member',
                'led' => 'bg-amber-500 shadow-[0_0_10px_#f59e0b]',
                'limit_color' => 'text-[#D4AF37]',
                'texture' => "url('https://www.transparenttextures.com/patterns/robots.png')",
                'texture_size' => 'auto',
                'texture_opacity' => 'group-hover:opacity-30'
            ]
        ];

        $c = $configs[$rank] ?? $configs['gold'];
        $inline_bg = isset($c['custom_bg']) ? "background-color: {$c['custom_bg']};" : "";
        $plate_number = $customer['plate_number'] ?? '51K-888.88';

        ob_start(); ?>
        <div class="member-card-wrapper cursor-pointer"
            data-rank="<?= $rank ?>"
            data-customer='<?= json_encode($customer) ?>'
            onclick="openVipEditor(this)">

            <div class="member-card group relative overflow-hidden bg-black/40 backdrop-blur-md border <?= $c['border'] ?> rounded-3xl p-5 transition-all duration-500 <?= $c['hover_border'] ?> <?= $c['shadow'] ?>"
                style="<?= $inline_bg ?>">

                <?php if ($rank === 'platinum'): ?>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:animate-[shimmer_2s_infinite] pointer-events-none"></div>
                <?php endif; ?>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="px-3 py-1 <?= $c['tag_bg'] ?> border <?= $c['tag_border'] ?> rounded-full">
                            <span class="text-[8px] <?= $c['tag_text'] ?> font-bold uppercase tracking-[2px]"><?= $c['label'] ?></span>
                        </div>
                        <div class="w-4 h-4 flex items-center justify-center rounded-full <?= $c['led'] ?> cursor-help"
                            onclick="event.stopPropagation(); openVaultPanel('<?= $plate_number ?>')">
                            <i class="ri-key-line text-[8px] text-white"></i>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full border-2 <?= $c['tag_border'] ?> overflow-hidden bg-[#111]">
                            <img src="<?= $avatar ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                        <div>
                            <h3 class="text-white font-medium text-sm"><?= $name ?></h3>
                            <p class="text-white/40 text-[10px] font-mono">ID: #<?= str_pad($id, 6, "0", STR_PAD_LEFT) ?></p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-white/5 flex justify-between">
                        <div>
                            <p class="text-[8px] text-white/30 uppercase">Bidding Limit</p>
                            <p class="text-xs <?= $c['limit_color'] ?> font-bold mt-1"><?= $limit ?> VND</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[8px] text-white/30 uppercase">Total Spent</p>
                            <p class="text-xs text-white font-bold mt-1"><?= $spent ?> VND</p>
                        </div>
                    </div>
                </div>

                <div class="absolute inset-0 <?= $c['texture_opacity'] ?> transition-opacity pointer-events-none rounded-3xl"
                    style="background-image: <?= $c['texture'] ?>; <?= $rank === 'diamond' ? 'background-size: 10px 10px;' : '' ?>"></div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
    public function add($data)
    {
        // SQL: Tên cột thực tế trong DB của bạn là 'phone' và 'password_hash'
        $sql = "INSERT INTO customers (full_name, email, phone_number, rank, total_spent, bidding_limit, avatar, password_hash) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = self::$connection->prepare($sql);

        // Xử lý mật khẩu
        $password = password_hash($data['password'] ?? '123456', PASSWORD_DEFAULT);

        // Bind param: 8 tham số (ssssddss)
        $stmt->bind_param(
            "ssssddss",
            $data['full_name'],
            $data['email'],
            $data['phone_number'], // Lấy từ key 'phone_number' bạn muốn
            $data['rank'],
            $data['total_spent'],
            $data['bidding_limit'],
            $data['avatar'],
            $password
        );

        return $stmt->execute();
    }

    /**
     * Hàm Cập nhật khách hàng
     */
    public function update($id, $data)
    {
        // Cập nhật tên cột đúng theo SQL: phone_number và avatar
        $sql = "UPDATE customers SET 
            full_name = ?, 
            email = ?, 
            rank = ?, 
            bidding_limit = ?, 
            avatar = ?, 
            phone_number = ? 
            WHERE id = ?";

        $stmt = self::$connection->prepare($sql);

        // Kiểu dữ liệu: sssds si
        $stmt->bind_param(
            "sssdssi",
            $data['full_name'],
            $data['email'],
            $data['rank'],
            $data['bidding_limit'],
            $data['avatar'],
            $data['phone_number'],
            $id
        );

        return $stmt->execute();
    }
    public function search($keyword)
    {
        // Làm sạch từ khóa để tránh SQL Injection
        $keyword = "%" . $keyword . "%";

        $sql = "SELECT * FROM customers 
            WHERE full_name LIKE ? 
            OR email LIKE ? 
            OR phone_number LIKE ? 
            LIMIT 10"; // Giới hạn 10 kết quả cho gợi ý nhanh

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
