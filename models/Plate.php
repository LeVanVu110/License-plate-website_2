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
}
