<?php
require_once "../config.php";
require_once "../Models/db.php";
$db = new Db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $type = $_POST['type'] ?? 'Push'; // Khớp với ENUM: 'Push','SMS','Email'
    $title = "Thông báo từ Sapphire"; // Tiêu đề mặc định hoặc bạn thêm input tiêu đề

    if (empty($content)) {
        echo json_encode(['status' => 'error', 'message' => 'Nội dung trống']);
        exit;
    }

    // Lấy danh sách ID của tất cả khách hàng để gửi hàng loạt
    $customer_query = "SELECT id FROM customers";
    $result = Db::$connection->query($customer_query);
    
    if ($result->num_rows > 0) {
        $sql = "INSERT INTO notifications (receiver_id, title, content, type, is_read, created_at) VALUES (?, ?, ?, ?, 0, NOW())";
        $stmt = Db::$connection->prepare($sql);
        
        $success_count = 0;
        while ($row = $result->fetch_assoc()) {
            $receiver_id = $row['id'];
            $stmt->bind_param("isss", $receiver_id, $title, $content, $type);
            if ($stmt->execute()) {
                $success_count++;
            }
        }
        
        echo json_encode([
            'status' => 'success', 
            'message' => "Đã gửi thành công tới $success_count khách hàng!"
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy khách hàng nào']);
    }
}
?>