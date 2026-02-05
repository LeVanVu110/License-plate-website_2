<?php
class Plate extends Db
{
    // public function get()
    // {
    //     // 1. Lấy danh sách Ô tô
    //     $sqlCar = "SELECT * FROM plates WHERE vehicle_type = 'Car' ORDER BY current_price DESC";
    //     $resCar = self::$connection->query($sqlCar);
    //     $cars = $resCar->fetch_all(MYSQLI_ASSOC);

    //     // 2. Lấy danh sách Xe máy
    //     $sqlMoto = "SELECT * FROM plates WHERE vehicle_type = 'Motorbike' ORDER BY current_price DESC";
    //     $resMoto = self::$connection->query($sqlMoto);
    //     $motorbikes = $resMoto->fetch_all(MYSQLI_ASSOC);

    //     // Trả về kết quả gộp
    //     return [
    //         'cars' => $cars,
    //         'motorbikes' => $motorbikes
    //     ];
    // }
    public function get()
    {
        $sql = "SELECT * FROM plates";
        $result = self::$connection->query($sql);
        $plates = $result->fetch_all(MYSQLI_ASSOC);

        $data = [
            'cars' => [],
            'motorbikes' => []
        ];

        foreach ($plates as $plate) {
            if ($plate['vehicle_type'] === 'Car') {
                $data['cars'][] = $plate;
            } else {
                $data['motorbikes'][] = $plate;
            }
        }
        return $data;
    }
    public function getByPlateNumber($plateNumber)
    {
        // Làm sạch dữ liệu đầu vào
        $plateNumber = "%" . self::$connection->real_escape_string($plateNumber) . "%";

        // Truy vấn tìm kiếm biển số
        // Giả sử bảng của bạn tên là 'plates' và cột biển số là 'plate_number'
        $sql = "SELECT * FROM plates WHERE plate_number LIKE ? LIMIT 1";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("s", $plateNumber);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về 1 kết quả duy nhất
    }
    // public function getSearchData($keyword = null)
    // {
    //     $data = ['cars' => [], 'motorbikes' => []];

    //     // 1. Nếu không có từ khóa hoặc từ khóa chỉ toàn khoảng trắng, trả về mảng rỗng luôn
    //     if (empty(trim($keyword))) {
    //         return $data;
    //     }

    //     // 2. Làm sạch từ khóa và chuẩn bị truy vấn tìm kiếm gần đúng
    //     // real_escape_string kết hợp với Prepared Statement giúp chống SQL Injection tuyệt đối
    //     $search = "%" . self::$connection->real_escape_string($keyword) . "%";

    //     // Tìm kiếm trong cột plate_number, sắp xếp theo giá giảm dần
    //     $sql = "SELECT * FROM plates WHERE plate_number LIKE ? ORDER BY current_price DESC";

    //     $stmt = self::$connection->prepare($sql);
    //     $stmt->bind_param("s", $search);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $plates = $result->fetch_all(MYSQLI_ASSOC);

    //     // 3. Phân loại dữ liệu vào đúng nhóm để hiển thị lên giao diện
    //     foreach ($plates as $plate) {
    //         if ($plate['vehicle_type'] === 'Car') {
    //             $data['cars'][] = $plate;
    //         } else if ($plate['vehicle_type'] === 'Motorbike') {
    //             $data['motorbikes'][] = $plate;
    //         }
    //     }

    //     return $data;
    // }
    // public function getSearchData($keyword = null, $category = null, $maxPrice = null)
    // {
    //     $data = ['cars' => [], 'motorbikes' => []];
    //     $conditions = [];
    //     $params = [];
    //     $types = "";

    //     $sql = "SELECT * FROM plates WHERE 1=1";

    //     // Lọc theo từ khóa tìm kiếm
    //     if (!empty($keyword)) {
    //         $sql .= " AND plate_number LIKE ?";
    //         $params[] = "%$keyword%";
    //         $types .= "s";
    //     }

