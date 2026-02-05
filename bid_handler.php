<?php
if ($bid_success) {
    // 1. Tạo mã giao dịch ngẫu nhiên
    $tx_code = "0x" . strtoupper(bin2hex(random_bytes(4))); 
    
    // 2. Ghi vào bảng transactions (Sổ Cái)
    $sql = "INSERT INTO transactions (transaction_code, customer_id, plate_id, type, amount, status) 
            VALUES (?, ?, ?, 'Tiền đặt cọc', -40000000, 'Success')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $tx_code, $user_id, $plate_id);
    $stmt->execute();
}