    //     // Lọc theo danh mục (Tứ quý, Sảnh tiến...)
    //     if (!empty($category) && $category !== 'all') {
    //         $sql .= " AND category = ?";
    //         $params[] = $category;
    //         $types .= "s";
    //     }

    //     // Lọc theo giá (Chuyển đổi từ tỷ sang VNĐ: 1 tỷ = 1,000,000,000)
    //     if (!empty($maxPrice)) {
    //         $sql .= " AND current_price <= ?";
    //         $params[] = $maxPrice * 1000000;
    //         $types .= "d";
    //     }

    //     $sql .= " ORDER BY current_price DESC";

    //     $stmt = self::$connection->prepare($sql);
    //     if (!empty($params)) {
    //         $stmt->bind_param($types, ...$params);
    //     }

    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $plates = $result->fetch_all(MYSQLI_ASSOC);

    //     foreach ($plates as $plate) {
    //         if ($plate['vehicle_type'] === 'Car') $data['cars'][] = $plate;
    //         else $data['motorbikes'][] = $plate;
    //     }
    //     return $data;
    // }
    public function getSearchData($keyword = null, $category = null, $maxPrice = null)
    {
        $data = ['cars' => [], 'motorbikes' => []];
        $params = [];
        $types = "";

        $sql = "SELECT * FROM plates WHERE 1=1";

        // NÂNG CẤP: Tìm kiếm kép (Số xe hoặc Danh mục)
        if (!empty(trim($keyword))) {
            $search = "%" . trim($keyword) . "%";
            // Nếu người dùng nhập "Tứ quý", nó sẽ khớp ở vế category
            $sql .= " AND (plate_number LIKE ? OR category LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }

        // Lọc theo nút bấm Category (Nếu có)
        if (!empty($category) && $category !== 'all') {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }

        // Lọc theo giá
        if (!empty($maxPrice)) {
            $sql .= " AND current_price <= ?";
            $params[] = $maxPrice * 1000000;
            $types .= "d";
        }

        $sql .= " ORDER BY current_price DESC";

        $stmt = self::$connection->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $plates = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($plates as $plate) {
            if ($plate['vehicle_type'] === 'Car') $data['cars'][] = $plate;
            else $data['motorbikes'][] = $plate;
        }
        return $data;
    }
    // Thêm vào class Plate trong file Plate.php
    public function renderPlateCard($plate)
    {
        // 1. Chuẩn bị dữ liệu JSON để truyền vào JS (quan trọng để Sửa)
        // Dùng htmlspecialchars để tránh lỗi khi dữ liệu có dấu nháy
        $plateJson = htmlspecialchars(json_encode($plate), ENT_QUOTES, 'UTF-8');

        $formattedPrice = number_format($plate['current_price'], 0, ',', '.') . 'đ';
        $isMotorbike = ($plate['vehicle_type'] === 'Motorbike');
        $icon = $isMotorbike ? 'ri-motorbike-fill' : 'ri-car-fill';
        $plateNumber = $plate['plate_number'];

        $plateDisplay = "";
        if ($isMotorbike && str_contains($plateNumber, '-')) {
            $parts = explode('-', $plateNumber);
            $plateDisplay = "
        <div class='bg-white border-2 border-gray-300 rounded-lg px-4 py-2 shadow-lg transform group-hover:scale-110 transition-transform duration-500 flex flex-col items-center justify-center leading-none min-w-[100px]'>
            <span class='text-black font-bold text-lg tracking-widest border-b border-gray-200 w-full text-center pb-1 mb-1'>{$parts[0]}</span>
            <span class='text-black font-bold text-xl tracking-tighter'>{$parts[1]}</span>
        </div>";
        } else {
            $plateDisplay = "
        <div class='bg-white border-2 border-gray-300 rounded px-4 py-1 shadow-lg transform group-hover:scale-110 transition-transform duration-500'>
            <span class='text-black font-bold text-xl tracking-tighter'>{$plateNumber}</span>
        </div>";
        }

        return "
    <div class='group relative bg-[#0a192f] border border-white/5 p-6 rounded-[2rem] hover:border-cyan-500/50 transition-all duration-500' 
         onclick='openVaultPanel({$plateJson})'>
        <div class='flex justify-between items-start mb-4'>
            <i class='{$icon} text-white/20 group-hover:text-cyan-400 transition-colors " . ($isMotorbike ? "text-xl" : "") . "'></i>
            <span class='text-[10px] font-bold text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded'>" . strtoupper($plate['status']) . "</span>
        </div>

        <div class='flex justify-center " . ($isMotorbike ? "py-4" : "py-6") . "'>
            {$plateDisplay}
        </div>

        <div class='mt-4 flex justify-between items-end'>
            <div>
                <p class='text-[9px] text-white/30 uppercase'>Current Price</p>
                <p class='text-white font-bold'>{$formattedPrice}</p>
            </div>
            <button class='w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-cyan-500 transition-all' 
                    onclick='event.stopPropagation(); openVaultPanel({$plateJson})'>
                <i class='ri-pencil-line text-xs'></i>
            </button>
        </div>
    </div>";
    }
    public function getWithPagination($keyword = '', $category = '', $maxPrice = null, $page = 1, $perPage = 8)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $types = "";

        $sql = "SELECT * FROM plates WHERE 1=1";

        // --- Giữ nguyên các bộ lọc cũ ---
        if (!empty(trim($keyword))) {
            $search = "%" . trim($keyword) . "%";
            $sql .= " AND (plate_number LIKE ? OR category LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }
        if (!empty($category) && $category !== 'all') {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }
        if (!empty($maxPrice)) {
            $sql .= " AND current_price <= ?";
            $params[] = $maxPrice * 1000000;
            $types .= "d";
        }

        // --- Thêm Limit và Offset để phân trang ---
        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        $types .= "ii";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalPlates($keyword = '', $category = '', $maxPrice = null)
    {
        $sql = "SELECT COUNT(*) as total FROM plates WHERE 1=1";
        // (Thêm các điều kiện WHERE tương tự như hàm get ở trên để đếm chính xác số lượng sau khi lọc)
        // ... logic lọc tương tự ...
        $result = self::$connection->query($sql);
        return $result->fetch_assoc()['total'];
    }
    public function add($plate_number, $starting_price, $current_price, $category, $vehicle_type, $address, $status)
    {
        $sql = "INSERT INTO plates (plate_number, starting_price, current_price, category, vehicle_type, address, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = self::$connection->prepare($sql);

        // "sddssss" tương ứng với các kiểu dữ liệu: string, decimal, decimal, string, string, string, string
        $stmt->bind_param(
            "sddssss",
            $plate_number,
            $starting_price,
            $current_price,
            $category,
            $vehicle_type,
            $address,
            $status
        );

        if ($stmt->execute()) {
            return $stmt->insert_id; // Trả về ID của bản ghi vừa tạo
        } else {
            return false;
        }
    }
    public function create($data)
    {
        $sql = "INSERT INTO plates (plate_number, starting_price, current_price, category, vehicle_type, address, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param(
            "sddssss",
            $data['plate_number'],
            $data['starting_price'],
            $data['current_price'],
            $data['category'],
            $data['vehicle_type'],
            $data['address'],
            $data['status']
        );

        if (!$stmt->execute()) {
            // Nếu lỗi là do trùng biển số (mã lỗi 1062)
            if (self::$connection->errno == 1062) {
                throw new Exception("Duplicate entry");
            }
            throw new Exception("Lỗi hệ thống: " . self::$connection->error);
        }
        return true;
    }
    public function update($id, $data)
    {
        $sql = "UPDATE plates SET plate_number = ?, starting_price = ?, current_price = ?, 
            category = ?, vehicle_type = ?, address = ?, status = ? WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param(
            "sddssssi",
            $data['plate_number'],
            $data['starting_price'],
            $data['current_price'],
            $data['category'],
            $data['vehicle_type'],
            $data['address'],
            $data['status'],
            $id
        );
        return $stmt->execute();
    }
}
